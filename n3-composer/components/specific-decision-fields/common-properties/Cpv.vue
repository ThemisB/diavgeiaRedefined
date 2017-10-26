<template>
  <div>
    <label :for="getCPVName" v-if="number === undefined">CPV</label>
    <label :for="getCPVName" v-if="isPaymentFinilisation" class="label">CPV</label>
    <input type="text" :name="getCPVName" class="input">
  </div>
</template>

<script>
export default {
  props: ['number', 'isPaymentFinilisation'],
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
