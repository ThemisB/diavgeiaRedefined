<template>
<div>
  <h4 class="subtitle has-text-centered">Ποσά και ΚΑΕ</h4>
  <div class="columns">
    <div class="column">
      <table class="table is-striped is-bordered has-has-text-centered" style="margin:0 auto;">
      <thead>
        <tr>
          <th>ΑΦΜ / ΕΠΩΝΥΜΙΑ</th>
          <th>ΑΡΙΘΜΟΣ ΚΑΕ</th>
          <th>ΠΟΣΟ ΜΕ ΦΠΑ</th>
          <th>ΥΠΟΛΟΙΠΟ ΔΙΑΘΕΣΙΜΗΣ ΠΙΣΤΩΣΗΣ</th>
          <th>ΥΠΟΛΟΙΠΟ ΚΑΕ</th>
          <th>ΠΡΟΣΘΗΚΗ</th>
        </tr>
      </thead>
      <tbody class="has-text-centered">
        <tr v-for="expense in expensesArray" :key="getKey('expense', expense)">
            <td>
              <div class="columns">
                <div class="column">
                  <input type="text" :name="getAFM(expense)" class="input" placeholder="ΑΦΜ">
                </div>
                <div class="column">
                  <input type="text" readonly="readonly" :name="getSponsored(expense)" value="ΕΠΩΝΥΜΙΑ Χ" class="input has-text-centered">
                </div>
              </div>
            </td>
            <td class="has-text-centered">
              <kae :number="expense"></kae>
            </td>
            <td class="has-text-centered">
              <div class="columns">
                <div class="column vcenter">
                  <label :for="getExpense(expense)" style="display:block !important">Ποσό</label>
                  <input type="text" :name="getExpense(expense)" class="input">
                </div>
                <div class="column vcenter">
                  <currencies :number="expense"></currencies>
                </div>
              </div>
            </td>
            <td>
              <input type="number" class="input" :name="getKaeBudgetRemainder(expense)" step="0.01">
            </td>
            <td>
              <input type="number" class="input" :name="getKaeCreditRemainder(expense)" step="0.01">
            </td>
          <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">
          <!-- TODO Integrate it with the GSIS service  -->
          <input type="hidden" value="Εθνικό" :name="getAfmTypeName(expense)">
          <td v-if="expense === 1"><button type="button" class="button is-info is-outlined" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου Ποσού</span></button></td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</div>
</template>

<script>

import Currencies from './Currencies.vue'
import Kae from './Kae.vue'

export default {
  methods: {
    incrementExpenses: function () {
      this.lastExpense++
      let expenseNumber = this.lastExpense
      this.nextExpense++
      this.expensesArray.push(expenseNumber)
    },
    getExpenseIndex: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][index]'
    },
    getExpense: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][expense_amount]'
    },
    getAFM: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][afm]'
    },
    getSponsored: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][sponsored]'
    },
    getAfmTypeName: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][afm_type]'
    },
    getKaeBudgetRemainder: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][kae_budget_remainder]'
    },
    getKaeCreditRemainder: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][kae_credit_remainder]'
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  },
  data: function () {
    return {
      expensesArray: [],
      lastExpense: 1,
      nextExpense: 2,
      selected: ''
    }
  },
  mounted: function () {
    let expenseNumber = 1
    this.lastExpense = 1
    this.nextExpense = 2
    this.expensesArray = [expenseNumber]
  },
  components: {Currencies, Kae}
}
</script>
