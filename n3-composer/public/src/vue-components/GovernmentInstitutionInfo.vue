<template>
  <div>
    <h3 class="text-center">Στοιχεία Φορέα</h3>
      <div class="row">
        <div class="col-xs-4">
          <label for="government_institution_name" class="form-control-label">Όνομα Φορέα</label>
          <input type="text" class="form-control" id="government_institution_name" name="government_institution_name" placeholder="π.χ. ΥΠΟΥΡΓΕΙΟ ΝΑΥΤΙΛΙΑΣ ΚΑΙ ΝΗΣΙΩΤΙΚΗΣ ΠΟΛΙΤΙΚΗΣ" required="required">
        </div>
        <div class="col-xs-4">
          <label for="government_institution_general_administration">Γενική Διεύθυνση</label>
          <input type="text" class="form-control" id="government_institution_general_administration" name="government_institution_general_administration" placeholder="π.χ. ΑΡΧΗΓΕΙΟ ΛΙΜΕΝΙΚΟΥ ΣΩΜΑΤΟΣ - ΕΛΛΗΝΙΚΗΣ ΑΚΤΟΦΥΛΑΚΗΣ">
        </div>
        <div class="col-xs-4">
          <label for="government_institution_department">Τμήμα</label>
          <input type="text" class="form-control" id="government_institution_department" name="government_institution_department" placeholder="π.χ. ΛΙΜΕΝΑΡΧΕΙΟ ΠΑΤΜΟΥ">
        </div>
     </div>
     <div class="row">
       <div class="col-xs-4">
         <label for="government_institution_address" class="form-control-label">Διεύθυνση</label>
         <input type="text" class="form-control" id="government_institution_address" name="government_institution_address" placeholder="π.χ. Ανδρέα Παπανδρέου 37" required="required">
      </div>
      <div class="col-xs-4">
        <label for="government_institution_postalcode" class="form-control-label">Τ.Κ.</label>
        <input type="text" class="form-control" id="government_institution_postalcode" name="government_institution_postalcode" required="required">
      </div>
      <div class="col-xs-4">
        <label for="government_institution_phone" class="form-control-label">Τηλέφωνο</label>
        <input type="text" class="form-control" id="government_institution_phone" name="government_institution_phone" required="required">
      </div>
    </div>

    <div class="row">
      <div class="col-xs-4">
        <label for="government_institution_fax" class="text-center">Fax</label>
        <input type="text" class="form-control" id="government_institution_fax" name="government_institution_fax">
      </div>
      <div class="col-xs-4">
        <label for="government_institution_fax" class="text-center">Website</label>
        <input type="text" class="form-control" id="government_institution_website" name="government_institution_website" placeholder="π.χ. http://www.minedu.gov.gr/">
      </div>
      <div class="col-xs-2">
        <label for="government_institution_information" class="text-center">Πληροφορίες</label>
        <input type="text" class="form-control" id="government_institution_information" name="government_institution_information" placeholder="Υπεύθυνος για πληροφορίες">
      </div>
      <div class="col-xs-2">
        <label for="government_institution_email" class="text-center">Email</label>
        <input type="email" class="form-control" id="government_institution_email" name="government_institution_email" placeholder="π.χ. patmos@hcg.gr">
      </div>
    </div>
  </div>
</template>

<script>
export default{}
</script>