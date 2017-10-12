<template>
  <div class="column">
    <div class="columns">
      <div class="column is-two-thirds">
        <label :for="getDecisionLabel"><span class="tag is-light">ΑΠΟΦΑΣΗ #{{decisionNumber}}</span></label>
        <textarea class="textarea" :id="getDecisionLabel" :name="getDecisionName" :placeholder="getBadgePlaceholder"></textarea>
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
