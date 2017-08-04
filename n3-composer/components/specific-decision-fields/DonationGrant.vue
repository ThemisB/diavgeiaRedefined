<template>
<div class="decisionSpecificFields">
  <div class="row">
    <div class="col-xs-3">
      <label for="donation_type">Είδος Πράξης</label>
      <select class="selectpicker pickers" title="Είδος Πράξης" data-live-search="true" id="donation_type" name="donation_type" data-width="auto">
        <option v-for="donationType in donationTypes" :data-tokens="donationType.keywords" :value="donationType.text">{{donationType.text}}</option>
      </select>
    </div>
    <div class="col-xs-3">
      <label for="expense_amount">Ποσό</label>
      <input type="number" class="form-control" name="expense_amount">
    </div>
    <div class="col-xs-3">
      <currencies></currencies>
    </div>
    <div class="col-xs-3">
      <kae></kae>
    </div>
  </div>
  <div class="row">
    <expense-donation></expense-donation>
  </div>
</div>
</template>

<script>

import Kae from './common-properties/Kae.vue'
import Currencies from './common-properties/Currencies.vue'
import ExpenseDonation from './common-properties/ExpenseDonation'
import $ from 'jquery'

export default {
  data: () => {
    return {
      donationTypes: [
        {text: 'Αποδοχή Δωρεάς', keywords: 'Αποδοχή Αποδοχη Δωρέας Δωρεας'},
        {text: 'Δωρεά(προς τρίτους)', keywords: 'Δωρεά Δωρεα Τρίτους Τριτους Προς'},
        {text: 'Επιχορήγηση', keywords: 'Επιχορήγηση Επιχορηγηση'},
        {text: 'Σύμβαση Πολιστικής Χορηγίας', keywords: 'Σύμβαση Συμβαση Πολιτιστικής Πολιτιστικης Χορηγίας Χορηγιας'}
      ]
    }
  },
  mounted: function () {
    $('#donation_type').selectpicker()
  },
  components: {Kae, Currencies, ExpenseDonation}
}
</script>
