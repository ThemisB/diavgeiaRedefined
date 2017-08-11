<template>
  <div class="decisionSpecificFields">
    <div class="row">
      <div class="col-xs-6">
        <label for="work_assignment_etc_category">Κατηγορία</label>
        <select class="selectpicker pickers" title="Κατηγορία" data-live-search="true" id="work_assignment_etc_category" name="work_assignment_etc_category" data-width="auto">
          <option v-for="workType in workTypes" :data-tokens="workType.keywords" :value="workType.text">{{workType.text}}</option>
        </select>
      </div>
      <div class="col-xs-6">
        <label for="has_related_undertaking">Σχετική Ανάληψη Υποχρέωσης</label>
        <input type="text" placeholder="Ο ΑΔΑ της σχετικής ανάληψης υποχρέωσης" name="has_related_undertaking" class="form-control">
      </div>
    </div>
    <div class="row">
      <table class="expensesTable table table-striped table-bordered expensesDonation">
        <thead>
          <tr>
            <th>ΑΦΜ ΦΟΡΕΑ</th>
            <th>ΕΠΩΝΥΜΙΑ</th>
            <th>ΠΡΟΣΘΗΚΗ</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="expense in expensesArray" :key="expense.id = expense">
              <td>
                <input type="text" :name="getAFM(expense)" class="form-control">
              </td>
              <td class="text-center">
                  <input type="text" readonly="readonly" :name="getSponsored(expense)" value="ΕΠΩΝΥΜΙΑ Χ" class="form-control text-center">
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
      <div class="col-xs-6">
        <div class="col-xs-6">
          <label for="expense_amount">Ποσό</label>
          <input type="text" name="expense_amount" class="form-control">
        </div>
        <div class="col-xs-6">
          <currencies></currencies>
        </div>
      </div>
      <div class="col-xs-6">
        <cpv></cpv>
      </div>
    </div>
  </div>
</template>

<script>

import $ from 'jquery'
import Currencies from './common-properties/Currencies.vue'
import Cpv from './common-properties/Cpv.vue'

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
    }
  },
  data: () => {
    return {
      workTypes: [
        {text: 'Έργα', keywords: 'Έργα Εργα'},
        {text: 'Μελέτες', keywords: 'Μελέτες Μελετες'},
        {text: 'Προμήθειες', keywords: 'Προμήθειες Προμηθειες'},
        {text: 'Υπηρεσίες', keywords: 'Υπηρεσίες Υπηρεσιες'}
      ],
      expensesArray: [],
      lastExpense: 1,
      nextExpense: 2
    }
  },
  mounted: function () {
    let expenseNumber = 1
    this.lastExpense = 1
    this.nextExpense = 2
    this.expensesArray = [expenseNumber]
    $('#work_assignment_etc_category').selectpicker()
  },
  components: {Currencies, Cpv}
}
</script>
