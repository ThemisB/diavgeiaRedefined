<template>
  <div class="decisionSpecificFields">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <h3 class="text-center"><u>Αριθμός ερωτήματος</u></h3>
        <textarea class="form-control" rows="2" id="opinion_question_number" name="opinion_question_number" placeholder="Σε αυτό το πεδίο γράφετε τον αριθμό ερωτήματος και κείμενο που πιθανόν να το συνοδεύει."></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <h3 class="text-center"><u>Περίληψη ερωτήματος</u></h3>
        <textarea class="form-control" rows="2" id="opinion_summary" name="opinion_summary" placeholder="Σε αυτό το πεδίο γράφετε την περίληψη του ερωτήματος."></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <h3 class="text-center"><u>Σύντομο Ιστορικό</u></h3>
        <textarea class="form-control" rows="2" id="opinion_history" name="opinion_history" placeholder="Σε αυτό το πεδίο γράφετε ένα σύντομο ιστορικό που αφορά το ερωτήμα."></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <h3 class="text-center"><u>Ανάλυση</u></h3>
        <textarea class="form-control" rows="2" id="opinion_analysis" name="opinion_analysis" placeholder="Η ανάλυση της γνωμοδότησης."></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <h3 class="text-center"><u>Συμπέρασμα - Απάντηση</u></h3>
        <textarea class="form-control" rows="2" id="opinion_conclusion" name="opinion_conclusion" placeholder="Το συμπέρασμα ή και η απάντηση της γνωμοδότησης."></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2">
        <label for="opinion_government_institution_type">Είδος Φορέα</label>
        <select class="selectpicker pickers" title="Είδος Φορέα" data-live-search="true" id="opinion_government_institution_type" name="opinion_government_institution_type" data-width="auto">
          <option v-for="opinionType in opinionTypes" :data-tokens="opinionType.keywords" :value="opinionType.text">{{opinionType.text}}</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>

import autosize from 'autosize'
import $ from 'jquery'

export default {
  mounted: function () {
    autosize($('#opinion_question_number'))
    autosize($('#opinion_summary'))
    autosize($('#opinion_history'))
    autosize($('#opinion_analysis'))
    autosize($('#opinion_conclusion'))
    $('#opinion_government_institution_type').selectpicker()
  },
  data: function () {
    return {
      opinionTypes: [
        {text: 'Ανεξάρτητη Αρχή', keywords: 'Ανεξάρτητη Ανεξαρτητη Αρχή Αρχη'},
        {text: 'ΝΣΚ', keywords: 'Νσκ'}
      ]
    }
  }
}
</script>
