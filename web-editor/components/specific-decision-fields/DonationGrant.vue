<template>
<div class="decisionSpecificFields">
  <div class="columns">
    <div class="column">
      <label for="donation_type">Είδος Πράξης</label>
      <multiselect v-model="selected" :options="donationTypes" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε το είδος πράξης</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="donation_type" :value="selected">
    </div>
    <div class="column">
      <kae></kae>
    </div>
  </div>
  <expense-donation></expense-donation>
</div>
</template>

<script>

import Kae from './common-properties/Kae.vue'
import ExpenseDonation from './common-properties/ExpenseDonation'
import Multiselect from 'vue-multiselect'


export default {
  data: () => {
    return {
      donationTypes: ['Αποδοχή Δωρεάς', 'Δωρεά(προς τρίτους)', 'Επιχορήγηση', 'Σύμβαση Πολιστικής Χορηγίας'],
      selected: ''
    }
  },
  components: {Kae, ExpenseDonation, Multiselect}
}
</script>
