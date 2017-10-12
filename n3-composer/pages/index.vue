<template>
  <div>
    <section class="hero is-primary">
      <div class="hero-body">
        <div class="container">
          <div class="columns is-vcentered">
            <div class="column">
              <h1 class="title" style="display:inline-block">Συγγραφή Αποφάσεων</h1>
              <h2 class="subtitle">Δημιουργία RDF Αποφάσεων σε text editor</h2>
            </div>
            <div class="column is-narrow">
              <div class="box">
                <article class="media">
                  <div class="media-left">
                    <figure class="image is-64x64">
                      <img src="../assets/national_emblem_64.png">
                    </figure>
                  </div>
                  <div class="media-content">
                    <div class="content">
                      <p><strong style="font-size:1.2em">Διαύγεια</strong> <br> Διαφάνεια στο κράτος</p>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <section class="section is-fullheight">
    <div class="container">
      <div class="alert alert-success alert-dismissible successfulSubmission" role="alert" v-if="success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Η απόφαση έχει αναρτηθεί στην Διαύγεια και στο SPARQL endpoint
      </div>

      <form action="/api/createDecision" method="post">
        <government-institution-info></government-institution-info>
        <h2 class="has-text-centered title dvgColor" style="margin-top:0.7em;">Συγγραφή Απόφασης</h2>
        <decisions-composer></decisions-composer>
        <div class="columns">
          <div class="column has-text-centered">
            <button type="submit" class="button is-primary">Ανεβάστε την Απόφαση</button>
          </div>
        </div>
      </form>
    </div>
  </section>
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
