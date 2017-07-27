import { Router } from 'express'
import bodyParser from 'body-parser'
import Decision from './classes/Decision.js'
var router = Router()

router.use(bodyParser.urlencoded({ extended: true }))

router.post('/createDecision', function(req, res) {
  console.log(req.body)
})

export default router