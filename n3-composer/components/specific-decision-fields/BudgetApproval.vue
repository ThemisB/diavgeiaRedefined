<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-4">
      <label for="budget_type">Είδος Προϋπολογισμού</label>
      <select class="selectpicker pickers" title="Είδος Προϋπολογισμού" data-live-search="true" id="budget_type" name="budget_type" data-width="auto">
        <option v-for="budgetType in budgetTypes" :data-tokens="budgetType.keywords" :value="budgetType.text">{{budgetType.text}}</option>
      </select>
    </div>
    <div class="col-xs-4">
      <budget-category></budget-category>
    </div>
    <div class="col-xs-4">
      <financial-year></financial-year>
    </div>
    <div class="row balanceAccountPadding">
      <div class="col-xs-4 col-xs-offset-1">
        <label for="is_budget_approval_for_org">Έγκριση Ισολογισμού/Απολογισμού τρίτου Φορέα</label>
        <input type="checkbox" name="is_budget_approval_for_org" id="is_budget_approval_for_org" v-model="checked">
      </div>
      <div v-if="checked" class="col-xs-4 col-xs-offset-1">
        <label for="has_related_institution">Φορέας που αφορά</label>
        <input name="has_related_institution" class="form-control">
      </div>
    </div>
  </div>
</template>

<script>

import $ from 'jquery'
import FinancialYear from './common-properties/FinancialYear.vue'
import BudgetCategory from './common-properties/BudgetCategory.vue'

export default {
  data: () => {
    return {
      budgetTypes: [
        {text: 'Κρατικός', keywords: 'Κρατικός Κρατικος'},
        {text: 'Φορέα', keywords: 'Φορέα Φορεα'}
      ],
      checked: ''
    }
  },
  mounted: function () {
    $('#budget_type').selectpicker()
  },
  components: {FinancialYear, BudgetCategory}
}
</script>
