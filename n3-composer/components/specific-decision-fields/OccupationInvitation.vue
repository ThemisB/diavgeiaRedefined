<template>
  <div class="decisionSpecificFields row">
    <div class="col-xs-8">
      <label for="vacancy_opening_type">Είδος Πράξης</label>
      <select class="selectpicker pickers" title="Είδος Πράξης" data-live-search="true" id="vacancy_opening_type" name="vacancy_opening_type" data-width="auto">
        <option v-for="option in options" :data-tokens="option.keywords" :value="option.text">{{option.text}}</option>
      </select>
    </div>
    <div class="col-xs-4">
      <label for="has_related_undertaking">ΑΔΑ Σχετικής Ανάληψης Υποχρέωσης</label>
      <input name="has_related_undertaking" class="form-control">
    </div>
  </div>
</template>

<script>

import $ from 'jquery'
import Fek from './common-properties/Fek.vue'

export default {
  data: () => {
    return {
      options: [
        {text: 'Προκήρυξη Εξετάσεων Άμισθων Υποθηκοφυλάκων', keywords: 'Προκήρυξη Προκηρυξη Εξετάσεων Εξετασεων Άμισθων Αμισθων Υποθηκοφυλάκων Υποθηκοφυλακων'},
        {text: 'Προκήρυξη Εξετάσεων Συμβολαιογράφων', keywords: 'Προκήρυξη Προκηρυξη Εξετάσεων Εξετασεων Συμβολαιογράφων Συμβολαιογραφων'},
        {text: 'Προκήρυξη Εξετάσεων Υποψήφιων Δικηγόρων', keywords: 'Προκήρυξη Προκηρυξη Εξετάσεων Εξετασεων Υποψήφιων Υποψηφιων Δικηγόρων Δικηγορων'},
        {text: 'Προκήρυξη Πλήρωσης Θέσεων Διδακτικού Ερευνητικού Προσωπικού (ΔΕΠ) Πανεπιστημιακού τομέα', keywords: 'Προκήρυξη Προκηρυξη Πλήρωσης Πληρωσης Θέσεων Θεσεων Διδακτικού Διδακτικου Ερευνητικού Ερευνητικου Προσωπικού Προσωπικου ΔΕΠ Πανεπιστημιακού Πανεπιστημιακου Τομέα Τομεα'},
        {text: 'Προκήρυξη Πλήρωσης Θέσεων Εκπαιδευτικού Προσωπικού (ΕΠ) Τεχνολογικού τομέα της Ανώτατης Εκπαίδευσης', keywords: 'Προκήρυξη Προκηρυξη Πλήρωσης Πληρωσης Θέσεων Θεσεων Εκπαιδευτικού Εκπαιδευτικου Προσωπικού Προσωπικου ΕΠ Τεχνολογικού Τεχνολογικου Τομέα Τομεα Της Ανώτατης Ανωτατης Εκπαίδευσης Εκπαιδευσης'},
        {text: 'Προκήρυξη Πλήρωσης Θέσεων με διαγωνισμό ή επιλογή στις οποίες περιλαμβάνονται και οι προκηρύξεις για επιλογή και πλήρωση θέσεων διευθυντικών στελεχών των ΝΠΔΔ, φορέων του ευρύτερου δημόσιου τομέα, και των επιχειρήσεων και φορέων του ΟΤΑ \'Α & \'Β βαθμού', keywords: 'Προκήρυξη Προκηρυξη Πλήρωσης Πληρωσης Θέσεων Θεσεων Διαγωνισμό Διαγωνισμο Επιλογή επιλογη ΝΠΔΔ ΟΤΑ'}
      ]
    }
  },
  mounted: function () {
    $('#vacancy_opening_type').selectpicker()
  },
  components: {Fek}
}
</script>
