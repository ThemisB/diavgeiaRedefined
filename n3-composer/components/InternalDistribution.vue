<template>
  <div>
    <label :for="getInternalDistributionLabel">{{number}}ος Αποδέκτης προς Εσωτερική Διανομή</span></label>
    <textarea class="form-control" rows="2" :id="getInternalDistributionLabel" :name="getInternalDistribution" :placeholder="getInternalDistributionPlaceholder"></textarea>
    <input type="hidden" :name="getInternalDistributionIndex" :value="number">
  </div>
</template>

<script>

module.exports = {
  props: ['number'],
  computed: {
    getInternalDistributionPlaceholder: function () {
      return 'Τα πλήρη στοιχεία του ' + this.number + 'ου αποδέκτη προς κοινοποίηση.'
    },
    getInternalDistributionLabel: function () {
      return 'internal-distr-' + this.number
    },
    getInternalDistribution: function () {
      return 'internal_distr[' + this.number + '][name]'
    },
    getInternalDistributionIndex: function () {
      return 'internal_distr[' + this.number + '][index]'
    }
  }
}
</script>
