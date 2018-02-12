<template>
  <div class="decisionSpecificFields columns">
    <div class="column">
      <normative-type></normative-type>
    </div>
    <div class="column">
      <label for="normative_number">Αριθμός Πράξης / Απόφασης</label>
      <input type="text" name="normative_number" class="input">
    </div>
    <div class="column">
      <fek></fek>
    </div>
  </div>
</template>

<script>

import NormativeType from './common-properties/NormativeType.vue'
import Fek from './common-properties/Fek.vue'

export default {
  components: {NormativeType, Fek}
}

</script>
