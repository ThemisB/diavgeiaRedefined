<?php
$READ_DOMAIN_INFO = true;
$SEARCH_PAGE = true;
include '../theme_header.php';
require_once '../queries.php';

$todayTimeStamp = time();
$today = date('d/m/Y', $todayTimeStamp);
$interval = new DateInterval('P30D');

$startDate = new DateTime();
$startDate->setTimestamp($todayTimeStamp);
$startDate->sub($interval);
$startDateStr = date('d/m/Y', $startDate->getTimestamp());
?>

<link type="text/css" rel="stylesheet" href="<?php echo $site_url; ?>/css/jquery.qtip.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $site_url; ?>/css/tooltips.css" />
<script type="text/javascript" src="<?php echo $search_url; ?>/autocomplete/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo $search_url; ?>/jscalendar/calendar.js"></script>
<script type="text/javascript" src="<?php echo $search_url; ?>/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="<?php echo $search_url; ?>/jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/dateutils.js"></script>
<script type="text/javascript" src="<?php echo $site_url; ?>/js/jquery.qtip.min.js"></script>
<script type="text/javascript">



  jQuery(function($) {
    addTitleToolTip();
    $('#include_foreas').mousedown(function() {
      if ($('#include_foreas:checked').length === 0) {
        $('#include_ypogid').removeClass('disabled');
        $('#include_ypogid').attr('disabled', '');
        $('#js_foreas').removeClass('disabled');
        $('#js_foreas').attr('disabled', '');
      } else {
        $('#field_telikos_ypografwn').addClass('disabled');
        $('#field_telikos_ypografwn').attr('disabled', 'true');
        $('#include_ypogid:checked').removeAttr('checked');
        $('#include_ypogid').addClass('disabled');
        $('#include_ypogid').attr('disabled', 'true');
        $('#js_foreas').addClass('disabled');
        $('#js_foreas').attr('disabled', 'true');
      }
    });

    $('#include_ada').mousedown(function() {
      if ($('#include_ada:checked').length == 0) {
        $('#field_ada').removeClass('disabled');
        $('#field_ada').attr('disabled', '');
      } else {
        $('#field_ada').addClass('disabled');
        $('#field_ada').attr('disabled', 'true');
      }
    });

    $('#include_protocol').mousedown(function() {
      if ($('#include_protocol:checked').length == 0) {
        $('#field_protocol').removeClass('disabled');
        $('#field_protocol').attr('disabled', '');
      } else {
        $('#field_protocol').addClass('disabled');
        $('#field_protocol').attr('disabled', 'true');
      }
    });

    $('#include_dsdf').mousedown(function() {
      if ($('#include_dsdf:checked').length == 0) {
        enableDateRangeFields();
      } else {
        disableDateRangeFields();

      }
    });

    $('#include_th').mousedown(function() {
      if ($('#include_th:checked').length == 0) {
        $('#field_thema').removeClass('disabled');
        $('#field_thema').attr('disabled', '');
      } else {
        $('#field_thema').addClass('disabled');
        $('#field_thema').attr('disabled', 'true');
      }
    });

    $('#include_thid').mousedown(function() {
      if ($('#include_thid:checked').length == 0) {
        $('#field_thematiki_enotita').removeClass('disabled');
        $('#field_thematiki_enotita').attr('disabled', '');
      } else {
        $('#field_thematiki_enotita').addClass('disabled');
        $('#field_thematiki_enotita').attr('disabled', 'true');
      }
    });

    $('#include_eia').mousedown(function() {
      if ($('#include_eia:checked').length == 0) {
        $('#field_eidos_apofasis').removeClass('disabled');
        $('#field_eidos_apofasis').attr('disabled', '');
      } else {
        $('#field_eidos_apofasis').addClass('disabled');
        $('#field_eidos_apofasis').attr('disabled', 'true');
      }
    });

    $('#include_ypogid').mousedown(function() {
      if ($('#include_ypogid:checked').length == 0) {
        $('#field_telikos_ypografwn').removeClass('disabled');
        $('#field_telikos_ypografwn').attr('disabled', '');
      } else {
        $('#field_telikos_ypografwn').addClass('disabled');
        $('#field_telikos_ypografwn').attr('disabled', 'true');
      }
    });

    $('#f-calendar-field-1').mask('99/99/9999', {placeholder: "0"});
    $('#f-calendar-field-2').mask('99/99/9999', {placeholder: "0"});



  });
  function disableDateRange() {
    if ($('#include_ada:checked').length === 0) {
      $('#include_dsdf')[0].checked = true;
      enableDateRangeFields();
    } else {
      $('#include_dsdf')[0].checked = false;
      disableDateRangeFields();
    }

  }
  function disableDateRangeFields() {
    $('#f-calendar-trigger-1').addClass('disabled_cal');
    $('#f-calendar-trigger-2').addClass('disabled_cal');
    $('#f-calendar-field-1').addClass('disabled');
    $('#f-calendar-field-1').attr('disabled', 'true');
    $('#f-calendar-field-2').addClass('disabled');
    $('#f-calendar-field-2').attr('disabled', 'true');
  }
  function enableDateRangeFields() {
    $('#f-calendar-trigger-1').removeClass('disabled_cal');
    $('#f-calendar-trigger-2').removeClass('disabled_cal');
    $('#f-calendar-field-1').removeClass('disabled');
    $('#f-calendar-field-1').attr('disabled', '');
    $('#f-calendar-field-2').removeClass('disabled');
    $('#f-calendar-field-2').attr('disabled', '');
  }

  function check_all_fields() {

    if ($('#include_foreas').length !== 0) {
      if ($('#include_foreas')[0].checked) {
        var foreas = document.getElementById('js_foreas').value;
        if (foreas.length < 5) {
          alert('Το πεδίο "Φορέας" πρέπει να περιέχει έναν έγκυρο φορέα.');
          return false;
        }
      }
    }
    if ($('#include_th')[0].checked) {
      var thema = document.getElementById('field_thema').value;
      if (thema.length < 5) {
        alert('Το πεδίο "Θέμα" πρέπει να περιέχει τουλάχιστον 5 χαρακτήρες');
        return false;
      }
    }

    if ($('#include_thid')[0].checked) {
      var thid = document.getElementById('field_thematiki_enotita').value;
      if (thid == 0) {
        alert('Παρακαλώ πραγματοποιήστε μία επιλογή για το πεδίο "Θεματική ενότητα"');
        return false;
      }
    }
    if ($('#include_eia')[0].checked) {
      var eia = document.getElementById('field_eidos_apofasis').value;
      if (eia == 0) {
        alert('Παρακαλώ πραγματοποιήστε μία επιλογή για το πεδίο "Είδος απόφασης"');
        return false;
      }
    }
    if ($('#include_ypogid')[0].checked) {
      var ypogid = document.getElementById('field_telikos_ypografwn').value;
      if (ypogid == 0) {
        alert('Παρακαλώ πραγματοποιήστε μία επιλογή για το πεδίο "Τελικός Υπογράφων"');
        return false;
      }
    }

    if ($('#include_dsdf')[0].checked) {

      if (!validateDateRange('f-calendar-field-1', 'f-calendar-field-2')) {
        return false;
      }
    }
    return true;
  }
  

