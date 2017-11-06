import { Router } from 'express'
import bodyParser from 'body-parser'
import Decision from './classes/Decision.js'
import sanitize from 'sanitize-filename'

var router = Router()

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

router.get('/downloadDecision', function (req, res) {
  if (!req.query.iun || !req.query.version) {
    res.send(404)
  }
  let iun = sanitize(req.query.iun)
  let version = sanitize(req.query.version)
  const fs = require('fs')
  const config = require('config')
  const expandHomeDir = require('expand-home-dir')
  let storageDir = expandHomeDir(config.get('decisionsSaveDir'))
  let fullPathDecision = storageDir + '/' + iun + '_' + version + '.n3.gz'
  if (!fs.existsSync(fullPathDecision)) {
    res.send(404)
  } else {
    res.download(fullPathDecision)
  }
})

export default router
