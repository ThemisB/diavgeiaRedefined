<template>
  <div class="col-xs-4 text-center">
    <label for="thematic_category" class="form-control-label">Θεματική Κατηγορία</label>
    <select class="selectpicker pickers" multiple title="Επιλογή 1 ή πολλών Θεμ. Κατηγοριών" data-live-search="true" id="thematic_category" name="thematic_category" data-width="auto">
      <option v-for="thematicCategory in thematicCategories" :data-tokens="thematicCategory.keywords" :value="thematicCategory.value">{{thematicCategory.text}}</option>
    </select>
  </div>
</template>

<script>

module.exports = {
  data: () => {
    return {
      thematicCategories: [
        {text: 'ΑΠΑΣΧΟΛΗΣΗ ΚΑΙ ΕΡΓΑΣΙΑ' , value:'Employment', keywords:'Απασχόληση Απασχοληση Εργασία Εργασια Και'},
        {text: 'BIOMHXANIA' , value:'Industry', keywords:'Βιομηχανία Βιομηχανια'},
        {text: 'ΓΕΩΡΓΙΑ, ΔΑΣΟΚΟΜΙΑ ΚΑΙ ΑΛΙΕΙΑ' , value:'AgricultureForestryFishery', keywords:'Γεωργία Γεωργια Δασοκομία Δασοκομια Αλιεία Και'},
        {text: 'ΓΕΩΓΡΑΦΙΑ' , value:'Geography', keywords:'Γεωγραφία Γεωγραφια'},
        {text: 'ΔΗΜΟΣΙΟΝΟΜΙΚΑ' , value:'Fiscals', keywords:'Δημοσιονομικά Δημοσιονομικα'},
        {text: 'ΔΙΑΤΡΟΦΗ ΚΑΙ ΓΕΩΡΓΙΚΑ ΠΡΟΪΟΝΤΑ' , value:'NutritionAgriculturalProducts', keywords:'Διατροφή Διατροφη Γεωργικά Γεωργικα Προϊόντα Προϊοντα Προιοντα Προϊοντα Και'},
        {text: 'ΔΙΕΘΝΕΙΣ ΟΡΓΑΝΙΣΜΟΙ' , value:'InternationalOrganizations', keywords:'Διεθνείς Διεθνεις Οργανισμοί Οργανισμοι'},
        {text: 'ΔΙΕΘΝΕΙΣ ΣΧΕΣΕΙΣ' , value:'InternationalRelations', keywords:'Διεθνείς Διεθνεις Σχέσεις Σχεσεις'},
        {text: 'ΔΙΚΑΙΟ' , value:'Laws', keywords:'Δίκαιο Δικαιο'},
        {text: 'ΕΝΕΡΓΕΙΑ' , value:'Energy', keywords:'Ενέργεια Ενεργεια'},
        {text: 'ΕΠΙΚΟΙΝΩΝΙΑ ΚΑΙ ΜΟΡΦΩΣΗ' , value:'CommunicationEducation', keywords:'Επικοινωνία Επικοινωνια Μόρφωση Μορφωση Και'},
        {text: 'ΕΠΙΣΤΗΜΕΣ' , value:'Science', keywords:'Επιστήμες Επιστημες'},
        {text: 'ΕΠΙΧΕΙΡΗΣΕΙΣ ΚΑΙ ΑΝΤΑΓΩΝΙΣΜΟΣ' , value:'BusinessCompetition', keywords:'Επιχειρήσεις Επιχειρησεις Ανταγωνισμός Ανταγωνισμος Και'},
        {text: 'ΕΥΡΩΠΑΪΚΗ ΕΝΩΣΗ' , value:'EuropeanUnion', keywords:'Ευρωπαϊκή Ευρωπαϊκη Ευρωπαικη Ευρωπαική Ένωση Ενωση'},
        {text: 'ΚΟΙΝΩΝΙΚΑ ΘΕΜΑΤΑ' , value:'SocialIssues', keywords:'Κοινωνικά Κοινωνικα Θέματα Θεματα'},
        {text: 'ΜΕΤΑΦΟΡΕΣ' , value:'Transport', keywords:'Μεταφορές Μεταφορες'},
        {text: 'ΟΙΚΟΝΟΜΙΚΕΣ ΚΑΙ ΕΜΠΟΡΙΚΕΣ ΣΥΝΑΛΛΑΓΕΣ' , value:'EconomicTradeExchanges', keywords:'Οικονομικές Οικονομικες Εμπορικές Εμπορικες Συναλλαγές Συναλλαγες Και'},
        {text: 'ΟΙΚΟΝΟΜΙΚΗ ΖΩΗ' , value:'EconomicActivity', keywords:'Οικονομική Οικονομικη Ζωή Ζωη'},
        {text: 'ΠΑΡΑΓΩΓΗ, ΤΕΧΝΟΛΟΓΙΑ ΚΑΙ ΕΡΕΥΝΑ' , value:'ManufactureTechnologyResearch', keywords:'Παραγωγή Παραγωγη Τεχνολογία Τεχνολογια Έρευνα Ερευνα Και'},
        {text: 'ΠΕΡΙΒΑΛΛΟΝ' , value:'Environment', keywords:'Περιβάλλον Περιβαλλον'},
        {text: 'ΠΟΛΙΤΙΚΗ ΖΩΗ' , value:'PoliticalLife', keywords:'Πολιτική Πολιτικη Ζωή Ζωη'}
      ]
    }
  }
};

</script>