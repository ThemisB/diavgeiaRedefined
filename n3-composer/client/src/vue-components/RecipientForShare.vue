<template>
  <div>
    <label :for="getRecipientForShare">{{number}}ος Αποδέκτης προς Κοινοποίηση</span></label>
    <textarea class="form-control" rows="2" :id="getRecipientForShare" :name="getRecipientForShare" :placeholder="getRecipientForSharePlaceholder"></textarea>
  </div>
</template>

<script>

import autosize from 'autosize/dist/autosize.min.js';

module.exports = {
  props: ['number'],
  computed: {
    getRecipientForSharePlaceholder: function() {
      return 'Τα πλήρη στοιχεία του '+this.number+'ου αποδέκτη προς κοινοποίηση.';
    },
    getRecipientForShare: function() {
      return 'recipient-for-share-'+this.number;
    }
  }
}
</script>