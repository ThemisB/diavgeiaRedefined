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
   *  get the data of the files inside decisionsFolder
   *  @returns {Promise}
   *  @resolve {DecisionsData}
   */

  getDecisionsData() {
    var _btcCommiter = this;

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
   * @param {DecisionsData}
   * @returns {Promise}
   * @resolve {DecisionsHash}
   */

  getDecisionsHash(decisionsData) {
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
   * @param {DecisionsHash}
   * @returns {MerkleTree}
   */
  constructMerkleTree(decisionsHash) {
    var _btcCommiter = this;
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

}

module.exports = BTCCommiter;