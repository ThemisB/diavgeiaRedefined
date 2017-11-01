process.env.NODE_ENV="development"
process.env.NODE_CONFIG_DIR="n3-composer/config"

const config = require('config')
const {spawn} = require('child_process')
const fs = require('fs')
const expandHomeDir = require('expand-home-dir')
const npmRun = require('npm-run')

// MONGO CONFIGURATIONS
mongod = spawn('mongod')

mongod.stderr.on('data', (data) => {
  console.log('Mongo stderr: ', data.toString())
})

mongod.on('close', (code)=> {
  console.log('Mongo exited with code ',code)
})

// FUSEKI CONFIGURATIONS

// Open Fuseki server
let sparqlStoreDir = expandHomeDir(config.get('sparqlStoreDir'))
if (!fs.existsSync(sparqlStoreDir)) {
  fs.mkdirSync(sparqlStoreDir)
}

process.env.FUSEKI_HOME="sparql_endpoint/fuseki/"

let runFusekiServer = spawn('sparql_endpoint/fuseki/fuseki-server', ['--update', '--loc', sparqlStoreDir, '/' + config.get('dataset')])

runFusekiServer.stderr.on('data', (data) => {
  console.log('Fuseki stderr: ', data.toString())
})

runFusekiServer.on('close', (code)=> {
  console.log('Fuseki exited with code ',code)
})
