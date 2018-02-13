const config = require('config');
const bcoin = require('bcoin').set(config.get('network'));
const path = require('path');
const co = require('co');
const fs = require('fs');

class Wallet {

  /**
   * Wallet
   * @constructor
   * @param {String} id - The wallet id
   * @param {String} location - The path in which wallet will be stored
   */

  constructor(id=config.get('wallet_id'), location = Wallet.getWalletLocation()) {
    this.id = id;
    this.location = location;
  }

  /**
   * Initializes the Wallet of Diavgeia.
   * If the wallet already exists, initialization is skipped
   */

  initialize() {
    var _wallet = this;
    if (! fs.existsSync(_wallet.location))
      fs.mkdirSync(_wallet.location);
    return co(function* () {
      let walletdb = yield _wallet.getWalletDB();
      let existingWallet = yield walletdb.get(_wallet.id);
      if (existingWallet === null) {
        yield walletdb.create({
          id:_wallet.id
        });
      }
      yield walletdb.close();
    });
  }

  /**
   * Creates and returns an instance of walletdb
   * @returns {Promise}
   */

  getWalletDB() {
    var walletDB = new bcoin.walletdb({
      db : 'leveldb',
      location : this.location + '/diavgeia-wallet',
      spv : true
    })
    return co(function* () {
      yield walletDB.open();
      yield walletDB.connect();
      return walletDB;
    });
  }

  /**
   * Path Normalization of the wallet_location, based on the user preference
   * of having enabled the home path option or not.
   * @returns {string}
   */

  static getWalletLocation() {
    let configWalletLocation = config.get('wallet_location');
    if (config.get('wallet_location_from_home'))
      return process.env.HOME + '/' + path.normalize(configWalletLocation);
    return path.normalize(configWalletLocation);
  }

}

module.exports = Wallet;