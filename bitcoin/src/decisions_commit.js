const config = require('config');
const bcoin = require('bcoin').set(config.get('network'));
const assert = require('assert');
const Wallet = require('./Wallet');
const co = require('co');

(co(function* () {

  var wallet = new Wallet();
  var dvgWallet = yield walletdb.get(config.get('wallet_id'));
  assert(dvgWallet != undefined, `No wallet '${config.get('wallet_id')}' found. You have to initialize it first.`)

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
    console.log('Wallet Address', address);

    spv.pool.watchAddress(dvgWallet.getAddress());

    dvgWallet.getBalance().then(balance => {console.log('Your balance is', balance)})

    dvgWallet.on('balance', (balance) => {
      var btc = bcoin.amount.btc(balance.unconfirmed);
      console.log('Your wallet balance has been updated: %s', btc);
      dvgWallet.getBalance().then(console.log);
    });

    spv.on('tx', function(tx) {
      spv.walletdb.addTX(tx).then({
      });
    })

    spv.connect().then(function(){
      spv.startSync();
    })

    spv.on('connect', function(entry, block) {
      walletdb.addBlock(entry, block.txs);
    });
  });

}));