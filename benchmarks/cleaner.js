exports.clean = () => {
  const expandHomeDir = require('expand-home-dir')
  const devConfigFile = require('../n3-composer/config/development.json')
  const decisionsSaveDir = devConfigFile.decisionsSaveDir
  const fs = require('fs')
  const path = require('path')

  let cleanupN3DecisionsDir = expandHomeDir(decisionsSaveDir)
  fs.readdir(cleanupN3DecisionsDir, (err, files) => {
    if (err) throw err
    for (const file of files) {
      fs.unlink(path.join(cleanupN3DecisionsDir, file), err => {
        if (err) throw err
      })
    }
  })
  const db = require('monk')(devConfigFile.mongoURL + '/' + devConfigFile.mongoDBName)
  const decisionsCollection = db.get('decisions')
  const blockchainCommitsCollection = db.get('blockchainCommits')
  decisionsCollection.remove({}).then(() => {
    blockchainCommitsCollection.remove({}).then(() => {
      db.close()
    }).catch((err) => {
      throw err
    })
  }).catch((err) => {
    throw err
  })
}
