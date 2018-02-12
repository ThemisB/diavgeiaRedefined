<template>
<div>
    <div class="columns">
      <div class="column">
        <table class="table is-striped is-bordered has-text-centered" style="margin:0 auto;">
          <thead>
            <tr>
              <th>ΑΦΜ</th>
              <th>Όνομα</th>
              <th>Είδος ΑΦΜ</th>
              <th>ΠΡΟΣΘΗΚΗ</th>
            </tr>
          </thead>
          <tbody class="has-text-centered">
            <tr v-for="expense in expensesArray" :key="getKey('expense', expense)">
              <td><input type="text" :name="getAFM(expense)" class="input"></td>
              <!--
                TODO
                Company and afm_type should be found by a web service like
                GSIS when the user types the afm
              -->
              <td><input type="text" :name="getCompany(expense)" value="ΕΤΑΙΡΕΙΑ Χ" readonly class="input"></td>
              <td><input :name="getAFMType(expense)" value="Εθνικό" readonly class="input"></td>
              <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">
              <td v-if="expense === 1"><button type="button" class="button is-info is-outlined" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου ΑΦΜ</span></button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <label for="expense_amount">Ποσό</label>
        <input name="expense_amount" type="number" step="0.01" class="input">
      </div>
      <div class="column">
        <currencies></currencies>
      </div>
      <div class="column">
        <label for="has_related_declaration_summary">ΑΔΑ Σχετικής Περίληψης Διακήρυξης</label>
        <input name="has_related_declaration_summary" class="input">
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
    getCompany: function (expenseNumber) {
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
