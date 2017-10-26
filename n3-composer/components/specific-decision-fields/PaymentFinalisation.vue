<template>
  <div class="decisionSpecificFields" style="padding-bottom:4em; padding-top:3em;">
    <div class="columns">
      <div class="column">
        <label for="payment_number">Αριθμός Πληρωμής</label>
        <input name="payment_number" class="input"></input>
      </div>
      <div class="column">
        <financial-year></financial-year>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <label for="organizationSponsorAfm">ΑΦΜ Φορέα που υλοποιεί το ένταλμα πληρωμής</label>
        <input type="text" name="organizationSponsorAfm" class="input">
      </div>
      <div class="column">
        <label for="organizationSponsorName">Όνομα Φορέα</label>
        <input type="text" name="organizationSponsorName" value="ΦΟΡΕΑΣ Χ" readonly class="input">
      </div>
      <input name="organizationSponsorAfmType" value="Εθνικό" readonly class="input" type="hidden">
    </div>
    <div class="columns">
      <div class="column has-text-centered">
        <div class="field">
          <label for="ignoreSponsoredAfm" class="checkbox">Παράληψη ΑΦΜ Δικαιούχων;&nbsp;<input type="checkbox" v-model="ignoreSponsoredAfm" name="ignoreSponsoredAfm"></label>
        </div>
      </div>
      <div class="column" v-if="ignoreSponsoredAfm">
        <div class="columns">
          <div class="column">
            <label for="reason_multiple_afm_ignorance">Αιτία παράλειψης πολλαπλών ΑΦΜ</label>
            <multiselect v-model="selectedReasonMultipleAfmIgnorance" :options="options" select-label="" selected-label="" deselect-label="" placeholder="">
            </multiselect>
            <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
            <input type="hidden" name="reason_multiple_afm_ignorance" :value="selectedReasonMultipleAfmIgnorance">
          </div>
          <div class="column">
            <label for="multiple_afm_ignorance_text">Κείμενο Παράληψης ΑΦΜ</label>
            <input type="text" class="input" name="multiple_afm_ignorance_text">
          </div>
        </div>
      </div>
    </div>
    <div v-for="expense in expensesArray" :key="getKey('expense', expense)">
      <h3 class="subtitle has-text-centered is-4" style="text-decoration-style:double;text-decoration-line:underline">{{expense}}ος Δικαιούχος Εντάλματος Πληρωμής</h3>
      <div class="columns">
        <div class="column">
          <div class="columns" v-if="!ignoreSponsoredAfm">
            <div class="column">
              <label :for="getAFM(expense)">ΑΦΜ Δικαιούχου</label>
              <input type="text" :name="getAFM(expense)" class="input">
            </div>
            <div class="column">
              <label :for="getCompany(expense)">Όνομα Δικαιούχου</label>
              <input type="text" :name="getCompany(expense)" value="ΕΤΑΙΡΕΙΑ Χ" readonly class="input">
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <div class="columns">
                <div class="column">
                  <label :for="getExpenseAmount(expense)" style="font-size:0.9em" v-if="!withHoldingsExist">Καθαρό Ποσό Δικαιούχου</label>
                  <label :for="getExpenseAmount(expense)" style="font-size:0.9em" v-if="withHoldingsExist">Μεικτό Ποσό Δικαιούχου</label>
                  <input :name="getExpenseAmount(expense)" step="0.01" type="number" class="input">
                </div>
                <div class="column">
                  <currencies v-bind:number="expense"></currencies>
                </div>
              </div>
              <div class="columns is-centered">
                <div class="column">
                  <div class="field">
                    <label for="withHoldingsExist" class="checkbox">Υπάρχουν κρατήσεις στον Δικαιούχο;&nbsp;<input type="checkbox" v-model="withHoldingsExist" name="withHoldingsExist"></label>
                  </div>
                </div>
              </div>
              <div class="columns" v-if="withHoldingsExist">
                <div class="column">
                  <label :for="getExpenseAmountWithHolding(expense)" style="font-size:0.9em">Ποσό Δικαιούχου με κρατήσεις</label>
                  <input :name="getExpenseAmountWithHolding(expense)" step="0.01" type="number" class="input">
                </div>
                <div class="column">
                  <currencies v-bind:number="expense" v-bind:paymentWithHolding="true"></currencies>
                </div>
              </div>
            </div>
            <input :name="getAFMType(expense)" value="Εθνικό" readonly class="input" type="hidden">
          </div>
          <h3 class="subtitle has-text-centered is-4" style="text-decoration-line:underline">Έξοδα με ΚΑΕ</h3>
          <withKaeSubExpense v-bind:expenseNumber="expense"></withKaeSubExpense>
          <div class="columns is-centered">
            <div class="column is-two-thirds">
              <label :for="getPaymentReason(expense)" class="label">Αιτία Πληρωμής</label>
              <textarea class="textarea" rows="2" :name="getPaymentReason(expense)" :id="getPaymentReasonId(expense)"></textarea>
            </div>
            <div class="column">
              <label :for="getPaymentSponsor(expense)" class="label">Χρηματοδότης</label>
              <input class="input" :name="getPaymentSponsor(expense)"></textarea>
            </div>
            <div class="column">
              <cpv v-bind:number="expense" v-bind:isPaymentFinilisation="true"></cpv>
            </div>
          </div>
          <withHolding v-if="withHoldingsExist" v-bind:expenseNumber="expense"></withHolding>
          <documents v-bind:expenseNumber="expense"></documents>
        </div>
      </div>
      <hr>
    </div>
    <div class="columns">
      <div class="column field has-text-centered">
        <a class="button is-info is-outlined" type="button" v-on:click="incrementExpenses">
          <span class="icon is-small is-left">
            <i class="fa fa-plus"></i>
          </span>
          <span>{{nextExpense}}ος δικαιούχος εντάλματος πληρωμής</span>
        </a>
      </div>
    </div>
  </div>
