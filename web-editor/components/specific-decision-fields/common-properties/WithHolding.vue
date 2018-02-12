<template>
<div>
  <div v-for="withholding in withHoldingsArray" :key="getKey('withholding', expenseNumber + '_' + withholding)">
    <div class="columns">
      <div class="column">
        <label :for="getWithHoldingTextName(withholding)" class="label">Αιτία {{withholding}}ης Παρακράτησης</label>
        <textarea class="textarea" :name="getWithHoldingTextName(withholding)"></textarea>
      </div>
      <div class="column" style="margin-top:auto">
        <h3 class="has-text-centered">Ποσό {{withholding}}ης Παρακράτησης</h3>
        <div class="columns">
          <div class="column">
            <label :for="getWithHoldingExpense(withholding)">Ποσό</label>
            <input type="number" class="input" :name="getWithHoldingExpense(withholding)" step="0.01">
          </div>
          <div class="column">
            <currencies v-bind:number="expenseNumber" v-bind:withholding_number="withholding"></currencies>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="columns">
    <div class="column field has-text-centered">
      <a class="button is-info is-outlined" type="button" v-on:click="incrementWithHolding">
        <span class="icon is-small is-left">
          <i class="fa fa-plus"></i>
        </span>
        <span>{{nextWithHolding}}η κράτηση</span>
      </a>
    </div>
  </div>
  </div>
</div>
</template>

<script>

import Currencies from './Currencies.vue'

export default {
  props: ['expenseNumber'],
  mounted: function () {
    this.lastWithHolding = 1
    this.nextWithHolding = 2
    this.withHoldingsArray = [this.lastWithHolding]
  },
  data: function () {
    return {
      lastWithHolding: 0,
      nextWithHolding: 1,
      withHoldingsArray: [],
    }
  },
  methods: {
    incrementWithHolding: function () {
      this.lastWithHolding++
      this.nextWithHolding++
      this.withHoldingsArray.push(this.lastWithHolding)
    },
    getWithHoldingExpense: function (withHoldingNumber) {
      return 'expense[' + this.expenseNumber + '][withholding][' + withHoldingNumber + '][withholding_expense]'
    },
    getWithHoldingTextName: function (withHoldingNumber) {
      return 'expense[' + this.expenseNumber + '][withholding][' + withHoldingNumber + '][withholding_text]'
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  },
  components: {Currencies}
}
</script>
