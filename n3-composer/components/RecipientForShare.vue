<template>
  <div>
    <label :for="getRecipientForShareLabel">{{number}}ος Αποδέκτης προς Κοινοποίηση</span></label>
    <textarea class="form-control" rows="2" :id="getRecipientForShareLabel" :name="getRecipientForShare" :placeholder="getRecipientForSharePlaceholder"></textarea>
    <input type="hidden" :name="getRecipientForShareIndex" :value="number">
  </div>
</template>

<script>

module.exports = {
  props: ['number'],
  computed: {
    getRecipientForSharePlaceholder: function () {
      return 'Τα πλήρη στοιχεία του ' + this.number + 'ου αποδέκτη προς κοινοποίηση.'
    },
    getRecipientForShareLabel: function () {
      return 'recipient-for-share-' + this.number
    },
    getRecipientForShare: function () {
      return 'recipient_for_share[' + this.number + '][name]'
    },
    getRecipientForShareIndex: function () {
      return 'recipient_for_share[' + this.number + '][index]'
    }
  }
}
</script>
