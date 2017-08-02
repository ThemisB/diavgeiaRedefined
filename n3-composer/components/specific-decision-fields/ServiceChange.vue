<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-4">
      <label for="service_change_decision_type">Είδος Πράξης</label>
      <select class="selectpicker pickers" title="Είδος Πράξης" data-live-search="true" id="service_change_decision_type" name="service_change_decision_type" data-width="auto">
        <option v-for="option in options" :data-tokens="option.keywords" :value="option.text">{{option.text}}</option>
      </select>
    </div>
    <div class="col-xs-8">
      <fek></fek>
    </div>
  </div>
</template>

<script>

import $ from 'jquery'
import Fek from './common-properties/Fek.vue'

export default {
  data: () => {
    return {
      options: [
        {text: 'Αποδοχή Παραίτησης', keywords: 'Αποδοχή Αποδοχη Παραίτησης Παραιτησης'},
        {text: 'Διαθεσιμότητα', keywords: 'Διαθεσιμότητα Διαθεσιμοτητα'},
        {text: 'Λύση Υπαλληλικής Σχέσης', keywords: 'Λύση Λυση Υπαλληλικής Υπαλληλικης Σχέσης Σχεσης'},
        {text: 'Υποβιβασμός', keywords: 'Υποβιβασμός Υποβιβασμος'}
      ]
    }
  },
  mounted: function () {
    $('#service_change_decision_type').selectpicker()
  },
  components: {Fek}
}
</script>
