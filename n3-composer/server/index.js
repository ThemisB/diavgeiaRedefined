const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const path = require('path');

app.use('/client', express.static(path.normalize(__dirname+'/../client')));
app.use('/node_modules', express.static(path.normalize(__dirname+'/../node_modules')));
app.use('/css', express.static(path.normalize(__dirname+'/../client/css')));

app.use(bodyParser.urlencoded({ extended: true }));

app.get('/', (req, res) => {
  res.sendFile(path.normalize(__dirname+'/../client/index.html'));
});

app.listen(8082, () => {
  console.log('Production app runs on port 8082');
});