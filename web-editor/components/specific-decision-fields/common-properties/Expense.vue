<template>
<div class="columns">
  <div class="column">
    <table class="table is-striped is-bordered has-text-centered expensesTable" style="margin:0 auto;">
      <thead>
        <tr>
          <th>ΑΦΜ</th>
          <th>ΟΝΟΜΑΤΕΠΩΝΥΜΟ</th>
          <th>ΕΙΔΟΣ ΑΦΜ</th>
          <th>ΠΡΟΣΘΗΚΗ</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <tr v-for="expense in expensesArray" :key="getKey('expense', expense)">
          <td><input type="text" :name="getAFM(expense)" class="input"></td>
          <!--
            TODO
            Company and afm_type should be found by a web service like
            GSIS when the user types the afm
          -->
          <td><input type="text" :name="getPerson(expense)" value="ΟΝΟΜΑΤΕΠΩΝΥΜΟ Χ" readonly="readonly" class="input"></td>
          <td><input :name="getAFMType(expense)" value="Εθνικό" readonly class="input"></td>
          <td v-if="expense === 1"><button type="button" class="button is-info is-outlined" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου ΑΦΜ</span></button></td>
          <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">
        </tr>
      </tbody>
    </table>
  </div>
  <div class="column">
    <div class="columns">
      <div class="column">
        <label for="expense_amount">Ποσό</label>
        <input name="expense_amount" type="number" class="input">
      </div>
      <div class="column">
        <currencies></currencies>
      </div>
    </div>
  </div>
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
    getAFM: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][afm]'
    },
    getExpenseIndex: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][index]'
    },
    getPerson: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][name]'
    },
    getAFMType: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][afm_type]'
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
