<template>
  <div class="notification">
    <h5 class="has-text-centered subtitle">{{number}}ος έλεγχος</h5>
    <div class="columns" v-for="verifier, verifierIndex in verifiers" :key="getKey('verifier', verifier)">
      <div class="column">
        <label :for="getVerifierName(verifierIndex)" class="label has-text-centered recipientsLabel">Όνομα και επώνυμο ελεγκτή</span></label>
        <input type="text" class="input" :name="getVerifierName(verifierIndex)">
      </div>
      <div class="column">
        <label :for="getVerifierRole(verifierIndex)" class="label has-text-centered recipientsLabel">Εργασία/Ρόλος ελεγκτή</span></label>
        <input type="text" class="input" :name="getVerifierRole(verifierIndex)" placeholder="π.χ. ΠΡΟΪΣΤΑΜΕΝΟΣ ΟΙΚΟΝΟΜΙΚΩΝ">
      </div>
    </div>
    <div class="columns">
      <div class="column">
        <label :for="getVerificationText" class="label">Κείμενο Ελέγχου</label>
        <textarea :class="getVerificationTextareaClass" rows="2" placeholder="Κείμενο για τον έλεγχο που πραγματοποιήθηκε." :name="getVerificationText"></textarea>
      </div>
    </div>
    <div class="columns has-text-centered">
      <div class="column">
        <div class="paddingRecipients">
          <div class="field">
            <a class="button is-primary is-outlined" type="button" v-on:click="incrementVerifiers">
              <span class="icon is-small is-left">
                <i class="fa fa-plus"></i>
              </span>
              <span>{{nextVerifier}}ος ελεγκτής</span>
            </a>
          </div>
        </div>
        <input type="hidden" :name="getVerificationNumber" :value="number">
      </div>
    </div>
  </div>
</template>

<script>

import $ from 'jquery'
import autosize from 'autosize'

export default {
  props: ['number'],
  computed: {
    getVerificationNumber: function () {
      return 'verification[' + this.number + '][index]'
    },
    getVerificationText: function () {
      return 'verification[' + this.number + '][has_text]'
    },
    getVerificationTextareaClass: function () {
      return 'textarea has-text-verification-' + this.number
    }
  },
  data: function(){
    return {
      verifiers: [],
      lastVerifier: 0,
      nextVerifier: 1,
    }
  },
  methods: {
    incrementVerifiers: function () {
      this.lastVerifier++
      this.nextVerifier++
      this.verifiers.push(this.lastVerifier)
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    },
    getVerifierName: function (verifierIndex) {
      return 'verification[' + this.number + '][' + verifierIndex + '][signer_name]'
    },
    getVerifierRole: function (verifierIndex) {
      return 'verification[' + this.number + '][' + verifierIndex + '][signer_job]'
    }
  },
  mounted: function () {
    this.lastVerifier = 1
    this.nextVerifier = 2
    this.verifiers = [this.verifiers]
    let _this = this
    autosize($('.has-text-verification-' + _this.number))
  }
}
</script>
