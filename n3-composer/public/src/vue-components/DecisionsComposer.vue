<template>
  <div>
      <div class="row">
        <div class="col-xs-4 col-xs-offset-4 text-center">
          <label for="title" class="form-control-label">Τίτλος Απόφασης</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="π.χ. Ανάκληση βεβαίωσης παροχέα υπηρεσιών καταδύσεων αναψυχής">
        </div>
        <div class="col-xs-2 col-xs-offset-1 private-data">
          <label for="has_private_data" class="form-control-label" style="display:inline-block">
            Προσωπικά Δεδομένα
          </label>
          <input id="" type="checkbox">
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 text-center">
          <label for="decision_type" class="form-control-label">Είδος Απόφασης</label>
          <select class="pickers selectpicker" title="Επιλέξτε το είδος απόφασης" data-live-search="true" id="decision_type" name="decision_type" data-width="auto">
            <optgroup v-for="decisions in DecisionTypes" :label="decisions.label">
              <option v-for="decision in decisions.data" :data-tokens="decision.keywords" :value="decision.value">{{decision.text}}</option>
            </optgroup>
          </select>
        </div>
        <thematic-categories></thematic-categories>
        <div class="col-xs-4 text-center">
          <label for="protocol_number" class="form-control-label">Αριθμός Πρωτοκόλλου</label>
          <input type="text" class="form-control" id="protocol_number" name="protocol_number">
        </div>
      </div>
      <div class="decisions-composer">
        <div class="row">
          <div class="col-xs-10 col-xs-offset-1">
            <h3 class="text-center"><u>Εισαγωγικό Κείμενο Απόφασης</u></h3>
            <textarea class="form-control" rows="2" id="preconsideration" name="preconsideration" placeholder="Σε αυτό το πεδίο γράφετε προαιρετικά ένα εισαγωγικό κείμενο της απόφασης, χωρίς να λαμβάνετε υπόψην την ελληνική νομοθεσία"></textarea>
          </div>
        </div>
        <div class="row">
          <h3 class="text-center"><u>Έχοντας λάβει υπόψην</u></h3>
          <div id="considerationsWrapper">
            <consideration v-for="consideration in considerationsArray" v-bind:number="consideration"></consideration>
          </div>
          <div class="col-xs-12 text-center addConsiderationBtn">
            <button class="btn btn-default" v-on:click="incrementConsiderations">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Προσθήκη {{nextConsideration}}ου "έχοντας λάβει υπόψην"
            </button>
          </div>
        </div>
        <div class="row">
          <h3 class="text-center"><u>Αποφάσεις</u></h3>
          <div class="col-xs-4 col-xs-offset-4 text-center">
            <label for="decision_call" class="form-control-label">Προσφώνηση Απόφασης</label>
            <input type="text" name="decision_call" id="decision_call" placeholder="π.χ. Αποφασίζουμε, Ανακαλούμε, Αναθεωρούμε,..." class="form-control">
          </div>
          <div id="decisionsWrapper">
            <decision v-for="decision in decisionsArray" v-bind:number="decision"></decision>
          </div>
          <div class="col-xs-12 text-center addDecisionsBtn">
            <button class="btn btn-default" v-on:click="incrementDecisions">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Προσθήκη {{nextDecision}}ης Απόφασης
            </button>
          </div>
          <div class="col-xs-10 col-xs-offset-1">
            <h3 class="text-center"><u>Επίλογος Απόφασης</u></h3>
            <textarea class="form-control" rows="2" id="afterconsideration" name="afterconsideration" placeholder="Σε αυτό το πεδίο γράφετε προαιρετικά τον επίλογο της απόφασης."></textarea>
          </div>
        </div>
        <div class="row" id="allRecipients">
          <div id="recipientsWrapper" class="col-xs-4">
            <h4 class="text-center">Αποδέκτες Απόφασης</h4>
            <recipient v-for="recipient in recipientsArray" v-bind:number="recipient"></recipient>
            <div class="paddingRecipients text-center">
              <button class="btn btn-default" v-on:click="incrementRecipients">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{nextRecipient}}ος αποδέκτης
              </button>
            </div>
          </div>
          <div id="recipientsShareWrapper" class="col-xs-4">
            <h4 class="text-center">Αποδέκτες προς Κοινοποίηση</h4>
            <recipient-for-share v-for="recipientshare in recipientForShareArray" v-bind:number="recipientshare"></recipient-for-share>
            <div class="paddingRecipients text-center">
              <button class="btn btn-default" v-on:click="incrementRecipientsForShare">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{nextRecipientForShare}}ος αποδέκτης
              </button>
            </div>
          </div>
          <div id="internalDistributionWrapper" class="col-xs-4">
            <h4 class="text-center">Εσωτερική Διανομή</h4>
            <internal-distribution v-for="internaldistr in internalDistributionArray" v-bind:number="internaldistr"></internal-distribution>
            <div class="paddingRecipients text-center">
              <button class="btn btn-default" v-on:click="incrementInternalDistribution">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{nextRecipientForShare}}ος αποδέκτης
              </button>
            </div>
          </div>
        </div>
        <div class="row">
          <div id="signers">
            <h4 class="text-center">Οι Υπογραφόντες</h4>
            <signer v-for="signer in signersArray" v-bind:number="signer"></signer>
            <div class="paddingRecipients text-center">
              <button class="btn btn-default" v-on:click="incrementSigner">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>{{nextSigner}}ος υπογραφών
              </button>
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
import Signer from './Signer.vue'
import autosize from 'autosize/dist/autosize.min.js'

