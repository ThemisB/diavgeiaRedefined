<template>
<div class="decisionSpecificFields">
  <div class="columns">
    <div class="column">
      <cpv></cpv>
    </div>
    <div class="column">
      <label for="tendering_procedure">Διαδικασία Διαγωνισμού</label>
      <multiselect v-model="selectedTenderingProcedure" :options="tenderingProcedures" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε η διαδικασία διαγωνισμού</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="tendering_procedure" :value="selectedTenderingProcedure">
    </div>
    <div class="column">
      <label for="contract_type">Τύπος Σύμβασης</label>
      <multiselect v-model="selectedContractType" :options="contractTypes" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε ο τύπος σύμβασης</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="contract_type" :value="selectedContractType">
    </div>
    <div class="column">
      <label for="selection_criterion">Κριτήριο Επιλογής</label>
      <multiselect v-model="selectedSelectionCriterion" :options="selectionCriteria" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε το κριτήριο επιλογής</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="selection_criterion" :value="selectedSelectionCriterion">
    </div>
  </div>
  <div class="columns">
    <div class="column">
      <label for="government_institution_budget_code">Κωδικός Προϋπολογισμού Φορέα</label>
      <multiselect v-model="selectedBudgetCode" :options="budgetCodes" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε ο κωδικός προϋπολογισμού φορέα</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="government_institution_budget_code" :value="selectedBudgetCode">
    </div>
    <div class="column">
      <label for="expense_amount">Ποσό</label>
      <input type="number" step="0.01" class="input" name="expense_amount">
    </div>
    <div class="column">
      <currencies></currencies>
    </div>
  </div>
</div>
</template>

<script>

import Cpv from './common-properties/Cpv.vue'
import Currencies from './common-properties/Currencies.vue'
import Multiselect from 'vue-multiselect'

import $ from 'jquery'

export default {
  data: () => {
    return {
      tenderingProcedures: ['Ανοικτός', 'Κλειστός', 'Πρόχειρος'],
      selectionCriteria: ['Συμφερότερη από οικονομικής άποψης','Χαμηλότερη Τιμή'],
      contractTypes: ['Έργα', 'Μελέτες', 'Προμήθειες', 'Υπηρεσίες'],
      budgetCodes: ['Πρόγραμμα Δημοσίων Επενδύσεων', 'Συγχρηματοδοτούμενο Έργο', 'Τακτικός Προϋπολογισμός'],
      selectedTenderingProcedure: '',
      selectedSelectionCriterion: '',
      selectedContractType: '',
      selectedBudgetCode: ''
    }
  },
  components: {Cpv, Currencies, Multiselect}
}
</script>
