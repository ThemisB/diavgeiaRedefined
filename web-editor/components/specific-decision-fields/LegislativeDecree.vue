<template>
  <div class="decisionSpecificFields columns">
    <div class="column">
      <label for="legislative_decree_number">Αριθμός Πράξης</label>
      <input type="text" name="legislative_decree_number" class="input">
    </div>
    <div class="column">
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
