export default {
  methods: {
    isNumber (e) {
      if (!e) {
        e = window.event
      }
      var charCode = (e.which) ? e.which : e.keyCode
      if ((charCode > 31 && charCode < 48) || charCode > 57) {
        return false
      }
      return true
    }
  }
}
