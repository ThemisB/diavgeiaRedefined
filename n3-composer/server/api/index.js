import { Router } from 'express'

import decisions from './decisions'

var router = Router()

router.use(decisions)

export default router
