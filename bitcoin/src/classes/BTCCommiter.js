const config = require('config');
const bcoin = require('bcoin').set(config.get('network'));
const fs = require('co-fs');
const crypto = require('crypto');
const co = require('co');
const merkle = require('merkle-tree-gen');
const assert = require('assert');

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
   *  Get the data of the files inside decisionsFolder
   *  @private
   *  @returns {Promise}
   *  @resolve {DecisionsData}
   */

  _getDecisionsData() {
    var _btcCommiter = this;
    console.log(__dirname)
    console.log(_btcCommiter.decisionsFolder)
    return co(function* () {
      const filenames = yield fs.readdir(_btcCommiter.decisionsFolder);
      const readAllFiles = filename => co(function*(){
        let fullpath = _btcCommiter.decisionsFolder+filename;
        let data = yield fs.readFile(fullpath);
        return {filepath:fullpath,data};
      });
      const filenamesBuffer = yield filenames.map(readAllFiles);
      return filenamesBuffer;
    });
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
       console.log('Proof of burn tx with hash ', txId , ' was broadcasted!');
       return txId;
     });
   }

   /**
    * @typedef {Object} Published
    * @property {MerkleTree} tree
    * @property {string} txId
    */

   /**
    * Reads decisions inside decisionsFolder, creates the Merkle Tree
    * creates a tx and broadcasts it to the blockchain.
    * @return {Published}
    */

    publishDecisionsToBTC(dvgWallet, spv) {
      var _btcCommiter = this;
      return co(function*(){
        const data = yield _btcCommiter._getDecisionsData();
        const hashes = yield _btcCommiter._getDecisionsHash(data);
        const tree = _btcCommiter._constructMerkleTree(hashes);
        const txId = yield _btcCommiter._broadcastMerkleTreeTransaction(tree.root, dvgWallet, spv);
        return { tree, txId };
      });
    };
}

module.exports = BTCCommiter;