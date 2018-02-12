import { Router } from 'express'
import bodyParser from 'body-parser'

import sanitize from 'sanitize-filename'
import mongosanitize from 'mongo-sanitize'

var router = Router()

const config = require('config')
const fs = require('fs')
const expandHomeDir = require('expand-home-dir')
const storageDir = expandHomeDir(config.get('decisionsSaveDir'))
const co = require('co')
const Decision = require('./classes/Decision.js')

router.use(bodyParser.urlencoded({ extended: true }))

router.post('/createDecision', function (req, res) {
  // TODO These 4 fields (IUN, Version, unitIds, organizationId) should be set
  // by the current implementation of Diavgeia
  const crypto = require('crypto')
  let iun = 'ΑΔΑ-' + crypto.randomBytes(8).toString('hex')
  let version = crypto.randomBytes(15).toString('hex')
  co(function * () {
    return new Decision(req.body, iun, version, ['6105'], '93302').generateN3()
  }).then((status) => {
    if (status) {
      res.redirect('/?success')
    } else {
      res.redirect('/?error')
    }
  }).catch((err) => {
    res.redirect('/?error')
    throw err
  })
})

router.post('/createDecisionBenchmark', function (req, res) {
  // TODO These 4 fields (IUN, Version, unitIds, organizationId) should be set
  // by the current implementation of Diavgeia
  const crypto = require('crypto')
  let iun = 'ΑΔΑ-' + crypto.randomBytes(8).toString('hex')
  let version = crypto.randomBytes(15).toString('hex')
  co(function * () {
    return new Decision(req.body, iun, version, ['6105'], '93302', true).generateN3()
  }).then((status) => {
    if (status) {
      res.setHeader('Content-Type', 'application/json')
      res.send(JSON.stringify('OK'))
    } else {
      res.setHeader('Content-Type', 'application/json')
      res.send(JSON.stringify('FAIL'))
    }
  }).catch((err) => {
    res.setHeader('Content-Type', 'application/json')
    res.send(JSON.stringify('FAIL'))
    throw err
  })
})

router.post('/getdecisions', function (req, res) {
  co(function * () {
    return Decision.getDecisions()
  }).then((decisions) => {
    res.setHeader('Content-Type', 'application/json')
    res.send(JSON.stringify(decisions))
  }).catch((err) => {
    throw err
  })
})

router.post('/getDecisionsByTxIndex', function (req, res) {
  if (!req.query.txIndex) {
    res.send(404)
  } else {
    let txIndex = mongosanitize(req.query.txIndex)
    co(function * () {
      return Decision.getDecisionsByTxIndex(txIndex)
    }).then((decisions) => {
      var Promise = require('bluebird')
      Promise.map(decisions, (decision) => {
        let fullPathDecision = storageDir + '/' + decision.iun + '_' + decision.version + '.n3.gz'
        return fs.readFileAsync(fullPathDecision)
      }).then(function (decisions) {
        const JSONB = require('json-buffer')
        res.send(JSONB.stringify(decisions))
      }).catch((err) => {
        throw err
      })
    }).catch((err) => {
      throw err
    })
  }
})

router.get('/downloadDecision', function (req, res) {
  if (!req.query.iun || !req.query.version) {
    res.send(404)
  }
  let iun = sanitize(req.query.iun)
  let version = sanitize(req.query.version)
  let fullPathDecision = storageDir + '/' + iun + '_' + version + '.n3.gz'
  if (!fs.existsSync(fullPathDecision)) {
    res.send(404)
  } else {
    res.download(fullPathDecision)
  }
})

router.post('/getLastBlockchainCommit', function (req, res) {
  co(function * () {
    return Decision.getLastBlockchainCommit()
  }).then((commit) => {
    res.setHeader('Content-Type', 'application/json')
    if (commit) {
      let commitObj = {
        lastCommit: commit.date,
        txId: commit.txId,
        tree: commit.tree
      }
      res.send(JSON.stringify(commitObj))
    } else {
      res.send(JSON.stringify(undefined))
    }
  }).catch((err) => {
    throw err
  })
})

router.get('/getLastMerkleTree', function (req, res) {
  co(function * () {
    return Decision.getLastBlockchainCommit()
  }).then((commit) => {
    if (commit) {
      res.setHeader('Content-Type', 'application/json')
      res.send({tree: commit.tree})
    } else {
      res.setHeader('Content-Type', 'application/json')
      res.send(JSON.stringify(null))
    }
  }).catch((err) => {
    throw err
  })
})

router.post('/getAllBlockchainCommits', function (req, res) {
  co(function * () {
    return Decision.getAllBlockchainCommits()
  }).then((commits) => {
    res.setHeader('Content-Type', 'application/json')
    res.send({commits})
  }).catch((err) => {
    throw err
  })
})
export default router
