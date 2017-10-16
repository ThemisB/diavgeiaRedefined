<template>
  <div>
      <div class="columns is-centered">
        <div class="column is-half has-text-centered">
            <div class="field">
              <label for="title" class="label">Τίτλος Απόφασης</label>
                <div class="control">
                  <textarea class="textarea" id="title" rows="1" name="title" placeholder="π.χ. Ανάκληση βεβαίωσης παροχέα υπηρεσιών καταδύσεων αναψυχής" required="required"></textarea>
                </div>
            </div>
          </div>
        </div>
        <div class="columns is-centered">
          <div class="column is-two-thirds">
            <div class="field">
              <label for="protocol_number" class="label">Αριθμός Πρωτοκόλλου</label>
              <input type="text" class="input" id="protocol_number" name="protocol_number" required="required">
            </div>
          </div>
          <div class="private-data column is-one-third has-text-centered">
            <div class="field">
              <label for="has_private_data" class="checkbox" style="display:inline-block">Απόφαση με Προσωπικά Δεδομένα&nbsp;<input id="has_private_data" name="has_private_data" type="checkbox"></label>
            </div>
          </div>
        </div>
      <div class="columns">
        <div class="column is-half">
          <label for="decision_type" class="label">Επιλέξτε το είδος της Απόφασης</label>
          <multiselect title="Επιλέξτε το είδος απόφασης" data-live-search="true" id="decision_type"  data-width="auto" required="required" v-model="selected" :options="DecisionTypes" group-values="data" group-label="label" track-by="text" label="text" placeholder="Επιλέγετε 1 είδος απόφασης" select-label="Πατήστε enter για επιλογή" selected-label="Επιλεγμένο" deselect-label="Πατήστε enter για αφαίρεση">
          <span slot="noResult">Δεν βρέθηκε είδος απόφασης</span>
          </multiselect>
          <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
          <input type="hidden" name="decision_type" :value="selected.value">
        </div>
        <thematic-categories></thematic-categories>
      </div>
      <div class="decisions-composer">
        <div v-if="selected.value !== 'Opinion'">
          <div class="columns">
            <div class="column">
              <h3 class="has-text-centered subtitle">Εισαγωγικό Κείμενο Απόφασης</h3>
              <textarea class="textarea" id="preconsideration" name="preconsideration" placeholder="Σε αυτό το πεδίο γράφετε προαιρετικά ένα εισαγωγικό κείμενο της απόφασης, χωρίς να λαμβάνετε υπόψην την ελληνική νομοθεσία"></textarea>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <h3 class="subtitle has-text-centered">Έχοντας λάβει υπόψην</h3>
              <div id="considerationsWrapper">
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
            <div class="columns is-centered">
              <div class="column is-half">
                <h3 class="subtitle has-text-centered">Αποφάσεις</h3>
                <div class="field">
                  <label for="decision_call" class="label has-text-centered">Προσφώνηση Απόφασης</label>
                  <input type="text" name="decision_call" id="decision_call" placeholder="π.χ. Αποφασίζουμε, Ανακαλούμε, ..." class="input" required="required">
                </div>
              </div>
            </div>

            <div id="decisionsWrapper columns">
              <decision v-for="decision in decisionsArray" v-bind:decisionNumber="decision" :key="getKey('decision', decision)"></decision>
            </div>
            <div class="column has-text-centered addDecisionsBtn">
              <div class="field">
                <a class="button is-info is-outlined" type="button" v-on:click="incrementDecisions">
                  <span class="icon is-small is-left">
                    <i class="fa fa-plus"></i>
                  </span>
                  <span> Προσθήκη {{nextDecision}}ης Απόφασης</span>
                </a>
              </div>
            </div>
          <div class="columns is-centered">
            <div class="column">
              <h3 class="subtitle has-text-centered">Επίλογος Απόφασης</h3>
              <textarea class="textarea" id="afterconsideration" name="afterconsideration" placeholder="Σε αυτό το πεδίο γράφετε προαιρετικά τον επίλογο της απόφασης."></textarea>
            </div>
          </div>
          <div v-if="!ifInGeneralDecisionsArray(selected.value)">
            <decision-specific-fields v-bind:selected="selected.value"></decision-specific-fields>
          </div>
        </div>
        <div v-else>
          <opinion></opinion>
        </div>
        <h2 class="has-text-centered subtitle">Αποδέκτες</h2>
        <div class="columns" id="allRecipients">
          <div id="recipientsWrapper" class="column">
            <h4 class="has-text-centered">Αποδέκτες Απόφασης</h4>
            <recipient v-for="recipient in recipientsArray" v-bind:number="recipient" :key="getKey('recipient', recipient)"></recipient>
            <div class="paddingRecipients has-text-centered">
              <div class="field">
                <a class="button is-info is-outlined" type="button" v-on:click="incrementRecipients">
                  <span class="icon is-small is-left">
                    <i class="fa fa-plus"></i>
                  </span>
                  <span>{{nextRecipient}}ος αποδέκτης</span>
                </a>
              </div>
            </div>
          </div>
          <div id="recipientsShareWrapper" class="column">
            <h4 class="has-text-centered">Αποδέκτες προς Κοινοποίηση</h4>
            <recipient-for-share v-for="recipientshare in recipientForShareArray" v-bind:number="recipientshare" :key="getKey('recipientshare', recipientshare)"></recipient-for-share>
            <div class="paddingRecipients has-text-centered">
              <div class="field">
                <a class="button is-info is-outlined" type="button" v-on:click="incrementRecipientsForShare">
                  <span class="icon is-small is-left">
                    <i class="fa fa-plus"></i>
                  </span>
                  <span>{{nextRecipientForShare}}ος αποδέκτης</span>
                </a>
              </div>
            </div>
          </div>
          <div id="internalDistributionWrapper" class="column">
            <h4 class="has-text-centered">Εσωτερική Διανομή</h4>
            <internal-distribution v-for="internaldistr in internalDistributionArray" v-bind:number="internaldistr" :key="getKey('internaldistr', internaldistr)"></internal-distribution>
            <div class="paddingRecipients has-text-centered">
              <div class="field">
                <a class="button is-info is-outlined" type="button" v-on:click="incrementInternalDistribution">
                  <span class="icon is-small is-left">
                    <i class="fa fa-plus"></i>
                  </span>
                  <span>{{nextInternalDistribution}}ος αποδέκτης</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <h2 class="has-text-centered subtitle">Υπογράφοντες &amp; Παρόντες</h2>
        <div class="columns">
          <div id="signersWrapper" class="column">
            <h4 class="has-text-centered subtitle">Οι Υπογραφόντες</h4>
            <signer v-for="signer in signersArray" v-bind:number="signer" :key="getKey('signer', signer)"></signer>
            <div class="paddingRecipients has-text-centered">
              <div class="field">
                <a class="button is-info is-outlined" type="button" v-on:click="incrementSigner">
                  <span class="icon is-small is-left">
                    <i class="fa fa-plus"></i>
                  </span>
                  <span>{{nextSigner}}ος υπογραφών</span>
                </a>
              </div>
            </div>
          </div>
          <div id="present" class="column">
            <h4 class="has-text-centered subtitle">Ήταν παρόντες στην απόφαση</h4>
            <present v-for="present in presentsArray" v-bind:number="present" :key="getKey('present', present)"></present>
            <div class="paddingRecipients has-text-centered">
              <div class="field">
                <a class="button is-info is-outlined" type="button" v-on:click="incrementPresent">
                  <span class="icon is-small is-left">
                    <i class="fa fa-plus"></i>
                  </span>
                  <span>{{nextPresent}}ος παρόντας</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <h4 class="has-text-centered subtitle">Η απόφαση ελέγχθηκε από:</h4>
            <verification v-for="verification in verificationsArray" v-bind:number="verification" :key="getKey('verification', verification)"></verification>
            <div class="paddingRecipients has-text-centered">
              <div class="field">
                <a class="button is-info is-outlined" type="button" v-on:click="incrementVerifications">
                  <span class="icon is-small is-left">
                    <i class="fa fa-plus"></i>
                  </span>
                  <span>{{nextVerification}}ος έλεγχος</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import ThematicCategories from './ThematicCategories.vue'
