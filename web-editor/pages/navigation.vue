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
        <div v-for="decision in decisions.slice((i-1) * 3, i * 3)" class="column is-one-third">
          <div class="card">
            <div class="card-content">
                <p class="title is-4 has-text-centered" style="padding-bottom:0.3em">{{decision.title}}</p>
                <p class="subtitle is-6">
                  <div style="padding-bottom:0.3em"><span class="tag">ΑΔΑ</span>:&nbsp;{{decision.iun}} </div>
                  <div style="padding-bottom:0.3em"><span class="tag"> Version</span>:&nbsp;{{decision.version}} </div>
                  <div><span class="tag">Ημερομηνία ανάρτησης</span>:&nbsp; <time>{{decision.date | formatDate}}</time></div>
                  <div class="has-text-centered" style="padding-top:1em" v-if="decision.txIndex || decision.txIndex === 0"><i class="fa fa-btc btcColor"></i><span style="font-size:1.1em"><b>-secured</b></span></div>
                </p>
            </div>
            <footer class="card-footer">
              <p class="card-footer-item">
                <a :href="visualiseLink(decision)" target="_blank">Oπτικοποίηση</a>
              </p>
              <p class="card-footer-item">
                <span><a :href="getDownloadLink(decision)">Κατεβάστε την απόφαση</a></span>
              </p>
            </footer>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
</template>

<script>

import axios from 'axios'
import Countdown from '../components/navigation/Countdown.vue'
import moment from 'moment'

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
    },
    visualiseLink: function (decision) {
      return 'http://localhost:3333/visualize?iun=' + decision.iun + '&version=' + decision.version
    },
    getDownloadLink: function (decision) {
      return '/api/downloadDecision?iun=' + decision.iun + '&version=' + decision.version
    }
  },
  filters: {
    formatDate: function (value) {
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY, hh:mm')
      }
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

