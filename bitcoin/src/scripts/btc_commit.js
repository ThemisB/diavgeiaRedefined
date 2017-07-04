const config = require('config');
const bcoin = require('bcoin').set(config.get('network'));
const assert = require('assert');
const Wallet = require('../classes/Wallet');
const BTCCommiter = require('../classes/BTCCommiter');
const crypto = require('crypto');
const co = require('co');

(co(function* () {

  var wallet = new Wallet();
  var walletdb = yield wallet.getWalletDB();
  var dvgWallet = yield walletdb.get(config.get('wallet_id'));
  assert(dvgWallet != undefined, `No wallet '${config.get('wallet_id')}' found.
  You have to initialize it first.`)

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
    var xpub = dvgWallet.master.key.toPublic().xpubkey();
    console.log('Wallet Address', address);
    console.log('Xpub',xpub,'\n');

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

}));