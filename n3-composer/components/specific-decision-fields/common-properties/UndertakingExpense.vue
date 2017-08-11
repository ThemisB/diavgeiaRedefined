<template>
<div class="text-center">
  <div class="row">
    <h4 class="text-center">Ποσό και ΚΑΕ</h4>
    <table class="expensesTable table table-striped table-bordered expensesDonation expensesExpenditureApproval">
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
    <tbody class="text-center">
      <tr v-for="expense in expensesArray" :key="expense.id = expense">
          <td>
            <div class="col-xs-6">
              <input type="text" :name="getAFM(expense)" class="form-control" placeholder="ΑΦΜ">
            </div>
            <div class="col-xs-6">
              <input type="text" readonly="readonly" :name="getSponsored(expense)" value="ΕΠΩΝΥΜΙΑ Χ" class="form-control text-center">
            </div>
          </td>
          <td class="text-center">
            <kae :number="expense"></kae>
          </td>
          <td class="text-center">
            <div class="col-xs-6 vcenter">
              <label :for="getExpense(expense)" style="display:block !important">Ποσό</label>
              <input type="text" :name="getExpense(expense)" class="form-control">
            </div>
            <div class="col-xs-6 vcenter">
              <currencies :number="expense"></currencies>
            </div>
          </td>
          <td>
            <input type="number" class="form-control" :name="getKaeBudgetRemainder(expense)">
          </td>
          <td>
            <input type="number" class="form-control" :name="getKaeCreditRemainder(expense)">
          </td>
        <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">
        <!-- TODO Integrate it with the GSIS service  -->
        <input type="hidden" value="Εθνικό" :name="getAfmTypeName(expense)">
        <td v-if="expense === 1"><button type="button" class="btn btn-default" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου Ποσού</span></button></td>
      </tr>
    </tbody>
  </table>
  </div>
  <div class="row">
    <div class="col-xs-4 col-xs-offset-4">
      <label for="has_related_undertaking">ΑΔΑ Σχετικής Ανάληψης Υποχρέωσης</label>
      <input name="has_related_undertaking" class="form-control">
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
