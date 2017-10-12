<template>
  <div class="column is-one-third">
    <div class="columns">
      <div class="column">
      <h5 class="has-text-centered">Είδος Νομοθεσίας</h5>
      <multiselect title="Επιλέξτε το είδος απόφασης" :id="getPicker" required="required" v-model="selected" :options="options" track-by="label" label="label" placeholder="Επιλογή νομοθεσίας" select-label="Πατήστε enter για επιλογή" selected-label="Επιλεγμένο" deselect-label="Πατήστε enter για αφαίρεση">
      <span slot="noResult">Δεν βρέθηκε νομοθεσία</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" :name="getType" :value="selected.value">
        <div v-if="selected.value != 'dvg'">
          <h5 class="has-text-centered">Νομοθεσία</h5>
          <div class="field is-grouped">
            <input type="text" :name="getYear" placeholder="Χρονιά" maxlength="4" minlength="4" class="input"/>
            <input type="text" :name="getNumber" placeholder="Αριθμός" class="input"/>
            <input type="text" :name="getArticle" placeholder="Άρθρο" class="input"/>
            <input type="text" :name="getParagraph" placeholder="Παράγραφος" class="input"/>
          </div>
        </div>
        <div v-else>
          <h5 class="has-text-centered">ΑΔΑ Απόφασης</h5>
          <div class="field is-grouped">
            <input type="text" :name="getIUN" placeholder="Ο ΑΔΑ της απόφασης" class="input">
          </div>
        </div>
        <input type="hidden" :name="getLegislationIndex" :value="getLegislationLinkingNumberValue">
      </div>
    </div>
  </div>
</template>

<script>

import InputHandler from './mixins/InputHandler.js'
import $ from 'jquery'
import Multiselect from 'vue-multiselect'
export default {
  props: ['decisionNumber', 'considerationNumber', 'type'],
  mixins: [ InputHandler ],
  components: {Multiselect},
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
      selected: 'law',
      options: [
        {label:'ΝΟΜΟΣ', value:'law'},
        {label:'ΠΡΟΕΔΡΙΚΟ ΔΙΑΤΑΓΜΑ', value:'pd'},
        {label:'ΑΠΟΦΑΣΗ ΔΙΑΥΓΕΙΑΣ', value:'dvg'}
      ]
    }
  },
  mounted: function () {
    let _this = this
    $('#' + _this.getInputGroupId + ' input').on('keypress', function (e) {
      return _this.isNumber(e)
    })
    // $('#' + _this.getPicker).selectpicker()
  }
}

</script>
