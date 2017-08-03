<template>
  <div>
    <label for="budget_category">Κατηγορία Προϋπολογισμού</label>
    <select class="selectpicker pickers" title="Κατηγορία Προϋπολογισμού" data-live-search="true" id="budget_category" name="budget_category" data-width="auto">
      <option v-for="category in categories" :data-tokens="category.keywords" :value="category.text">{{category.text}}</option>
    </select>
  </div>
</template>

<script>

import $ from 'jquery'

export default {
  data: () => {
    return {
      categories: [
        {text: 'Ίδια Έσοδα', keywords: 'Ίδια Ιδια Έσοδα Εσοδα'},
        {text: 'Πρόγραμμα Δημοσίων', keywords: 'Πρόγραμμα Προγραμμα Δημοσίων Δημοσιων'},
        {text: 'Τακτικός Προϋπολογισμός', keywords: 'Τακτικός Τακτικος Προϋπολογισμός Προϋπολογισμος Προυπολογισμος'}
      ]
    }
  },
  mounted: function () {
    $('#budget_category').selectpicker()
  }
}
</script>
