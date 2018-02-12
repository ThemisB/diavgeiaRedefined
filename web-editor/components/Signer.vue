<template>
  <div>
    <h5 class="has-text-centered">Στοιχεία {{number}}ου υπογραφών</h5>
    <div class="columns">
      <div class="column">
        <label :for="getSignerNameLabel" class="label recipientsLabel has-text-centered">Όνομα και επώνυμο</span></label>
        <input type="text" class="input" :id="getSignerNameLabel" :name="getSignerName">
      </div>
      <div class="column">
        <label :for="getSignerJobLabel" class="label recipientsLabel has-text-centered">Τίτλος Εργασίας</span></label>
        <input type="text" class="input" :id="getSignerJobLabel" :name="getSignerJob" placeholder="π.χ. ΑΝΤΙΔΗΜΑΡΧΟΣ ΠΕΙΡΑΙΑ">
      </div>
      <input type="hidden" :name="getSignerIndex" :value="number">
    </div>
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
