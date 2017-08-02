<template>
<div>
  <h3 class="text-center"><u>Ειδικά πεδία {{ selected | getSpecialFieldsTranslator}}</u></h3>
  <div v-if="selected === 'Normative'">
    <normative></normative>
  </div>
  <div v-else-if="selected === 'Circular'">
    <circular></circular>
  </div>
  <div v-else-if="selected === 'Appointment'">
    <appointment></appointment>
  </div>
  <div v-else-if="selected === 'Award'">
    <award></award>
  </div>
</div>
</template>

<script>

import Normative from './specific-decision-fields/Normative.vue'
import Circular from './specific-decision-fields/Circular.vue'
import Appointment from './specific-decision-fields/Appointment.vue'
import Award from './specific-decision-fields/Award.vue'

export default {
  props: ['selected'],
  filters: {
    getSpecialFieldsTranslator: function (value) {
      const translations = {
        'Law': 'Νόμου',
        'LegislativeDecree': 'Πράξης Νομοθετικού Περιεχομένου',
        'Normative': 'Κανονιστικής Πράξης',
        'Circular': 'Εγκυγκλίου',
        'Records': 'Πρακτικών',
        'Opinion': 'Γνωμοδότησης',
        'BudgetApproval': 'Έγκρισης Προϋπολογισμού',
        'Undertaking': 'Ανάληψης Υποχρέωσης',
        'ExpenditureApproval': 'Έγκρισης Δαπάνης',
        'PaymentFinalisation': 'Οριστικοποίησης Πληρωμής',
        'CommisionWarrant': 'Επιτροπικό Ένταλμα',
        'BalanceAccount': 'Ισολογισμού - Απολογισμού',
        'DonationGrant': 'Δωρεάς - Επιχορήγησης',
        'OwnershipTransferOfAssets': 'Παραχώρησης χρήσης περιουσιακών στοιχείων',
        'Appointment': 'Διορισμού',
        'SuccessfulAppointedRunnerUpList': 'Πινάκων Επιτυχόντων, Διοριστέων & Επιλαχόντων',
        'GeneralSpecialSecretaryMonocraticBody': 'Πράξης που αφορά σε θέση Γενικού - Ειδικού Γραμματέα - Μονομελές Όργανο',
        'CollegialBodyCommisionWorkingGroup': 'Πράξης που αφορά σε Συλλογικό Όργανο - Επιτροπή - Ομάδα Εργασίας - Ομάδα Έργου - Μέλη Συλλογικού Οργάνου',
        'OccupationInvitation': 'Προκήρυξης Πλήρωσης Θέσεων',
        'Contract': 'Σύμβασης',
        'ServiceChange': 'Υπηρεσιακής Μεταβολής',
        'DisciplinaryAcquitance': 'Αθωωτικής Πειθαρχικής Απόφασης',
        'StartProductionalFunctionOfInvestment': 'Απόφασης Έναρξης Παραγωγικής Λειτουργίας Επένδυσης',
        'OtherDevelopmentLaw': 'Άλλης Πράξης Αναπτυξιακού Νόμου',
        'WorkAssignmentSupplyServicesStudies': 'Ανάθεσης Έργων / Προμηθειών / Υπηρεσιών / Μελετών',
        'Award': 'Κατακύρωσης',
        'DeclarationSummary': 'Περίληψης Διακήρυξης',
        'OtherDecisions': 'Λοιπών Ατομικών Διοικητικών Πράξεων'
      }
      return translations[value]
    }
  },
  components: {Normative, Circular, Appointment, Award}
}
</script>
