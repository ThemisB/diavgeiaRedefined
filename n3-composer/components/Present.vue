<template>
  <div class="row">
    <h5 class="text-center">Στοιχεία {{number}}ου παρόντα</h5>
    <div class="col-xs-6">
      <label :for="getPresentNameLabel">Όνομα και επώνυμο</span></label>
      <input type="text" class="form-control" :id="getPresentNameLabel" :name="getPresentName">
    </div>
    <div class="col-xs-6">
      <label :for="getPresentRoleLabel">Ρόλος Παρόντα</span></label>
      <input type="text" class="form-control" :id="getPresentRoleLabel" :name="getPresentRole" placeholder="π.χ. ΜΕΛΟΣ ΕΠΙΤΡΟΠΗΣ">
    </div>
    <input type="hidden" :name="getPresentIndex" :value="number">
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
