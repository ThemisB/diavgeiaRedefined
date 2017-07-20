const express = require('express');
const app = express();
const path = require('path');

app.use('/public', express.static(path.join(__dirname, 'public')))
app.use('/node_modules', express.static(path.join(__dirname, 'node_modules')))

app.get('/', (req, res) => {
  res.sendFile(__dirname +'/index.html');
});

app.listen(3000, () => {
  console.log('App runs on port 3000');
});