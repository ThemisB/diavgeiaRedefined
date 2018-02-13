Consistency Verifier
====================

Sections
-------
1. [Verification Algorithm](#verification-algorithm)
2. [Configuration](#configuration)

Verification Algorithm
----------------------

Consistency Verifier is the tool which can be used by the interested parties in order to verify that decisions have remained immutable over time. Algorithm 1 formalizes the steps Consistency Verifier takes to verify the integrity of decisions.

The first step is to download the compressed Notation3 decisions which have been included in stamping transactions. Afterwards, the verifier downloads in ascending time order all bitcoin transactions (using the \textit{chain.so} bitcoin block reader, available at \url{https://chain.so/}), related to the used public addresses derived from Diavgeia's master public key. In case of a stamping transaction, the verifier constructs the Merkle tree using the decisions of the first step. If the computed Merkle root is equal to the Merkle root found on the stamping transaction, decisions have remained unmodified.

For the time being, the verification algorithm performs a "full verification", meaning that it checks that all decisions of Diavgeia have remained immutable. In the future, we plan to implement an "inclusion verification", that is given a pair of `iun`-`version`, we can check if a given decision has already been stamped, employing the published Merkle Tree.

Configuration
-------------

```json
{
  "network": "testnet",
  "diavgeiaURI": "http://localhost:3000",
  "xpubkey": "The master public key of Diavgeia",
  "hash_algorithm": "sha256"
}
```

**network** : The Bitcoin network in which the verifier will run. The value can be one of `main, testnet, regtest, segnet4`. `Main` corresponds to the main Bitcoin Network and this is the value that should be used in production. For testing reasons i highly recommend to use `testnet` as you can get free BTC and experiment with the application without worrying about real BTC.

**diavgeiaURI** : This is the URI of the endpoint which Diavgeia offers the ability to download the decisions of the public authorities (e.g. `https://diavgeia.gov.gr/`). For testing reasons you can set it to `http://localhost:3000`.

**xpubkey** : This is the master public key which has been published once by the administrators of Diavgeia.

**hash_algorithm** : The algorithm which will be used on Merkle Tree Construction. The `hash_algorithm` is dependent on the available algorithms supported by the version of OpenSSL platform. Examples are `sha256`, `sha512`, etc. On recent releases of OpenSSL, `openssl list-message-digest-algorithms` will display the available digest algorithms.

**NOTE** : After configuring your `.json` file, you have to export the *NODE_ENV* according to the configuration file name. For instance, if you have named your configuration file `development.json` you have to `export NODE_ENV=development`. Please read more about this, [here](https://github.com/lorenwest/node-config/wiki/Environment-Variables)