import { Router } from 'express'
import bodyParser from 'body-parser'
import Decision from './classes/Decision.js'
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

export default router
