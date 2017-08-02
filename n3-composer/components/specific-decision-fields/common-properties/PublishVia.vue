<template>
  <div>
  <div class="col-xs-6">
    <label for="publish_via">Μέσο Δημοσίευσης της Πράξης</label>
    <select class="selectpicker pickers" title="Τύπος Πράξης" data-live-search="true" id="publishViaSelector" name="publish_via" data-width="auto" v-model="selected">
      <option v-for="option in options" :data-tokens="option.keywords" :value="option.text">{{option.text}}</option>
    </select>
  </div>
  <div v-if="selected === 'Στο ΦΕΚ'" class="col-xs-6">
    <fek></fek>
  </div>
</div>
</template>

<script>

import $ from 'jquery'
import Fek from './Fek.vue'

export default {
  data: function () {
    return {
      options: [
        {text: 'Ημερήσιος Τύπος', keywords: 'Ημερήσιος Ημερησιος Τύπος Τυπος'},
        {text: 'Ιστοσελίδα του φορέα', keywords: 'Ιστοσελίδα Ιστοσελιδα Φορέα Φορεα Του'},
        {text: 'Κατάστημα της Υπηρεσίας', keywords: 'Κατάστημα Καταστημα Υπηρεσίας Υπηρεσιας Της'},
        {text: 'Στο ΦΕΚ', keywords: 'ΦΕΚ Στο'}
      ],
      selected: ''
    }
  },
  mounted: function () {
    $('#publishViaSelector').selectpicker()
  },
  components: {Fek}
}

</script>
