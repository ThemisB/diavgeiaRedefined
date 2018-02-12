<template>
<div>
  <div class="columns">
    <div class="column">
      <table class="table is-striped is-bordered has-text-centered expensesTable">
        <thead>
          <tr>
            <th>ΠΟΣΑ ΔΩΡΕΑΣ</th>
            <th>ΑΦΜ ΦΟΡΕΑ ΠΟΥ ΛΑΜΒΑΝΕΙ ΤΗΝ ΔΩΡΕΑ</th>
            <th>ΕΠΩΝΥΜΙΑ ΑΠΟΔΕΚΤΗ ΔΩΡΕΑΣ</th>
            <th>ΠΡΟΣΘΗΚΗ</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <tr v-for="expense in expensesArray" :key="getKey('expense', expense)">
              <td>
                <div class="columns">
                  <div class="column">
                    <label :for="getExpenseAmount(expense)">Ποσό</label>
                    <input type="number" class="input" :name="getExpenseAmount(expense)" step="0.01" >
                  </div>
                  <div class="column">
                    <currencies :number="expense"></currencies>
                  </div>
                </div>
              </td>
              <td style="vertical-align:middle">
                <input type="text" :name="getAFM(expense)" class="input">
              </td>
              <td class="text-center" style="vertical-align:middle">
                  <input type="text" readonly="readonly" :name="getSponsored(expense)" value="ΕΠΩΝΥΜΙΑ Χ" class="input has-text-centered">
              </td>
            <input type="hidden" :value="expense" :name="getExpenseIndex(expense)">
            <!-- TODO Integrate it with the GSIS service  -->
            <input type="hidden" value="Εθνικό" :name="getAfmTypeName(expense)">
            <td v-if="expense === 1" style="vertical-align:middle"><button type="button" class="button is-info is-outlined" v-on:click="incrementExpenses"><span>Προσθήκη {{nextExpense}}ου Ποσού</span></button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <h4 class="subtitle has-text-centered">Στοιχεία φορέα που υλοποιεί την δωρεά</h4>
    <div class="columns">
      <div class="column">
        <label for="sponsor_afm_type">Τύπος ΑΦΜ Φορέα που υλοποιεί την Δωρεά</label>
        <multiselect v-model="selected" :options="afmTypes" select-label="" selected-label="" deselect-label="" placeholder="">
        <span slot="noResult">Δεν βρέθηκε ο τύπος ΑΦΜ</span>
        </multiselect>
        <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
        <input type="hidden" name="sponsor_afm_type" :value="selected">
      </div>
      <!-- Εθνικό -->
      <div class="column" v-if="selected === 'Εθνικό'">
        <div class="columns">
          <div class="column">
            <label for="sponsor_afm">ΑΦΜ Φορέα</label>
            <input type="text" class="input" name="sponsor_afm">
          </div>
          <div class="column">
            <label for="sponsor_name">Επωνυμία Φορέα</label>
            <input type="text" readonly="readonly" name="sponsor_name" value="ΕΠΩΝΥΜΙΑ Χ" class="input has-text-centered">
          </div>
        </div>
      </div>
      <!-- Εκτός Ε.Ε. -->
      <div class="column" v-if="selected === 'Εκτός Ε.Ε.'">
        <div class="columns">
          <div class="column">
            <label for="sponsor_afm">ΑΦΜ Φορέα</label>
            <input type="text" class="form-control" name="sponsor_afm">
          </div>
          <div class="column">
            <label for="sponsor_name">Επωνυμία Φορέα</label>
            <input type="text" name="sponsor_name" class="form-control text-center">
          </div>
        </div>
      </div>
      <!-- Νομικό Πρόσωπο στην Ε.Ε. -->
      <div class="column" v-if="this.selected === 'Νομικό Πρόσωπο στην Ε.Ε.'">
        <div class="columns">
          <div class="column">
            <label for="country">Χώρα που υπάγεται ο φορέας</label>
            <multiselect v-model="selectedCountry" :options="countries" select-label="" selected-label="" deselect-label="" placeholder="">
            <span slot="noResult">Δεν βρέθηκε χώρα</span>
            </multiselect>
            <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
            <input type="hidden" name="country" :value="selectedCountry">
          </div>
          <div class="column">
            <label for="sponsor_afm">ΑΦΜ Φορέα</label>
            <input type="text" class="input" name="sponsor_afm">
          </div>
          <div class="column">
            <label for="sponsor_name">Επωνυμία Φορέα</label>
            <input type="text" name="sponsor_name" class="input has-text-centered" readonly="readonly" value="ΕΠΩΝΥΜΙΑ Χ">
          </div>
        </div>
      </div>
      <!-- Φυσικό Πρόσωπο στην Ε.Ε. -->
      <div class="column" v-if="this.selected === 'Φυσικό Πρόσωπο στην Ε.Ε.'">
        <div class="columns">
          <div class="column">
            <label for="country">Χώρα που υπάγεται ο φορέας</label>
            <multiselect v-model="selectedCountry" :options="countries" select-label="" selected-label="" deselect-label="" placeholder="">
            <span slot="noResult">Δεν βρέθηκε χώρα</span>
            </multiselect>
            <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
            <input type="hidden" name="country" :value="selectedCountry">
          </div>
          <div class="column">
            <label for="sponsor_afm">ΑΦΜ Φορέα</label>
            <input type="text" class="input" name="sponsor_afm">
          </div>
          <div class="column">
            <label for="sponsor_name">Επωνυμία Φορέα</label>
            <input type="text" name="sponsor_name" class="input has-text-centered" value="ΕΠΩΝΥΜΙΑ Χ">
          </div>
        </div>
      </div>
      <!-- Οργανισμός Χωρίς ΑΦΜ -->
      <div class="column" v-if="this.selected === 'Οργανισμοί χωρίς ΑΦΜ'">
          <label for="sponsor_name">Οργανισμοί χωρίς Α.Φ.Μ.</label>
          <multiselect v-model="selectedNoAfm" :options="noAfmOrganizations" select-label="" selected-label="" deselect-label="" placeholder="">
          <span slot="noResult">Δεν βρέθηκε οργανισμός χωρίς ΑΦΜ</span>
          </multiselect>
          <!-- Hack for vue-multiselect, based on this issue https://github.com/monterail/vue-multiselect/issues/299 -->
          <input type="hidden" name="sponsor_name" :value="selectedNoAfm">
      </div>
    </div>
  </div>
