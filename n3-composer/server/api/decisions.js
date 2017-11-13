import { Router } from 'express'
import bodyParser from 'body-parser'
import Decision from './classes/Decision.js'
import sanitize from 'sanitize-filename'
import mongosanitize from 'mongo-sanitize'

var router = Router()

const config = require('config')
const fs = require('fs')
const expandHomeDir = require('expand-home-dir')
const storageDir = expandHomeDir(config.get('decisionsSaveDir'))

router.use(bodyParser.urlencoded({ extended: true }))

router.post('/createDecision', function (req, res) {
  // TODO These 4 fields (IUN, Version, unitIds, organizationId) should be set
  // by the current implementation of Diavgeia
  const crypto = require('crypto')
  let iun = 'ΑΔΑ-' + crypto.randomBytes(8).toString('hex')
  let version = crypto.randomBytes(15).toString('hex')
  let status = new Decision(req.body, iun, version, ['6105'], '93302').generateN3()
  if (status) {
    res.redirect('/?success')
  } else {
    res.redirect('/?error')
  }
})

router.post('/getdecisions', function (req, res) {
  Decision.getDecisions((decisions) => {
    res.setHeader('Content-Type', 'application/json')
    res.send(JSON.stringify(decisions))
  })
})

router.post('/getDecisionsByTxIndex', function (req, res) {
  if (!req.query.txIndex) {
    res.send(404)
  } else {
    let txIndex = mongosanitize(req.query.txIndex)
    var Promise = require('bluebird')
    Decision.getDecisionsByTxIndex(txIndex, (decisions) => {
      Promise.map(decisions, (decision) => {
        let fullPathDecision = storageDir + '/' + decision.iun + '_' + decision.version + '.n3.gz'
        return fs.readFileAsync(fullPathDecision)
      }).then(function (decisions) {
        res.send(JSON.stringify(decisions))
      })
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
  let blockchainPoBMinutes = config.get('blockchainPoBMinutes')
  Decision.getLastBlockchainCommit((commit) => {
    res.setHeader('Content-Type', 'application/json')
    let commitObj = {
      lastCommit: commit[0].date,
      txId: commit[0].txId,
      tree: commit[0].tree,
      blockchainPoBMinutes
    }
    res.send(JSON.stringify(commitObj))
  })
})

router.get('/getLastMerkleTree', function (req, res) {
  Decision.getLastBlockchainCommit((commit) => {
    res.setHeader('Content-Type', 'application/json')
    res.send({tree: commit[0].tree})
  })
})

router.post('/getAllBlockchainCommits', function (req, res) {
  Decision.getAllBlockchainCommits((commits) => {
    res.setHeader('Content-Type', 'application/json')
    res.send({commits})
  })
})
export default router
