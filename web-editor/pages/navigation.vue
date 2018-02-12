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
      <countdown v-bind:blockchainCommitObj="blockchainCommitObj"></countdown>
      <div class="columns" v-for="i in Math.ceil(decisions.length / 3)">
        <decision v-for="decision in decisions.slice((i-1) * 3, i * 3)" v-bind:decision="decision" :key="getDecisionsCounter()"></decision>
      </div>
    </div>
  </section>
</div>
</template>

<script>

import axios from 'axios'
import Decision from '../components/navigation/Decision.vue'
import Countdown from '../components/navigation/Countdown.vue'

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
  methods: {
    getDecisionsCounter: function () {
      this.decisionsCounter++
      return 'decision_' + this.decisionsCounter
    }
  },
  async asyncData({app}) {
    const decisions = await app.$axios.$post('getdecisions')
    const blockchainCommitObj = await app.$axios.$post('getLastBlockchainCommit')
    return {decisions, blockchainCommitObj}
  },
  components: {Decision, Countdown}
}

</script>

