<template>
  <div>
    <label for="budget_category">Κατηγορία Προϋπολογισμού</label>
    <multiselect id="budget_category" v-model="selected" :options="categories" select-label="" selected-label="" deselect-label="" placeholder="">
    <span slot="noResult">Δεν βρέθηκε κατηγορία προϋπολογισμού</span>
    </multiselect>
    <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
    <input type="hidden" name="budget_category" :value="selected">
  </div>
</template>

<script>

import Multiselect from 'vue-multiselect'

export default {
  data: () => {
    return {
      categories: ['Ίδια Έσοδα', 'Πρόγραμμα Δημοσίων', 'Τακτικός Προϋπολογισμός'],
      selected: ''
    }
  },
  components: {Multiselect}
}
</script>
