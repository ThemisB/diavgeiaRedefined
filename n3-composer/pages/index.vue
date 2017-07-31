<template>
  <div class="container">
    <h1 class="text-center decisionCreation dvgColor">Δημιουργία Απόφασης Φορέα</h1>
    <form class="panel" action="/api/createDecision" method="post">
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

import GovernmentInstitutionInfo from '../components/GovernmentInstitutionInfo.vue'
import DecisionsComposer from '../components/DecisionsComposer.vue'

export default {
  components: {GovernmentInstitutionInfo, DecisionsComposer}
}
</script>
