<template>
  <div class="decisionSpecificFields" style="padding-bottom:1.3em">
    <div class="columns">
      <div class="column">
        <label for="work_assignment_etc_category">Κατηγορία</label>
        <multiselect v-model="selectedWorkType" :options="workTypes" select-label="" selected-label="" deselect-label="" placeholder="">
        <span slot="noResult">Δεν βρέθηκε η κατηγορία</span>
        </multiselect>
        <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
        <input type="hidden" name="spatial_planning_decision_type" :value="selectedWorkType">
      </div>
      <div class="column">
        <label for="has_related_undertaking">Σχετική Ανάληψη Υποχρέωσης</label>
        <input type="text" placeholder="Ο ΑΔΑ της σχετικής ανάληψης υποχρέωσης" name="has_related_undertaking" class="input">
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <table class="table is-striped is-bordered has-has-text-centered" style="margin:0 auto;">
          <thead>
            <tr>
              <th>ΑΦΜ ΦΟΡΕΑ</th>
              <th>ΕΠΩΝΥΜΙΑ</th>
              <th>ΠΡΟΣΘΗΚΗ</th>
            </tr>
          </thead>
          <tbody class="has-text-centered">
            <tr v-for="expense in expensesArray" :key="getKey('expense', expense)">
                <td>
                  <input type="text" :name="getAFM(expense)" class="input">
                </td>
                <td class="has-text-centered">
                    <input type="text" readonly="readonly" :name="getSponsored(expense)" value="ΕΠΩΝΥΜΙΑ Χ" class="input has-text-centered">
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
    <div class="columns">
      <div class="column">
        <div class="columns">
          <div class="column">
            <label for="expense_amount">Ποσό</label>
            <input type="text" name="expense_amount" class="input">
          </div>
          <div class="column">
            <currencies></currencies>
          </div>
        </div>
      </div>
      <div class="column">
        <cpv></cpv>
      </div>
    </div>
  </div>
</template>

<script>

import Currencies from './common-properties/Currencies.vue'
import Cpv from './common-properties/Cpv.vue'
import Multiselect from 'vue-multiselect'

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
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  },
  data: () => {
    return {
      workTypes: ['Έργα', 'Μελέτες', 'Προμήθειες', 'Υπηρεσίες'],
      selectedWorkType: '',
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
  },
  components: {Currencies, Cpv, Multiselect}
}
</script>
