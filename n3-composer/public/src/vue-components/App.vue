<template>
  <div class="container-fluid">
    <h1 class="text-center decisionCreation dvgColor">Δημιουργία Απόφασης Φορέα</h1>
    <form class="panel">
      <government-institution-info></government-institution-info>
      <h2 class="text-center dvgColor">Συγγραφή Απόφασης</h2>
      <decisions-composer></decisions-composer>
      <div class="row">
        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-md">Ανεβάστε την Απόφαση</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>

import GovernmentInstitutionInfo from './GovernmentInstitutionInfo.vue'
import DecisionsComposer from './DecisionsComposer.vue'

module.exports = {
  components: {GovernmentInstitutionInfo, DecisionsComposer}
}

</script>