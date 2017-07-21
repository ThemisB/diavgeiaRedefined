<template>
  <div class="col-xs-12 consideration">
    <div class="row">
      <div class="col-xs-7">
        <label :for="getConsiderationLabel"><span class="badge">ΚΕΙΜΕΝΟ #{{number}}</span></label>
        <textarea class="form-control" rows="2" :id="getConsiderationLabel" :name="getConsiderationLabel" :placeholder="getBadgePlaceholder"></textarea>
      </div>
      <div class="col-xs-5">
        <div class="col-xs-3">
        <h5 class="text-center">Είδος Νομοθεσίας</h5>
        <select class="pickers selectpicker" title="" :id="getConsiderationType" :name="getConsiderationType" data-width="auto">
          <option value="law">ΝΟΜΟΣ</option>
          <option value="pd">ΠΡΟΕΔΡΙΚΟ ΔΙΑΤΑΓΜΑ</option>
        </select>
        </div>
        <div class="col-xs-9 text-center">
          <h5 class="text-center">Νομοθεσία</h5>
          <div class="input-group" :id="getInputGroupId">
            <input type="text" name="month" placeholder="Χρονιά" maxlength="4" minlength="4" class="form-control" required="true"/>
            <span class="input-group-addon">/</span>
            <input type="text" name="year" placeholder="Αριθμός" class="form-control" required="true"/>
            <span class="input-group-addon">/</span>
            <input type="text" name="month" placeholder="Άρθρο" maxlength="4" minlength="4" class="form-control" required="true"/>
            <span class="input-group-addon">/</span>
            <input type="text" name="month" placeholder="Παράγραφος" maxlength="4" minlength="4" class="form-control" required="true"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import autosize from 'autosize/dist/autosize.min.js';
import InputHandler from './mixins/InputHandler.js'

module.exports = {
  mixins: [ InputHandler ],
  props: ['number'],
  computed: {
    getBadgePlaceholder: function() {
      return 'Το κείμενο της απόφασης για το '+this.number+'ο "έχοντας λάβει υπόψην".';
    },
    getConsiderationLabel: function() {
      return 'consideration-'+this.number;
    },
    getConsiderationType: function() {
      return 'consideration-type-'+this.number;
    },
    getInputGroupId: function() {
      return 'input-consideration-group-'+this.number;
    }
  },
  mounted: function() {
    let _this = this;
    this.$nextTick(function() {
      autosize($('#'+_this.getConsiderationLabel));
      $('#'+_this.getConsiderationType).selectpicker();
    });
    $("#"+_this.getInputGroupId+' input').on("keypress", function(e){
      return _this.isNumber(e);
    });
  }
}
</script>