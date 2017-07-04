const config = require('config');
const bcoin = require('bcoin').set(config.get('network'));
const fs = require('co-fs');
const crypto = require('crypto');
const co = require('co');

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
}

module.exports = BTCCommiter;