module.exports = {
  components: {ThematicCategories, Consideration, Decision, Recipient, RecipientForShare, InternalDistribution, Signer},
  mounted: function() {
    this.lastConsideration = 1;
    this.nextConsideration = 2;
    this.considerationsArray = [this.lastConsideration];
    this.lastDecision = 1;
    this.nextDecision = 2;
    this.decisionsArray = [this.lastDecision];
    this.lastRecipient = 1;
    this.nextRecipient = 2;
    this.recipientsArray = [this.lastRecipient];
    this.lastRecipientForShare = 1;
    this.nextRecipientForShare = 2;
    this.recipientForShareArray = [this.lastRecipientForShare];
    this.lastInternalDistribution = 1;
    this.nextInternalDistribution = 2;
    this.internalDistributionArray = [this.lastInternalDistribution];
    this.lastSigner = 1;
    this.nextSigner = 2;
    this.signersArray = [this.lastSigner];

    autosize($('#afterconsideration'));
    autosize($('#preconsideration'));
  },
  data: function() {
    return {
      DecisionTypes: {

        Laws: {
          data: [
            {text: 'ΝΟΜΟΣ', value:'Law', keywords:'Νόμος Νομος'},
            {text: 'ΠΡΑΞΗ ΝΟΜΟΘΕΤΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ (Σύνταγμα, άρθρο 44, παρ 1)', value:'LegislativeDecree', keywords:'Πράξη Πραξη Νομοθετικού Νομοθετικου Περιεχομένου Περιεχομενου Σύνταγμα Συνταγμα Άρθρο αρθρο παρ 44 1'},
            {text: 'ΚΑΝΟΝΙΣΤΙΚΗ ΠΡΑΞΗ', value:'Normative', keywords:'Κανονιστική Κανονιστικη Πράξη Πραξη'},
            {text: 'ΕΓΚΥΚΛΙΟΣ', value:'Circular', keywords:'Εγκύκλιος Εγκυκλιος'},
            {text: 'ΠΡΑΚΤΙΚΑ (Νομικού Συμβουλίου του Κράτους)', value:'Records', keywords:'Πρακτικά Πρακτικα Νομικού Νομικου Συμβουλίου Συμβολιου Κράτους Κρατους Του'},
            {text: 'ΕΚΘΕΣΗ ΑΠΟΤΙΜΗΣΗΣ ΓΙΑ ΤΗΝ ΚΑΤΑΣΤΑΣΗ ΤΗΣ ΥΦΙΣΤΑΜΕΝΗΣ ΝΟΜΟΘΕΣΙΑΣ', value:'EvaluationReportOfLaw', keywords:'Έκθεση Εκθεση Αποτίμησης Αποτιμησης Κατάσταση Κατασταση Υφιστάμενης Υφισταμενης Για Την Της'},
            {text: 'ΓΝΩΜΟΔΟΤΗΣΗ', value:'Opinion', keywords:'Γνωμοδότηση Γνωμοδοτηση'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΚΑΝΟΝΙΣΤΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ, ΕΓΚΥΚΛΙΟΙ, ΓΝΩΜΟΔΟΤΗΣΕΙΣ'
        },

        Financial: {
          data: [
            {text: 'ΕΓΚΡΙΣΗ ΠΡΟΫΠΟΛΟΓΙΣΜΟΥ', value:'BudgetApproval', keywords:'Έγκριση Εγκριση Προϋπολογισμού Προϋπολογισμου Προυπολογισμού Προυπολογισμου'},
            {text: 'ΑΝΑΛΗΨΗ ΥΠΟΧΡΕΩΣΗΣ', value:'Undertaking', keywords:'Ανάληψη Αναληψη Υποχρέωσης Υποχρεωσης'},
            {text: 'ΕΓΚΡΙΣΗ ΔΑΠΑΝΗΣ', value:'ExpenditureApproval', keywords:'Έγκριση Εγκριση Δαπάνης Δαπανης'},
            {text: 'ΟΡΙΣΤΙΚΟΠΟΙΗΣΗ ΠΛΗΡΩΜΗΣ', value:'PaymentFinalisation', keywords:'Οριστικοποίηση Οριστικοποιηση Πληρωμής Πληρωμης'},
            {text: 'ΕΠΙΤΡΟΠΙΚΟ ΕΝΤΑΛΜΑ', value:'CommisionWarrant', keywords:'Επιτροπικό Επιτροπικο Ένταλμα Ενταλμα'},
            {text: 'ΙΣΟΛΟΓΙΣΜΟΣ - ΑΠΟΛΟΓΙΣΜΟΣ', value:'BalanceAccount', keywords:'Ισολογισμός Ισολογισμος Απολογισμός Απολογισμος'},
            {text: 'ΔΩΡΕΑ - ΕΠΙΧΟΡΗΓΗΣΗ', value:'DonationGrant', keywords:'Δωρεά Δωρεα Επιχορήγηση Επιχορηγηση'},
            {text: 'ΠΑΡΑΧΩΡΗΣΗ ΧΡΗΣΗΣ ΠΕΡΙΟΥΣΙΑΚΩΝ ΣΤΟΙΧΕΙΩΝ', value:'OwnershipTransferOfAssets', keywords:'Παραχώρηση Παραχωρηση Χρήσης Χρησης Περιουσιακών Περιουσιακων Στοιχείων Στοιχειων'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΟΙΚΟΝΟΜΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ'
        },

        Management: {
          data: [
            {text: 'ΔΙΟΡΙΣΜΟΣ', value:'Appointment', keywords:'Διορισμός Διορισμος'},
            {text: 'ΠΙΝΑΚΕΣ ΕΠΙΤΥΧΟΝΤΩΝ, ΔΙΟΡΙΣΤΕΩΝ & ΕΠΙΛΑΧΟΝΤΩΝ', value:'SuccessfulAppointedRunnerUpList', keywords:'Πίνακες Πινακες Επιτυχόντων Επιτυχοντων Διοριστέων Διοριστεων Επιλαχόντων Και'},
            {text: 'ΠΡΑΞΗ ΠΟΥ ΑΦΟΡΑ ΣΕ ΘΕΣΗ ΓΕΝΙΚΟΥ - ΕΙΔΙΚΟΥ ΓΡΑΜΜΑΤΕΑ - ΜΟΝΟΜΕΛΕΣ ΟΡΓΑΝΟ', value:'GeneralSpecialSecretaryMonocraticBody', keywords:'Πράξη Πραξη Αφορά Αφορα Θέση Θεση Γενικού Γενικου Ειδικού Ειδικού Γραμματέα Γραμματεα Μονομελές Μονομελες Όργανο Όργανο Που Σε'},
            {text: 'ΠΡΑΞΗ ΠΟΥ ΑΦΟΡΑ ΣΕ ΣΥΛΛΟΓΙΚΟ ΟΡΓΑΝΟ - ΕΠΙΤΡΟΠΗ - ΟΜΑΔΑ ΕΡΓΑΣΙΑΣ - ΟΜΑΔΑ ΕΡΓΟΥ - ΜΕΛΗ ΣΥΛΛΟΓΙΚΟΥ ΟΡΓΑΝΟΥ', value:'CollegialBodyCommisionWorkingGroup', keywords:'Πράξη Πραξη Αφορά Αφορα Συλλογικό Συλλογικο Όργανο Οργανο Επιτροπή Επιτροπη Ομάδα Ομαδα Εργασίας Εργασιας Έργου Εργου Συλλογικού Συλλογικου Οργάνου Οργανου'},
            {text: 'ΠΡΟΚΗΡΥΞΗ ΠΛΗΡΩΣΗΣ ΘΕΣΕΩΝ', value:'OccupationInvitation', keywords:'Προκήρυξη Προκηρυξη Πλήρωσης Πληρωσης Θέσεων Θεσεων'},
            {text: 'ΣΥΜΒΑΣΗ', value:'Contract', keywords:'Σύμβαση Συμβαση'},
            {text: 'ΥΠΗΡΕΣΙΑΚΗ ΜΕΤΑΒΟΛΗ', value:'ServiceChange', keywords:'Υπηρεσιακή Υπηρεασιακη Μεταβολή Μεταβολη'},
            {text: 'ΑΘΩΩΤΙΚΗ ΠΕΙΘΑΡΧΙΚΗ ΑΠΟΦΑΣΗ', value:'DesciplinaryAcquitance', keywords:'Αθωωτική Αθωωτικη Πειθαρχική Πειθαρχικη Απόφαση Αποφαση'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΟΡΓΑΝΩΤΙΚΟΥ ΚΑΙ ΔΙΟΙΚΗΤΙΚΟΥ ΠΕΡΙΕΧΟΜΕΝΟΥ'
        },

        Development: {
          data: [
            {text: 'ΑΠΟΦΑΣΗ ΕΝΑΡΞΗΣ ΠΑΡΑΓΩΓΙΚΗΣ ΛΕΙΤΟΥΡΓΙΑΣ ΕΠΕΝΔΥΣΗΣ', value:'StartProductionalFunctionOfInvestment', keywords:'Απόφαση Αποφαση Έναρξης Εναρξης Παραγωγική Παραγωγικης Λειτουργίας Λειτουργιας Επένδυσης Επενδυσης'},
            {text: 'ΠΡΑΞΗ ΥΠΑΓΩΓΗΣ ΕΠΕΝΔΥΣΕΩΝ', value:'InvestmentPlacing', keywords:'Πράξη Πραξη Υπαγωγής Υπαγωγης Επενδύσεων Επενδυσεων'},
            {text: 'ΣΥΜΒΑΣΗ - ΠΡΑΞΕΙΣ ΑΝΑΠΤΥΞΙΑΚΩΝ ΝΟΜΩΝ', value:'DevelopmentLawContract', keywords:'Σύμβαση Συμβαση Πράξεις Πραξεις Αναπτυξιακών Αναπτυξιακων Νόμων Νομων'},
            {text: 'ΑΛΛΗ ΠΡΑΞΗ ΑΝΑΠΤΥΞΙΑΚΟΥ ΝΟΜΟΥ', value:'OtherDevelopmentLaw', keywords:'Άλλη Αλλη Πράξη Πραξη Αναπτυξιακού Αναπτυξιακου Νόμου Νομου'}
          ],
          label: 'ΠΡΑΞΕΙΣ ΑΝΑΠΤΥΞΙΑΚΩΝ ΝΟΜΩΝ'
        },

        Funds: {
          data: [
            {text: 'ΑΝΑΘΕΣΗ ΕΡΓΩΝ / ΠΡΟΜΗΘΕΙΩΝ / ΥΠΗΡΕΣΙΩΝ / ΜΕΛΕΤΩΝ', value:'WorkAssignmentSupplyServicesStudies', keywords:'Ανάθεση Αναθεση Έργων Εργων Προμηθειών Προμηθειων Υπηρεσιών Υπηρεσιων Μελετών Μελετων'},
            {text: 'ΚΑΤΑΚΥΡΩΣΗ', value:'Award', keywords:'Κατακύρωση Κατακυρωση'},
            {text: 'ΠΕΡΙΛΗΨΗ ΔΙΑΚΗΡΥΞΗΣ', value:'DeclarationSummary', keywords:'Περίληψη Περιληψη Διακήρυξης Διακηρυξης'},
          ],
          label: 'ΠΡΑΞΕΙΣ ΑΝΑΘΕΣΕΩΝ ΠΡΟΜΗΘΕΙΩΝ ΚΑΙ ΔΙΑΓΩΝΙΣΜΩΝ - ΔΗΜΟΣΙΩΝ ΣΥΜΒΑΣΕΩΝ'
        },

        OtherManagementDecisions: {
          data: [
            {text: 'ΛΟΙΠΕΣ ΑΤΟΜΙΚΕΣ ΔΙΟΙΚΗΤΙΚΕΣ ΠΡΑΞΕΙΣ', value:'OtherDecisions', keywords:'Λοιπές Λοιπες Ατομικές Ατομικες Διοικητικές Διοικητικες Πράξεις Πραξεις'}
          ],
          label: 'ΛΟΙΠΕΣ ΑΤΟΜΙΚΕΣ ΔΙΟΙΚΗΤΙΚΕΣ ΠΡΑΞΕΙΣ'
        },

        OtherDecisions: {
          data: [
            {text: 'ΔΗΜΟΣΙΑ ΠΡΟΤΥΠΑ ΕΓΓΡΑΦΑ', value:'PublicPrototypeDocuments', keywords:'Δημόσια Δημοσια Πρότυπα Προτυπα Έγγραφα Εγγραφα'}
          ],
          label: 'ΛΟΙΠΕΣ ΠΡΑΞΕΙΣ'
        }
      },
      lastConsideration: 0,
      nextConsideration: 1,
      considerationsArray: [],
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
      signersArray: []
    }
  },
  methods: {
    incrementConsiderations: function () {
      this.lastConsideration++;
      this.nextConsideration++;
      this.considerationsArray.push(this.lastConsideration);
    },
    incrementDecisions: function () {
      this.lastDecision++;
      this.nextDecision++;
      this.decisionsArray.push(this.lastDecision);
    },
    incrementRecipients: function() {
      this.lastRecipient++;
      this.nextRecipient++;
      this.recipientsArray.push(this.lastRecipient);
    },
    incrementRecipientsForShare: function() {
      this.lastRecipientForShare++;
      this.nextRecipientForShare++;
      this.recipientForShareArray.push(this.lastRecipientForShare);
    },
    incrementInternalDistribution: function() {
      this.lastInternalDistribution++;
      this.nextInternalDistribution++;
      this.internalDistributionArray.push(this.lastInternalDistribution);
    },
    incrementSigner: function() {
      this.lastSigner++;
      this.nextSigner++;
      this.signersArray.push(this.lastSigner);
    }
  }
};
</script>