</script>
<style lang="text/css">
  .helpStyle{

    float: left;
    margin-left: 30px;

  }
  .tableLabelStyle{
    border-spacing:0;
    border-collapse:collapse;
    border:0px;
    
  }
  .tableLabelStyle tr td{
    padding:0px;
  }
</style>


<div id="content" class="searchpage">
  <div id="notice">
    <strong>Αναζήτηση Αναρτήσεων</strong><br />
 
 Για την αναζήτηση των αναρτήσεων παρέχεται η παρακάτω φόρμα
 
    <br />

    
  </div>

  <form  style="margin-bottom: 0" id="Apofaseis_Ypourgeiou" name="Apofaseis_Ypourgeiou" 
        method="post" action="<?php echo $config['site_url'] . '/search/results.php'; ?>" onsubmit="return check_all_fields()">

    <input type="hidden" name="field_arithmos_protokolou_hidden" value="" />
    <input type="hidden" name="field_tags_hidden" value="" />

    <fieldset class="upload">  
      <div class="sada sarea">
        <table class="tableLabelStyle">
          <tr>
            <td>
              <input type="checkbox" class="checkleft" name="include_ada" id="include_ada" onchange="disableDateRange();"/>
            </td>
            <td>
              <div class="sLabel">ΑΔΑ (Aριθμός Διαδικτυακής Ανάρτησης)</div>   
            </td>
          </tr>
        </table>
        <div class="sInput">
          <input disabled class="disabled" name="field_ada" type="text" title="Πληκτρολογείστε τον ΑΔΑ για τον οποίο επιθυμείτε να πραγματοποιήσετε αναζήτηση." id="field_ada" tabindex="0" value="" maxlength="300" wrap="virtual" ></input>          
        </div>
      </div>
      <?php if (all_orgs()): ?>
        <div class="sforeis  sarea">
          <table class="tableLabelStyle">
            <tr>
              <td>
                <input type="checkbox" class="checkleft" name="include_foreas" id="include_foreas" />
              </td>
              <td>
               Φορέας
              </td>
            </tr>
          </table>
          <div class="sInput">
            <input disabled class="disabled" name="field_foreas" type="text" id="js_foreas" tabindex="0" value="" maxlength="50" wrap="virtual" title="Αρχίστε να πληκτρολογείτε το όνομα του φορέα για τον οποίο επιθυμείτε να πραγματοποιήσετε αναζήτηση και θα εμφανιστεί η βοήθεια. Για την σωστή λειτουργία της βοήθειας θα χρειαστεί να πληκτρολογήσετε τουλάχιστον 4 χαρακτήρες και μόνο στα ελληνικά. Με την επιλογή Φορέα ενεργοποιείται και η δυνατότητα επιλογής συγκεκριμένου Υπογράφοντα."/>
            <input name="field_foreas_id" type="hidden" id="js_foreas_id" tabindex="0" value="" maxlength="50" wrap="virtual"  />

            <script language="javascript" type="text/javascript">
  $("#js_foreas").autocomplete("autocomplete_foreas.php", {
    width: 320,
    max: 100,
    highlight: false,
    delay: 50,
    multiple: false,
    multipleSeparator: " ",
    scroll: true,
    scrollHeight: 300,
    formatItem: function(row, i, max) {
      return row[0].split("|")[0];
    }
  });
  $("#js_foreas").result(function(event, data, formatted) {
    var thisName = data[0];
    var thisID = data[1];

    if (thisID > 0)
    {
      var vali = thisID;
      var opti = thisName;
      document.getElementById("js_foreas").value = opti;
      $("#js_foreas_id").val(vali);
      $.get('../queries.php',
              {
                list_for_search_signer: $('#js_foreas_id').val()
              }, function(data) {
        $('#field_telikos_ypografwn').html('');
        $('#field_telikos_ypografwn').html(data);
        $('#field_telikos_ypografwn').prepend('<option selected="selected" value="0">  </option>');
        $("#field_telikos_ypografwn")[0].options[0].selected = true;
      });

      $.get('../queries.php',
              {
                list_for_search_thema: $('#js_foreas_id').val()
              }, function(data) {
        $('#field_thematiki_enotita').html('');
        $('#field_thematiki_enotita').html(data);
        $('#field_thematiki_enotita').prepend('<option selected="selected" value="0">  </option>');
        $("#field_thematiki_enotita")[0].options[0].selected = true;
      });

      $.get('../queries.php',
              {
                list_for_search_eidos: $('#js_foreas_id').val()
              }, function(data) {
        $('#field_eidos_apofasis').html('');
        $('#field_eidos_apofasis').html(data);
        $('#field_eidos_apofasis').prepend('<option selected="selected" value="0">  </option>');
        $("#field_eidos_apofasis")[0].options[0].selected = true;
      });
    }
  });
            </script>
          </div>
        </div>
      <?php endif; ?>

      <div class="sprotocol sarea">
        <table class="tableLabelStyle">
          <tr>
            <td>
              <input type="checkbox" class="checkleft" name="include_protocol" id="include_protocol" />
            </td>
            <td>
            Αρ. Πρωτοκόλλου
            </td>
          </tr>
        </table>
        <div class="sInput">
          <input disabled class="disabled" name="field_protocol" type="text" title="Πληκτρολογείστε τον αριθμό πρωτοκόλου για τον οποίο επιθυμείτε να πραγματοποιήσετε αναζήτηση." id="field_protocol" tabindex="0" value="" maxlength="300" wrap="virtual" ></input>           
        </div>
      </div>
      <div class="scalendar sarea">
        <table class="tableLabelStyle">
          <tr>
            <td>
              <input type="checkbox" class="checkleft" checked="checked" name="include_dsdf" id="include_dsdf" />
            </td>
            <td>
             Ημερομηνία Aνάρτησης
            </td>
          </tr>
        </table>
        <div class="scalendarm sarea">
          <table class="tableLabelStyle">
            <tr>             
              <td>
                <span class="sLabelm">από</span>
              </td>
              <td>
                <span class="sInput_cal">
                  <input name="field_apofasi_date_start" title="Εάν το κριτήριο αναζήτησης 'Ημερομηνία Ανάρτησης' είναι επιλεγμένο, τότε το μέγιστο επιτρεπόμενο εύρος ημερομηνιών ανάρτησης είναι 30 ημερολογιακές ημέρες." value="<?php echo $startDateStr; ?>" id="f-calendar-field-1" type="text" onchange="validateGreekDate(this);" />
                </span>
              </td>
              <td>
                <a href="#" disabled  id="f-calendar-trigger-1"><img align="absmiddle" border="0" src="jscalendar/img.gif" alt=""  width="16" height="16"  /></a>
              </td>
              <td>
                <span class="sLabelm">εώς</span>
              </td>                      
              <td>
                <span class="sInput_cal">
                  <input name="field_apofasi_date_finish"  title="Εάν το κριτήριο αναζήτησης 'Ημερομηνία Ανάρτησης' είναι επιλεγμένο, τότε το μέγιστο επιτρεπόμενο εύρος ημερομηνιών ανάρτησης είναι 30 ημερολογιακές ημέρες." value="<?php echo $today; ?>" id="f-calendar-field-2" type="text" onchange="validateGreekDate(this);" />
                </span>
              </td>
              <td>
                <a href="#" disabled  id="f-calendar-trigger-2"><img align="absmiddle" border="0" src="jscalendar/img.gif" alt=""  width="16" height="16"  /></a>
              </td>

            </tr>
          </table>

        </div>
        <script type="text/javascript">
  var dcalendar = Calendar.setup({"ifFormat": "%d/%m/%Y", "daFormat": "%d/%m/%Y", "firstDay": 1, "showsTime": 0, "showOthers": true, "timeFormat": 24, "inputField": "f-calendar-field-1", "button": "f-calendar-trigger-1"});
  var dcalendar = Calendar.setup({"ifFormat": "%d/%m/%Y", "daFormat": "%d/%m/%Y", "firstDay": 1, "showsTime": 0, "showOthers": true, "timeFormat": 24, "inputField": "f-calendar-field-2", "button": "f-calendar-trigger-2"});
        </script>
      </div>
      <script type="text/javascript" src="<?php echo $search_url; ?>/calendar.js"></script>


      <div class="sthema sarea">
        <table class="tableLabelStyle" >
          <tr>
            <td>
              <input type="checkbox" class="checkleft" name="include_th" id="include_th" />
            </td>
            <td>
              Θέμα
            </td>
          </tr>
        </table>
        <div class="sInput">
          <textarea disabled title="Για την καλύτερη αποδοτικότητα της αναζήτησης παρακαλώ συμπληρώστε το πεδίο 'Θέμα' με τουλάχιστον 5 χαρακτήρες." class="disabled" id="field_thema" name="field_thema"  maxlength="300" tabindex="0" wrap="virtual"></textarea>          
        </div>
      </div>


      <div class="sthematiki sarea">
        <table class="tableLabelStyle">
          <tr>
            <td>
              <input type="checkbox" class="checkleft" name="include_thid" id="include_thid" />
            </td>
            <td>
              Θεματική ενότητα
            </td>
          </tr>
        </table>
        <div class="sInput">
          <select disabled name="field_thematiki_enotita" title="Στην λίστα εμφανίζονται μόνο οι Θεματικές Ενότητες για τις οποίες υπάρχουν αποφάσεις." id="field_thematiki_enotita" size="1" class="sthemas disabled" tabindex="0">
            <option value="0" selected="selected"></option>
            <?php
            $arr = list_for_search_thema($config['foreas']);
            foreach ($arr['rows'] as $row) {
              $id = $row['id'];
              $name = htmlspecialchars($row['label']);
              echo "<option value=\"$id\">$name</option>";
            }
            ?>
          </select>

        </div>
      </div>

      <div class="seidos sarea">
        <table class="tableLabelStyle">
          <tr>
            <td>
              <input type="checkbox" class="checkleft" name="include_eia" id="include_eia" />
            </td>
            <td>
             Είδος απόφασης
            </td>
          </tr>
        </table>
        <div class="sInput">
          <select disabled name="field_eidos_apofasis" title="Στην λίστα εμφανίζονται μόνο τα Είδη αποφάσεων για τα οποία έχουν πραγματοποιηθεί αναρτήσεις αποφάσεων." id="field_eidos_apofasis" size="1" class="sthemas disabled"  tabindex="0">
            <option value="0" selected="selected">  </option>
            <?php
            $arr = list_for_eidos_optimized($config['foreas']);
            foreach ($arr['rows'] as $row) {
              $id = $row['id'];
              $name = htmlspecialchars($row['label']);
              echo "<option value=\"$id\">$name</option>";
            }
            ?>
          </select>            
        </div>
      </div>
      <?php if (!(all_orgs())): ?>
        <div class="sfsigner sarea">	
          <table class="tableLabelStyle">
            <td>
              <input type="checkbox" class="checkleft" name="include_ypogid" id="include_ypogid" />
            </td>
            <td>
              Τελικός Υπογράφων
            </td>
            </tr>
          </table>
          <div class="sInput">
            <select disabled name="field_telikos_ypografwn" title="Στην λίστα εμφανίζονται μόνο οι Τελικοί Υπογράφοντες οι οποίοι έχουν πραγματοποιήσει αναρτήσεις αποφάσεων." id="field_telikos_ypografwn" class="sthemas disabled"  size="1"  tabindex="0">
              <option value="0" selected="selected">  </option>
              <?php
              $arr = list_for_search_signer($config['foreas']);
              foreach ($arr['rows'] as $row) {
                $id = $row['id'];
                $name = htmlspecialchars($row['label']);
                $pbid = $row['pbid'];
                echo "<option value=\"$id\">$name</option>";
              }
              ?>
            </select>

          </div>
        </div>
      <?php else: ?>
        <div class="sfsigner sarea">	
          <table class="tableLabelStyle">
            <tr>
              <td>
                <input disabled type="checkbox"  class="checkleft disabled" name="include_ypogid" id="include_ypogid" />
              </td>
              <td>
               Τελικός Υπογράφων
              </td>
            </tr>
          </table>
          <div class="sInput">
            <select disabled name="field_telikos_ypografwn" title="Στην λίστα εμφανίζονται μόνο οι Τελικοί Υπογράφοντες οι οποίοι έχουν πραγματοποιήσει αναρτήσεις αποφάσεων. Το πεδίο ενεργοποιείται μόνο μετά την επιλογή συγκεκριμένου Φορέα." id="field_telikos_ypografwn" class="sthemas disabled"  size="1"  tabindex="0">
              <option value="0" selected="selected">  </option>                    
            </select>

          </div>
        </div>
      <?php endif; ?>

      <div id="SubmitButton_outer">
        <input type="submit" class="sButton" id="SubmitButton" name="SubmitButton" value="Αναζήτηση"     tabindex="0"    />
      </div>

   
    </fieldset>        
  </form>

  <div id="queryresultsURL"></div>
</div>



<?php include '../theme_footer.php'; ?>
