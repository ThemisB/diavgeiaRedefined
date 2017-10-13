<template>
  <div class="decisionSpecificFields columns">
    <div class="column">
      <label for="number_employees">Αριθμός Φυσικών Προσώπων</label>
      <input type="text" name="number_employees" class="input">
    </div>
    <div class="column">
      <label for="appointment_employer_org">Φορέας που γίνεται ο διορισμός</label>
      <input type="text" name="appointment_employer_org" class="input">
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
