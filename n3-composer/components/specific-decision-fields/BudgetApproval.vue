<template>
  <div class="decisionSpecificFields" style="padding-bottom:2em;">
    <div class="columns">
      <div class="column">
        <label for="budget_type">Είδος Προϋπολογισμού</label>
        <multiselect id="budget_type" v-model="selected" :options="budgetTypes" select-label="" selected-label="" deselect-label="" placeholder="">
        <span slot="noResult">Δεν βρέθηκε το είδος προϋπολογισμού</span>
        </multiselect>
        <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
        <input type="hidden" name="budget_type" :value="selected">
      </div>
      <div class="column">
        <budget-category></budget-category>
      </div>
      <div class="column">
        <financial-year></financial-year>
      </div>
    </div>
    <div class="columns">
      <div class="column is-one-third">
        <div class="field">
          <label for="is_budget_approval_for_org" class="checkbox">Έγκριση Ισολογισμού/Απολογισμού τρίτου Φορέα<input type="checkbox" name="is_budget_approval_for_org" id="is_budget_approval_for_org" v-model="checked"></label>
        </div>
      </div>
      <div v-if="checked" class="column is-two-thirds has-text-centered">
        <label for="has_related_institution">Φορέας που αφορά</label>
        <input name="has_related_institution" class="input">
      </div>
    </div>
  </div>
</template>

<script>

import FinancialYear from './common-properties/FinancialYear.vue'
import BudgetCategory from './common-properties/BudgetCategory.vue'
import Multiselect from 'vue-multiselect'

export default {
  data: () => {
    return {
      budgetTypes: ['Κρατικός', 'Φορέα'],
      checked: '',
      selected: ''
    }
  },
  components: {FinancialYear, BudgetCategory, Multiselect}
}
</script>
