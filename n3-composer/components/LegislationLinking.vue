<template>
  <div class="col-xs-5">
    <div class="col-xs-3">
    <h5 class="text-center">Είδος Νομοθεσίας</h5>
    <select class="pickers" :name="getType" :id="getPicker" data-width="auto" v-model="selected">
      <option value="law">ΝΟΜΟΣ</option>
      <option value="pd">ΠΡΟΕΔΡΙΚΟ ΔΙΑΤΑΓΜΑ</option>
      <option value="dvg">ΑΠΟΦΑΣΗ ΔΙΑΥΓΕΙΑΣ</option>
    </select>
    </div>
    <div class="col-xs-9 text-center">
      <div v-if="selected != 'dvg'">
        <h5 class="text-center">Νομοθεσία</h5>
        <div class="input-group">
          <input type="text" :name="getYear" placeholder="Χρονιά" maxlength="4" minlength="4" class="form-control"/>
          <span class="input-group-addon">/</span>
          <input type="text" :name="getNumber" placeholder="Αριθμός" class="form-control"/>
          <span class="input-group-addon">/</span>
          <input type="text" :name="getArticle" placeholder="Άρθρο" class="form-control"/>
          <span class="input-group-addon">/</span>
          <input type="text" :name="getParagraph" placeholder="Παράγραφος" class="form-control"/>
        </div>
      </div>
      <div v-else>
        <h5>ΑΔΑ Απόφασης</h5>
        <input type="text" :name="getIUN" placeholder="Ο ΑΔΑ της απόφασης, όπως έχει αναρτηθεί στην Διαύγεια" class="form-control">
      </div>
      <input type="hidden" :name="getLegislationIndex" :value="getLegislationLinkingNumberValue">
    </div>
  </div>
</template>

<script>

import InputHandler from './mixins/InputHandler.js'
import $ from 'jquery'

export default {
  props: ['decisionNumber', 'considerationNumber', 'type'],
  mixins: [ InputHandler ],
  computed: {
    // Considerations
    getConsiderationType: function () {
      return 'considerations[' + this.considerationNumber + '][type]'
    },
    getConsiderationYear: function () {
      return 'considerations[' + this.considerationNumber + '][year]'
    },
    getConsiderationNumber: function () {
      return 'considerations[' + this.considerationNumber + '][number]'
    },
    getConsiderationArticle: function () {
      return 'considerations[' + this.considerationNumber + '][article]'
    },
    getConsiderationParagraph: function () {
      return 'considerations[' + this.considerationNumber + '][paragraph]'
    },
    getConsiderationIUN: function () {
      return 'considerations[' + this.considerationNumber + '][IUN]'
    },
    getConsiderationIndex: function () {
      return 'considerations[' + this.considerationNumber + '][index]'
    },
    getConsiderationPicker: function () {
      return 'considerationpicker_' + this.considerationNumber
    },
    // Decisions
    getDecisionType: function () {
      return 'decisions[' + this.decisionNumber + '][type]'
    },
    getDecisionYear: function () {
      return 'decisions[' + this.decisionNumber + '][year]'
    },
    getDecisionNumber: function () {
      return 'decisions[' + this.decisionNumber + '][number]'
    },
    getDecisionArticle: function () {
      return 'decisions[' + this.decisionNumber + '][article]'
    },
    getDecisionParagraph: function () {
      return 'decisions[' + this.decisionNumber + '][paragraph]'
    },
    getDecisionIUN: function () {
      return 'decisions[' + this.decisionNumber + '][IUN]'
    },
    getDecisionIndex: function () {
      return 'decisions[' + this.decisionNumber + '][index]'
    },
    getDecisionPicker: function () {
      return 'leg_decisionpicker_' + this.decisionNumber
    },
    // Getters
    getType: function () {
      return this.type === 'consideration' ? this.getConsiderationType : this.getDecisionType
    },
    getYear: function () {
      return this.type === 'consideration' ? this.getConsiderationYear : this.getDecisionYear
    },
    getNumber: function () {
      return this.type === 'consideration' ? this.getConsiderationNumber : this.getDecisionNumber
    },
    getArticle: function () {
      return this.type === 'consideration' ? this.getConsiderationArticle : this.getDecisionArticle
    },
    getParagraph: function () {
      return this.type === 'consideration' ? this.getConsiderationParagraph : this.getDecisionParagraph
    },
    getIUN: function () {
      return this.type === 'consideration' ? this.getConsiderationIUN : this.getDecisionIUN
    },
    getPicker: function () {
      return this.type === 'consideration' ? this.getConsiderationPicker : this.getDecisionPicker
    },
    getLegislationIndex: function () {
      return this.type === 'consideration' ? this.getConsiderationIndex : this.getDecisionIndex
    },
    getLegislationLinkingNumberValue: function () {
      return this.type === 'consideration' ? this.considerationNumber : this.decisionNumber
    }
  },
  data: function () {
    return {
      selected: 'law'
    }
  },
  mounted: function () {
    let _this = this
    $('#' + _this.getInputGroupId + ' input').on('keypress', function (e) {
      return _this.isNumber(e)
    })
    $('#' + _this.getPicker).selectpicker()
  }
}

</script>
