<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-8">
      <label for="record_subject">Θέμα</label>
      <textarea class="form-control" rows="2" id="record_subject" name="record_subject" placeholder="Το θέμα του εγγράφου"></textarea>
    </div>
    <div class="col-xs-4">
      <label for="record_number">Αριθμός Πρακτικού</label>
      <input class="form-control" type="text" id="record_number" name="record_number"></input>
    </div>
  </div>
</template>

<script>

import $ from 'jquery'
import autosize from 'autosize'

export default {
  mounted: function () {
    autosize($('#record_subject'))
  }
}
</script>
