if (process.argv.length > 2 ) {
  process.env.NODE_ENV = process.argv[2] === '--dev' ? 'development' : 'production'
} else {
  process.env.NODE_ENV = "development"
}
process.env.NODE_CONFIG_DIR = "n3-composer/config"

const config = require('config')
const {spawn} = require('child_process')
const {fork} = require('child_process')
const fs = require('fs')
const expandHomeDir = require('expand-home-dir')
const npmRun = require('npm-run')

// FUSEKI CONFIGURATIONS
// Open Fuseki server
let sparqlStoreDir = expandHomeDir(config.get('sparqlStoreDir'))
if (!fs.existsSync(sparqlStoreDir)) {
  fs.mkdirSync(sparqlStoreDir)
}
process.env.FUSEKI_HOME="sparql_endpoint/fuseki"
process.env.FUSEKI_BASE=expandHomeDir("~/.fuseki_run")
spawn('sparql_endpoint/fuseki/fuseki-server', ['--update', '--loc', sparqlStoreDir, '/' + config.get('dataset')])

// Visualizer
fork('index.js', {cwd: 'visualizer', stdio: 'ignore'})