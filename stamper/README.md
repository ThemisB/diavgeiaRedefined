Adoption of Bitcoin Blockchain in Diavgeia
====

Sections
-------
1. [Preserving Decisions using Bitcoin Blockchain](#preserving-decisions-using-bitcoin-blockchain)
2. [Configuration](#configuration)
3. [Usage](#usage)
4. [Test](#test)
5. [Disclaimer](#disclaimer)

Preserving Decisions using Bitcoin Blockchain
---------------------------

Stamper is the tool which should be used by the administrators of Diavgeia in
order to store public sector decisions on the bitcoin blockchain. The stamping
procedure is described as follows:

1. Government institutions upload their decisions on Diavgeia. The backend of Diavgeia stores decisions as compressed Notation3 files in its filesystem and in the triple store.

2. The administrator of Diavgeia has to decide that the stamping procedure should take place at predefined time intervals *t*, ensuring the integrity of decisions. Thus, the backend of Diavgeia starts a new stamping procedure every *t* time units.

3. At the start of the stamping procedure, we find all the compressed Notation3 decisions which have not been stamped yet. Stamper organizes and aggregates these decisions into a [Merkle Tree](https://en.wikipedia.org/wiki/Merkle_tree), using the hash function SHA-256. The root of the Merkle tree represents the fingerprint of the decisions which will be included in the forthcoming bitcoin transaction. By applying the SHA-256 hash function on the Merkle tree construction, the resulting root has a constant size of 32 bytes.

4. The next step is to create a Bitcoin transaction and broadcast it to the rest of the network. DiavgeiaRedefined uses the [bcoin library](http://bcoin.io/), offering Diavgeia an spv node, maintaining only a chain, a pool, and a hierarchical deterministic (HD) wallet based on BIP44.

A stamping transaction in our model consists of two outputs and one input. The first output contains the `OP_RETURN` opcode followed by the Merkle root in the *scriptPubKey* output *scriptPubKey = OP_RETURN + Root*. This output guarantees the immutability of decisions. The second output is a *pay-to-pubkey-hash*, having as *pubKey* the next derived public address of the HD wallet. The input *scriptSig* consists of Diavgeia's signature and the current *publicKey* derived from HD wallet (*scriptSig = signature + publicKey*). The size of a stamping transaction is 267 bytes. In order to have certain guarantees that our transaction will be written into the next block and confirmed nearly immediately, mining fees can cost up to 120,150 satoshi (0.00125 bitcoin), which at the time of writing roughly amounts to *$16.84*.

A visualization of the procedure:

![Stamping procedure](https://i.imgur.com/5Kt1xsp.png)

After the end of each stamping transaction, Diavgeia publishes to its website the transaction identifier (Txid) and the order of decisions, as used for the Merkle tree construction. It also publishes once, the Master Public Key of its HD wallet. By publishing Diavgeia's master public key, interested parties are able to track the sequence of public keys and stamping transactions of Diavgeia. These publications are necessary to be made for the proper functionality of the [Consistency Verifier](https://github.com/ThemisB/diavgeiaRedefined/tree/master/consistency-verifier).

**Guarantees of Stamper**

The Stamper tool provides high levels of immutability guarantees, especially when *t* value is configured to be small. Generally, the threat of a decision's modification or deletion appears on the time gap between two consecutive stampings. Small *t* values imply more stamping invocations and as a result Diavgeia creates more stamping transactions, but this comes at a higher cost. We consider a *t* value ranging from 3 hours to 1 day, to be an affordable solution for the government, since the daily cost of the usage of the blockchain will range from 0.00125 to 0.005 bitcoin (*$16.84* - *$134.72*). The threshold for a decision's modification is also small, since an adversary (the administrators of Diavgeia, the government or other public authorities) are able to modify the decision in the next 3 hours to 1 day after its publishment.

As mentioned, the Stamper tool uses the open source bitcoin library (bcoin) in order to create the stamping transactions and relay them to the network. DiavgeiaRedefined does not use existing blockchain timestamping services (such as [Stampery](https://stampery.com/) or [OpenTimeStamps](https://opentimestamps.org/)) because, in case of a foul play by an adversary, these third-party services might be accused of having modified the Merkle root in the first place.

Configuration
-------------

The application uses the [node-config](https://github.com/lorenwest/node-config) module, in order to easily configure its settings. Before running the application, you have to first define a `.json` file having the same keys as of [this json file](https://github.com/eellak/gsoc17-diavgeia/blob/master/bitcoin/config/development.json). For instance, consider the following configuration:

```json
{
  "wallet_location_from_home" : true,
  "wallet_location" : ".bcoin",
  "wallet_id" : "diavgeia",
  "network" : "testnet",
  "hash_algorithm" : "sha256"
}
```

**wallet_location_from_home** : A boolean value that indicates whether the **wallet_location** value, indicates a directory under your home path. If set to `false`, then **wallet_location** indicates an absolute path.

**wallet_location** : The path in which *.bcoin* components (database, chain, wallet) will be stored.

**wallet_id** : The name of Diavgeia's wallet.

**network** : The Bitcoin network in which decisions will be uploaded to. The value can be one of `main, testnet, regtest, segnet4`. `Main` corresponds to the main Bitcoin Network and this is the value that should be used in production. For testing reasons i highly recommend to use `testnet` as you can get free BTC and experiment with the application without worrying about real BTC.

**hash_algorithm** : The algorithm which will be used on Merkle Tree Construction. The `hash_algorithm` is dependent on the available algorithms supported by the version of OpenSSL platform. Examples are `sha256`, `sha512`, etc. On recent releases of OpenSSL, `openssl list-message-digest-algorithms` will display the available digest algorithms.

**NOTE** : After configuring your `.json` file, you have to export the *NODE_ENV* according to the configuration file name. For instance, if you have named your configuration file `development.json` you have to `export NODE_ENV=development`. Please read more about this, [here](https://github.com/lorenwest/node-config/wiki/Environment-Variables)

Usage
-----

The main script which is responsible for committing the decisions to the Bitcoin Blockchain, can be found at `src/scripts/main.js`. This script provides the following three functionalities:

1. Initialize Diavgeia's wallet. You have to initialize your wallet first before running anything else and most probably, this script will not be called again.

  Invocation : `node src/scripts/main.js --init`.

2. SPV Sync. Downloads the `spvchain.ldb` and monitors your wallet balance.

  Invocation : `node src/scripts/main.js --spv`.

3. While SPV sync is running, you can charge your wallet on the address which will appear on the terminal. Once your charging transaction gets confirmed by the miners, a message will appear on the spv sync script, displaying the new wallet balance.

4. Commit Decisions to Blockchain. This script call will find the decisions which have not been stamped yet and store them on the bitcoin blockchain.

  Invocation : `node src/scripts/main.js --commit`.

Test
-----

This is the procedure that one may follow in order to test the application.

1. Make sure that the configuration value of `network` is `testnet`.
2. Initialize your wallet with `node src/scripts/main.js --init`.
3. Download the spvchain with `node src/scripts/main.js --spv`. Simultaneously, you can get some free BTC coins [here](https://testnet.coinfaucet.eu/en/), using the wallet address that program reports. Wait until the balance is updated.
4. Author one or more decisions using the [Web editor](https://github.com/ThemisB/diavgeiaRedefined/tree/master/web-editor). Then run `node src/scripts/main.js --commit`. Go to the explore page of DiavgeiaRedefined and you can see that your decisions have been stamped. A link is provided to the latest stamping transaction to the interested parties, using the [Chain.so explorer](https://chain.so/).

Disclaimer
----------

The Stamper tool does not guarantee you against theft or lost funds due to bugs, mishaps, or your own incompetence. The administratiors of Diavgeia alone are responsible for securing the money.