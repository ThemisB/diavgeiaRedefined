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
      <div class="columns is-centered">
        <div class="notification is-primary is-half colum" v-if="success">
          <button class="delete"></button>
            Η απόφαση έχει αναρτηθεί στην Διαύγεια και στο SPARQL endpoint
        </div>
      </div>
      <decisions-composer></decisions-composer>
    </div>
  </section>
</div>
</template>

<script>

import DecisionsComposer from '../components/DecisionsComposer.vue'
import $ from 'jquery'
export default {
  components: {DecisionsComposer},
  mounted: function () {

    $(document).on('click', '.notification > button.delete', function() {
      $(this).parent().addClass('is-hidden');
      return false;
    });
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
