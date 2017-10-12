<template>
  <div class="decisionSpecificFields">
    <div class="columns">
      <div class="column">
        <h3 class="has-text-centered subtitle">Αριθμός ερωτήματος</h3>
        <textarea class="textarea" id="opinion_question_number" name="opinion_question_number" placeholder="Σε αυτό το πεδίο γράφετε τον αριθμό ερωτήματος και κείμενο που πιθανόν να το συνοδεύει."></textarea>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <h3 class="has-text-centered subtitle">Περίληψη ερωτήματος</h3>
        <textarea class="textarea" rows="2" id="opinion_summary" name="opinion_summary" placeholder="Σε αυτό το πεδίο γράφετε την περίληψη του ερωτήματος."></textarea>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <h3 class="has-text-centered subtitle">Σύντομο Ιστορικό</h3>
        <textarea class="textarea" rows="2" id="opinion_history" name="opinion_history" placeholder="Σε αυτό το πεδίο γράφετε ένα σύντομο ιστορικό που αφορά το ερωτήμα."></textarea>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <h3 class="subtitle has-text-centered">Έχοντας λάβει υπόψην</h3>
        <div id="considerationsWrapper columns">
          <consideration v-for="consideration in considerationsArray" v-bind:considerationNumber="consideration" :key="getKey('consideration', consideration)"></consideration>
        </div>
        <div class="column has-text-centered addConsiderationBtn">
          <div class="field">
              <a class="button is-info is-outlined" type="button" v-on:click="incrementConsiderations">
                <span class="icon is-small is-left">
                  <i class="fa fa-plus"></i>
                </span>
                <span>Προσθήκη {{nextConsideration}}ου "έχοντας λάβει υπόψην"</span>
              </a>
            </div>
        </div>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <h3 class="has-text-centered subtitle">Ανάλυση</h3>
        <textarea class="textarea" rows="2" id="opinion_analysis" name="opinion_analysis" placeholder="Η ανάλυση της γνωμοδότησης."></textarea>
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <h3 class="has-text-centered subtitle">Συμπέρασμα - Απάντηση</h3>
        <textarea class="textarea" rows="2" id="opinion_conclusion" name="opinion_conclusion" placeholder="Το συμπέρασμα ή και η απάντηση της γνωμοδότησης."></textarea>
      </div>
    </div>
    <div class="columns is-centered" style="padding-bottom:1em;">
      <div class="column is-half">
        <label for="opinion_government_institution_type" class="label has-text-centered">Είδος Φορέα</label>
        <multiselect title="Είδος φορέα" data-live-search="true" id="decision_type" v-model="selected" :options="opinionTypes" track-by="text" label="text" placeholder="Επιλέξτε το είδος του φορέα" :searchable="false" select-label="Πατήστε enter για επιλογή" selected-label="Επιλεγμένο" deselect-label="Πατήστε enter για αφαίρεση">
        <span slot="noResult">Δεν βρέθηκε είδος απόφασης</span>
        </multiselect>
        <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
        <input type="hidden" name="opinion_government_institution_type" :value="selected.text">
      </div>
    </div>
  </div>
</template>

<script>

import autosize from 'autosize'
import $ from 'jquery'
import Consideration from '../Consideration.vue'
import Multiselect from 'vue-multiselect'

export default {
  components: {Consideration, Multiselect},
  mounted: function () {
    this.lastConsideration = 1
    this.nextConsideration = 2
    this.considerationsArray = [this.lastConsideration]
    autosize($('#opinion_question_number'))
    autosize($('#opinion_summary'))
    autosize($('#opinion_history'))
    autosize($('#opinion_analysis'))
    autosize($('#opinion_conclusion'))
  },
  data: function () {
    return {
      opinionTypes: [
        {text: 'Ανεξάρτητη Αρχή', keywords: 'Ανεξάρτητη Ανεξαρτητη Αρχή Αρχη'},
        {text: 'ΝΣΚ', keywords: 'Νσκ'}
      ],
      lastConsideration: 0,
      nextConsideration: 1,
      considerationsArray: [],
      selected: ''
    }
  },
  methods: {
    incrementConsiderations: function () {
      this.lastConsideration++
      this.nextConsideration++
      this.considerationsArray.push(this.lastConsideration)
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  }
}
</script>
