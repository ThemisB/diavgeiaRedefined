<template>
<div>
  <div v-for="subExpenseNumber in withKaeSubExpensesArray" :key="getKey('withKaeSubExpense', expenseNumber + '_' + subExpenseNumber)">
    <div class="columns">
      <div class="column">
        <kae v-bind:number="expenseNumber" v-bind:subExpenseNumber="subExpenseNumber"></kae>
      </div>
      <div class="column" style="margin-top:auto">
        <div class="columns">
          <div class="column">
            <label :for="getExpenseAmount(subExpenseNumber)">Ποσό</label>
            <input type="number" class="input" :name="getExpenseAmount(subExpenseNumber)" step="0.01">
          </div>
          <div class="column">
            <currencies v-bind:number="expenseNumber" v-bind:subExpenseNumber="subExpenseNumber"></currencies>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="columns">
    <div class="column field has-text-centered">
      <a class="button is-info is-outlined" type="button" v-on:click="incrementWithKaeSubExpenses">
        <span class="icon is-small is-left">
          <i class="fa fa-plus"></i>
        </span>
        <span>{{nextWithKaeSubExpense}}ο έξοδο με ΚΑΕ</span>
      </a>
    </div>
  </div>
</div>
</template>

<script>

import Currencies from './Currencies.vue'
import Kae from './Kae.vue'

export default {
  props: ['expenseNumber'],
  mounted: function() {
    this.lastWithKaeSubExpense = 1
    this.nextWithKaeSubExpense = 2
    this.withKaeSubExpensesArray = [this.lastWithKaeSubExpense]
  },
  data: function () {
    return {
      lastWithKaeSubExpense: 0,
      nextWithKaeSubExpense: 1,
      withKaeSubExpensesArray: []
    }
  },
  methods: {
    incrementWithKaeSubExpenses: function () {
      this.lastWithKaeSubExpense++
      this.nextWithKaeSubExpense++
      this.withKaeSubExpensesArray.push(this.lastWithKaeSubExpense)
    },
    getExpenseAmount: function(subExpenseNumber) {
      return 'expense[' + this.expenseNumber + '][withKaeSubExpense][' + subExpenseNumber + '][expense_amount]'
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  },
  components: {Currencies, Kae}
}
</script>
