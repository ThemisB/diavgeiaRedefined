<template>
  <div class="col-xs-5">
    <div class="col-xs-3">
    <h5 class="text-center">Είδος Νομοθεσίας</h5>
    <select class="pickers selectpicker" :id="getType" :name="getType" data-width="auto" v-model="selected">
      <option value="law">ΝΟΜΟΣ</option>
      <option value="pd">ΠΡΟΕΔΡΙΚΟ ΔΙΑΤΑΓΜΑ</option>
      <option value="dvg">ΑΠΟΦΑΣΗ ΔΙΑΥΓΕΙΑΣ</option>
    </select>
    </div>
    <div class="col-xs-9 text-center">
      <div v-if="selected != 'dvg'">
        <h5 class="text-center">Νομοθεσία</h5>
        <div class="input-group" :id="getInputGroupId">
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
        <input type="text" :name="getADANumber" placeholder="Ο ΑΔΑ της απόφασης, όπως έχει αναρτηθεί στην Διαύγεια" class="form-control">
      </div>
    </div>
  </div>
</template>

<script>

import InputHandler from './mixins/InputHandler.js'

module.exports = {
  props:['number', 'type'],
  mixins: [ InputHandler ],
  computed: {
    getADANumber: function() {
      return 'leglink-dvg-'+this.number;
    },
    // Considerations
    getConsiderationType: function() {
      return 'leglink-consideration-type-'+this.number;
    },
    getConsiderationInputGroupId: function() {
      return 'leglink-input-consideration-group-'+this.number;
    },
    getConsiderationYear: function() {
      return 'leglink-year-consideration-'+this.number;
    },
    getConsiderationNumber: function() {
      return 'leglink-number-consideration-'+this.number;
    },
    getConsiderationArticle: function() {
      return 'leglink-article-consideration-'+this.number;
    },
    getConsiderationParagraph: function() {
      return 'leglink-paragraph-consideration-'+this.number;
    },
    // Decisions
    getDecisionLabel: function() {
      return 'leglink-decision-'+this.number;
    },
    getDecisionType: function() {
      return 'leglink-decision-type-'+this.number;
    },
    getDecisionInputGroupId: function() {
      return 'leglink-input-decision-group-'+this.number;
    },
    getDecisionYear: function() {
      return 'leglink-year-decision-'+this.number;
    },
    getDecisionNumber: function() {
      return 'leglink-number-decision-'+this.number;
    },
    getDecisionArticle: function() {
      return 'leglink-article-decision-'+this.number;
    },
    getDecisionParagraph: function() {
      return 'leglink-paragraph-decision-'+this.number;
    },

    //Getters
    getLabel: function() {
      return this.type === 'consideration' ? this.getConsiderationLabel : this.getDecisionLabel ;
    },
    getInputGroupId: function() {
      return this.type === 'consideration' ? this.getConsiderationInputGroupId : this.getDecisionInputGroupId ;
    },
    getType: function() {
      return this.type === 'consideration' ? this.getConsiderationType : this.getDecisionType ;
    },
    getYear: function() {
      return this.type === 'consideration' ? this.getConsiderationYear : this.getDecisionYear ;
    },
    getNumber: function() {
      return this.type === 'consideration' ? this.getConsiderationNumber : this.getDecisionNumber ;
    },
    getArticle: function() {
      return this.type === 'consideration' ? this.getConsiderationArticle : this.getDecisionArticle ;
    },
    getParagraph: function() {
      return this.type === 'consideration' ? this.getConsiderationParagraph : this.getDecisionParagraph ;
    },
  },
  mounted: function() {
    let _this = this;
    $("#"+_this.getInputGroupId+' input').on("keypress", function(e){
      return _this.isNumber(e);
    });
    $('#'+_this.getType).selectpicker();
  },
  data: function() {
    return {
      selected: 'law'
    }
  }
}

</script>