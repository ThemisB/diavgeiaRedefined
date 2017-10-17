<template>
  <div class="decisionSpecificFields">
    <div class="columns">
      <div class="column">
        <label for="collegial_body_decision_type">Τύπος Πράξης</label>
        <multiselect v-model="selectedDecisionType" :options="decisionTypes" select-label="" selected-label="" deselect-label="" placeholder="">
        <span slot="noResult">Δεν βρέθηκε ο τύπος πράξης</span>
        </multiselect>
        <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
        <input type="hidden" name="collegial_body_decision_type" :value="selectedDecisionType">
      </div>
      <div class="column">
        <label for="collegial_body_party_type">Τύπος Οργάνου</label>
        <multiselect v-model="selectedPartyType" :options="partyTypes" select-label="" selected-label="" deselect-label="" placeholder="">
        <span slot="noResult">Δεν βρέθηκε ο τύπος οργάνου</span>
        </multiselect>
        <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
        <input type="hidden" name="collegial_body_party_type" :value="selectedPartyType">
      </div>
      <div v-if="selectedDecisionType === 'Καθορισμός Αμοιβής - Αποζημίωσης'" class="column">
        <div class="columns">
          <div class="column">
            <label for="collegial_body_refund">Ποσό</label>
            <input type="number" name="collegial_body_refund" class="input" required="required">
          </div>
          <div class="column">
            <currencies></currencies>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <fek></fek>
      </div>
    </div>
  </div>
</template>

<script>

import Fek from './common-properties/Fek.vue'
import Currencies from './common-properties/Currencies.vue'
import Multiselect from 'vue-multiselect'

export default {
  data: () => {
    return {
      decisionTypes: ['Αποδοχή Παραίτησης Μέλους', 'Καθορισμός Αμοιβής - Αποζημίωσης', 'Παύση - Αντικατάσταση μέλους', 'Συγκρότηση'],
      partyTypes: ['Όργανο Γνωμοδοτικής Αρμοδιότητας', 'Όργανο άλλης αρμοδιότητας', 'Επιτροπή', 'Ομάδα έργου', 'Ομάδα εργασίας', 'Συλλογικό όργανο Διοίκησης'],
      selectedDecisionType: '',
      selectedPartyType: ''
    }
  },
  components: {Fek, Currencies, Multiselect}
}
</script>
