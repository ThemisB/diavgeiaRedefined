<template>
  <div class="decisionSpecificFields">
  <div class="row">
    <div class="col-xs-4">
      <label for="contract_decision_type">Είδος Πράξης</label>
      <select class="selectpicker pickers" title="Είδος Πράξης" data-live-search="true" id="contract_decision_type" name="contract_decision_type" data-width="auto" v-model="contractType">
        <option v-for="contractDecisionType in contractDecisionTypes" :data-tokens="contractDecisionType.keywords" :value="contractDecisionType.text">{{contractDecisionType.text}}</option>
      </select>
    </div>
    <div class="col-xs-4">
      <number-employees></number-employees>
    </div>
    <div v-if="contractType !== 'Σύμβαση Ιδιωτικού Δικαίου Αορίστου Χρόνου'" class="col-xs-4">
      <label for="contract_is_co_funded" class="contract_is_co_funded text-center">Συγχρηματοδοτούμενο έργο</label>
      <input type="checkbox" name="contract_is_co_funded" class="contract_is_co_funded">
    </div>
  </div>
  <div class="row" v-if="contractType === 'Σύμβαση Έργου' ">
    <h4 class="text-center"><u>Στοιχεία Έργου</u></h4>
    <div class="col-xs-10 col-xs-offset-1">
        <expense></expense>
    </div>
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1">
        <div class="col-xs-4 col-xs-offset-1">
          <label for="contract_start">Έναρξη Έργου</label>
          <input type="date" class="form-control" name="contract_start">
        </div>
        <div class="col-xs-4 col-xs-offset-1">
          <label for="contract_end">Λήξη Έργου</label>
          <input type="date" class="form-control" name="contract_end">
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
</template>

<script>

import $ from 'jquery'
import NumberEmployees from './common-properties/NumberEmployees.vue'
import Expense from './common-properties/Expense.vue'

export default {
  data: () => {
    return {
      contractDecisionTypes: [
        {text: 'Σύμβαση Έργου', keywords: 'Σύμβαση Συμβαση Έργου Εργου'},
        {text: 'Σύμβαση Ιδιωτικού Δικαίου Αορίστου Χρόνου', keywords: 'Σύμβαση Συμβαση Ιδιωτικού Ιδιωτικου Δικαίου Δικαιου Αορίστου Χρόνου Χρονου'},
        {text: 'Σύμβαση Ιδιωτικού Δικαίου Ορισμένου Χρόνου', keywords: 'Σύμβαση Συμβαση Ιδιωτικού Ιδιωτικου Δικαίου Δικαιου Ορισμένου Ορισμενου Χρόνου Χρονου'}
      ],
      contractType: ''
    }
  },
  mounted: function () {
    $('#contract_decision_type').selectpicker()
  },
  components: {NumberEmployees, Expense}
}
</script>