</template>

<script>

import Multiselect from 'vue-multiselect'
import WithHolding from './common-properties/WithHolding.vue'
import Documents from './common-properties/Documents.vue'
import WithKaeSubExpense from './common-properties/WithKaeSubExpense.vue'
import autosize from 'autosize'
import Currencies from './common-properties/Currencies.vue'
import Cpv from './common-properties/Cpv.vue'
import FinancialYear from './common-properties/FinancialYear.vue'

import $ from 'jquery'

export default {
  components: {Multiselect, Currencies, WithHolding, Documents, Cpv, WithKaeSubExpense, FinancialYear},
  mounted: function () {
    let expenseNumber = 1
    this.lastExpense = 1
    this.nextExpense = 2
    this.expensesArray = [expenseNumber]

    $(document).ready(function(){
      autosize($('#payment-reason-1'))
    })
  },
  data: function () {
    return {
      expensesArray: [],
      lastExpense: 1,
      nextExpense: 2,
      withHoldingsExist: false,
      ignoreSponsoredAfm: false,
      selectedReasonMultipleAfmIgnorance: '',
      options: ['Μαζικές Αποζημιώσεις', 'Μισθοδοσία']
    }
  },
  methods: {
    incrementExpenses: function () {
      this.lastExpense++
      let expenseNumber = this.lastExpense
      this.nextExpense++
      this.expensesArray.push(expenseNumber)
      autosize($('#payment-reason-'+this.lastExpense))
    },
    getExpenseAmount: function (expenseNumber) {
      return 'expense[' + expenseNumber +'][expense_amount]'
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
    getPaymentReason: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][payment_reason]'
    },
    getPaymentSponsor: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][payment_sponsor]'
    },
    getExpenseAmountWithHolding: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][payment_with_withholdings]'
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    },
    getPaymentReasonId: function (expenseNumber) {
      return 'payment-reason-' + expenseNumber
    }
  }
}
</script>
