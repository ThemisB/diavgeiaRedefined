const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const webpack = require('webpack');
const path = require('path');
const express = require('express');

module.exports = {
  entry: __dirname+'/client/src/main.js',
  output: {
    path: path.resolve(__dirname, 'client','dist'),
    publicPath: '/client/dist/',
    filename: 'build.js'
  },
  module: {
    loaders: [
      { test: /\.js$/, loader: 'babel-loader', exclude: /node_modules/ },
      { test: /\.vue$/, loader: 'vue-loader'}
    ]
  },
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js'
    }
  },
  devServer: {
    setup(app) {
      app.use('/node_modules/',express.static(path.join(__dirname,'node_modules')))
    }
  }
}

console.log(module.exports);