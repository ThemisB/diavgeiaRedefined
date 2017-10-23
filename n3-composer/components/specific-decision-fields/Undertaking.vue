<template>
  <div class="decisionSpecificFields" style="padding-bottom:1.3em">
    <div class="columns">
      <div class="column">
        <financial-year></financial-year>
      </div>
      <div class="column">
        <budget-category></budget-category>
      </div>
      <div class="column">
        <label for="entry_number">Αριθμός Καταχώρησης</label>
        <input name="entry_number" class="input" type="text">
      </div>
      <div class="column">
        <div class="columns">
          <div class="column">
            <div class="field">
              <label for="partialead" class="checkbox" style="display:inline-block">Τμηματική Ανάληψη<input id="partialead" name="partialead" type="checkbox"></label>
            </div>
          </div>
          <div class="column">
            <label for="recalled_expense" class="checkbox" style="display:inline-block">Ανακλητική Ανάληψη<input id="recalled_expense" name="recalled_expense" type="checkbox"></label>
          </div>
        </div>
      </div>
    </div>
    <undertaking-expense></undertaking-expense>
    <div class="columns">
      <div class="column">
        <label for="has_related_undertaking">ΑΔΑ Σχετικής Ανάληψης Υποχρέωσης</label>
        <input name="has_related_undertaking" class="input" placeholder="Ο ΑΔΑ της σχετικής ανάληψης υποχρέωσης">
      </div>
      <div class="column">
        <label for="has_related_partial">Σχετική Αρχική Τμηματική</label>
        <input type="text" class="input" placeholder="Ο ΑΔΑ της σχετικής αρχικής τμηματικής απόφασης">
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
