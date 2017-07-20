<template>
  <div>
      <div class="row">
        <div class="col-xs-4 col-xs-offset-4 text-center">
          <label for="title" class="form-control-label">Τίτλος Απόφασης</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="π.χ. Ανάκληση βεβαίωσης παροχέα υπηρεσιών καταδύσεων αναψυχής">
        </div>
      </div>
      <div class="row">
        <div class="col-xs-4 text-center col-xs-offset-1">
          <label for="decision_type" class="form-control-label">Είδος Απόφασης</label>
          <select class="pickers selectpicker" title="Επιλέξτε το είδος απόφασης" data-live-search="true" id="decision_type" name="decision_type" data-width="auto">
            <optgroup v-for="decisions in DecisionTypes" :label="decisions.label">
              <option v-for="decision in decisions.data" :data-tokens="decision.keywords" :value="decision.value">{{decision.text}}</option>
            </optgroup>
          </select>
        </div>
        <thematic-categories></thematic-categories>
      </div>
  </div>
</template>

<script>

import ThematicCategories from './ThematicCategories.vue'

module.exports = {
  components: {ThematicCategories},
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
      }
    }
  }
};
</script>