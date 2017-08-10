<template>
  <div>
    <label for="kae" v-if="number === undefined">Αριθμός ΚΑΕ</label>
    <input type="text" :name="getKaeName" class="form-control">
  </div>
</template>

<script>
export default{
  props: ['number'],
  computed: {
    getKaeName: function () {
      if (this.number !== undefined) {
        return 'expense[' + this.number + '][kae]'
      }
      return 'kae'
    }
  }
}
</script>
