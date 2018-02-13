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

  constructor() {}

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
       let n3ConfigurationFilePromise = yield fs.readFile('../web-editor/config/' + environment + '.json');
       let n3ConfigurationFile = JSON.parse(n3ConfigurationFilePromise);
       var monk = require('monk');
       var wrap = require('co-monk');
       let db = monk(n3ConfigurationFile['mongoURL'] + '/' + n3ConfigurationFile['mongoDBName']);
       var blockchainCommitsCollection = wrap(db.get('blockchainCommits'));
       var lastCommitDate = yield blockchainCommitsCollection.findOne({}, {sort: {_id: -1}, limit: 1, fields:{'date' : 1, '_id': 0 }});

       // If at least one PoB has been done
       if (lastCommitDate !== null) {
         console.log(lastCommitDate)
         lastCommitDate = lastCommitDate.date;
       }

       var decisionsCollection = wrap(db.get('decisions'));
       var decisionsNotCommited;

       // Get all decisions that have not been commited yet
       if (lastCommitDate !== null) {
          let q = {
            date: {
             '$gte': new Date(lastCommitDate)
            }
          };
         decisionsNotCommited = yield decisionsCollection.find(q, {sort: {date: -1}, fields:{'iun': 1, 'version': 1, '_id': '1'}});
       } else {
        // No PoB has been done yet. So we should get all decisions.
        decisionsNotCommited = yield decisionsCollection.find({}, {sort: {date: -1}, fields:{'iun': 1, 'version': 1, '_id': '1'}});
       }

       const expandHomeDir = require('expand-home-dir');
       const decisionsDirectory = expandHomeDir(n3ConfigurationFile['decisionsSaveDir']);
       var array = [];
       const readAllFiles = decision => co(function*(){
         let fullpath = decisionsDirectory + '/' + decision.iun + '_' + decision.version + '.n3.gz';
         let data = yield fs.readFile(fullpath);
         return {filepath: fullpath, data};
       });
       const filenamesBuffer = yield decisionsNotCommited.map(readAllFiles);
       const ObjectID = require('mongodb').ObjectID;
       decisionsNotCommited = yield decisionsNotCommited.map(decision => new ObjectID(decision._id));
       return [filenamesBuffer, decisionsNotCommited];
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
    if (hashes.length === 0) {
      throw 'NO_DECISIONS';
    }
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
        throw new Error('Merkle Tree construction error', err);
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
       script.pushSym('OP_RETURN');
       script.pushString(root);
       script.compile();
       var changeAddress = dvgWallet.getAddress();
       var mtx = new bcoin.mtx();
       mtx.addOutput({
         script,
         address: null
       });
       var coins = yield dvgWallet.getCoins();
       yield mtx.fund(coins, {changeAddress, rate: 706560, confirmed: true});
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
        const uncommitedData = yield _btcCommiter._getDecisionsNotCommitedYet();
        const rawData = uncommitedData[0]
        const uncommitedDecisionObjs = uncommitedData[1]
        const hashes = yield _btcCommiter._getDecisionsHash(rawData);
        const tree = _btcCommiter._constructMerkleTree(hashes);
        const txId = yield _btcCommiter._broadcastMerkleTreeTransaction(tree.root, dvgWallet, spv);
        let environment = (process.env.NODE_ENV !== undefined) ? process.env.NODE_ENV : 'development';
        let n3ConfigurationFilePromise = yield fs.readFile('../web-editor/config/' + environment + '.json');
        let n3ConfigurationFile = JSON.parse(n3ConfigurationFilePromise);
        var monk = require('monk');
        var wrap = require('co-monk');
        let db = monk(n3ConfigurationFile['mongoURL'] + '/' + n3ConfigurationFile['mongoDBName']);
        var blockchainCommitsCollection = wrap(db.get('blockchainCommits'));
        var decisionsCollection = wrap(db.get('decisions'));
        // Stored merkle tree and txId to mongo
        let txIndex = yield blockchainCommitsCollection.count({});
        yield blockchainCommitsCollection.insert({txId, tree, date: new Date(), txIndex});
        yield decisionsCollection.update({ _id : { $in: uncommitedDecisionObjs }}, {$set: {txIndex}}, {multi: true});
        return { tree, txId };
      });
    };
}

module.exports = BTCCommiter;