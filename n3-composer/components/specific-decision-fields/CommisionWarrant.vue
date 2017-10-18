<template>
  <div class="decisionSpecificFields">
  <div class="columns">
    <div class="column">
      <label for="primary_officer">Πρωτεύων Διατάκτης</label>
      <input type="text" name="primary_officer" class="input">
      </select>
    </div>
    <div class="column">
      <label for="secondary_officer">Δευτερεύων Διατάκτης</label>
      <input type="text" name="secondary_officer" class="input">
    </div>
    <div class="column">
      <budget-category></budget-category>
    </div>
    <div class="column">
      <financial-year></financial-year>
    </div>
  </div>
  <div class="columns">
    <expense-with-kae></expense-with-kae>
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
