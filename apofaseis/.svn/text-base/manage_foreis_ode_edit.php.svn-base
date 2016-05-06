<?php
/*
define(MY_SESSION_VAR_NAME,"_MY_SESSION");

session_start();

// save session variables before destruction by VCL
$_MYSESSION=$_SESSION[MY_SESSION_VAR_NAME];

// provoke the VCL to kill the session
$_GET['restore_session']="1";

// access functions for session variables
function SetSessionVar($aVarName,$aValue) {
$_SESSION[MY_SESSION_VAR_NAME][$aVarName]=$aValue;
}

function GetSessionVar($aVarName) {
return $_SESSION[MY_SESSION_VAR_NAME][$aVarName];
}                                     */

require_once("vcl/vcl.inc.php");


//Includes
require_once("apAuth.php");
require_once("utilClasses.php");
require_once("vcl/vcl.inc.php");
use_unit("menus.inc.php");
use_unit("pager.inc.php");
use_unit("webservices.inc.php");
use_unit("Zend/zacl.inc.php");
use_unit("mysql.inc.php");
use_unit("dbctrls.inc.php");
use_unit("dbgrids.inc.php");
use_unit("db.inc.php");
use_unit("dbtables.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

global $apAuth;
global $aclmanager;

$apAuth->ZAuth->Execute();

$aclmanager->Role = $apAuth->ZAuth->UserRealm;
$apAuth->initUserData();
if((!($apAuth->ZAuth->UserRealm == 'admin'))AND(!($apAuth->ZAuth->UserRealm == 'admin_foreas')))
{
   redirect_withdetection("login.php");
}


//$_SESSION[MY_SESSION_VAR_NAME]=$_MYSESSION;

//Class definition
class manage_foreis_ode_edit extends Page
{
   public $foreas_latin_name_label = null;
   public $foreas_latin_name = null;
   public $fek_arithmos = null;
   public $ypefthinos_mobile_phone = null;
   public $Label19 = null;
   public $status_label = null;
   public $field_oda_members_foreas_type = null;
   public $Label21 = null;
   public $dimos_pb_id = null;
   public $dimos_lgoid_label = null;
   public $Label24 = null;
   public $fek_tefxos = null;
   public $fek_etos = null;
   public $Label23 = null;
   public $Label22 = null;
   public $Label18 = null;
   public $ypefthinos_telephone = null;
   public $ypefthinos_email = null;
   public $ypefthinos_onomateponymo = null;
   public $Label13 = null;
   public $Label5 = null;
   public $Label4 = null;
   public $dimos_status_label = null;
   public $dimos_status = null;
   public $status = null;
   public $Pager = null;
   public $Label20 = null;
   public $foreas_url = null;
   public $support_contact_phone = null;
   public $contact_email = null;
   public $foreas_afm = null;
   public $TK = null;
   public $arithmos = null;
   public $diefthinsi = null;
   public $foreas_new_name = null;
   public $Label16 = null;
   public $Label15 = null;
   public $Label12 = null;
   public $Label11 = null;
   public $Label10 = null;
   public $Label7 = null;
   public $Label6 = null;
   public $foreas_pb_id = null;
   public $Label3 = null;
   public $field_level0_text = null;
   public $field_name = null;
   public $Label_searchterms = null;
   public $Button_searchterms = null;
   public $field_searchterms = null;
   public $ID = null;
   public $Label8 = null;
   public $pb_id_value_label = null;
   public $field_search_terms = null;
   public $LineLabel = null;
   public $editLabel = null;
   public $EditTable = null;
   public $EditTableDs = null;
   public $LogoutLabel = null;
   public $Label1 = null;
   public $btnUpdate = null;
   public $Label9 = null;
   public $Label17 = null;
   public $lbMessages = null;
   public $Label14 = null;
   public $dsRepeater = null;
   public $Label2 = null;
   public $DBRepeater1 = null;
   public $Panel1 = null;
   function field_nameBeforeShow($sender, $params)
   {
      global $apAuth;
      global $aclmanager;
      $query = "SELECT * FROM foreis where pb_id='" . $this->EditTable->foreas_pb_id . "'";
      $apAuth->Query_General2->SQL = $query;
      $apAuth->Query_General2->LimitCount = "-1";
      $apAuth->Query_General2->LimitStart = "-1";
      $apAuth->Query_General2->Prepare();
      $apAuth->Query_General2->close();
      $apAuth->Query_General2->open();

      if($aclmanager->Role == 'admin_foreas')
      {

         $this->field_name->Text = $apAuth->Query_General2->Fields['name'];

      }

      if($aclmanager->Role == 'admin')
      {
         $this->field_name->Text = $this->EditTable->ID . ' - ' . $apAuth->Query_General2->Fields['name'] . ' (' . $apAuth->Query_General2->Fields['pb_id'] . ')';

      }


   }

   function btnUpdateJSClick($sender, $params)
   {
      global $apAuth;
      global $aclmanager;



?>
   //Add your javascript code here

function validateAFM(f) {
    var a = true,
        b = document.getElementById(f).value;
    if (!b.match(/^\d{9}$/) || b == "000000000") a = false;
    else {
        for (var e = 1, d = 0, c = 7; c >= 0; c--) {
            e *= 2;
            d += b.charAt(c) * e
        }
        a = d % 11 % 10 == b.charAt(8)
    }!a && alert("Παρακαλούμε σημειώσατε το πεδίο ΑΦΜ με ένα έγκυρο ΑΦΜ.");
    return a
};

        var returnval;
        returnval=true;
<?php
        if($aclmanager->Role == 'admin')
      {

        ?>

        <?php

      }
      elseif ($aclmanager->Role == 'admin_foreas')
      {
?>
        if (document.getElementById("field_level0_text").value=='0')
         {
               document.getElementById("field_level0_text").focus();
               alert('Παρακαλούμε Επιλέξτε τον πατέρα του Φορέα.');
               returnval=false;

         }
        else if (document.getElementById("field_name").value=='')
         {
               document.getElementById("field_name").focus();
               alert('Παρακαλούμε εισάγετε ένα όνομα φορέα.');
               returnval=false;

         }
                        <?php
                        /*
        else if (document.getElementById("fek_arithmos").value=='0')
         {
               document.getElementById("fek_arithmos").focus();
               alert('Παρακαλούμε εισάγετε ένα αριθμό ΦΕΚ.');
               returnval=false;

         }

        else if (document.getElementById("fek_tefxos").value=='0')
         {
               document.getElementById("fek_tefxos").focus();
               alert('Παρακαλούμε εισάγετε ένα τεύχος ΦΕΚ.');
               returnval=false;

         }

        else if ((document.getElementById("fek_etos").value=='0') || (document.getElementById("fek_etos").value==''))
         {
               document.getElementById("fek_etos").focus();
               alert('Παρακαλούμε εισάγετε ένα έτος ΦΕΚ.');
               returnval=false;

         }                */
                     ?>
        else if (document.getElementById("field_oda_members_foreas_type").value=='')
         {
               document.getElementById("field_oda_members_foreas_type").focus();
               alert('Παρακαλούμε εισάγετε ένα τύπο φορέα.');
               returnval=false;

         }



        else if (document.getElementById("dimos_pb_id").value=='0')
         {
               document.getElementById("dimos_pb_id").focus();
               alert('Παρακαλούμε εισάγετε ένα Δήμο (Διεύθυνσης).');
               returnval=false;

         }

        else if (document.getElementById("diefthinsi").value=='')
         {
               document.getElementById("diefthinsi").focus();
               alert('Παρακαλούμε εισάγετε διεύθυνση.');
               returnval=false;

         }

        else if (document.getElementById("arithmos").value=='')
         {
               document.getElementById("arithmos").focus();
               alert('Παρακαλούμε εισάγετε ένα αριθμό διεύθυνσης.');
               returnval=false;

         }

        else if (document.getElementById("TK").value=='')
         {
               document.getElementById("TK").focus();
               alert('Παρακαλούμε εισάγετε ένα ΤΚ.');
               returnval=false;

         }

        else if (!validateAFM("foreas_afm"))
         {

               document.getElementById("foreas_afm").focus();
               returnval=false;

         }

        else if (document.getElementById("contact_email").value=='')
         {
               document.getElementById("contact_email").focus();
               alert('Παρακαλούμε εισάγετε ένα Ηλ. Διευθυνση Φορέα.');
               returnval=false;

         }

        else if (document.getElementById("support_contact_phone").value=='')
         {
               document.getElementById("support_contact_phone").focus();
               alert('Παρακαλούμε εισάγετε ένα τηλέφωνο φορέα.');
               returnval=false;

         }

        else if (document.getElementById("foreas_url").value=='')
         {
               document.getElementById("foreas_url").focus();
               alert('Παρακαλούμε εισάγετε την ιστοσελίδα φορέα.');
               returnval=false;

         }

        else if (document.getElementById("ypefthinos_onomateponymo").value=='')
         {
               document.getElementById("ypefthinos_onomateponymo").focus();
               alert('Παρακαλούμε εισάγετε το ονοματεπώνυμο υπευθύνου φορέα.');
               returnval=false;

         }

        else if (document.getElementById("ypefthinos_email").value=='')
         {
               document.getElementById("ypefthinos_email").focus();
               alert('Παρακαλούμε εισάγετε το email του υπευθύνου φορέα.');
               returnval=false;

         }

        else if (document.getElementById("ypefthinos_telephone").value=='')
         {
               document.getElementById("ypefthinos_telephone").focus();
               alert('Παρακαλούμε εισάγετε το τηλέφωνο υπευθύνου φορέα ΟΔΕ.');
               returnval=false;

         }

        else if (document.getElementById("ypefthinos_mobile_phone").value=='')
         {
               document.getElementById("ypefthinos_mobile_phone").focus();
               alert('Παρακαλούμε εισάγετε το Κινητό τηλέφωνο υπευθύνου φορέα ΟΔΕ.');
               returnval=false;

         }


        else if (document.getElementById("dimos_status").value=='3')
         {
               document.getElementById("dimos_status").focus();
               alert('Παρακαλούμε εισάγετε την κατάσταση του φορέα.');
               returnval=false;

         }
        else if (document.getElementById("status").value=='')
         {
               document.getElementById("status").focus();
               alert('Παρακαλούμε επιέξτε την κατάσταση εγγραφής του φορέα.');
               returnval=false;

         }

<?php
}
?>
        return returnval;
<?php
      /*
      else if (document.getElementById("foreas_new_name").value=='')
      {
      document.getElementById("foreas_new_name").focus();
      alert('Παρακαλούμε εισάγετε ένα νέο όνομα φορέα ή το υπάρχον όνομα φορέα');
      returnval=false;

      }
      */
   }







   function ypografontesCSVAddJSClick($sender, $params)
   {

?>
   //Add your javascript code here


<?php

   }






   function manage_foreis_ode_editCreate($sender, $params)
   {

      global $apAuth;
      setlocale(LC_ALL, "el_GR.UTF-8");
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");
      $apAuth->initUserData();

      global $aclmanager;
      $usermessage = '<div align="left"><small> <a href="login.php?restore_session=1">ΕΞΟΔΟΣ</a>&nbsp;|&nbsp;<a href="index.php">ΕΠΙΛΟΓΕΣ</a>';
      $usermessage .= '&nbsp;|&nbsp;<a href="index.php?restore_session=1">ΑΠΟΣΥΝΔΕΣΗ</a></font>';
      $usermessage .= "<br><STRONG> Χρήστης:</STRONG> " . $apAuth->ZAuth->UserName;


      if($aclmanager->Role == 'admin_foreas')
      {

         $usermessage .= "<br><STRONG>Logged in as admin_foreas</STRONG>";
         $this->status->Visible = false;
         $this->status_label->Visible = false;
         $this->foreas_latin_name->Visible = false;
         $this->foreas_latin_name_label->Visible = false;
         $this->Button_searchterms->Visible = false;
         $this->Label_searchterms->Visible = false;
         $this->field_searchterms->Visible = false;
         $this->field_search_terms->Visible = false;

         $field_searchterms = $apAuth->userData["start_pb_id"];
         $apAuth->oda_masterTable->LimitStart = 0;
         $apAuth->oda_masterTable->LimitCount = 20;
         $apAuth->oda_masterTable->Filter =
         $text_from_foreas_query . "  foreas_pb_id = '" . $apAuth->userData["start_pb_id"] . "' ";
         $this->Pager->current_page = 1;
         //echo $apAuth->oda_masterTable->Filter;
         $apAuth->oda_masterTable->Active = false;
         $apAuth->oda_masterTable->Active = true;
         $apAuth->oda_masterTable->refresh();

      }

      if($aclmanager->Role == 'admin')
      {
         $this->status->Visible = true;
         $this - $this->status_label->Visible = true;
         $this->foreas_latin_name->Visible = true;
         $this->foreas_latin_name_label->Visible = true;
         $usermessage .= "<br><STRONG>Logged in as admin</STRONG>";
         //$this->Label17->Visible = false;
         if(isset($_REQUEST['field_searchterms']))
         {
            $field_searchterms = mysql_escape_string($_REQUEST['field_searchterms']);
            $_SESSION['field_searchterms'] = $field_searchterms;
         }


         if(isset($_REQUEST['field_searchterms'])or isset($_SESSION['field_searchterms'])and(!($_REQUEST['field_searchterms'] == '')or !($_SESSION['field_searchterms'] == '')))
         {
            if(!(isset($_REQUEST['action'])))
            {

               $text_from_foreas_query = '';
               if(!($_SESSION['field_searchterms'] == ''))
               {
                  $query = "SELECT * FROM `foreis` WHERE name LIKE '%" . $_SESSION['field_searchterms'] . "%' AND pb_id IN (SELECT foreas_pb_id FROM oda_members_master)";
                  $apAuth->Query_General2->SQL = $query;
                  $apAuth->Query_General2->LimitCount = "-1";
                  $apAuth->Query_General2->LimitStart = "-1";
                  $apAuth->Query_General2->Prepare();
                  $apAuth->Query_General2->close();
                  $apAuth->Query_General2->open();
                  for($i = 0; $i < $apAuth->Query_General2->RecordCount; $i++)
                  {
                     $text_from_foreas_query .= " foreas_pb_id='" . $apAuth->Query_General2->Fields['pb_id'] . "' OR ";
                     $apAuth->Query_General2->next();
                  }
               }

               $apAuth->oda_masterTable->LimitStart = 0;
               $apAuth->oda_masterTable->LimitCount = 20;
               $apAuth->oda_masterTable->Filter =
               $text_from_foreas_query . "  contact_email LIKE '%" . $_SESSION['field_searchterms'] . "%' OR foreas_latin_name LIKE '%" . $_SESSION['field_searchterms'] . "%' OR foreas_pb_id LIKE '%" . $_SESSION['field_searchterms'] . "%' ";
               $this->Pager->current_page = 1;
               //echo $apAuth->oda_masterTable->Filter;
               $apAuth->oda_masterTable->Active = false;
               $apAuth->oda_masterTable->Active = true;
               $apAuth->oda_masterTable->refresh();
            }
            else
            {
               $apAuth->oda_masterTable->LimitStart = 0;
               $apAuth->oda_masterTable->LimitCount = 20;
               $apAuth->oda_masterTable->Filter =
               "  contact_email LIKE '-1234567890987654321' OR foreas_latin_name LIKE '-1234567890987654321' OR foreas_pb_id LIKE '-1234567890987654321' ";
               $this->Pager->current_page = 1;
               $apAuth->oda_masterTable->Active = false;
               $apAuth->oda_masterTable->Active = true;
               $this->field_searchterms->Text = '';
            }
         }
         else
         {
            $apAuth->oda_masterTable->LimitStart = 0;
            $apAuth->oda_masterTable->LimitCount = 20;
            $apAuth->oda_masterTable->Filter =
            "  contact_email LIKE '-1234567890987654321' OR foreas_latin_name LIKE '-1234567890987654321' OR foreas_pb_id LIKE '-1234567890987654321' ";
            $this->Pager->current_page = 1;
            $apAuth->oda_masterTable->Active = false;
            $apAuth->oda_masterTable->Active = true;
         }
      }
      
      $usermessage .= "</small></div>";
      $this->Label1->Caption = $usermessage;

      /*    */
      if($apAuth->oda_masterTable->RecordCount == 0)
      {
         $this->Pager->DataSource = null;
         $this->Pager->Visible = false;
      }
      else
      {
         $this->Pager->DataSource = $this->dsRepeater;
      }


      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");

      $this->field_level0_text->Clear();
      $this->field_level0_text->AddItem("", null , "0");
      $query = "SELECT * FROM `foreis` WHERE pb_supervisor_id=324 AND NOT(pb_id=12) ORDER BY name ASC";
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();
      for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
      {
         $this->field_level0_text->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['pb_id']);
         $apAuth->Query_General->next();
      }
      $query = "SELECT * FROM `foreis` WHERE pb_supervisor_id=5000 OR (`pb_supervisor_id`>=5001 AND `pb_supervisor_id`<5014 AND `pb_id`>=6001 AND `pb_id`<6500) ORDER BY pb_id ASC";
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();
      for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
      {
         $this->field_level0_text->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['pb_id']);
         $apAuth->Query_General->next();
      }
      /*
      $query = "SELECT * FROM `foreis` WHERE `pb_id` LIKE '991%' and level=2 ORDER BY pb_supervisor_id ASC";
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();
      for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
      {
      $this->field_level0_text->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['pb_id']);
      $apAuth->Query_General->next();
      }
      */
      $this->field_level0_text->AddItem("Τίποτα από τα παραπάνω", null , "99300001");
      $this->field_level0_text->Enabled = true;
      $this->field_level0_text->ItemIndex = 0;


   }

   function manage_foreis_ode_editJSSubmit($sender, $params)
   {
?>

<?php
   }

   function Label17JSClick($sender, $params)
   {
?>
    //Add your javascript code here
    return(confirm("Είστε σίγουροι ότι θέλελε να διαγράψετε την εγγραφή?"));
<?php
   }

   function Label17BeforeShow($sender, $params)
   {
      //      global $apAuth;
      //      global $aclmanager;
      //Setup a link to delete

      //          $query = "SELECT * FROM ypografontes where type_id='" . $apAuth->YpografontesTypesTable->ID . "'";
      ///           $apAuth->Query_General2->SQL = $query;
      //          $apAuth->Query_General2->LimitCount = "-1";
      //           $apAuth->Query_General2->LimitStart = "-1";
      //          $apAuth->Query_General2->Prepare();
      //          $apAuth->Query_General2->close();
      //          $apAuth->Query_General2->open();

      //   if ($apAuth->Query_General2->RecordCount==0)
      //   {
      //    $this->Label17->Enabled=true;
      //    $this->Label17->Link = "manage_foreis_ode_edit.php?action=delete&edit_id=" . md5($apAuth->oda_masterTable->Fields['pb_id']);
      //   $this->Label17->Caption = "[Διαγραφή]";
      //    }
      //   else
      //    {
      //     $this->Label17->Enabled=false;
      //     $this->Label17->Link = "";
      //     $this->Label17->Caption = "";
      //     }

   }

   function lbMessagesAfterShow($sender, $params)
   {
      //This is a simple message label, so must show and be hidden for next operations
      $sender->Visible = false;
   }

   function btnAddClick($sender, $params)
   {
      //Cancel any pending change
      $this->EditTable->Cancel();
      $this->EditTable->Active = false;
      $this->EditTable->Active = true;

      //Append a new record
      $this->EditTable->Append();

      $this->Label14->Caption = "Δημιουργία νέου Φορέα";
      //Prompt the user for info
      $this->btnUpdate->Visible = false;
      $this->Panel1->Visible = true;
   }

   function fdClassesBeforeShow($sender, $params)
   {
      global $apAuth;
      global $aclmanager;
      //Before showing the label, set the Link property to the URL we want

      $query = "SELECT * FROM foreis where pb_id='" . $apAuth->oda_masterTable->foreas_pb_id . "'";
      $apAuth->Query_General2->SQL = $query;
      $apAuth->Query_General2->LimitCount = "-1";
      $apAuth->Query_General2->LimitStart = "-1";
      $apAuth->Query_General2->Prepare();
      $apAuth->Query_General2->close();
      $apAuth->Query_General2->open();

      if($aclmanager->Role == 'admin_foreas')
      {

         $this->LineLabel->Caption = $apAuth->Query_General2->Fields['name'];

      }

      if($aclmanager->Role == 'admin')
      {
         $this->LineLabel->Caption = $apAuth->oda_masterTable->ID . ' - ' . $apAuth->Query_General2->Fields['name'] . ' (' . $apAuth->Query_General2->Fields['pb_id'] . ')';

      }

      //$this->LineLabel->Caption = $apAuth->Query_General2->Fields['name'];

      $this->editLabel->Link = "manage_foreis_ode_edit.php?action=edit&edit_id=" . md5($apAuth->oda_masterTable->Fields['ID']);

   }

   function Panel1AfterShow($sender, $params)
   {
      //This way, the panel is hidden so it's only shown when editing
      $sender->Visible = false;
   }

   function manage_foreis_ode_editBeforeShow($sender, $params)
   {
      global $apAuth;
      $apAuth->initUserData();
      global $aclmanager;
      $action = $this->input->action;


      //var_dump($_POST);
      //if (false)
      if(isset($_POST["btnUpdate"]))
      {

         //Just post the modified contents so get stored
         try
         {
            global $apAuth;
             if ((!isset($_REQUEST['fek_etos'])) || ($_REQUEST['fek_etos']==''))
             {
             $_REQUEST['fek_etos']=0;
             }
             if ((!isset($_REQUEST['fek_arithmos'])) || ($_REQUEST['fek_arithmos']==''))
             {
             $_REQUEST['fek_arithmos']=0;
             }
            if($aclmanager->Role == 'admin_foreas')
            {
               if(($_REQUEST['field_level0_text'] == '111111111') || ($_REQUEST['field_level0_text'] == ''))
               {
                  $query =
                  "UPDATE oda_members_master
           SET
  foreas_new_name  = '" . mysql_escape_string($_REQUEST['foreas_new_name']) . "',
  diefthinsi  = '" . mysql_escape_string($_REQUEST['diefthinsi']) . "',
  arithmos  = '" . mysql_escape_string($_REQUEST['arithmos']) . "',
  TK  = '" . mysql_escape_string($_REQUEST['TK']) . "',
  foreas_afm  = '" . mysql_escape_string($_REQUEST['foreas_afm']) . "',
  contact_email  = '" . mysql_escape_string($_REQUEST['contact_email']) . "',
  support_contact_phone  = '" . mysql_escape_string($_REQUEST['support_contact_phone']) . "',
  foreas_url  = '" . mysql_escape_string($_REQUEST['foreas_url']) . "',
  dimos_pb_id  = '" . mysql_escape_string($_REQUEST['dimos_pb_id']) . "' ,
  fek_arithmos  = " . mysql_escape_string($_REQUEST['fek_arithmos']) . " ,
  fek_etos  = " . mysql_escape_string($_REQUEST['fek_etos']) . " ,
  fek_tefxos  = '" . mysql_escape_string($_REQUEST['fek_tefxos']) . "',
  ypefthinos_onomateponymo  = '" . mysql_escape_string($_REQUEST['ypefthinos_onomateponymo']) . "',
  ypefthinos_email  = '" . mysql_escape_string($_REQUEST['ypefthinos_email']) . "',
  ypefthinos_telephone  = '" . mysql_escape_string($_REQUEST['ypefthinos_telephone']) . "',
  ypefthinos_mobile_phone  = '" . mysql_escape_string($_REQUEST['ypefthinos_mobile_phone']) . "',
  oda_members_foreas_type  = " . mysql_escape_string($_REQUEST['field_oda_members_foreas_type']) . "
           WHERE ID ='" . mysql_escape_string($_REQUEST['ID']) . "'";
               }
               else
               {
                  $query = "UPDATE oda_members_master
           SET
  ypourgeia_pb_id  = '" . mysql_escape_string($_REQUEST['field_level0_text']) . "',
  ypourgeio_to_check  = '" . mysql_escape_string($_REQUEST['field_level0_text']) . "',
  foreas_new_name  = '" . mysql_escape_string($_REQUEST['foreas_new_name']) . "',
  diefthinsi  = '" . mysql_escape_string($_REQUEST['diefthinsi']) . "',
  arithmos  = '" . mysql_escape_string($_REQUEST['arithmos']) . "',
  TK  = '" . mysql_escape_string($_REQUEST['TK']) . "',
  foreas_afm  = '" . mysql_escape_string($_REQUEST['foreas_afm']) . "',
  contact_email  = '" . mysql_escape_string($_REQUEST['contact_email']) . "',
  support_contact_phone  = '" . mysql_escape_string($_REQUEST['support_contact_phone']) . "',
  foreas_url  = '" . mysql_escape_string($_REQUEST['foreas_url']) . "',
  dimos_pb_id  = '" . mysql_escape_string($_REQUEST['dimos_pb_id']) . "' ,
  fek_arithmos  = " . mysql_escape_string($_REQUEST['fek_arithmos']) . " ,
  fek_etos  = " . mysql_escape_string($_REQUEST['fek_etos']) . " ,
  fek_tefxos  = '" . mysql_escape_string($_REQUEST['fek_tefxos']) . "',
  ypefthinos_onomateponymo  = '" . mysql_escape_string($_REQUEST['ypefthinos_onomateponymo']) . "',
  ypefthinos_email  = '" . mysql_escape_string($_REQUEST['ypefthinos_email']) . "',
  ypefthinos_telephone  = '" . mysql_escape_string($_REQUEST['ypefthinos_telephone']) . "',
  ypefthinos_mobile_phone  = '" . mysql_escape_string($_REQUEST['ypefthinos_mobile_phone']) . "',
  oda_members_foreas_type  = " . mysql_escape_string($_REQUEST['field_oda_members_foreas_type']) . "
           WHERE ID ='" . mysql_escape_string($_REQUEST['ID']) . "'";
               }
            }

            if($aclmanager->Role == 'admin')
            {
               if(($_REQUEST['field_level0_text'] == '111111111') || ($_REQUEST['field_level0_text'] == ''))
               {
                  $query =
                  "UPDATE oda_members_master
           SET
  foreas_new_name  = '" . mysql_escape_string($_REQUEST['foreas_new_name']) . "',
  diefthinsi  = '" . mysql_escape_string($_REQUEST['diefthinsi']) . "',
  arithmos  = '" . mysql_escape_string($_REQUEST['arithmos']) . "',
  TK  = '" . mysql_escape_string($_REQUEST['TK']) . "',
  foreas_afm  = '" . mysql_escape_string($_REQUEST['foreas_afm']) . "',
  contact_email  = '" . mysql_escape_string($_REQUEST['contact_email']) . "',
  support_contact_phone  = '" . mysql_escape_string($_REQUEST['support_contact_phone']) . "',
  foreas_url  = '" . mysql_escape_string($_REQUEST['foreas_url']) . "',
  dimos_pb_id  = '" . mysql_escape_string($_REQUEST['dimos_pb_id']) . "' ,
  fek_arithmos  = " . mysql_escape_string($_REQUEST['fek_arithmos']) . " ,
  fek_etos  = " . mysql_escape_string($_REQUEST['fek_etos']) . " ,
  fek_tefxos  = '" . mysql_escape_string($_REQUEST['fek_tefxos']) . "',
  ypefthinos_onomateponymo  = '" . mysql_escape_string($_REQUEST['ypefthinos_onomateponymo']) . "',
  ypefthinos_email  = '" . mysql_escape_string($_REQUEST['ypefthinos_email']) . "',
  ypefthinos_telephone  = '" . mysql_escape_string($_REQUEST['ypefthinos_telephone']) . "',
  ypefthinos_mobile_phone  = '" . mysql_escape_string($_REQUEST['ypefthinos_mobile_phone']) . "',
  `status`  = '" . mysql_escape_string($_REQUEST['status']) . "',
  `foreas_latin_name`  = '" . mysql_escape_string($_REQUEST['foreas_latin_name']) . "',
  oda_members_foreas_type  = " . mysql_escape_string($_REQUEST['field_oda_members_foreas_type']) . "
           WHERE ID ='" . mysql_escape_string($_REQUEST['ID']) . "'";
               }
               else
               {
                  $query = "UPDATE oda_members_master
           SET
  ypourgeia_pb_id  = '" . mysql_escape_string($_REQUEST['field_level0_text']) . "',
  ypourgeio_to_check  = '" . mysql_escape_string($_REQUEST['field_level0_text']) . "',
  foreas_new_name  = '" . mysql_escape_string($_REQUEST['foreas_new_name']) . "',
  diefthinsi  = '" . mysql_escape_string($_REQUEST['diefthinsi']) . "',
  arithmos  = '" . mysql_escape_string($_REQUEST['arithmos']) . "',
  TK  = '" . mysql_escape_string($_REQUEST['TK']) . "',
  foreas_afm  = '" . mysql_escape_string($_REQUEST['foreas_afm']) . "',
  contact_email  = '" . mysql_escape_string($_REQUEST['contact_email']) . "',
  support_contact_phone  = '" . mysql_escape_string($_REQUEST['support_contact_phone']) . "',
  foreas_url  = '" . mysql_escape_string($_REQUEST['foreas_url']) . "',
  dimos_pb_id  = '" . mysql_escape_string($_REQUEST['dimos_pb_id']) . "' ,
  fek_arithmos  = " . mysql_escape_string($_REQUEST['fek_arithmos']) . " ,
  fek_etos  = " . mysql_escape_string($_REQUEST['fek_etos']) . " ,
  fek_tefxos  = '" . mysql_escape_string($_REQUEST['fek_tefxos']) . "',
  ypefthinos_onomateponymo  = '" . mysql_escape_string($_REQUEST['ypefthinos_onomateponymo']) . "',
  ypefthinos_email  = '" . mysql_escape_string($_REQUEST['ypefthinos_email']) . "',
  ypefthinos_telephone  = '" . mysql_escape_string($_REQUEST['ypefthinos_telephone']) . "',
  ypefthinos_mobile_phone  = '" . mysql_escape_string($_REQUEST['ypefthinos_mobile_phone']) . "',
  `status`  = '" . mysql_escape_string($_REQUEST['status']) . "',
  `foreas_latin_name`  = '" . mysql_escape_string($_REQUEST['foreas_latin_name']) . "',
  oda_members_foreas_type  = " . mysql_escape_string($_REQUEST['field_oda_members_foreas_type']) . "
           WHERE ID ='" . mysql_escape_string($_REQUEST['ID']) . "'";
               }
            }
            //  echo "1aaa<BR>";         echo $query; exit;
            $apAuth->DB_General->execute($query);

            if(!($_REQUEST['dimos_status'] == '') && !($_REQUEST['dimos_status'] == '3') && (isset($_REQUEST['dimos_status'])))
            {

               $query = "UPDATE oda_members_master SET dimos_status  = " .
               mysql_escape_string($_REQUEST['dimos_status']) .
               "  WHERE ID ='" . mysql_escape_string($_REQUEST['ID']) . "'";
               $apAuth->DB_General->execute($query);
            }
            if(!($_REQUEST['status'] == '') && (isset($_REQUEST['status'])))
            {
               $query = "UPDATE oda_members_master SET status  = '" .
               mysql_escape_string($_REQUEST['status']) .
               "'  WHERE ID ='" . mysql_escape_string($_REQUEST['ID']) . "'";
               $apAuth->DB_General->execute($query);
            }

            $apAuth->oda_masterTable->Filter =
            " ID ='" . mysql_escape_string($_REQUEST['ID']) . "' ";

            $apAuth->oda_masterTable->Active = false;

            $apAuth->oda_masterTable->Active = true;

            $this->lbMessages->Caption = "Record saved succesfully";

            $this->lbMessages->Visible = true;
            //echo $query;exit;
         }
         catch(Exception $e)
         {
            echo $e->getMessage();
            $this->lbMessages->Caption = "Error saving the record, please, check required fields";
            $this->lbMessages->Visible = true;
            $this->Panel1->Visible = true;
         }

      }









      if(is_object($action))
      {

         //If there is any edit_id on the input
         $edit_id = $this->input->edit_id;
         if(is_object($edit_id))
         {
            $apAuth->DB_General->DoConnect();
            $apAuth->DB_General->execute("SET NAMES utf8");
            $query = "SELECT * FROM oda_members_master where MD5(ID)='" . mysql_escape_string($_REQUEST['edit_id']) . "'";
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $edit_id->stream['edit_id'] = $apAuth->Query_General->Fields['ID'];
            //Filter the table
            $this->EditTable->Filter = " ID='" . $edit_id->asInteger() . "' ";
            $this->EditTable->Active = false;
            $this->EditTable->Active = true;
            $this->EditTable->Refresh();
            $this->ID->Value = $edit_id->asString();


            //If the user wants to edit a register
            if($action->asString() == 'edit')
            {
               $query = "SELECT * FROM oda_members_master where ID='" . $edit_id->asInteger() . "'";
               $apAuth->Query_General->SQL = $query;
               $apAuth->Query_General->LimitCount = "-1";
               $apAuth->Query_General->LimitStart = "-1";
               $apAuth->Query_General->Prepare();
               $apAuth->Query_General->close();
               $apAuth->Query_General->open();
               $parent_pb_id = $apAuth->Query_General->Fields['ypourgeia_pb_id'];
               $foreas_pb_id = $apAuth->Query_General->Fields['foreas_pb_id'];
               $dimos_status = $apAuth->Query_General->Fields['dimos_status'];
               $this->status->ItemIndex = $apAuth->Query_General->Fields['status'];
               $dimos_pb_id = $apAuth->Query_General->Fields['dimos_pb_id'];
               $this->ypefthinos_telephone = $apAuth->Query_General->Fields['ypefthinos_telephone'];
               $this->ypefthinos_email = $apAuth->Query_General->Fields['ypefthinos_email'];
               $this->ypefthinos_onomateponymo = $apAuth->Query_General->Fields['ypefthinos_onomateponymo'];
               $oda_members_foreas_type = $apAuth->Query_General->Fields['oda_members_foreas_type'];
               $fek_tefxos = $apAuth->Query_General->Fields['fek_tefxos'];
               $fek_arithmos = $apAuth->Query_General->Fields['fek_arithmos'];
               if($parent_pb_id == '0')
               {
                  $parent_pb_id = $apAuth->Query_General->Fields['ypourgeio_to_check'];
               }
               $this->field_oda_members_foreas_type->ItemIndex = $oda_members_foreas_type;
               if(($parent_pb_id > 6000) && ($parent_pb_id < 6326))
               {
                  $this->dimos_status_label->Visible = true;
                  $this->dimos_status->Visible = true;
                  if($dimos_status == '0')
                  {
                     $this->dimos_status->ItemIndex = 3;
                  }
                  else
                  {
                     $this->dimos_status->ItemIndex = $dimos_status;
                  }

               }
               else
               {
                  $this->dimos_status_label->Visible = false;
                  $this->dimos_status->Visible = false;
               }

               $this->dimos_pb_id->Clear();
               $this->dimos_pb_id->AddItem('', null , '0');
               $query = "SELECT * from foreis WHERE pb_id>6000 AND pb_id<6326";
               $apAuth->Query_General->SQL = $query;
               $apAuth->Query_General->LimitCount = "-1";
               $apAuth->Query_General->LimitStart = "-1";
               $apAuth->Query_General->Prepare();
               $apAuth->Query_General->close();
               $apAuth->Query_General->open();
               for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
               {
                  $this->dimos_pb_id->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['pb_id']);
                  $apAuth->Query_General->next();
               }
               $this->dimos_pb_id->ItemIndex = $dimos_pb_id;


               $this->field_oda_members_foreas_type->Clear();
               $this->field_oda_members_foreas_type->AddItem('', null , '0');
               $query = "SELECT * from oda_members_foreas_types";
               $apAuth->Query_General->SQL = $query;
               $apAuth->Query_General->LimitCount = "-1";
               $apAuth->Query_General->LimitStart = "-1";
               $apAuth->Query_General->Prepare();
               $apAuth->Query_General->close();
               $apAuth->Query_General->open();
               for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
               {
                  if(!($apAuth->Query_General->Fields['ID'] == '4')//DEKO is Hidden
                  &&
                  !($apAuth->Query_General->Fields['ID'] == '5'))// ALLO is hidden
                  {
                     $this->field_oda_members_foreas_type->AddItem($apAuth->Query_General->Fields['label'], null , $apAuth->Query_General->Fields['ID']);
                  }
                  $apAuth->Query_General->next();
               }

               $this->fek_tefxos->Clear();
               // $this->fek_arithmos->Clear();
               $this->fek_tefxos->AddItem('', null , '0');
               // $this->fek_arithmos->AddItem('', null , '0');
               $query = "SELECT * FROM et_fek_tefxos_names";
               $apAuth->Query_General->SQL = $query;
               $apAuth->Query_General->LimitCount = "-1";
               $apAuth->Query_General->LimitStart = "-1";
               $apAuth->Query_General->Prepare();
               $apAuth->Query_General->close();
               $apAuth->Query_General->open();
               for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
               {

                  // $this->fek_arithmos->AddItem($apAuth->Query_General->Fields['ET_FEK_tefxos_ID'], null , $apAuth->Query_General->Fields['ET_FEK_tefxos_ID']);
                  $this->fek_tefxos->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ET_FEK_tefxos_ID']);
                  $apAuth->Query_General->next();
               }
               // $this->fek_arithmos->ItemIndex = $fek_arithmos;
               $this->fek_tefxos->ItemIndex = $fek_tefxos;
               $this->fek_arithmos->Text = $fek_arithmos;


               if($this->field_level0_text->Items[$parent_pb_id] == NULL)
               {
                  $this->field_level0_text->AddItem("Μη ενημερώσιμο πεδίο", null , "111111111");
                  $this->field_level0_text->ItemIndex = 111111111;
                  $this->field_level0_text->Enabled = false;
               }
               else
               {
                  $this->field_level0_text->ItemIndex = $parent_pb_id;
               }





               $this->Label14->Caption = "Ενημέρωση Στοιχείων Φορέων";
               $this->btnUpdate->Visible = true;
               //Make the panel visible
               $this->Panel1->Visible = true;

            }
            else if($action->asString() == 'delete')
            {
               //Delete the register and refresh the repeater table
               // global $apAuth;
               // $query = "DELETE FROM oda_members_master WHERE ID=" . $edit_id->asInteger();
               //  $apAuth->DB_General->execute($query);
               //  $apAuth->oda_masterTable->Refresh();
            }
         }

      }
   }


}

global $application;

global $manage_foreis_ode_edit;

//Creates the form
$manage_foreis_ode_edit = new manage_foreis_ode_edit($application);

//Read from resource file
$manage_foreis_ode_edit->loadResource(__FILE__);

//Shows the form
$manage_foreis_ode_edit->show();

?>