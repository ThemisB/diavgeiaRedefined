<template>
<div>
  <div v-for="documentNumber in documentsArray" :key="getKey('document', expenseNumber + '_' + documentNumber)">
    <div class="columns is-centered">
      <div class="column is-half">
        <label :for="getDocumentLabel(documentNumber)" class="label">{{documentNumber}}ο Δικαιολογητικό</label>
        <input class="input" :name="getDocumentLabel(documentNumber)"></input>
      </div>
    </div>
  </div>
  <div class="columns">
    <div class="column field has-text-centered">
      <a class="button is-info is-outlined" type="button" v-on:click="incrementDocuments">
        <span class="icon is-small is-left">
          <i class="fa fa-plus"></i>
        </span>
        <span>{{nextDocument}}ο δικαιολογητικό</span>
      </a>
    </div>
  </div>
</div>
</template>

<script>

import Currencies from './Currencies.vue'

export default {
  props: ['expenseNumber'],
  mounted: function () {
    this.lastDocument = 1
    this.nextDocument = 2
    this.documentsArray = [this.lastDocument]
  },
  data: function () {
    return {
      lastDocument: 0,
      nextDocument: 1,
      documentsArray: []
    }
  },
  methods: {
    incrementDocuments: function () {
      this.lastDocument++
      this.nextDocument++
      this.documentsArray.push(this.lastDocument)
    },
    getDocumentLabel: function (documentNumber) {
      return 'expense[' + this.expenseNumber + '][document][' + documentNumber + ']'
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  },
  components: {Currencies}
}
</script>
