<template>
  <div class="row">
  <div class="col-xs-6 col-xs-offset-3">
    <h5 class="text-center">Στοιχεία {{number}}ου υπογραφών</h5>
    <div class="col-xs-6">
      <label :for="getSignerName">Όνομα και επώνυμο</span></label>
      <input type="text" class="form-control" :id="getSignerName" :name="getSignerName">
    </div>
    <div class="col-xs-6">
      <label :for="getSignerJob">Τίτλος Εργασίας</span></label>
      <input type="text" class="form-control" :id="getSignerJob" :name="getSignerJob" placeholder="π.χ. ΑΝΤΙΔΗΜΑΡΧΟΣ ΚΟΙΝΩΝΙΚΗΣ ΠΟΛΙΤΙΚΗΣ">
    </div>
  </div>
</div>
</template>

<script>

import autosize from 'autosize/dist/autosize.min.js';

module.exports = {
  props: ['number'],
  computed: {
    getSignerName: function() {
      return 'signer-name-'+this.number;
    },
    getSignerJob: function() {
      return 'signer-job-'+this.number;
    }
  }
}
</script>