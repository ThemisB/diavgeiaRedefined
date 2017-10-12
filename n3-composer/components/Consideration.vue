<template>
  <div class="column">
    <div class="columns">
      <div class="column is-two-thirds">
        <label :for="getConsiderationLabel"><span class="tag is-light">ΛΑΜΒΑΝΩ ΥΠΟΨΗΝ #{{considerationNumber}}</span></label>
        <textarea class="textarea" :id="getConsiderationLabel" :name="getConsiderationName" :placeholder="getBadgePlaceholder"></textarea>
      </div>
      <legislation-linking type="consideration" v-bind:considerationNumber="considerationNumber"></legislation-linking>
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
  props: ['considerationNumber'],
  components: {LegislationLinking},
  computed: {
    getBadgePlaceholder: function () {
      return 'Το κείμενο της απόφασης για το ' + this.considerationNumber + 'ο "έχοντας λάβει υπόψην".'
    },
    getConsiderationLabel: function () {
      return 'consideration-' + this.considerationNumber
    },
    getConsiderationName: function () {
      return 'considerations[' + this.considerationNumber + '][text]'
    }
  },
  mounted: function () {
    autosize($('#' + this.getConsiderationLabel))
  }
}
</script>
