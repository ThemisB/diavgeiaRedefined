const randomDecision = require('./random-decision.js')
const request = require('request')
const async = require('async')
const LOCALHOST = 'http://localhost:3000'
const DATA_SAMPLES = 1000

const randomDecisions = []
for (let i = 0; i < DATA_SAMPLES; i++) {
  randomDecisions.push(randomDecision.generate())
}
let randomDecisionInsertion = (decision) => {
  return new Promise((resolve, reject) => {
    request.post(LOCALHOST + '/api/createDecisionBenchmark', {form: decision}, function (err, httpResponse, data) {
      if (err) return reject(err)
      let result = JSON.parse(data)
      if (result !== 'OK') return reject(err)
      resolve(result)
    })
  })
}

async.mapLimit(randomDecisions, 5, async function (decision) {
  let result = await randomDecisionInsertion(decision)
  return result
}, (err, result) => {
  if (err) throw err
})
