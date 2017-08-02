<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-4">
      <label for="legislative_decree_number">Αριθμός Πράξης</label>
      <input type="text" name="legislative_decree_number" class="form-control">
    </div>
    <div class="col-xs-8">
      <fek></fek>
    </div>
  </div>
</template>

<script>

import Fek from './common-properties/Fek.vue'

export default {
  components: {Fek}
}

</script>
