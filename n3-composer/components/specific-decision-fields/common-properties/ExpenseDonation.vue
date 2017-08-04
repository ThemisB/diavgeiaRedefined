<template>
<div class="text-center">
  <table class="expensesTable table table-striped table-bordered expensesDonation">
    <thead>
      <tr>
        <th>ΑΦΜ ΦΟΡΕΑ ΠΟΥ ΛΑΜΒΑΝΕΙ ΤΗΝ ΔΩΡΕΑ</th>
        <th>ΕΠΩΝΥΜΙΑ</th>
        <th>ΠΡΟΣΘΗΚΗ</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <tr v-for="expense in expensesArray" :key="expense.id = expense">
          <td>
            <input type="text" :name="getAFM(expense)" class="form-control">
          </td>
          <td class="text-center">
              <input type="text" readonly="readonly" :name="getSponsored(expense)" value="ΕΠΩΝΥΜΙΑ Χ" class="form-control text-center">
          </td>
        <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">
        <!-- TODO Integrate it with the GSIS service  -->
        <input type="hidden" value="Εθνικό" :name="getAfmTypeName(expense)">
        <td v-if="expense === 1"><button type="button" class="btn btn-default" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου Ποσού</span></button></td>
      </tr>
    </tbody>
  </table>
  <div class="row">
    <h4><u>Στοιχεία φορέα που υλοποιεί την δωρεά</u></h4>
    <div class="col-xs-4">
      <label for="sponsor_afm_type">Τύπος ΑΦΜ Φορέα που υλοποιεί την Δωρεά</label>
      <select class="afm_type" title="Τύπος ΑΦΜ" data-live-search="true" name="sponsor_afm_type" data-width="auto" v-model="selected">
        <option v-for="afmType in afmTypes" :data-tokens="afmType.keywords" :value="afmType.text">{{afmType.text}}</option>
      </select>
    </div>
    <!-- Εθνικό -->
    <div class="col-xs-8" v-if="selected === 'Εθνικό'">
      <div class="col-xs-6">
        <label for="sponsor_afm">ΑΦΜ Φορέα</label>
        <input type="text" class="form-control" name="sponsor_afm">
      </div>
      <div class="col-xs-6">
        <label for="sponsor_name">Επωνυμία Φορέα</label>
        <input type="text" readonly="readonly" name="sponsor_name" value="ΕΠΩΝΥΜΙΑ Χ" class="form-control text-center">
      </div>
    </div>
    <!-- Εκτός Ε.Ε. -->
    <div class="col-xs-8" v-if="selected === 'Εκτός Ε.Ε.'">
      <div class="col-xs-6">
        <label for="sponsor_afm">ΑΦΜ Φορέα</label>
        <input type="text" class="form-control" name="sponsor_afm">
      </div>
      <div class="col-xs-6">
        <label for="sponsor_name">Επωνυμία Φορέα</label>
        <input type="text" name="sponsor_name" class="form-control text-center">
      </div>
    </div>
    <!-- Νομικό Πρόσωπο στην Ε.Ε. -->
    <div class="col-xs-8" v-if="this.selected === 'Νομικό Πρόσωπο στην Ε.Ε.'">
      <div class="col-xs-4">
        <label for="country">Χώρα που υπάγεται ο φορέας</label>
        <select title="Χώρα" data-live-search="true" name="country" data-width="auto" id="countries">
          <option v-for="country in countries" :data-tokens="country.keywords" :value="country.text">{{country.text}}</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="sponsor_afm">ΑΦΜ Φορέα</label>
        <input type="text" class="form-control" name="sponsor_afm">
      </div>
      <div class="col-xs-4">
        <label for="sponsor_name">Επωνυμία Φορέα</label>
        <input type="text" name="sponsor_name" class="form-control text-center" readonly="readonly" value="ΕΠΩΝΥΜΙΑ Χ">
      </div>
    </div>
    <!-- Φυσικό Πρόσωπο στην Ε.Ε. -->
    <div class="col-xs-8" v-if="this.selected === 'Φυσικό Πρόσωπο στην Ε.Ε.'">
      <div class="col-xs-4">
        <label for="country">Χώρα που υπάγεται ο φορέας</label>
        <select title="Χώρα" data-live-search="true" name="country" data-width="auto" id="countries">
          <option v-for="country in countries" :data-tokens="country.keywords" :value="country.text">{{country.text}}</option>
        </select>
      </div>
      <div class="col-xs-4">
        <label for="sponsor_afm">ΑΦΜ Φορέα</label>
        <input type="text" class="form-control" name="sponsor_afm">
      </div>
      <div class="col-xs-4">
        <label for="sponsor_name">Επωνυμία Φορέα</label>
        <input type="text" name="sponsor_name" class="form-control text-center" value="ΕΠΩΝΥΜΙΑ Χ">
      </div>
    </div>
    <!-- Οργανισμός Χωρίς ΑΦΜ -->
    <div class="col-xs-8" v-if="this.selected === 'Οργανισμοί χωρίς ΑΦΜ'">
        <label for="sponsor_name">Οργανισμοί χωρίς Α.Φ.Μ.</label>
        <select title="Οργανισμοί Χωρίς Α.Φ.Μ." data-live-search="true" name="sponsor_name" data-width="auto" id="sponsor_name">
          <option v-for="noafm in noAfmOrganizations" :data-tokens="noafm.text" :value="noafm.text">{{noafm.text}}</option>
        </select>
    </div>
  </div>
