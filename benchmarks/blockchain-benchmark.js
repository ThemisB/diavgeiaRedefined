/*
 * This benchmark is used to measure the per-day verification time, that is the
 * time needed to verify that Diavgeia is consistent with Bitcoin blockchain.
 * The benchmark tries to mimic a common day of Diavgeia (about 16.000 daily
 * decisions). We measure the time needed to verify a month's (22 working days)
 * workload (352.000 decisions and 22 blockchain commits).
 *
 * Important: You should have already setup Diavgeias' wallet and it should be
 * charged with some bitcoins (in order to pay miner fees).
 */

const importer = require('./importer.js')
const cleaner = require('./cleaner.js')
const spawn = require('co-child-process')
const path = require('path')
const co = require('co')
const async = require('async')
const DAYS = 22

var daysArray = Array.from(Array(DAYS), () => 0)
var daysCompleted = 0
let counter = 0
async.eachSeries(daysArray, (_, next) => {
  counter++
  console.log('Day', counter)
  importer.import(() => {
  // Commit to bitcoin the daily decisions
    co(function * () {
      var output
      try {
        output = yield spawn('node', ['src/scripts/main.js', '--commit', 'commit'], {cwd: path.resolve('../bitcoin')})
      } catch (e) {
      }
      return output
    }).then(() => {
      daysCompleted++
      if (daysCompleted === DAYS) {
        console.log('Validator is running..')
        // Run validator
        co(function * () {
          var verificationTime
          try {
            verificationTime = yield spawn('node', ['index.js'], {cwd: path.resolve('../bitcoin-validator')})
            const moment = require('moment')
            const fs = require('fs')
            let filename = 'verification-' + moment().format('MMMM-Do-YYYY-h:mm:ss') + '.out'
            fs.writeFile(filename, verificationTime, (err) => {
              if (err) throw err
            })
          } catch (e) {
            console.error(e)
          }
        }).then(() => {
          console.log('Cleanup process is running..')
          cleaner.clean() // cleans everything that benchmark has made
        })
      }
      next()
    })
  })
})
