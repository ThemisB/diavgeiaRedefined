if (process.argv.length > 2 ) {
  process.env.NODE_ENV = process.argv[2] === '--dev' ? 'development' : 'production'
} else {
  process.env.NODE_ENV = "development"
}
process.env.NODE_CONFIG_DIR = "web-editor/config"

const config = require('config')
const {spawn} = require('child_process')
const {fork} = require('child_process')
const fs = require('fs')
const expandHomeDir = require('expand-home-dir')
const npmRun = require('npm-run')

fork('index.js', {cwd: 'visualizer', stdio: 'ignore'})