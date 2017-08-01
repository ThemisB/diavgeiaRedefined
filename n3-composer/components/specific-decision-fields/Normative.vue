<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-4">
      <normative-type></normative-type>
    </div>
    <div class="col-xs-4">
      <label for="normative_number">Αριθμός Πράξης / Απόφασης</label>
      <input type="text" name="normative_number" class="form-control">
    </div>
    <div class="col-xs-4">
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
