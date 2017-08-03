<template>
  <div class="decisionSpecificFields">
  <div class="row">
    <div class="col-xs-3">
      <label for="primary_officer">Πρωτεύων Διατάκτης</label>
      <input type="text" name="primary_officer" class="form-control">
      </select>
    </div>
    <div class="col-xs-3">
      <label for="secondary_officer">Δευτερεύων Διατάκτης</label>
      <input type="text" name="secondary_officer" class="form-control">
    </div>
    <div class="col-xs-3">
      <budget-category></budget-category>
    </div>
    <div class="col-xs-3">
      <financial-year></financial-year>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2">
      <expense-with-kae></expense-with-kae>
    </div>
  </div>
</div>
</template>

<script>

import FinancialYear from './common-properties/FinancialYear.vue'
import BudgetCategory from './common-properties/BudgetCategory.vue'
import ExpenseWithKae from './common-properties/ExpenseWithKae.vue'

export default {
  components: {FinancialYear, BudgetCategory, ExpenseWithKae}
}
</script>
