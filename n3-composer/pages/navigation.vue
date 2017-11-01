<template>
  <div>
    <section class="hero is-primary">
      <div class="hero-body">
        <div class="container">
          <div class="columns is-vcentered">
            <div class="column">
              <h1 class="title" style="display:inline-block">Περιήγηση στις αποφάσεις της Διαύγειας</h1>
              <h2 class="subtitle"><i class="fa fa-clock-o" aria-hidden="true"></i> και countdown για εισαγωγή στο blockchain</h2>
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
      <div v-for="decision in decisions">
        <div class="columns" v-if="decisionsCounter % 3 === 0">
          <decision v-bind:decision="decision"></decision>
        </div>
        <div v-else>
          <decision></decision>
        </div>
      </div>
    </div>
  </section>
</div>
</template>

<script>

import axios from 'axios'
import Decision from '../components/navigation/Decision.vue'

export default {
  head() {
    return {
      title: 'Περιήγηση Αποφάσεων',
    }
  },
  data: function ()  {
    return {
      decisionsCounter: 0
    }
  },
  async asyncData({app}) {
    const decisions = await app.$axios.$post('getdecisions')
    return {decisions}
  },
  components: {Decision}
}

</script>

