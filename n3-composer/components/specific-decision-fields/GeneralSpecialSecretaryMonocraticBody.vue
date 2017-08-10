<template>
  <div class="decisionSpecificFields">
    <div class="row">
      <div class="col-xs-4">
        <label for="position_decision_type">Είδος Πράξης</label>
        <select class="selectpicker pickers" title="Είδος Πράξης" data-live-search="true" id="position_decision_type" name="position_decision_type" data-width="auto" v-model="selected">
          <option v-for="decisionType in decisionTypes" :data-tokens="decisionType.keywords" :value="decisionType.text">{{decisionType.text}}</option>
        </select>
      </div>
      <div v-if="selected === 'Καθορισμός Αμοιβής - Αποζημίωσης'" class="col-xs-8">
        <div class="col-xs-6">
          <label for="expense_amount">Ποσό</label>
          <input type="number" class="form-control" name="expense_amount">
        </div>
        <div class="col-xs-6">
          <currencies></currencies>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 col-xs-offset-1">
        <label for="position">Θέση</label>
        <select class="selectpicker pickers" title="Θέση" data-live-search="true" id="position" name="position" data-width="auto">
          <option v-for="position in positions" :data-tokens="position.keywords" :value="position.text">{{position.text}}</option>
        </select>
      </div>
      <div class="col-xs-4 col-xs-offset-1">
        <label for="position_org">Φορέας που υφίσταται η θέση</label>
        <input type="text" class="form-control">
      </div>
    </div>
  </div>
</template>

<script>

import $ from 'jquery'
import Currencies from './common-properties/Currencies.vue'

export default {
  data: () => {
    return {
      decisionTypes: [
        {text: 'Αθωωτική Πειθαρχική Απόφαση', keywords: 'Αθωωτική Αθωωτικη Πειθαρχική Πειθαρχικη Απόφαση Αποφαση'},
        {text: 'Αντικατάσταση', keywords: 'Αντικατάσταση Αντικατασταση'},
        {text: 'Αποδοχή Παραίτησης', keywords: 'Αποδοχή Αποδοχη Παραίτησης Παραιτησης'},
        {text: 'Διορισμός', keywords: 'Διορισμός Διορισμος'},
        {text: 'Καθορισμός Αμοιβής - Αποζημίωσης', keywords: 'Καθορισμός Καθορισμος Αμοιβής Αμοιβης Αποζημίωσης Αποζημιωσης'},
        {text: 'Παύση', keywords: 'Παύση Παυση'}
      ],
      positions: [
        {text: 'Γενικός Γραμματέας Αποκεντρωμένης Διοίκησης', keywords: 'Γενικός Γενικος Γραμματέας Γραμματεας Αποκεντρωμένης Αποκεντρωμενης Διοίκησης Διοικησης'},
        {text: 'Γενικός Γραμματέας Υπουργείου', keywords: 'Γενικός Γενικος Γραμματέας Γραμματεας Υπουργείου Υπουργειου'},
        {text: 'Ειδικός Γραμματέας Υπουργείου', keywords: 'Ειδικός Ειδικος Γραμματέας Γραμματεας Υπουργείου Υπουργειου'},
        {text: 'Μονομελές Όργανο', keywords: 'Μονομελές Μονομελες Όργανο Οργανο'}
      ],
      selected: ''
    }
  },
  mounted: function () {
    $('#position_decision_type').selectpicker()
    $('#position').selectpicker()
  },
  components: {Currencies}
}
</script>