</div>
</template>

<script>

import Multiselect from 'vue-multiselect'
import Currencies from './Currencies.vue'

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
    getExpenseAmount: function (expenseNumber) {
      return 'expense[' + expenseNumber +'][expense_amount]'
    },
    getKey: function (keyName, index) {
      return keyName + '_' + index
    }
  },
  data: function () {
    return {
      expensesArray: [],
      lastExpense: 1,
      nextExpense: 2,
      selected: '',
      afmChoice: '',
      selectedCountry: '',
      selectedNoAfm: '',
      afmTypes: ['Εθνικό', 'Εκτός Ε.Ε.', 'Νομικό Πρόσωπο στην Ε.Ε.','Φυσικό Πρόσωπο στην Ε.Ε.', 'Οργανισμοί χωρίς ΑΦΜ'],
      countries: ['Αυστρία', 'Βέλγιο', 'Βουλγαρία', 'Τσεχική Δημοκρατία', 'Γερμανία', 'Δανία', 'Εσθονία', 'Ελλάδα', 'Ισπανία', 'Φινλανδία', 'Γαλλία', 'Ηνωμένο Βασίλειο', 'Ουγγαρία', 'Ιρλανδία', 'Ιταλία', 'Λιθουανία', 'Λουξεμβούργο', 'Λεττονία', 'Μάλτα', 'Κάτω Χώρες', 'Πολωνία', 'Πορτογαλία', 'Ρωμανία', 'Σουηδία', 'Σλοβενία', 'Σλοβακία'],
      noAfmOrganizations: ['Οργανισμός Οικονομικής Συνεργασίας και Ανάπτυξης (ΟΟΣΑ)', 'INTERNATIONAL SEED TESTING ASSOSIATION (ISTA)', 'Ευρωπαϊκή Τράπεζα Επενδύσεων', 'National Reference Laboratory, Department of Proficiency Testing Programmes (NRL, OMPZ)']
    }
  },
  mounted: function () {
    let expenseNumber = 1
    this.lastExpense = 1
    this.nextExpense = 2
    this.expensesArray = [expenseNumber]
  },
  components: {Multiselect, Currencies}
}
</script>
