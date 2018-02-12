Adoption of Bitcoin Blockchain in Diavgeia
====

Sections
-------
1. [What does blockchain offer ?](#what-does-blockchain-offer-)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Usage](#usage)
5. [Test](#test)
6. [Disclaimer](#disclaimer)

What does blockchain offer ?
---------------------------

Beggining October 1st, 2010, Diavgeia started as an effort that promotes transparency and by now it hosts over 24.5 Million decisions. Greek government claims that `the transparency program introduced unprecedented levels of transparency within all levels of Greek public administration and established a new “social contract” between the citizen and the state.`([link](https://diavgeia.gov.gr/en)). This is partially right, as all government institutions are obliged to upload their decisions online. But what happens when a government institution or the greek government silently deletes or modifies a decision, in order to hide corruption?  It is of crucial importance that citizens and government institutions have guarantees about decisions' immutability over time.

Through the use of the bitcoin blockchain, we force government data to remain immutable. In order to limit the time span in which a document can be altered (modified or removed), Diavgeia will be forced to store a log in the Bitcoin Network, at predefined time intervals. It is obvious that smaller time intervals imply more transparency, as the government keeps more logs. That said, let’s assume Diavgeia is forced to keep daily logs.

1. Diavgeia gathers all decisions that have not been included in the previous log. These documents are organized into a Merkle Tree.

2. Diavgeia gets the root of the Merkle tree and signs it. Diavgeia commits the signed root of the Merkle Tree as [proof of burn](https://en.bitcoin.it/wiki/Proof_of_burn) to the Bitcoin Network.

3. After the confirmation of the transaction, Diavgeia should also publish the following to its website:
  - The merkle tree (that is the order of the documents). This is crucial, because citizens should be able to verify that the root of the merkle tree is valid.
  - Bitcoin transaction id

Then, citizens and government institutions can verify their acts and be sure that their decisions will remain immutable over time.

A visualization of the procedure:

![Commit to Bitcoin Blockchain procedure](https://image.ibb.co/fH0Nca/Drawing_2.jpg)

It is obvious that this is an extremely cheap way to provide decisions' immutability, as government should only pay once a day a configurable transaction fee.

Installation
------------

Everything that has been described in [What does blockchain offer ?](#what-does-blockchain-offer-) section, has been implemented [here](https://github.com/eellak/gsoc17-diavgeia/tree/master/bitcoin).

The installation process is pretty straightforward. Just `git clone https://github.com/eellak/gsoc17-diavgeia && cd bitcoin` and then `npm install`.

**NODE VERSION** : You have to use a node version that supports ES6 features and the application has been tested on node version 8.1.2.

Configuration
-------------

The application uses the [node-config](https://github.com/lorenwest/node-config) module, in order to easily configure its settings. Before running the application, you have to first define a `.json` file having the same keys as of [this json file](https://github.com/eellak/gsoc17-diavgeia/blob/master/bitcoin/config/development.json). For instance, consider the following configuration:

```json
{
  "wallet_location_from_home" : true,
  "wallet_location" : ".bcoin",
  "wallet_id" : "diavgeia",
  "network" : "testnet",
  "hash_algorithm" : "sha256",
  "proof_of_burn_fee" : 20000
}
```

**wallet_location_from_home** : A boolean value that indicates whether the **wallet_location** value, indicates a directory under your home path. If set to `false`, then **wallet_location** indicates an absolute path.

**wallet_location** : The path in which *.bcoin* components (database, chain, wallet) will be stored.

**wallet_id** : The name of Diavgeia's wallet.

**network** : The cryptocurrency in which decisions will be uploaded to. The value can be one of `main, testnet, regtest, segnet4`. `Main` corresponds to the main Bitcoin Network and this is the value that should be used in production. For testing reasons i highly recommend to use `testnet` as you can get free BTC and experiment with the application without worrying about real BTC.

**hash_algorithm** : The algorithm which will be used on Merkle Tree Construction. The `hash_algorithm` is dependent on the available algorithms supported by the version of OpenSSL platform. Examples are `sha256`, `sha512`, etc. On recent releases of OpenSSL, `openssl list-message-digest-algorithms` will display the available digest algorithms.

**proof_of_burn_fee** : The transaction fee. Miners usually include transactions with the highest fees first and thus a higher fee probably means faster transaction confirmation. The value of this key, refers to [satoshi unit](https://en.bitcoin.it/wiki/Satoshi_(unit)).

**NOTE** : After configuring your `.json` file, you have to export the *NODE_ENV* according to the configuration file name. For instance, if you have named your configuration file `development.json` you have to `export NODE_ENV=development`. Please read more about this, [here](https://github.com/lorenwest/node-config/wiki/Environment-Variables)

Usage
-----

The main script which is responsible for committing the decisions to the Bitcoin Blockchain, can be found at `src/scripts/main.js`. This script provides the following three functionalities:

1. Initialize Diavgeia's wallet. You have to initialize your wallet first before running anything else and most probably, this script will not be called again.

Invocation : `node src/scripts/main.js --init`.

2. SPV Sync. Downloads the `spvchain.ldb` and monitors your wallet balance.

Invocation : `node src/scripts/main.js --spv`.

3. Commit Decisions to Blockchain. This script call will construct the merkle tree, a Proof Of Burn bitcoin transaction and will return an object (merkle tree Object and transaction id) that should be published on the website. `decisionsPath` is a file system path that should contain all the decisions.

Invocation : `node src/scripts/main.js --commit decisionsPath`.

**PUBLISH** : Diavgeia should **publish once** the Master Public Key which is reported when running the script, in order to provide citizens amd government institutions a mechanism to track every transaction that Diavgeia commits to the Bitcoin Blockchain. By doing this, Diavgeia has no more the anonymity that blockchain offers.

This also covers the case in which Diavgeia creates two transactions of two different merkle trees ("good" and "evil"), by first exposing the good transaction and some time after silently swaps the good merkle tree with the evil one. In other words, citizens and government institutions consider valid only the transactions that have public addresses which derive from the Master Public Key.

Test
-----

This is the procedure that one may follow in order to test the application.

1. Make sure that the configuration value of `network` is `testnet`.
2. Initialize your wallet with `node src/scripts/main.js --init`.
3. Download the spvchain with `node src/scripts/main.js --spv`. Simultaneously, you can get some free BTC coins [here](https://testnet.coinfaucet.eu/en/), using the wallet address that program reports. Wait until the balance is updated.
4. I have created a [sample directory](https://github.com/eellak/gsoc17-diavgeia/tree/master/bitcoin/decisions-sample) that contains 32 decisions and can be used as a test case. That said, you can create a proof of burn transaction of the sample decisions with `node src/scripts/main.js --commit ./decisions-sample`. When the transaction gets broadcasted, application informs you about the Merkle Tree and transaction id that should be published. You can use the transaction id on a [Bitcoin Testnet Explorer](https://live.blockcypher.com/btc-testnet/) and see your transaction in the network.

Disclaimer
----------

The application does not guarantee you against theft or lost funds due to bugs, mishaps, or your own incompetence. Diavgeia alone is responsible for securing the money.