<template>
  <div>
    <h5 class="has-text-centered">Στοιχεία {{number}}ου παρόντα</h5>
    <div class="columns">
      <div class="column">
        <label :for="getPresentNameLabel" class="label has-text-centered recipientsLabel">Όνομα και επώνυμο</span></label>
        <input type="text" class="input" :id="getPresentNameLabel" :name="getPresentName">
      </div>
      <div class="column">
        <label :for="getPresentRoleLabel" class="label has-text-centered recipientsLabel">Ρόλος Παρόντα</span></label>
        <input type="text" class="input" :id="getPresentRoleLabel" :name="getPresentRole" placeholder="π.χ. ΜΕΛΟΣ ΕΠΙΤΡΟΠΗΣ">
      </div>
      <input type="hidden" :name="getPresentIndex" :value="number">
    </div>
  </div>
</template>

<script>

module.exports = {
  props: ['number'],
  computed: {
    getPresentNameLabel: function () {
      return 'present-name-' + this.number
    },
    getPresentRoleLabel: function () {
      return 'present-role-' + this.number
    },
    getPresentName: function () {
      return 'present[' + this.number + '][name]'
    },
    getPresentRole: function () {
      return 'present[' + this.number + '][role]'
    },
    getPresentIndex: function () {
      return 'present[' + this.number + '][index]'
    }
  }
}
</script>
