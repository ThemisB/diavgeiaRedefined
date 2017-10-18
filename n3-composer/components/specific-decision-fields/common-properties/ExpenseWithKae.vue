<template>
  <div class="column" style="padding-bottom:2.5em;">
    <table class="table is-striped is-bordered has-text-centered expenses-table" style="margin:0 auto;">
      <thead>
        <tr>
          <th>ΑΡΙΘΜΟΣ ΚΑΕ</th>
          <th>ΠΟΣΟ ΜΕ ΦΠΑ</th>
          <th>ΠΡΟΣΘΗΚΗ</th>
        </tr>
      </thead>
      <tbody class="has-text-centered">
        <tr v-for="expense in expensesArray" :key="getKey('expense', expense)">
          <td>
            <input type="text" :name="getKae(expense)" class="input">
          </td>
          <td>
            <div class="columns">
              <div class="column">
                <label :for="getExpense(expense)">Ποσό</label>
                <input type="text" :name="getExpense(expense)" class="input">
              </div>
              <div class="column">
                <currencies :number="expense"></currencies>
              </div>
            </div>
          </td>
          <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">
          <td v-if="expense === 1"><button type="button" class="button is-info is-outlined" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου Ποσού</span></button></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

import Currencies from './Currencies.vue'

export default {
  components: {Currencies},
  mounted: function () {
    let expenseNumber = 1
    this.lastExpense = 1
    this.nextExpense = 2
    this.expensesArray = [expenseNumber]
  },
  methods: {
    incrementExpenses: function () {
      this.lastExpense++
      let expenseNumber = this.lastExpense
      this.nextExpense++
      this.expensesArray.push(expenseNumber)
    },
    getKae: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][kae]'
    },
    getExpenseIndex: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][index]'
    },
    getExpense: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][expense_amount]'
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  },
  data: function () {
    return {
      expensesArray: [],
      lastExpense: 1,
      nextExpense: 2
    }
  }
}
</script>
