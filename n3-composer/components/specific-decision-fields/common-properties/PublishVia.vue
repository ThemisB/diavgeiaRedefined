<template>
<div class="columns">
  <div class="column">
    <label for="publish_via">Μέσο Δημοσίευσης της Πράξης</label>
    <multiselect id="publishViaSelector" v-model="selected" :options="options" select-label="" selected-label="" deselect-label="" placeholder="">
    <span slot="noResult">Δεν βρέθηκε μέσο δημοσίευσης</span>
    </multiselect>
    <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
    <input type="hidden" name="publish_via" :value="selected">
  </div>
  <div v-if="selected === 'Στο ΦΕΚ'" class="column">
    <fek></fek>
  </div>
</div>
</template>

<script>

import Fek from './Fek.vue'
import Multiselect from 'vue-multiselect'

export default {
  data: function () {
    return {
      options: ['Ημερήσιος Τύπος', 'Ιστοσελίδα του φορέα', 'Κατάστημα της Υπηρεσίας', 'Στο ΦΕΚ'],
      selected: ''
    }
  },
  components: {Fek, Multiselect}
}

</script>
