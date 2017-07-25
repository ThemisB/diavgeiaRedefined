import 'expose-loader?$!expose-loader?jQuery!jquery'
import Vue from 'vue'
import 'bootstrap/dist/js/bootstrap.min.js';
import 'bootstrap-select/dist/js/bootstrap-select.min.js';
import App from './vue-components/App.vue';

new Vue({
  el: '#app',
  render: h => h(App)
});