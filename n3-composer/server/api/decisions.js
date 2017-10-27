import { Router } from 'express'
import bodyParser from 'body-parser'
import Decision from './classes/Decision.js'
var router = Router()

router.use(bodyParser.urlencoded({ extended: true }))

router.post('/createDecision', function (req, res) {
  // TODO These 4 fields (IUN, Version, unitIds, organizationId) should be set
  // by the current implementation of Diavgeia
  let err = new Decision(req.body, '60Β3ΩΡΙ-ΒΝ3', 'b4ae1411-f81d-437b-9c63-a8b7d4ed866b', ['6105'], '93302').generateN3()
  if (err) {
    res.redirect('/?error')
  }
  res.redirect('/?success')
})

export default router
