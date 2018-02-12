<template>
  <div class="decisionSpecificFields columns" style="padding-bottom:1.3em">
    <div class="column is-one-third">
      <label for="service_change_decision_type">Είδος Πράξης</label>
      <multiselect v-model="selectedOption" :options="options" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε το είδος απόφασης</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="collegial_body_party_type" :value="selectedOption">
    </div>
    <div class="column">
      <fek></fek>
    </div>
  </div>
</template>

<script>

import Fek from './common-properties/Fek.vue'
import Multiselect from 'vue-multiselect'

export default {
  data: () => {
    return {
      options: ['Αποδοχή Παραίτησης', 'Διαθεσιμότητα', 'Λύση Υπαλληλικής Σχέσης', 'Υποβιβασμός'],
      selectedOption: ''
    }
  },
  components: {Fek, Multiselect}
}
</script>
