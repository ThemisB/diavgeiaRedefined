<template>
  <div>
    <h3 class="has-text-centered subtitle" style="padding-bottom:2em"><b>Blockchain Status</b>: {{blockchainCommitObj | formatDate}}</h3>
  </div>
</template>

<script>

import axios from 'axios'
import moment from 'moment'

export default {
  props: ['blockchainCommitObj'],
  methods: {
    visualiseLink: function () {
      return 'localhost:3333/visualize?iun=' + this.decision.iun + '&version=' + this.decision.version
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
