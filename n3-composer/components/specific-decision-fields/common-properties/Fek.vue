<template>
  <div class="row noPadding">
    <div class="col-xs-4">
      <label for="fek_number">Αρ.ΦΕΚ</label>
      <input name="fek_number" type="text" class="form-control">
    </div>
    <div class="col-xs-4">
      <label for="fek_issue">Τεύχος ΦΕΚ</label>
      <select class="selectpicker pickers" title="Τεύχος ΦΕΚ" data-live-search="true" id="fek_issue" name="fek_issue" data-width="auto">
        <option v-for="issue in issues" :data-tokens="issue.keywords" :value="issue.text">{{issue.text}}</option>
      </select>
    </div>
    <div class="col-xs-4">
      <label for="fek_year">Έτος ΦΕΚ</label>
      <input type="text" name="fek_year" id="fek_year" maxlength="4" minlength="4" class="form-control">
    </div>
  </div>
</template>

<script>

import $ from 'jquery'
import InputHandler from '../../mixins/InputHandler.js'

export default {
  mixins: [InputHandler],
  data: () => {
    return {
      issues: [
        {text: 'Α', keywords: 'Α'},
        {text: 'Β', keywords: 'Β'},
        {text: 'Γ', keywords: 'Γ'},
        {text: 'Δ', keywords: 'Δ'},
        {text: 'Α.Α.Π.', keywords: 'Α.Α.Π. ΑΑΠ'},
        {text: 'Ε.Β.Ι.', keywords: 'Ε.Β.Ι. ΕΒΙ'},
        {text: 'Α.Σ.Ε.Π.', keywords: 'Α.Σ.Ε.Π ΑΣΕΠ'},
        {text: 'Δ.Δ.Σ.', keywords: 'Δ.Δ.Σ. ΔΔΣ'},
        {text: 'Α.Ε.Δ.', keywords: 'Α.Ε.Δ. ΑΕΔ'},
        {text: 'Ο.Π.Κ.', keywords: 'Ο.Π.Κ. ΟΠΚ'},
        {text: 'Ν.Π.Δ.Δ.', keywords: 'Ν.Π.Δ.Δ. ΝΠΔΔ'},
        {text: 'Α.Π.Σ.', keywords: 'Α.Π.Σ. ΑΠΣ'},
        {text: 'ΠΑΡΑΡΤΗΜΑ', keywords: 'Παράρτημα Παραρτημα'}
      ]
    }
  },
  mounted: function () {
    var _this = this
    $('#fek_issue').selectpicker()
    $('#fek_year').on('keypress', function (e) {
      return _this.isNumber(e)
    })
  }
}

</script>
