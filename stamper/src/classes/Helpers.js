const config = require('config');
const bcoin = require('bcoin').set(config.get('network'));
const Wallet = require('./Wallet');
const BTCCommiter = require('./BTCCommiter');
const co = require('co');


/**
 * Helper functions organized in this class
 */

class Helpers {


  /**
   * Does the SPV Sync and finds Wallet Balance
   * @param {WalletDB} walletdb
   * @param {Wallet} dvgWallet - Wallet of Diavgeia
   * @returns {SPVNode}
   */

  static runSPV(walletdb, dvgWallet) {
    var spv = new bcoin.spvnode({
      prefix : Wallet.getWalletLocation(),
      network : config.get('network'),
      location : Wallet.getWalletLocation(),
      db : 'leveldb'
    });

    spv.ensure()
    .then(() => spv.open())
    .then(()=> {

      var address = dvgWallet.getAddress('base58');
      console.log('Charge your wallet at BTC address: ', address);
      console.log('-----MASTER PUBLIC KEY ', dvgWallet.account.accountKey.xpubkey(), ' -----\n');

      spv.pool.watchAddress(dvgWallet.getAddress());

      dvgWallet.getBalance().then(balance => {
        let btcConfirmed = bcoin.amount.btc(balance.confirmed);
        console.log('Blockchain-secured wallet balance %s', btcConfirmed, 'BTC');
      })

      dvgWallet.on('balance', (balance) => {
        var btc = bcoin.amount.btc(balance.unconfirmed);
        console.log('Your wallet balance has been updated: %s', btc, 'BTC\n');
      });

      spv.on('tx', function(tx) {
        spv.walletdb.addTX(tx).then({});
      })

      spv.connect().then(function(){
        spv.startSync();
      })

      spv.on('connect', function(entry, block) {
        walletdb.addBlock(entry, block.txs);
      });
    });
    return spv;
  }

  /**
   * Creates the merkle root consisting of Diavgeia's decisions,
   * creates a Proof of Burn tx of the merkle root,
   * console.log what should be published on Diavgeia's website and returns
   * the published Object.
   *
   * @param {string} decisionsPath - The path in which Diavgeia decisions have been stored to
   * @param {Wallet} dvgWallet - Wallet of Diavgeia
   * @param {SPVNode} spv
   * @returns {Published}
   */

  static publishToBTC(dvgWallet, spv) {
    return co( function*() {
      const btcCommiter = new BTCCommiter();
      const published = yield btcCommiter.publishDecisionsToBTC(dvgWallet, spv);
      process.exit(0);
    });
  }
}

module.exports = Helpers;