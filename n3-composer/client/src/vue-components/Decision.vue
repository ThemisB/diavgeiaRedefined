<template>
  <div class="col-xs-12 decision">
    <div class="row">
      <div class="col-xs-7">
        <label :for="getDecisionLabel"><span class="badge">ΑΠΟΦΑΣΗ #{{number}}</span></label>
        <textarea class="form-control" rows="2" :id="getDecisionLabel" :name="getDecisionLabel" :placeholder="getBadgePlaceholder"></textarea>
      </div>
      <legislation-linking type="decision" v-bind:number="number"></legislation-linking>
    </div>
  </div>
</template>

<script>

import autosize from 'autosize/dist/autosize.min.js'
import InputHandler from './mixins/InputHandler.js'
import LegislationLinking from './LegislationLinking.vue'

module.exports = {
  mixins: [ InputHandler ],
  props: ['number'],
  components: {LegislationLinking},
  computed: {
    getBadgePlaceholder: function() {
      return 'Η '+this.number+'η Απόφαση του φορέα.';
    },
    getDecisionLabel: function() {
      return 'decision-'+this.number;
    },
  }
}
</script>