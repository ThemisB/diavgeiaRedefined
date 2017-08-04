<template>
<div class="decisionSpecificFields">
  <div class="row">
    <div class="col-xs-3">
      <cpv></cpv>
    </div>
    <div class="col-xs-3">
      <label for="tendering_procedure">Διαδικασία Διαγωνισμού</label>
      <select class="selectpicker pickers" title="Διαδικασία Διαγωνισμού" data-live-search="true" id="tendering_procedure" name="tendering_procedure" data-width="auto">
        <option v-for="tenderingProcedure in tenderingProcedures" :data-tokens="tenderingProcedure.keywords" :value="tenderingProcedure.text">{{tenderingProcedure.text}}</option>
      </select>
    </div>
    <div class="col-xs-3">
      <label for="contract_decision_type">Τύπος Σύμβασης</label>
      <select class="selectpicker pickers" title="Τύπος Σύμβασης" data-live-search="true" id="contract_decision_type" name="contract_decision_type" data-width="auto">
        <option v-for="contractType in contractTypes" :data-tokens="contractType.keywords" :value="contractType.text">{{contractType.text}}</option>
      </select>
    </div>
    <div class="col-xs-3">
      <label for="selection_criterion">Κριτήριο Επιλογής</label>
      <select class="selectpicker pickers" title="Κριτήριο Επιλογής" data-live-search="true" id="selection_criterion" name="selection_criterion" data-width="auto">
        <option v-for="selectionCriterion in selectionCriteria" :data-tokens="selectionCriterion.keywords" :value="selectionCriterion.text">{{selectionCriterion.text}}</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-10 col-xs-offset-1">
      <div class="col-xs-4">
        <label for="government_institution_budget_code">Κωδικός Προϋπολογισμού Φορέα</label>
        <select class="selectpicker pickers" title="Κωδικός Προϋπολογισμού Φορέα" data-live-search="true" id="government_institution_budget_code" name="government_institution_budget_code" data-width="auto">
          <option v-for="budgetCode in budgetCodes" :data-tokens="budgetCode.keywords" :value="budgetCode.text">{{budgetCode.text}}</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="expense_amount">Ποσό</label>
        <input type="number" class="form-control" name="expense_amount">
      </div>
      <div class="col-xs-4">
        <currencies></currencies>
      </div>
    </div>
  </div>
</div>
</template>

<script>

import Cpv from './common-properties/Cpv.vue'
import Currencies from './common-properties/Currencies.vue'
import $ from 'jquery'

export default {
  data: () => {
    return {
      tenderingProcedures: [
        {text: 'Ανοικτός', keywords: 'Ανοικτός Ανοικτος'},
        {text: 'Κλειστός', keywords: 'Κλειστός Κλειστος'},
        {text: 'Πρόχειρος', keywords: 'Πρόχειρος Προχειρος'}
      ],
      selectionCriteria: [
        {text: 'Συμφερότερη από οικονομικής άποψης', keywords: 'Συμφερότερη Συμφεροτερη Από Απο Οικονομικής Οικονομικης Άποψης Αποψης'},
        {text: 'Χαμηλότερη Τιμή', keywords: 'Χαμηλότερη Χαμηλοτερη Τιμή Τιμη'}
      ],
      contractTypes: [
        {text: 'Έργα', keywords: 'Έργα Εργα'},
        {text: 'Μελέτες', keywords: 'Μελέτες Μελετες'},
        {text: 'Προμήθειες', keywords: 'Προμήθειες Προμηθειες'},
        {text: 'Υπηρεσίες', keywords: 'Υπηρεσίες Υπηρεσιες'}
      ],
      budgetCodes: [
        {text: 'Πρόγραμμα Δημοσίων Επενδύσεων', keywords: 'Πρόγραμμα Προγραμμα Δημοσίων Δημοσιων Επενδύσεων Επενδυσεων'},
        {text: 'Συγχρηματοδοτούμενο Έργο', keywords: 'Συγχρηματοδοτούμενο Συγχρηματοδοτουμενο Έργο Εργο'},
        {text: 'Τακτικός Προϋπολογισμός', keywords: 'Τακτικός Τακτικος Προϋπολογισμός Προϋπολογισμος Προυπολογισμος'}
      ]
    }
  },
  mounted: function () {
    $('#tendering_procedure').selectpicker()
    $('#selection_criterion').selectpicker()
    $('#government_institution_budget_code').selectpicker()
    $('#contract_decision_type').selectpicker()
  },
  components: {Cpv, Currencies}
}
</script>
