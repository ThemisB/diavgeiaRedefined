<template>
  <div class="decisionSpecificFields">
    <div class="row">
      <div class="col-xs-3">
        <financial-year></financial-year>
      </div>
      <div class="col-xs-3">
        <budget-category></budget-category>
      </div>
      <div class="col-xs-3">
        <label for="entry_number">Αριθμός Καταχώρησης</label>
        <input name="entry_number" class="form-control" type="text">
      </div>
      <div class="col-xs-3">
        <div class="col-xs-6">
          <label for="partialead">Τμηματική Ανάληψη</label>
          <input type="checkbox" name="partialead">
        </div>
        <div class="col-xs-6">
          <label for="recalled_expense">Ανακλητική Απόφαση</label>
          <input type="checkbox" name="recalled_expense">
        </div>
      </div>
    </div>
    <div class="row">
      <undertaking-expense></undertaking-expense>
    </div>
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3">
        <label for="has_related_partial">Σχετική Αρχική Τμηματική</label>
        <input type="text" class="form-control" placeholder="Ο ΑΔΑ της σχετικής αρχικής τμηματικής απόφασης">
      </div>
    </div>
  </div>
</template>

<script>

import FinancialYear from './common-properties/FinancialYear.vue'
import BudgetCategory from './common-properties/BudgetCategory.vue'
import UndertakingExpense from './common-properties/UndertakingExpense.vue'

export default {
  components: {FinancialYear, BudgetCategory, UndertakingExpense}
}
</script>
