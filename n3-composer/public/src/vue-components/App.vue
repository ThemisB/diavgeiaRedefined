<template>
  <div class="container-fluid">
    <h1 class="text-center decisionCreation">Δημιουργία Απόφασης Φορέα</h1>
    <form class="panel">
      <government-institution-info></government-institution-info>
      <h3 class="text-center">Συγγραφή Απόφασης</h3>
      <decisions></decisions>
    </form>
  </div>
</template>

<script>

import GovernmentInstitutionInfo from './GovernmentInstitutionInfo.vue'
import Decisions from './Decisions.vue'

export default{
  components: {GovernmentInstitutionInfo, Decisions}
}

</script>