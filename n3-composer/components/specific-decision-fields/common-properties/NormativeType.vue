<template>
  <div>
    <label for="normative_type">Τύπος Πράξης</label>
    <multiselect v-model="selected" :options="normativeTypes" select-label="" selected-label="" deselect-label="" placeholder="">
    <span slot="noResult">Δεν βρέθηκε ο τύπος πράξης</span>
    </multiselect>
    <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
    <input type="hidden" name="normative_type" :value="selected">
  </div>
</template>

<script>

import Multiselect from 'vue-multiselect'

export default {
  data: () => {
    return {
      normativeTypes: ['Προεδρικό Διάταγμα', 'Πράξη Πρωθυπουργού', 'Κοινή Υπουργική Απόφαση','Υπουργική Απόφαση','Πράξη Ανεξάρτητης Αρχής', 'Πράξη Γενικού / Ειδικού Γραμματέα Υπουργείου', 'Πράξη Γενικού Γραμματέα Αποκεντρωμένης Διοίκησης', 'Πράξη Οργάνου Διοίκησης Ν.Π.Δ.Δ.', 'Πράξη Οργάνου Διοίκησης ΟΤΑ Α\' και Β\' Βαθμού (και εποπτευόμενων φορέων τους)', 'Πράξη Οργάνου Διοίκησης Φορέων Ευρύτερου Δημοσίου Τομέα', 'Πράξη Προέδρου της Δημοκρατίας', 'Πράξη Ρυθμιστικής Αρχής', 'Πράξη Συλλογικού Κυβερνητικού Οργάνου', 'Διϋπουργική Απόφαση(ΔΕΕΑ)', 'Πράξη Υπουργού, Αναπληρωτή Υπουργού, Υφυπουργού'],
      selected:''
    }
  },
  components: {Multiselect}
}

</script>
