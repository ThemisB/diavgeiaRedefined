<template>
  <div class="decisionSpecificFields columns" style="padding-bottom:1em">
    <div class="column">
      <label for="vacancy_opening_type">Είδος Πράξης</label>
      <multiselect v-model="selected" :options="options" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε το είδος πράξης</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="vacancy_opening_type" :value="selected">
    </div>
    <div class="column">
      <label for="has_related_undertaking">ΑΔΑ Σχετικής Ανάληψης Υποχρέωσης</label>
      <input name="has_related_undertaking" class="input">
    </div>
  </div>
</template>

<script>

import Fek from './common-properties/Fek.vue'
import Multiselect from 'vue-multiselect'

export default {
  data: () => {
    return {
      options:[ 'Προκήρυξη Εξετάσεων Άμισθων Υποθηκοφυλάκων', 'Προκήρυξη Εξετάσεων Συμβολαιογράφων', 'Προκήρυξη Εξετάσεων Υποψήφιων Δικηγόρων', 'Προκήρυξη Πλήρωσης Θέσεων Διδακτικού Ερευνητικού Προσωπικού (ΔΕΠ) Πανεπιστημιακού τομέα', 'Προκήρυξη Πλήρωσης Θέσεων Εκπαιδευτικού Προσωπικού (ΕΠ) Τεχνολογικού τομέα της Ανώτατης Εκπαίδευσης', 'Προκήρυξη Πλήρωσης Θέσεων με διαγωνισμό ή επιλογή στις οποίες περιλαμβάνονται και οι προκηρύξεις για επιλογή και πλήρωση θέσεων διευθυντικών στελεχών των ΝΠΔΔ, φορέων του ευρύτερου δημόσιου τομέα, και των επιχειρήσεων και φορέων του ΟΤΑ \'Α & \'Β βαθμού'],
      selected: ''
    }
  },
  components: {Fek, Multiselect}
}
</script>
