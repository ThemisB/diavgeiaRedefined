<template>
  <div class="col-xs-12 consideration">
    <div class="row">
      <div class="col-xs-7">
        <label :for="getConsiderationLabel"><span class="badge">ΛΑΜΒΑΝΩ ΥΠΟΨΗΝ #{{considerationNumber}}</span></label>
        <textarea class="form-control" rows="2" :id="getConsiderationLabel" :name="getConsiderationName" :placeholder="getBadgePlaceholder"></textarea>
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
