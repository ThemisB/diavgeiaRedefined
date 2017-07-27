<template>
  <div>
    <label :for="getRecipientLabel">{{number}}ος Αποδέκτης</span></label>
    <textarea class="form-control" rows="2" :id="getRecipientLabel" :name="getRecipientLabel" :placeholder="getRecipientPlaceholder"></textarea>
  </div>
</template>

<script>

module.exports = {
  props: ['number'],
  computed: {
    getRecipientPlaceholder: function () {
      return 'Τα πλήρη στοιχεία του ' + this.number + 'ου αποδέκτη της Απόφασης.'
    },
    getRecipientLabel: function () {
      return 'recipient-' + this.number
    }
  }
}
</script>
