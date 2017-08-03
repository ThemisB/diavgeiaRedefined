<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-4">
      <label for="collegial_body_decision_type">Είδος Πράξης</label>
      <select class="selectpicker pickers" title="Είδος Πράξης" data-live-search="true" id="collegial_body_decision_type" name="collegial_body_decision_type" data-width="auto" v-model="selected">
        <option v-for="decisonType in decisionTypes" :data-tokens="decisonType.keywords" :value="decisonType.text">{{decisonType.text}}</option>
      </select>
    </div>
    <div class="col-xs-4">
      <label for="collegial_body_party_type">Τύπος Οργάνου</label>
      <select class="selectpicker pickers" title="Τύπος Οργάνου" data-live-search="true" id="collegial_body_party_type" name="collegial_body_party_type" data-width="auto">
        <option v-for="partyType in partyTypes" :data-tokens="partyType.keywords" :value="partyType.text">{{partyType.text}}</option>
      </select>
    </div>
    <div v-if="selected === 'Καθορισμός Αμοιβής - Αποζημίωσης'" class="col-xs-4">
      <div class="col-xs-6">
        <label for="collegial_body_refund">Ποσό</label>
        <input type="number" name="collegial_body_refund" class="form-control">
      </div>
      <div class="col-xs-6">
        <currencies></currencies>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <fek></fek>
      </div>
    </div>
  </div>
</template>

<script>

import Fek from './common-properties/Fek.vue'
import Currencies from './common-properties/Currencies.vue'
import $ from 'jquery'

export default {
  data: () => {
    return {
      decisionTypes: [
        {text: 'Αποδοχή Παραίτησης Μέλους', keywords: 'Αποδοχή Αποδοχη Παραίτησης Παραιτησης Μέλους Μελους'},
        {text: 'Καθορισμός Αμοιβής - Αποζημίωσης', keywords: 'Καθορισμός Καθορισμος Αμοιβής Αμοιβης Αποζημίωσης Αποζημιωσης'},
        {text: 'Παύση - Αντικατάσταση μέλους', keywords: 'Παύση Παυση Αντικατάσταση Αντικατασταση Μέλους Μελους'},
        {text: 'Συγκρότηση', keywords: 'Συγκρότηση Συγκροτηση'}
      ],
      partyTypes: [
        {text: 'Όργανο Γνωμοδοτικής Αρμοδιότητας', keywords: 'Όργανο Οργανο Γνωμοδοτικής Γνωμοδοτικης Αρμοδιότητας Αρμοδιοτητας'},
        {text: 'Όργανο άλλης αρμοδιότητας', keywords: 'Όργανο Οργανο Αρμοδιότητας Αρμοδιοτητας Άλλης Αλλης'},
        {text: 'Επιτροπή', keywords: 'Επιτροπή Επιτροπη'},
        {text: 'Ομάδα έργου', keywords: 'Ομάδα Ομαδα Έργου Εργου'},
        {text: 'Ομάδα εργασίας', keywords: 'Ομάδα Ομαδα Εργασίας Εργασιας'},
        {text: 'Συλλογικό όργανο Διοίκησης', keywords: 'Συλλογικό Συλλογικο Όργανο Οργανο Διοίκησης Διοικησης'}
      ],
      selected: ''
    }
  },
  mounted: function () {
    $('#collegial_body_decision_type').selectpicker()
    $('#collegial_body_party_type').selectpicker()
  },
  components: {Fek, Currencies}
}
</script>
