<template>
<div class="decisionSpecificFields">
  <div class="row">
    <expense-expenditure-approval></expense-expenditure-approval>
  </div>
</div>
</template>

<script>

import Kae from './common-properties/Kae.vue'
import Currencies from './common-properties/Currencies.vue'
import ExpenseExpenditureApproval from './common-properties/ExpenseExpenditureApproval.vue'
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
  components: {Kae, Currencies, ExpenseExpenditureApproval}
}
</script>
