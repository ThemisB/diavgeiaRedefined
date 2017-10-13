<template>
  <div class="columns noPadding">
    <div class="column">
      <label for="fek_number">Αρ. ΦΕΚ</label>
      <input name="fek_number" type="text" class="input">
    </div>
    <div class="column">
      <label for="fek_issue">Τεύχος ΦΕΚ</label>
      <multiselect id="fek_issue" v-model="selected" :options="issues" select-label="" selected-label="" deselect-label="" placeholder="">
      <span slot="noResult">Δεν βρέθηκε τεύχος</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="fek_issue" :value="selected">
    </div>
    <div class="column">
      <label for="fek_year">Έτος ΦΕΚ</label>
      <input name="fek_year" id="fek_year" maxlength="4" minlength="4" class="input" type="number">
    </div>
  </div>
</template>

<script>

import InputHandler from '../../mixins/InputHandler.js'
import Multiselect from 'vue-multiselect'

export default {
  mixins: [InputHandler],
  components: {Multiselect},
  data: () => {
    return {
      issues: ['Α', 'Β', 'Γ', 'Δ', 'Α.Α.Π.', 'Ε.Β.Ι.', 'Α.Σ.Ε.Π.', 'Δ.Δ.Σ.', 'Α.Ε.Δ.', 'Ο.Π.Κ.', 'Ν.Π.Δ.Δ.', 'Α.Π.Σ.', 'ΠΑΡΑΡΤΗΜΑ'],
      selected: ''
    }
  }
}

</script>
