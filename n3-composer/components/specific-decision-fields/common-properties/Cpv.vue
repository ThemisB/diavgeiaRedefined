<template>
  <div>
    <label for="cpv" v-if="number === undefined">CPV</label>
    <input type="text" :name="getCPVName" class="form-control">
  </div>
</template>

<script>
export default {
  props: ['number'],
  computed: {
    getCPVName: function () {
      if (this.number !== undefined) {
        return 'expense[' + this.number + '][cpv]'
      }
      return 'cpv'
    }
  }
}
</script>
