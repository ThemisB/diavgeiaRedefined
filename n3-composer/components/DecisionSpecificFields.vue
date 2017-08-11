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
  <div v-else-if="selected === 'LegislativeDecree'">
    <legislative-decree></legislative-decree>
  </div>
  <div v-else-if="selected === 'OtherDecisions' || selected === 'OtherDevelopmentLaw'">
    <other-decisions-general></other-decisions-general>
  </div>
  <div v-else-if="selected === 'ServiceChange'">
    <service-change></service-change>
  </div>
  <div v-else-if="selected === 'OccupationInvitation'">
    <occupation-invitation></occupation-invitation>
  </div>
  <div v-else-if="selected === 'Records'">
    <records></records>
  </div>
  <div v-else-if="selected === 'BalanceAccount'">
    <balance-account></balance-account>
  </div>
  <div v-else-if="selected === 'BudgetApproval'">
    <budget-approval></budget-approval>
  </div>
  <div v-else-if="selected === 'CollegialBodyCommisionWorkingGroup'">
    <collegial-body-commision-working-group></collegial-body-commision-working-group>
  </div>
  <div v-else-if="selected === 'CommisionWarrant'">
    <commision-warrant></commision-warrant>
  </div>
  <div v-else-if="selected === 'Contract'">
    <contract></contract>
  </div>
  <div v-else-if="selected === 'DeclarationSummary'">
    <declaration-summary></declaration-summary>
  </div>
  <div v-else-if="selected === 'DonationGrant'">
    <donation-grant></donation-grant>
  </div>
  <div v-else-if="selected === 'SpatialPlanningDecisions'">
    <spatial-planning-decisions></spatial-planning-decisions>
  </div>
  <div v-else-if="selected === 'ExpenditureApproval'">
    <expenditure-approval></expenditure-approval>
  </div>
  <div v-else-if="selected === 'GeneralSpecialSecretaryMonocraticBody'">
    <general-special-secretary-monocratic-body></general-special-secretary-monocratic-body>
  </div>
  <div v-else-if="selected === 'OwnershipTransferOfAssets'">
    <ownership-transfer-of-assets></ownership-transfer-of-assets>
  </div>
  <div v-else-if="selected === 'SuccessfulAppointedRunnerUpList'">
    <successful-appointed-runner-up-list></successful-appointed-runner-up-list>
  </div>
</div>
</template>

<script>

import Normative from './specific-decision-fields/Normative.vue'
import Circular from './specific-decision-fields/Circular.vue'
import Appointment from './specific-decision-fields/Appointment.vue'
import Award from './specific-decision-fields/Award.vue'
import LegislativeDecree from './specific-decision-fields/LegislativeDecree.vue'
import OtherDecisionsGeneral from './specific-decision-fields/OtherDecisionsGeneral.vue'
import ServiceChange from './specific-decision-fields/ServiceChange.vue'
import OccupationInvitation from './specific-decision-fields/OccupationInvitation.vue'
import Records from './specific-decision-fields/Records.vue'
import BalanceAccount from './specific-decision-fields/BalanceAccount.vue'
import BudgetApproval from './specific-decision-fields/BudgetApproval.vue'
import CollegialBodyCommisionWorkingGroup from './specific-decision-fields/CollegialBodyCommisionWorkingGroup.vue'
import CommisionWarrant from './specific-decision-fields/CommisionWarrant.vue'
import Contract from './specific-decision-fields/Contract.vue'
import DeclarationSummary from './specific-decision-fields/DeclarationSummary.vue'
import DonationGrant from './specific-decision-fields/DonationGrant.vue'
import SpatialPlanningDecisions from './specific-decision-fields/SpatialPlanningDecisions.vue'
import ExpenditureApproval from './specific-decision-fields/ExpenditureApproval.vue'
import GeneralSpecialSecretaryMonocraticBody from './specific-decision-fields/GeneralSpecialSecretaryMonocraticBody.vue'
import OwnershipTransferOfAssets from './specific-decision-fields/OwnershipTransferOfAssets.vue'
import SuccessfulAppointedRunnerUpList from './specific-decision-fields/SuccessfulAppointedRunnerUpList.vue'

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
        'SpatialPlanningDecisions': 'Πράξεων Χωροταξικού - Πολεοδομικού Περιεχομένου',
        'OtherDecisions': 'Λοιπών Ατομικών Διοικητικών Πράξεων'
      }
      return translations[value]
    }
  },
  components: {Normative, Circular, Appointment, Award, LegislativeDecree, OtherDecisionsGeneral, ServiceChange, OccupationInvitation, Records, BalanceAccount, BudgetApproval, CollegialBodyCommisionWorkingGroup, CommisionWarrant, Contract, DeclarationSummary, DonationGrant, SpatialPlanningDecisions, ExpenditureApproval, GeneralSpecialSecretaryMonocraticBody, OwnershipTransferOfAssets, SuccessfulAppointedRunnerUpList}
}
</script>
