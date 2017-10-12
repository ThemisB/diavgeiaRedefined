<template>
  <div>
    <h2 class="has-text-centered dvgColor title">Στοιχεία Φορέα</h2>
      <div class="columns">
        <div class="column">
          <div class="field">
            <label for="government_institution_name" class="label">Όνομα Φορέα</label>
            <div class="control">
              <input type="text" class="input" id="government_institution_name" name="government_institution_name" placeholder="π.χ. ΥΠΟΥΡΓΕΙΟ ΝΑΥΤΙΛΙΑΣ ΚΑΙ ΝΗΣΙΩΤΙΚΗΣ ΠΟΛΙΤΙΚΗΣ" required="required">
            </div>
          </div>
        </div>
        <div class="column">
          <div class="field">
            <label for="government_institution_general_administration" class="label">Γενική Διεύθυνση</label>
            <div class="control">
              <input type="text" class="input" id="government_institution_general_administration" name="government_institution_general_administration" placeholder="π.χ. ΑΡΧΗΓΕΙΟ ΛΙΜΕΝΙΚΟΥ ΣΩΜΑΤΟΣ - ΕΛΛΗΝΙΚΗΣ ΑΚΤΟΦΥΛΑΚΗΣ">
            </div>
          </div>
        </div>
        <div class="column">
          <div class="field">
            <label for="government_institution_department" class="label">Τμήμα</label>
            <input type="text" class="input" id="government_institution_department" name="government_institution_department" placeholder="π.χ. ΛΙΜΕΝΑΡΧΕΙΟ ΠΑΤΜΟΥ">
          </div>
        </div>
     </div>
     <div class="columns">
       <div class="column">
         <div class="field">
           <label for="government_institution_address" class="label">Διεύθυνση</label>
           <div class="control has-icons-left">
             <input type="text" class="input" id="government_institution_address" name="government_institution_address" placeholder="π.χ. Ανδρέα Παπανδρέου 37" required="required">
             <span class="icon is-small is-left">
                 <i class="fa fa-map-marker"></i>
             </span>
           </div>
         </div>
      </div>
      <div class="column">
        <div class="field">
          <label for="government_institution_postalcode" class="label">Τ.Κ.</label>
          <input type="text" class="input" id="government_institution_postalcode" name="government_institution_postalcode">
        </div>
      </div>
      <div class="column">
        <div class="field">
          <label for="government_institution_phone" class="label">Τηλέφωνο</label>
          <div class="control has-icons-left">
          <input type="text" class="input" id="government_institution_phone" name="government_institution_phone" required="required">
            <span class="icon is-small is-left">
              <i class="fa fa-phone"></i>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="columns">
      <div class="column is-two-thirds">
        <div class="columns">
          <div class="column">
            <label for="government_institution_fax" class="label">Fax</label>
            <div class="control has-icons-left">
              <input type="text" class="input" id="government_institution_fax" name="government_institution_fax">
              <span class="icon is-small is-left">
                <i class="fa fa-fax"></i>
              </span>
            </div>
          </div>
          <div class="column">
            <div class="field">
              <label for="government_institution_fax" class="label">Website</label>
              <div class="control has-icons-left">
                <input type="text" class="input" id="government_institution_website" name="government_institution_website" placeholder="π.χ. http://www.minedu.gov.gr/">
                <span class="icon is-small is-left">
                  <i class="fa fa-globe"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="column">
        <div class="columns">
          <div class="column">
            <div class="field">
              <label for="government_institution_information" class="label">Πληροφορίες</label>
              <div class="control has-icons-left">
                <input type="text" class="input" id="government_institution_information" name="government_institution_information" placeholder="Υπεύθυνος για πληροφορίες">
                <span class="icon is-small is-left">
                  <i class="fa fa-info"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="field">
              <label for="government_institution_email" class="label">Email</label>
              <div class="control has-icons-left">
                <input type="email" class="input" id="government_institution_email" name="government_institution_email" placeholder="π.χ. patmos@hcg.gr">
                <span class="icon is-small is-left">
                  <i class="fa fa-envelope"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import InputHandler from './mixins/InputHandler.js'

export default {
  mixins: [ InputHandler ]
}

</script>
