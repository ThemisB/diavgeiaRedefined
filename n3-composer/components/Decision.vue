<template>
  <div class="col-xs-12 decision">
    <div class="row">
      <div class="col-xs-7">
        <label :for="getDecisionLabel"><span class="badge">ΑΠΟΦΑΣΗ #{{decisionNumber}}</span></label>
        <textarea class="form-control" rows="2" :id="getDecisionLabel" :name="getDecisionName" :placeholder="getBadgePlaceholder"></textarea>
      </div>
      <legislation-linking type="decision" v-bind:decisionNumber="decisionNumber"></legislation-linking>
    </div>
  </div>
</template>

<script>

import InputHandler from './mixins/InputHandler.js'
import LegislationLinking from './LegislationLinking.vue'
import $ from 'jquery'
import autosize from 'autosize'

export default {
  mixins: [ InputHandler ],
  props: ['decisionNumber'],
  components: {LegislationLinking},
  computed: {
    getBadgePlaceholder: function () {
      return 'Η ' + this.decisionNumber + 'η Απόφαση του φορέα.'
    },
    getDecisionLabel: function () {
      return 'decision-' + this.decisionNumber
    },
    getDecisionName: function () {
      return 'decisions[' + this.decisionNumber + '][text]'
    }
  },
  mounted: function () {
    autosize($('#' + this.getDecisionLabel))
  }
}
</script>
