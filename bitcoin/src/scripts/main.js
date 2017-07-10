const config = require('config');
const bcoin = require('bcoin').set(config.get('network'));
const assert = require('assert');
const Wallet = require('../classes/Wallet');
const BTCCommiter = require('../classes/BTCCommiter');
const crypto = require('crypto');
const co = require('co');
const ArgumentParser = require('argparse').ArgumentParser;
const Helpers = require('../classes/Helpers');

(co(function* () {

  var parser = new ArgumentParser({
    addHelp: true,
    description: 'Script for commiting Diavgeia decisions to Bitcoin Blockchain'
  });

  parser.addArgument(
    ['--init'],
    {
      help: 'Initialize Diavgeia\'s wallet',
      nargs: 0,
      defaultValue: false,
      action: 'storeTrue'
    }
  );

  parser.addArgument(
    ['--spv'],
    {
      help:'Just sync blockchain and find wallet balance',
      nargs: 0,
      defaultValue: false,
      action: 'storeTrue'
    }
  );

  parser.addArgument(
    ['--commit'],
    {
      help:'Commits all the decisions inside decisionsPath to Bitcoin blockchain',
      nargs: 1,
      metavar: 'decisionsPath'
    }
  );

  var args = parser.parseArgs();
  if (!args['spv'] && !args['commit'] && !args['init']) {
    parser.printHelp();
    return;
  }
  var dvgWallet = undefined;
  var walletdb = undefined;
  var wallet = new Wallet();

  if (args['init']) {
    yield wallet.initialize();
    walletdb = yield wallet.getWalletDB();
  }
  else {
    walletdb = yield wallet.getWalletDB();
  }
  dvgWallet = yield walletdb.get(config.get('wallet_id'));

  if (!args['spv'] && !args['commit'])
    return;

  assert(dvgWallet != undefined, `No wallet '${config.get('wallet_id')}' found.You have to initialize it first.`)
  const spv = Helpers.runSPV(walletdb, dvgWallet);
  if (args['commit']) {
    Helpers.publishToBTC(args['commit'][0], dvgWallet, spv);
  }
}));