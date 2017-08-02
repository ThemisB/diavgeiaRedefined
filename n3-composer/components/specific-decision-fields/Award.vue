<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-10 col-xs-offset-1">
     <expense-award></expense-award>
    </div>
  </div>
</template>

<script>

import ExpenseAward from './common-properties/ExpenseAward.vue'

export default {
  components: {ExpenseAward}
}

</script>
