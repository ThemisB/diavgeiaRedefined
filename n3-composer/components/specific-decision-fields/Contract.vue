<template>
  <div class="decisionSpecificFields">
  <div class="columns">
    <div class="column">
      <label for="contract_decision_type">Είδος Πράξης</label>
      <multiselect v-model="contractType" :options="contractDecisionTypes" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε το είδος πράξης</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="contract_decision_type" :value="contractType">
    </div>
    <div class="column">
      <number-employees></number-employees>
    </div>
    <div v-if="contractType !== 'Σύμβαση Ιδιωτικού Δικαίου Αορίστου Χρόνου'" class="column">
      <div class="field">
        <label for="contract_is_co_funded" class="checkbox">Συγχρηματοδοτούμενο έργο<input type="checkbox" name="contract_is_co_funded" id="contract_is_co_funded"></label>
      </div>
    </div>
  </div>
  <div v-if="contractType === 'Σύμβαση Έργου' ">
    <h4 class="has-text-centered subtitle">Στοιχεία Έργου</h4>
    <div class="columns">
      <expense></expense>
    </div>
    <div class="columns" style="padding-bottom:1.5em">
      <div class="column">
          <label for="contract_start">Έναρξη Έργου</label>
          <input type="date" class="input" name="contract_start">
      </div>
      <div class="column">
        <label for="contract_end">Λήξη Έργου</label>
        <input type="date" class="input" name="contract_end">
      </div>
    </div>
    </div>
  </div>
  </div>
</div>
</template>

<script>

import NumberEmployees from './common-properties/NumberEmployees.vue'
import Expense from './common-properties/Expense.vue'
import Multiselect from 'vue-multiselect'

export default {
  data: () => {
    return {
      contractDecisionTypes: ['Σύμβαση Έργου', 'Σύμβαση Ιδιωτικού Δικαίου Αορίστου Χρόνου','Σύμβαση Ιδιωτικού Δικαίου Ορισμένου Χρόνου'],
      contractType: ''
    }
  },
  components: {NumberEmployees, Expense, Multiselect}
}
</script>
