<template>
  <div class="decisionSpecificFields">
    <div class="columns">
      <div class="column">
        <label for="position_decision_type">Είδος Πράξης</label>
        <multiselect v-model="selectedDecisionType" :options="decisionTypes" select-label="" selected-label="" deselect-label="" placeholder="">
        <span slot="noResult">Δεν βρέθηκε το είδος πράξης</span>
        </multiselect>
        <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
        <input type="hidden" name="position_decision_type" :value="selectedDecisionType">
      </div>
      <div v-if="selectedDecisionType === 'Καθορισμός Αμοιβής - Αποζημίωσης'" class="column">
        <div class="columns">
          <div class="column">
            <label for="expense_amount">Ποσό</label>
            <input type="number" class="input" name="expense_amount" step="0.01">
          </div>
          <div class="column">
            <currencies></currencies>
          </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <label for="position">Θέση</label>
        <multiselect v-model="selectedPosition" :options="positions" select-label="" selected-label="" deselect-label="" placeholder="">
        <span slot="noResult">Δεν βρέθηκε θέση</span>
        </multiselect>
        <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
        <input type="hidden" name="position" :value="selectedPosition">
      </div>
      <div class="column">
        <label for="position_org">Φορέας που υφίσταται η θέση</label>
        <input type="text" class="input" name="position_org">
      </div>
    </div>
  </div>
</template>

<script>

import Currencies from './common-properties/Currencies.vue'
import Multiselect from 'vue-multiselect'

export default {
  data: () => {
    return {
      decisionTypes: ['Αθωωτική Πειθαρχική Απόφαση', 'Αντικατάσταση', 'Αποδοχή Παραίτησης','Διορισμός', 'Καθορισμός Αμοιβής - Αποζημίωσης', 'Παύση'],
      positions: ['Γενικός Γραμματέας Αποκεντρωμένης Διοίκησης', 'Γενικός Γραμματέας Υπουργείου', 'Ειδικός Γραμματέας Υπουργείου', 'Μονομελές Όργανο'],
      selectedDecisionType: '',
      selectedPosition: ''
    }
  },
  components: {Currencies, Multiselect}
}
</script>
