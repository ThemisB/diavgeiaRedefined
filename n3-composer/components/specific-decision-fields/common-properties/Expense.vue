<template>
<div class="text-center">
  <table class="expensesTable table table-striped table-bordered">
    <thead>
      <tr>
        <th>ΑΦΜ</th>
        <th>ΟΝΟΜΑΤΕΠΩΝΥΜΟ</th>
        <th>ΠΡΟΣΘΗΚΗ</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <tr v-for="expense in expensesArray" :key="expense.id = expense">
        <td><input type="text" :name="getAFM(expense)" class="form-control"></td>
        <!--
          TODO
          Company and afm_type should be found by a web service like
          GSIS when the user types the afm
        -->
        <td><input type="text" :name="getPerson(expense)" value="ΟΝΟΜΑΤΕΠΩΝΥΜΟ Χ" readonly="readonly"></td>
        <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">
        <input type="hidden" :name="getAFMType(expense)" value="Εθνικό">
        <td v-if="expense === 1"><button type="button" class="btn btn-default" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου ΑΦΜ</span></button></td>
      </tr>
    </tbody>
  </table>
  <div class="row">
    <div class="col-xs-4 col-xs-offset-1">
      <label for="expense_amount">Ποσό</label>
      <input name="expense_amount" type="number" class="form-control">
    </div>
    <div class="col-xs-4 col-xs-offset-1">
      <currencies></currencies>
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