import Consideration from './Consideration.vue'
import Decision from './Decision.vue'
import Recipient from './Recipient.vue'
import RecipientForShare from './RecipientForShare.vue'
import InternalDistribution from './InternalDistribution.vue'
import Present from './Present.vue'
import Signer from './Signer.vue'
import DecisionSpecificFields from './DecisionSpecificFields.vue'
import $ from 'jquery'
import autosize from 'autosize'
import Multiselect from 'vue-multiselect'
import Opinion from './specific-decision-fields/Opinion.vue'
import Verification from './Verification.vue'

export default {
  components: {ThematicCategories, Consideration, Decision, Recipient, RecipientForShare, InternalDistribution, Signer, Present, DecisionSpecificFields, Multiselect, Opinion, Verification},
  mounted: function () {
    this.lastConsideration = 1
    this.nextConsideration = 2
    this.considerationsArray = [this.lastConsideration]
    this.lastVerification = 1
    this.nextVerification = 2
    this.verificationsArray = [this.lastVerification]
    this.lastDecision = 1
    this.nextDecision = 2
    this.decisionsArray = [this.lastDecision]
    this.lastRecipient = 1
    this.nextRecipient = 2
    this.recipientsArray = [this.lastRecipient]
    this.lastRecipientForShare = 1
    this.nextRecipientForShare = 2
    this.recipientForShareArray = [this.lastRecipientForShare]
    this.lastInternalDistribution = 1
    this.nextInternalDistribution = 2
    this.internalDistributionArray = [this.lastInternalDistribution]
    this.lastSigner = 1
    this.nextSigner = 2
    this.signersArray = [this.lastSigner]
    this.lastPresent = 1
    this.nextPresent = 2
    this.presentsArray = [this.lastPresent]
    autosize($('#afterconsideration'))
    autosize($('#preconsideration'))
    autosize($('#title'))
  },
  data: function () {
    return {
      selected: '',
      generalDecisions: ['InvestmentPlacing', 'DevelopmentLawContract', 'DisciplinaryAcquitance', 'EvaluationReportOfLaw', 'PublicPrototypeDocuments', 'StartProductionalFunctionOfInvestment'],
      DecisionTypes: [
        {
          data: [
            {text: 'ΝΟΜΟΣ', value: 'Law', keywords: 'Νόμος Νομος'},
            {text: 'ΠΡΑΞΗ ΝΟΜΟΘΕΤΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ (Σύνταγμα, άρθρο 44, παρ 1)', value: 'LegislativeDecree', keywords: 'Πράξη Πραξη Νομοθετικού Νομοθετικου Περιεχομένου Περιεχομενου Σύνταγμα Συνταγμα Άρθρο αρθρο παρ 44 1'},
            {text: 'ΚΑΝΟΝΙΣΤΙΚΗ ΠΡΑΞΗ', value: 'Normative', keywords: 'Κανονιστική Κανονιστικη Πράξη Πραξη'},
            {text: 'ΕΓΚΥΚΛΙΟΣ', value: 'Circular', keywords: 'Εγκύκλιος Εγκυκλιος'},
            {text: 'ΠΡΑΚΤΙΚΑ (Νομικού Συμβουλίου του Κράτους)', value: 'Records', keywords: 'Πρακτικά Πρακτικα Νομικού Νομικου Συμβουλίου Συμβολιου Κράτους Κρατους Του'},
            {text: 'ΕΚΘΕΣΗ ΑΠΟΤΙΜΗΣΗΣ ΓΙΑ ΤΗΝ ΚΑΤΑΣΤΑΣΗ ΤΗΣ ΥΦΙΣΤΑΜΕΝΗΣ ΝΟΜΟΘΕΣΙΑΣ', value: 'EvaluationReportOfLaw', keywords: 'Έκθεση Εκθεση Αποτίμησης Αποτιμησης Κατάσταση Κατασταση Υφιστάμενης Υφισταμενης Για Την Της'},
            {text: 'ΓΝΩΜΟΔΟΤΗΣΗ', value: 'Opinion', keywords: 'Γνωμοδότηση Γνωμοδοτηση'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΚΑΝΟΝΙΣΤΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ, ΕΓΚΥΚΛΙΟΙ, ΓΝΩΜΟΔΟΤΗΣΕΙΣ'
        },

        {
          data: [
            {text: 'ΕΓΚΡΙΣΗ ΠΡΟΫΠΟΛΟΓΙΣΜΟΥ', value: 'BudgetApproval', keywords: 'Έγκριση Εγκριση Προϋπολογισμού Προϋπολογισμου Προυπολογισμού Προυπολογισμου'},
            {text: 'ΑΝΑΛΗΨΗ ΥΠΟΧΡΕΩΣΗΣ', value: 'Undertaking', keywords: 'Ανάληψη Αναληψη Υποχρέωσης Υποχρεωσης'},
            {text: 'ΕΓΚΡΙΣΗ ΔΑΠΑΝΗΣ', value: 'ExpenditureApproval', keywords: 'Έγκριση Εγκριση Δαπάνης Δαπανης'},
            {text: 'ΟΡΙΣΤΙΚΟΠΟΙΗΣΗ ΠΛΗΡΩΜΗΣ', value: 'PaymentFinalisation', keywords: 'Οριστικοποίηση Οριστικοποιηση Πληρωμής Πληρωμης'},
            {text: 'ΕΠΙΤΡΟΠΙΚΟ ΕΝΤΑΛΜΑ', value: 'CommisionWarrant', keywords: 'Επιτροπικό Επιτροπικο Ένταλμα Ενταλμα'},
            {text: 'ΙΣΟΛΟΓΙΣΜΟΣ - ΑΠΟΛΟΓΙΣΜΟΣ', value: 'BalanceAccount', keywords: 'Ισολογισμός Ισολογισμος Απολογισμός Απολογισμος'},
            {text: 'ΔΩΡΕΑ - ΕΠΙΧΟΡΗΓΗΣΗ', value: 'DonationGrant', keywords: 'Δωρεά Δωρεα Επιχορήγηση Επιχορηγηση'},
            {text: 'ΠΑΡΑΧΩΡΗΣΗ ΧΡΗΣΗΣ ΠΕΡΙΟΥΣΙΑΚΩΝ ΣΤΟΙΧΕΙΩΝ', value: 'OwnershipTransferOfAssets', keywords: 'Παραχώρηση Παραχωρηση Χρήσης Χρησης Περιουσιακών Περιουσιακων Στοιχείων Στοιχειων'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΟΙΚΟΝΟΜΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ'
        },

        {
          data: [
            {text: 'ΔΙΟΡΙΣΜΟΣ', value: 'Appointment', keywords: 'Διορισμός Διορισμος'},
            {text: 'ΠΙΝΑΚΕΣ ΕΠΙΤΥΧΟΝΤΩΝ, ΔΙΟΡΙΣΤΕΩΝ & ΕΠΙΛΑΧΟΝΤΩΝ', value: 'SuccessfulAppointedRunnerUpList', keywords: 'Πίνακες Πινακες Επιτυχόντων Επιτυχοντων Διοριστέων Διοριστεων Επιλαχόντων Και'},
            {text: 'ΠΡΑΞΗ ΠΟΥ ΑΦΟΡΑ ΣΕ ΘΕΣΗ ΓΕΝΙΚΟΥ - ΕΙΔΙΚΟΥ ΓΡΑΜΜΑΤΕΑ - ΜΟΝΟΜΕΛΕΣ ΟΡΓΑΝΟ', value: 'GeneralSpecialSecretaryMonocraticBody', keywords: 'Πράξη Πραξη Αφορά Αφορα Θέση Θεση Γενικού Γενικου Ειδικού Ειδικού Γραμματέα Γραμματεα Μονομελές Μονομελες Όργανο Όργανο Που Σε'},
            {text: 'ΠΡΑΞΗ ΠΟΥ ΑΦΟΡΑ ΣΕ ΣΥΛΛΟΓΙΚΟ ΟΡΓΑΝΟ - ΕΠΙΤΡΟΠΗ - ΟΜΑΔΑ ΕΡΓΑΣΙΑΣ - ΟΜΑΔΑ ΕΡΓΟΥ - ΜΕΛΗ ΣΥΛΛΟΓΙΚΟΥ ΟΡΓΑΝΟΥ', value: 'CollegialBodyCommisionWorkingGroup', keywords: 'Πράξη Πραξη Αφορά Αφορα Συλλογικό Συλλογικο Όργανο Οργανο Επιτροπή Επιτροπη Ομάδα Ομαδα Εργασίας Εργασιας Έργου Εργου Συλλογικού Συλλογικου Οργάνου Οργανου'},
            {text: 'ΠΡΟΚΗΡΥΞΗ ΠΛΗΡΩΣΗΣ ΘΕΣΕΩΝ', value: 'OccupationInvitation', keywords: 'Προκήρυξη Προκηρυξη Πλήρωσης Πληρωσης Θέσεων Θεσεων'},
            {text: 'ΣΥΜΒΑΣΗ', value: 'Contract', keywords: 'Σύμβαση Συμβαση'},
            {text: 'ΥΠΗΡΕΣΙΑΚΗ ΜΕΤΑΒΟΛΗ', value: 'ServiceChange', keywords: 'Υπηρεσιακή Υπηρεασιακη Μεταβολή Μεταβολη'},
            {text: 'ΑΘΩΩΤΙΚΗ ΠΕΙΘΑΡΧΙΚΗ ΑΠΟΦΑΣΗ', value: 'DisciplinaryAcquitance', keywords: 'Αθωωτική Αθωωτικη Πειθαρχική Πειθαρχικη Απόφαση Αποφαση'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΟΡΓΑΝΩΤΙΚΟΥ ΚΑΙ ΔΙΟΙΚΗΤΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ'
        },

        {
          data: [
            {text: 'ΑΠΟΦΑΣΗ ΕΝΑΡΞΗΣ ΠΑΡΑΓΩΓΙΚΗΣ ΛΕΙΤΟΥΡΓΙΑΣ ΕΠΕΝΔΥΣΗΣ', value: 'StartProductionalFunctionOfInvestment', keywords: 'Απόφαση Αποφαση Έναρξης Εναρξης Παραγωγική Παραγωγικης Λειτουργίας Λειτουργιας Επένδυσης Επενδυσης'},
            {text: 'ΠΡΑΞΗ ΥΠΑΓΩΓΗΣ ΕΠΕΝΔΥΣΕΩΝ', value: 'InvestmentPlacing', keywords: 'Πράξη Πραξη Υπαγωγής Υπαγωγης Επενδύσεων Επενδυσεων'},
            {text: 'ΣΥΜΒΑΣΗ - ΠΡΑΞΕΙΣ ΑΝΑΠΤΥΞΙΑΚΩΝ ΝΟΜΩΝ', value: 'DevelopmentLawContract', keywords: 'Σύμβαση Συμβαση Πράξεις Πραξεις Αναπτυξιακών Αναπτυξιακων Νόμων Νομων'},
            {text: 'ΑΛΛΗ ΠΡΑΞΗ ΑΝΑΠΤΥΞΙΑΚΟΥ ΝΟΜΟΥ', value: 'OtherDevelopmentLaw', keywords: 'Άλλη Αλλη Πράξη Πραξη Αναπτυξιακού Αναπτυξιακου Νόμου Νομου'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΑΝΑΠΤΥΞΙΑΚΩΝ ΝΟΜΩΝ'
        },

        {
          data: [
            {text: 'ΑΝΑΘΕΣΗ ΕΡΓΩΝ / ΠΡΟΜΗΘΕΙΩΝ / ΥΠΗΡΕΣΙΩΝ / ΜΕΛΕΤΩΝ', value: 'WorkAssignmentSupplyServicesStudies', keywords: 'Ανάθεση Αναθεση Έργων Εργων Προμηθειών Προμηθειων Υπηρεσιών Υπηρεσιων Μελετών Μελετων'},
            {text: 'ΚΑΤΑΚΥΡΩΣΗ', value: 'Award', keywords: 'Κατακύρωση Κατακυρωση'},
            {text: 'ΠΕΡΙΛΗΨΗ ΔΙΑΚΗΡΥΞΗΣ', value: 'DeclarationSummary', keywords: 'Περίληψη Περιληψη Διακήρυξης Διακηρυξης'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΑΝΑΘΕΣΕΩΝ ΠΡΟΜΗΘΕΙΩΝ ΚΑΙ ΔΙΑΓΩΝΙΣΜΩΝ - ΔΗΜΟΣΙΩΝ ΣΥΜΒΑΣΕΩΝ'
        },

        {
          data: [
            {text: 'ΛΟΙΠΕΣ ΑΤΟΜΙΚΕΣ ΔΙΟΙΚΗΤΙΚΕΣ ΠΡΑΞΕΙΣ', value: 'OtherDecisions', keywords: 'Λοιπές Λοιπες Ατομικές Ατομικες Διοικητικές Διοικητικες Πράξεις Πραξεις'}
          ],
          label: 'ΛΟΙΠΕΣ ΑΤΟΜΙΚΕΣ ΔΙΟΙΚΗΤΙΚΕΣ ΠΡΑΞΕΙΣ'
        },

        {
          data: [
            {text: 'ΔΗΜΟΣΙΑ ΠΡΟΤΥΠΑ ΕΓΓΡΑΦΑ', value: 'PublicPrototypeDocuments', keywords: 'Δημόσια Δημοσια Πρότυπα Προτυπα Έγγραφα Εγγραφα'}
          ],
          label: 'ΛΟΙΠΕΣ ΠΡΑΞΕΙΣ'
        },
        {
          data: [
            {text: 'ΠΡΑΞΕΙΣ ΧΩΡΟΤΑΞΙΚΟΥ - ΠΟΛΕΟΔΟΜΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ', value: 'SpatialPlanningDecisions', keywords: 'Πράξεις Πραξεις Χωροταξικού Χωροταξικου Πολεοδομικού Πολεοδομικού Περιεχομένου Περιεχομενου'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΧΩΡΟΤΑΞΙΚΟΥ - ΠΟΛΕΟΔΟΜΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ'
        }
      ],
      lastConsideration: 0,
      nextConsideration: 1,
      considerationsArray: [],
      lastVerification: 0,
      nextVerification: 1,
      verificationsArray: [],
      lastDecision: 0,
      nextDecision: 1,
      decisionsArray: [],
      lastRecipient: 0,
      nextRecipient: 1,
      recipientsArray: [],
      lastRecipientForShare: 0,
      nextRecipientForShare: 1,
      recipientForShareArray: [],
      lastInternalDistribution: 0,
      nextInternalDistribution: 1,
      internalDistributionArray: [],
      lastSigner: 0,
      nextSigner: 1,
      signersArray: [],
      lastPresent: 0,
      nextPresent: 1,
      presentsArray: []
    }
  },
  methods: {
    incrementConsiderations: function () {
      this.lastConsideration++
      this.nextConsideration++
      this.considerationsArray.push(this.lastConsideration)
    },
    incrementDecisions: function () {
      this.lastDecision++
      this.nextDecision++
      this.decisionsArray.push(this.lastDecision)
    },
    incrementRecipients: function () {
      this.lastRecipient++
      this.nextRecipient++
      this.recipientsArray.push(this.lastRecipient)
    },
    incrementRecipientsForShare: function () {
      this.lastRecipientForShare++
      this.nextRecipientForShare++
      this.recipientForShareArray.push(this.lastRecipientForShare)
    },
    incrementInternalDistribution: function () {
      this.lastInternalDistribution++
      this.nextInternalDistribution++
      this.internalDistributionArray.push(this.lastInternalDistribution)
    },
    incrementSigner: function () {
      this.lastSigner++
      this.nextSigner++
      this.signersArray.push(this.lastSigner)
    },
    incrementPresent: function () {
      this.lastPresent++
      this.nextPresent++
      this.presentsArray.push(this.lastPresent)
    },
    incrementVerifications: function () {
      this.lastVerification++
      this.nextVerification++
      this.verificationsArray.push(this.lastVerification)
    },
    ifInGeneralDecisionsArray: function (value) {
      return this.generalDecisions.includes(value) || value === ''
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  }
}
</script>
