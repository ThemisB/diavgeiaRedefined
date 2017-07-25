<template>
  <div>
    <label :for="getInternalDistributionLabel">{{number}}ος Αποδέκτης προς Εσωτερική Διανομή</span></label>
    <textarea class="form-control" rows="2" :id="getInternalDistributionLabel" :name="getInternalDistributionLabel" :placeholder="getInternalDistributionPlaceholder"></textarea>
  </div>
</template>

<script>

import autosize from 'autosize/dist/autosize.min.js';

module.exports = {
  props: ['number'],
  computed: {
    getInternalDistributionPlaceholder: function() {
      return 'Τα πλήρη στοιχεία του '+this.number+'ου αποδέκτη προς κοινοποίηση.';
    },
    getInternalDistributionLabel: function() {
      return 'recipient-for-share-'+this.number;
    }
  }
}
</script>