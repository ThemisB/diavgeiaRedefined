<template>
<div class="text-center">
  <table class="expensesTable table table-striped table-bordered expensesWithKae">
    <thead>
      <tr>
        <th>ΑΡΙΘΜΟΣ ΚΑΕ</th>
        <th>ΠΟΣΟ ΜΕ ΦΠΑ</th>
        <th>ΠΡΟΣΘΗΚΗ</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <tr v-for="expense in expensesArray" :key="expense.id = expense">
        <td><input type="text" :name="getKae(expense)" class="form-control"></td>
        <td>
          <div class="col-xs-6">
          <label :for="getExpense(expense)">Ποσό</label>
          <input type="text" :name="getExpense(expense)">
        </div>
          <div class="col-xs-6">
            <currencies :number="expense"></currencies>
          </div>
        </td>
        <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">

        <td v-if="expense === 1"><button type="button" class="btn btn-default" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου Ποσού</span></button></td>
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
