<template>
  <div class="container">
    <div class="alert alert-success alert-dismissible successfulSubmission" role="alert" v-if="success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Η απόφαση έχει αναρτηθεί στην Διαύγεια και στο SPARQL endpoint
    </div>

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
  components: {GovernmentInstitutionInfo, DecisionsComposer},
  mounted: function () {
    // On successful form submission API returns URL:?success
    let isSuccess = (function () {
      let param = 'success'
      let url = window.location.href
      param = param.replace(/[[\]]/g, '\\$&')
      let regex = new RegExp('[?&]' + param + '(=([^&#]*)|&|#|$)')
      var results = regex.exec(url)
      if (results && !results[2]) {
        return true
      }
      return false
    })()

    if (isSuccess) {
      this.success = true
      history.pushState(null, '', window.location.href.substring(0, window.location.href.indexOf('?')))
    }
  },
  data: function () {
    return {
      success: false
    }
  }
}
</script>

<style scoped>
.successfulSubmission {
  margin-top: 1.4em;
}
</style>
