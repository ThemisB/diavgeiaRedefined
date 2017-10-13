<template>
  <div class="columns">
    <div class="column">
      <label for="balance_account_type">Είδος Πράξης</label>
      <multiselect id="balance_account_type" v-model="selectedAccountType" :options="accountTypes" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε είδος πράξης</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="balance_account_type" :value="selectedAccountType">
    </div>
    <div class="column">
      <label for="balance_account_time_period">Χρονική Περίοδος</label>
      <multiselect id="balance_account_time_period" v-model="selectedTimePeriod" :options="accountTimePeriods" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε χρονική περίοδος</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="balance_account_time_period" :value="selectedTimePeriod">
    </div>
    <div class="column">
      <financial-year></financial-year>
    </div>
    <div class="column">
      <div class="columns">
        <div class="column is-two-thirds">
          <div class="field">
            <label for="is_balance_account_approval_for_org">Έγκριση Ισολογισμού/Απολογισμού τρίτου Φορέα<input type="checkbox" name="is_balance_account_approval_for_org" id="is_balance_account_approval_for_org" v-model="checked"></label>
          </div>
        </div>
        <div v-if="checked" class="column is-one-third">
          <label for="has_related_institution">Φορέας που αφορά</label>
          <input name="has_related_institution" class="input">
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import Multiselect from 'vue-multiselect'
import FinancialYear from './common-properties/FinancialYear.vue'

export default {
  data: () => {
    return {
      accountTypes: ['Απολογισμός', 'Ισολογισμός', 'Ισολογισμός και Απολογισμός'],
      accountTimePeriods: ['Έτος','Εξάμηνο','Τρίμηνο'],
      checked: '',
      selectedAccountType: '',
      selectedTimePeriod: ''
    }
  },
  components: {FinancialYear, Multiselect}
}
</script>
