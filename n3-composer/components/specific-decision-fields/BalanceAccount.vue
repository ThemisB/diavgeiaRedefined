<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-4">
      <label for="balance_account_type">Είδος Πράξης</label>
      <select class="selectpicker pickers" title="Είδος Πράξης" data-live-search="true" id="balance_account_type" name="balance_account_type" data-width="auto">
        <option v-for="accountType in accountTypes" :data-tokens="accountType.keywords" :value="accountType.text">{{accountType.text}}</option>
      </select>
    </div>
    <div class="col-xs-4">
      <label for="balance_account_time_period">Χρονική Περίοδος</label>
      <select class="selectpicker pickers" title="Χρονική Περίοδος" data-live-search="true" id="balance_account_time_period" name="balance_account_time_period" data-width="auto">
        <option v-for="accountTimePeriod in accountTimePeriods" :data-tokens="accountTimePeriod.keywords" :value="accountTimePeriod.text">{{accountTimePeriod.text}}</option>
      </select>
    </div>
    <div class="col-xs-4">
      <financial-year></financial-year>
    </div>
    <div class="row balanceAccountPadding">
      <div class="col-xs-4 col-xs-offset-1">
        <label for="is_balance_account_approval_for_org">Έγκριση Ισολογισμού/Απολογισμού τρίτου Φορέα</label>
        <input type="checkbox" name="is_balance_account_approval_for_org" id="is_balance_account_approval_for_org" v-model="checked">
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

export default {
  data: () => {
    return {
      accountTypes: [
        {text: 'Απολογισμός', keywords: 'Απολογισμός Απολογισμος'},
        {text: 'Ισολογισμός', keywords: 'Ισολογισμός Ισολογισμος'},
        {text: 'Ισολογισμός και Απολογισμός', keywords: 'Ισολογισμός Ισολογισμος Απολογισμός Απολογισμος Και'}
      ],
      accountTimePeriods: [
        {text: 'Έτος', keywords: 'Έτος Ετος'},
        {text: 'Εξάμηνο', keywords: 'Εξάμηνο Εξαμηνο'},
        {text: 'Τρίμηνο', keywords: 'Τρίμηνο Τριμηνο'}
      ],
      checked: ''
    }
  },
  mounted: function () {
    $('#balance_account_type').selectpicker()
    $('#balance_account_time_period').selectpicker()
  },
  components: {FinancialYear}
}
</script>
