const config = require('config');
const bcoin = require('bcoin').set(config.get('network'));
const fs = require('co-fs');
const crypto = require('crypto');
const co = require('co');
const merkle = require('merkle-tree-gen');
const assert = require('assert');
const path = require('path');

class BTCCommiter {

  /**
   * BTCCommiter
   * @constructor
   * @param {String} decisionsFolder - A folder that contains all the decisions that will be commited in a tx on the Bitcoin blockchain.
   */

  constructor(decisionsFolder) {
    this.decisionsFolder = decisionsFolder;
  }

  /**
   * @typedef {Array.<DecisionData>} DecisionsData
   */

  /**
   * @typedef {Object} DecisionData
   * @property {string} filepath - The fullpath of the decision
   * @property {Buffer} data - The data of the decision
   */

  /**
   * Get the decisions that have not commited yet to blockchain
   * @private
   * @returns {Promise}
   * @resolve {DecisionsData}
   */

   _getDecisionsNotCommitedYet() {
     var _btcCommiter = this;
     return co(function* () {
       let environment = (process.env.NODE_ENV !== undefined) ? process.env.NODE_ENV : 'development';
       let n3ConfigurationFilePromise = yield fs.readFile('../n3-composer/config/' + environment + '.json');
       let n3ConfigurationFile = JSON.parse(n3ConfigurationFilePromise);
       var monk = require('monk');
       var wrap = require('co-monk');
       let db = monk(n3ConfigurationFile['mongoURL'] + '/' + n3ConfigurationFile['mongoDBName']);
       var blockchainCommitsCollection = wrap(db.get('blockchainCommits'));
       var lastCommit = yield blockchainCommitsCollection.find({}, {sort: {_id: -1}, limit: 1});
       let lastCommitDate = lastCommit[0].date;
       var decisionsCollection = wrap(db.get('decisions'));
       let q = {
         date: {
          '$gte': new Date(lastCommitDate)
         }
       };
       var decisionsNotCommited = yield decisionsCollection.find(q, 'iun version');
       const expandHomeDir = require('expand-home-dir');
       const decisionsDirectory = expandHomeDir(n3ConfigurationFile['decisionsSaveDir']);
       var array = [];
       const readAllFiles = decision => co(function*(){
         let fullpath = decisionsDirectory + '/' + decision.iun + '_' + decision.version + '.n3.gz';
         let data = yield fs.readFile(fullpath);
         return {filepath: fullpath, data};
       });
       const filenamesBuffer = yield decisionsNotCommited.map(readAllFiles);
       return filenamesBuffer;
     })
   }
  /**
   * @typedef {Array.<DecisionHash>} DecisionsHash
   */

  /**
   * @typedef {Object} DecisionHash
   * @property {string} filepath - The fullpath of the decision
   * @property {string} hash - The hash of the decision
   */

  /**
   * get the hash of decisions
   * @private
   * @param {DecisionsData}
   * @returns {Promise}
   * @resolve {DecisionsHash}
   */

  _getDecisionsHash(decisionsData) {
    var _btcCommiter = this;

    return co(function* () {
      const hashCalculate = decisionsData => {
        let hash = crypto.createHash(config.get('hash_algorithm'));
        return {
          filepath: decisionsData.filepath,
          hash: hash.update(decisionsData.data).digest('hex')
        };
      }
      return decisionsData.map(hashCalculate);
    });
  }

  /**
   * @typedef {Object.<hash, MerkleTreeNode>} MerkleTreeNodes
   */

  /**
   * @typedef {Object} MerkleTreeNode
   * @property {('leaf'|'node'|'root')} type - Role of the tree node
   * @property {number} level - The height of the node
   * @property {string} left - The left tree node of this tree node
   * @property {string} right - The right tree node of this tree node
   * @property {string} parent - The parent of the tree node
   */

  /**
   * @typedef {Object} MerkleTree
   * @property {string} root - The root of the Merkle Tree
   * @property {string} hashalgo - The hash algorithm used on Merkle Tree Construction
   * @property {number} leaves - The leaves of the tree. Equivalent to the number of decisions
   * @property {number} levels - The height of the tree
   * @property {Object} MerkleTreeNodes - Dynamic properties of the MerkleTree Object,
   * corresponding to a node of the tree and keyed by their hash.
   */

  /**
   * Create the Merkle Tree
   * @private
   * @param {DecisionsHash}
   * @returns {MerkleTree}
   */
  _constructMerkleTree(decisionsHash) {
    const hashes = decisionsHash.map(decisionHash => decisionHash.hash);
    const merkleTreeArgs = {
      array: hashes,
      hashalgo: config.get('hash_algorithm'),
      hashlist: true
    };
    var tree = undefined;
    merkle.fromArray(merkleTreeArgs, function(err, tr) {
      if(!err){
        tree = tr;
      }
      else {
        assert.fail('Merkle Tree construction error', err);
      }
    });
    return tree;
  }

  /**
   * Creates and broadcasts a proof of burn tx.
   * @private
   * @param {string} root - The root of the Merkle Tree
   * @param {Wallet} dvgWallet - The wallet of Diavgeia
   * @param {SPVNode} spv
   * @returns {string} The tx id that should be published on Diavgeia website
   */

   _broadcastMerkleTreeTransaction(root, dvgWallet, spv) {
     return co(function* () {
       var opcodes = bcoin.script.opcodes;
       var script = new bcoin.script();
       script.push(opcodes.OP_RETURN);
       script.push(root);
       script.compile();
       var changeAddress = dvgWallet.getAddress();
       var mtx = new bcoin.mtx();
       mtx.addOutput({
         script,
         value: config.get('proof_of_burn_fee'),
         address: null
       });
       var coins = yield dvgWallet.getCoins();
       yield mtx.fund(coins, {changeAddress, confirmed: true});
       yield dvgWallet.sign(mtx);
       var tx = mtx.toTX();
       yield dvgWallet.db.addTX(tx);
       yield dvgWallet.db.send(tx);
       yield spv.sendTX(tx);
       const txId = tx.txid();
       return txId;
     });
   }

   /**
    * @typedef {Object} Published
    * @property {MerkleTree} tree
    * @property {string} txId
    */

   /**
    * Reads decisions that have not commited yet,
    * creates a tx and broadcasts it to the blockchain.
    * @return {Published}
    */

    publishDecisionsToBTC(dvgWallet, spv) {
      var _btcCommiter = this;
      return co(function*(){
        const data = yield _btcCommiter._getDecisionsNotCommitedYet();
        const hashes = yield _btcCommiter._getDecisionsHash(data);
        const tree = _btcCommiter._constructMerkleTree(hashes);
        const txId = yield _btcCommiter._broadcastMerkleTreeTransaction(tree.root, dvgWallet, spv);
        let environment = (process.env.NODE_ENV !== undefined) ? process.env.NODE_ENV : 'development';
        let n3ConfigurationFilePromise = yield fs.readFile('../n3-composer/config/' + environment + '.json');
        let n3ConfigurationFile = JSON.parse(n3ConfigurationFilePromise);
        var monk = require('monk');
        var wrap = require('co-monk');
        let db = monk(n3ConfigurationFile['mongoURL'] + '/' + n3ConfigurationFile['mongoDBName']);
        var blockchainCommitsCollection = wrap(db.get('blockchainCommits'));
        // Stored merkle tree and txId to mongo
        yield blockchainCommitsCollection.insert({txId, tree, date: new Date()});
        return { tree, txId };
      });
    };
}

module.exports = BTCCommiter;