<template>
  <div>
    <div v-if="blockchainCommitObj">
      <h3 class="has-text-centered subtitle"><b>Blockchain Status</b>: {{blockchainCommitObj | formatDate}}</h3>
      <h4 class="has-text-centered subtitle is-6" style="padding-bottom:2em"><b>Τελευταίο Commit στο Blockchain</b>: <a :href="getLastBlockchainCommitLink(blockchainCommitObj)" target="_blank">{{blockchainCommitObj.txId}}</a> (<a href="/api/getLastMerkleTree" target="_blank">Merkle Tree</a>)</h4>
    </div>
    <div v-else>
      <h3 class="has-text-centered subtitle is-4" style="padding-bottom:2em">Δεν έχει αναρτηθεί καμία απόφαση στο <span style="color: #ff9900">Bitcoin Blockchain</span> ακόμα.</h3>
    </div>
  </div>
</template>

<script>

import axios from 'axios'
import moment from 'moment'

export default {
  props: ['blockchainCommitObj'],
  methods: {
    getLastBlockchainCommitLink: function (blockchainCommitObj) {
      return 'https://chain.so/tx/BTCTEST/' + blockchainCommitObj.txId
    }
  },
  filters: {
    formatDate: function (blockchainCommitObj) {
      if (blockchainCommitObj.lastCommit && blockchainCommitObj.blockchainPoBMinutes) {
        let lastCommitUnix = moment(String(blockchainCommitObj.lastCommit)).unix()
        let currentTime = moment().unix()
        let timeDifference = blockchainCommitObj.blockchainPoBMinutes - parseInt((currentTime - lastCommitUnix) / 60)
        if (timeDifference < 0) {
          return 'Σε αναμονή για commit στο Blockchain'
        } else if (timeDifference == 1) {
          return 'Απομένει περίπου 1 λεπτό για commit στο Blockchain'
        } else {
          return 'Απομένουν ' + timeDifference + ' λεπτά για commit στο Blockchain'
        }
      }
    }
  }
}
</script>
