<template>
  <div class="column is-half">
      <label for="thematic_category" class="label">Θεματικές Κατηγορίες</label>
      <multiselect title="Επιλέξτε το είδος απόφασης" id="thematic_category" data-width="auto" required="required" :options="thematicCategoriesValues" :custom-label="formatLabel" placeholder="Επιλογή πολλών θεματικών κατηγοριών" select-label="Πατήστε enter για επιλογή" selected-label="Επιλεγμένο" deselect-label="Πατήστε enter για αφαίρεση" :multiple="true" v-model="value">
      <span slot="noResult">Δεν βρέθηκε θεματική κατηγορία</span>
      </multiselect>
      <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
      <input type="hidden" name="thematic_category[]" v-for="val in value" :value="val">
  </div>
</template>

<script>

import Multiselect from 'vue-multiselect'

export default {
  components: {Multiselect},
  data: () => {
    return {
      value: '',
      thematicCategoriesValues: ['Employment', 'Industry', 'AgricultureForestryFishery', 'Geography', 'PublicAdministration', 'Fiscals', 'NutritionAgriculturalProducts', 'InternationalOrganizations', 'InternationalRelations', 'Laws', 'Energy', 'CommunicationEducation', 'Science', 'BusinessCompetition', 'EuropeanUnion', 'SocialIssues', 'Transport', 'EconomicTradeExchanges', 'EconomicActivity', 'ManufactureTechnologyResearch', 'Environment', 'PoliticalLife'],
      thematicCategories: {
        'Employment': 'ΑΠΑΣΧΟΛΗΣΗ ΚΑΙ ΕΡΓΑΣΙΑ',
        'Industry': 'BIOMHXANIA',
        'AgricultureForestryFishery': 'ΓΕΩΡΓΙΑ, ΔΑΣΟΚΟΜΙΑ ΚΑΙ ΑΛΙΕΙΑ',
        'Geography': 'ΓΕΩΓΡΑΦΙΑ',
        'PublicAdministration': 'ΔΗΜΟΣΙΑ ΔΙΟΙΚΗΣΗ',
        'Fiscals': 'ΔΗΜΟΣΙΟΝΟΜΙΚΑ',
        'NutritionAgriculturalProducts': 'ΔΙΑΤΡΟΦΗ ΚΑΙ ΓΕΩΡΓΙΚΑ ΠΡΟΪΟΝΤΑ',
        'InternationalOrganizations': 'ΔΙΕΘΝΕΙΣ ΟΡΓΑΝΙΣΜΟΙ',
        'InternationalRelations': 'ΔΙΕΘΝΕΙΣ ΣΧΕΣΕΙΣ',
        'Laws': 'ΔΙΚΑΙΟ',
        'Energy': 'ΕΝΕΡΓΕΙΑ',
        'CommunicationEducation': 'ΕΠΙΚΟΙΝΩΝΙΑ ΚΑΙ ΜΟΡΦΩΣΗ',
        'Science': 'ΕΠΙΣΤΗΜΕΣ',
        'BusinessCompetition': 'ΕΠΙΧΕΙΡΗΣΕΙΣ ΚΑΙ ΑΝΤΑΓΩΝΙΣΜΟΣ',
        'EuropeanUnion': 'ΕΥΡΩΠΑΪΚΗ ΕΝΩΣΗ',
        'SocialIssues': 'ΚΟΙΝΩΝΙΚΑ ΘΕΜΑΤΑ',
        'Transport': 'ΜΕΤΑΦΟΡΕΣ',
        'EconomicTradeExchanges': 'ΟΙΚΟΝΟΜΙΚΕΣ ΚΑΙ ΕΜΠΟΡΙΚΕΣ ΣΥΝΑΛΛΑΓΕΣ',
        'EconomicActivity': 'ΟΙΚΟΝΟΜΙΚΗ ΖΩΗ',
        'ManufactureTechnologyResearch': 'ΠΑΡΑΓΩΓΗ, ΤΕΧΝΟΛΟΓΙΑ ΚΑΙ ΕΡΕΥΝΑ',
        'Environment': 'ΠΕΡΙΒΑΛΛΟΝ',
        'PoliticalLife': 'ΠΟΛΙΤΙΚΗ ΖΩΗ'
      }
    }
  },
  methods: {
    formatLabel: function(value) {
      return this.thematicCategories[value]
    }
  }
}

</script>
