const fs = require('fs')
const resolve = require('path').resolve
const join = require('path').join
const cp = require('child_process')
const exit = require('process').exit

const NODE_VERSION_REQUIREMENT = 8.0
let nodeVersion = Number(process.version.match(/^v(\d+\.\d+)/)[1])

if (nodeVersion < NODE_VERSION_REQUIREMENT) {
  console.error('Node version detected', nodeVersion +'. You should upgrade at least to Node', NODE_VERSION_REQUIREMENT)
  exit(1)
}

var projectRoot = resolve(__dirname, './')

cp.spawnSync('npm', ['i'], { env: process.env, cwd: projectRoot, stdio: 'inherit'})
console.log('Succesfully installed node_modules on', projectRoot)
fs.readdirSync(projectRoot).forEach((modules) => {
  let modulePath = join(projectRoot, modules)
  if (!fs.existsSync(join(modulePath, 'package.json'))) {
    return
  }
  let installingProc = cp.spawnSync('npm', ['i'], { env: process.env, cwd: modulePath, stdio: 'inherit'})
  console.log('Succesfully installed node_modules on', modulePath)
})