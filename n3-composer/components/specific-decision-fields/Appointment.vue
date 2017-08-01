<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-4">
      <label for="number_employees">Αριθμός Φυσικών Προσώπων</label>
      <input type="text" name="number_employees" class="form-control">
    </div>
    <div class="col-xs-4">
      <label for="appointment_employer_org">Φορέας που γίνεται ο διορισμός</label>
      <input type="text" name="appointment_employer_org" class="form-control">
    </div>
    <div class="col-xs-4">
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
