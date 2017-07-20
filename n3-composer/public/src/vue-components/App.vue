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
import autosize from 'autosize/dist/autosize.min.js';

module.exports = {
  components: {GovernmentInstitutionInfo, Decisions},
  mounted: () => {
    autosize($('textarea'));
  }
}

</script>