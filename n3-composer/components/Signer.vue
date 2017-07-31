<template>
  <div class="row">
    <h5 class="text-center">Στοιχεία {{number}}ου υπογραφών</h5>
    <div class="col-xs-6">
      <label :for="getSignerNameLabel">Όνομα και επώνυμο</span></label>
      <input type="text" class="form-control" :id="getSignerNameLabel" :name="getSignerName">
    </div>
    <div class="col-xs-6">
      <label :for="getSignerJobLabel">Τίτλος Εργασίας</span></label>
      <input type="text" class="form-control" :id="getSignerJobLabel" :name="getSignerJob" placeholder="π.χ. ΑΝΤΙΔΗΜΑΡΧΟΣ ΠΕΙΡΑΙΑ">
    </div>
    <input type="hidden" :name="getSignerIndex" :value="number">
  </div>
</template>

<script>

module.exports = {
  props: ['number'],
  computed: {
    getSignerNameLabel: function () {
      return 'signer-name-' + this.number
    },
    getSignerJobLabel: function () {
      return 'signer-job-' + this.number
    },
    getSignerName: function () {
      return 'signer[' + this.number + '][name]'
    },
    getSignerJob: function () {
      return 'signer[' + this.number + '][job]'
    },
    getSignerIndex: function () {
      return 'signer[' + this.number + '][index]'
    }
  }
}
</script>
