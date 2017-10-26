<template>
  <div>
    <label :for="getKaeName" v-if="number === undefined">Αριθμός ΚΑΕ</label>
    <label :for="getKaeName" v-if="subExpenseNumber !== undefined">Κωδικός ΚΑΕ</label>
    <input type="text" :name="getKaeName" class="input">
  </div>
</template>

<script>
export default{
  props: ['number', 'subExpenseNumber'],
  computed: {
    getKaeName: function () {
      if (this.number !== undefined) {
        if (this.subExpenseNumber !== undefined) {
          return 'expense[' + this.number + '][withKaeSubExpense][' + this.subExpenseNumber + '][kae]'
        }
        return 'expense[' + this.number + '][kae]'
      }
      return 'kae'
    }
  }
}
</script>
