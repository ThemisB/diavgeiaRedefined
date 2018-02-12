<template>
  <div class="column is-one-third">
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
          <a :href="visualiseLink()" target="_blank">Oπτικοποίηση</a>
        </p>
        <p class="card-footer-item">
          <span><a :href="getDownloadLink()">Κατεβάστε την απόφαση</a></span>
        </p>
      </footer>
    </div>
  </div>
</template>

<script>

import moment from 'moment'

export default {
  props: ['decision'],
  methods: {
    visualiseLink: function () {
      return 'http://localhost:3333/visualize?iun=' + this.decision.iun + '&version=' + this.decision.version
    },
    getDownloadLink: function () {
      return '/api/downloadDecision?iun=' + this.decision.iun + '&version=' + this.decision.version
    }
  },
  filters: {
    formatDate: function (value) {
      if (value) {
        return moment(String(value)).format('DD/MM/YYYY, hh:mm')
      }
    }
  }
}
</script>