</div>
</template>

<script>

import $ from 'jquery'

export default {
  methods: {
    incrementExpenses: function () {
      this.lastExpense++
      let expenseNumber = this.lastExpense
      this.nextExpense++
      this.expensesArray.push(expenseNumber)
    },
    getExpenseIndex: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][index]'
    },
    getExpense: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][expense_amount]'
    },
    getAFM: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][afm]'
    },
    getSponsored: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][sponsored]'
    },
    getAfmTypeName: function (expenseNumber) {
      return 'expense[' + expenseNumber + '][afm_type]'
    },
    getSelectedAFMType: function (expenseNumber) {
      return $('#expense_select_' + expenseNumber).val()
    }
  },
  data: function () {
    return {
      expensesArray: [],
      lastExpense: 1,
      nextExpense: 2,
      selected: '',
      afmChoice: '',
      afmTypes: [
        {text: 'Εθνικό', keywords: 'Εθνικό Εθνικο'},
        {text: 'Εκτός Ε.Ε.', keywords: 'Εκτός Εκτος ΕΕ Ε.Ε.'},
        {text: 'Νομικό Πρόσωπο στην Ε.Ε.', keywords: 'Νομικό Νομικο Πρόσωπο Προσωπο στην ΕΕ Ε.Ε.'},
        {text: 'Φυσικό Πρόσωπο στην Ε.Ε.', keywords: 'Φυσικό Φυσικο Πρόσωπο Προσωπο στην ΕΕ Ε.Ε.'},
        {text: 'Οργανισμοί χωρίς ΑΦΜ', keywords: 'Οργανισμοί Οργανισμοι Χωρίς Χωρις ΑΦΜ'}
      ],
      countries: [
        {text: 'Αυστρία', keywords: 'Αυστρία Αυστρια'},
        {text: 'Βέλγιο', keywords: 'Βέλγιο Βελγιο'},
        {text: 'Βουλγαρία', keywords: 'Κύπρος Κυπρος'},
        {text: 'Τσεχική Δημοκρατία', keywords: 'Τσεχική Τσεχικη Δημοκρατία Δημοκρατια'},
        {text: 'Γερμανία', keywords: 'Γερμανία Γερμανια'},
        {text: 'Δανία', keywords: 'Δανία Δανια'},
        {text: 'Εσθονία', keywords: 'Εσθονία Εσθονια'},
        {text: 'Ελλάδα', keywords: 'Ελλάδα Ελλαδα'},
        {text: 'Ισπανία', keywords: 'Ισπανία Ισπανια'},
        {text: 'Φινλανδία', keywords: 'Φινλανδία Φινλανδια'},
        {text: 'Γαλλία', keywords: 'Γαλλία Γαλλια'},
        {text: 'Ηνωμένο Βασίλειο', keywords: 'Κροατία Κροατια'},
        {text: 'Ουγγαρία', keywords: 'Ουγγαρία Ουγγαρια'},
        {text: 'Ιρλανδία', keywords: 'Ιρλανδία Ιρλανδια'},
        {text: 'Ιταλία', keywords: 'Ιταλία Ιταλια'},
        {text: 'Λιθουανία', keywords: 'Λιθουανία Λιθουανια'},
        {text: 'Λουξεμβούργο', keywords: 'Λουξεμβούργο Λουξεμβουργο'},
        {text: 'Λεττονία', keywords: 'Λεττονία Λεττονια'},
        {text: 'Μάλτα', keywords: 'Μάλτσα Μαλτα'},
        {text: 'Κάτω Χώρες', keywords: 'Κάτω Κατω Χώρες Χωρες'},
        {text: 'Πολωνία', keywords: 'Πολωνία Πολωνια'},
        {text: 'Πορτογαλία', keywords: 'Πορτογαλία Πορτογαλια'},
        {text: 'Ρωμανία', keywords: 'Ρωμανία Ρωμανια'},
        {text: 'Σουηδία', keywords: 'Σουηδία Σουηδια'},
        {text: 'Σλοβενία', keywords: 'Σλοβενία Σλοβενια'},
        {text: 'Σλοβακία', keywords: 'Σλοβακία'}
      ],
      noAfmOrganizations: [
        {text: 'Οργανισμός Οικονομικής Συνεργασίας και Ανάπτυξης (ΟΟΣΑ)'},
        {text: 'INTERNATIONAL SEED TESTING ASSOSIATION (ISTA)'},
        {text: 'Ευρωπαϊκή Τράπεζα Επενδύσεων'},
        {text: 'National Reference Laboratory, Department of Proficiency Testing Programmes (NRL, OMPZ)'}
      ]
    }
  },
  mounted: function () {
    let expenseNumber = 1
    this.lastExpense = 1
    this.nextExpense = 2
    this.expensesArray = [expenseNumber]
    $('.afm_type').selectpicker()
    $('#countries').selectpicker()
  }
}
</script>
