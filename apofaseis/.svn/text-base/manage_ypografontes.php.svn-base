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
class manage_ypografontes extends Page
{
   public $email = null;
   public $Pager = null;
   public $Label_searchterms = null;
   public $Button_searchterms = null;
   public $field_searchterms = null;
   public $Label13 = null;
   public $Label12 = null;
   public $monada_id = null;
   public $Label3 = null;
   public $ID = null;
   public $ypourgeio_table = null;
   public $pb_id = null;
   public $Label7 = null;
   public $Label8 = null;
   public $pb_id_value_label = null;
   public $field_search_terms = null;
   public $Button_search = null;
   public $field_results = null;
   public $Button2 = null;
   public $Label5 = null;
   public $LineLabel = null;
   public $editLabel = null;
   public $en_energeia = null;
   public $address = null;
   public $fax = null;
   public $telephone = null;
   public $type_id = null;
   public $EditTable = null;
   public $EditTableDs = null;
   public $Label16 = null;
   public $Label6 = null;
   public $Label4 = null;
   public $Label18 = null;
   public $LogoutLabel = null;
   public $Label1 = null;
   public $lastname = null;
   public $firstname = null;
   public $btnUpdate = null;
   public $Label11 = null;
   public $Label10 = null;
   public $Label9 = null;
   public $Label17 = null;
   public $lbMessages = null;
   public $btnAdd = null;
   public $Label14 = null;
   public $dsRepeater = null;
   public $Label2 = null;
   public $DBRepeater1 = null;
   public $Panel1 = null;
   public $btnPost = null;



   function Button2JSClick($sender, $params)
   {

?>
   //Add your javascript code here
   var si=document.getElementById("field_results").selectedIndex;
   var vali=document.getElementById("field_results").options[si].value;
   var texti=document.getElementById("field_results").options[si].text;
   if (vali>0)
   {
     document.getElementById("pb_id_value_label").value=texti;
     document.getElementById("pb_id").value=vali.toString();
   }
   else
   {
      alert('Επιλέξτε ένα φορέα απο την λίστα πρώτα.');
   }

<?php

   }

   function Button_searchJSClick($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

    try {
      document.getElementById("Button_search_outer").innerHTML='<?php

      echo '<input type="button" tabindex="0" style="font-family: Verdana; font-size: 10px; height: 25px; width: 75px;" onclick="return Button_searchJSClick(event)" value="Αναζήτηση" name="Button_search" id="Button_search">';
?>';
    } catch (e) {  }

var resultsContent='<?php
      echo '<select name="field_results" id="field_results" size="4" style=" font-family: Verdana; font-size: 10px;  height:120px;width:599px;"   tabindex="0"   >';
?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';

 document.getElementById("field_results_outer").innerHTML=resultsContent;
  }
  }

    var st=document.getElementById("field_search_terms").value;

    try {
      document.getElementById("Button_search_outer").innerHTML='<?php
      echo '<img src="progress_loading.gif">';
?>';
    } catch (e) {  }


    xmlhttp.open("GET","getSearchResults.php?search_terms="+st,true);
    xmlhttp.send();


   return false;
<?php

   }


   function ypografontesCSVAddJSClick($sender, $params)
   {

?>
   //Add your javascript code here


<?php

   }






   function manage_ypografontesCreate($sender, $params)
   {

      global $apAuth;
      setlocale(LC_ALL, "el_GR.UTF-8");
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");
      $apAuth->initUserData();

      global $aclmanager;
      $usermessage='<div align="left"><small> <a href="login.php?restore_session=1">ΕΞΟΔΟΣ</a>&nbsp;|&nbsp;<a href="index.php">ΕΠΙΛΟΓΕΣ</a>';
      $usermessage.='&nbsp;|&nbsp;<a href="index.php?restore_session=1">ΑΠΟΣΥΝΔΕΣΗ</a></font>';
      $usermessage .= "<br><STRONG> Χρήστης:</STRONG> ".$apAuth->ZAuth->UserName;

      if($aclmanager->Role == 'user')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Χρήστης Φορέα:</STRONG> ".$apAuth->userData['foreas_name']."";
         $this->field_results->Visible = false;
         $this->field_search_terms->Visible = false;
         $this->Button2->Visible = false;
         $this->Button_search->Visible = false;
         $this->Label7->Visible = false;
         //$this->Label17->Visible = false;
         if (isset($_REQUEST['field_searchterms']))
         {
            $field_searchterms=mysql_escape_string($_REQUEST['field_searchterms']);
            $_SESSION['field_searchterms']=$field_searchterms;
         }

         if (isset($_REQUEST['field_searchterms']) or isset($_SESSION['field_searchterms']) and (!($_REQUEST['field_searchterms']=='') or !($_SESSION['field_searchterms']=='')))
         {
            $apAuth->YpografontesTable->LimitStart=0;
            $apAuth->YpografontesTable->LimitCount=20;
            $apAuth->YpografontesTable->Filter =
            " (firstname LIKE '%".$_SESSION['field_searchterms']."%' OR ".
            "  lastname LIKE '%".$_SESSION['field_searchterms']."%') AND ".
            " pb_id='" . $apAuth->userData['start_pb_id'] . "'";
            $this->Pager->current_page=1;
         }
         else
         {
            $apAuth->YpografontesTable->Filter = " pb_id='" . $apAuth->userData['start_pb_id'] . "'";
         }
      }
      if($aclmanager->Role == 'admin_foreas')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Διαχειριστής Φορέα:</STRONG> ".$apAuth->userData['foreas_name']."";
         $this->field_results->Visible = false;
         $this->field_search_terms->Visible = false;
         $this->Button2->Visible = false;
         $this->Button_search->Visible = false;
         $this->Label7->Visible = false;
         //$this->Label17->Visible = false;
         if (isset($_REQUEST['field_searchterms']))
         {
            $field_searchterms=mysql_escape_string($_REQUEST['field_searchterms']);
            $_SESSION['field_searchterms']=$field_searchterms;
         }

         if (isset($_REQUEST['field_searchterms']) or isset($_SESSION['field_searchterms']) and (!($_REQUEST['field_searchterms']=='') or !($_SESSION['field_searchterms']=='')))
         {
            $apAuth->YpografontesTable->LimitStart=0;
            $apAuth->YpografontesTable->LimitCount=20;
            $apAuth->YpografontesTable->Filter =
            " (firstname LIKE '%".$_SESSION['field_searchterms']."%' OR ".
            "  lastname LIKE '%".$_SESSION['field_searchterms']."%') AND ".
            " pb_id='" . $apAuth->userData['start_pb_id'] . "'";
            $this->Pager->current_page=1;
         }
         else
         {
            $apAuth->YpografontesTable->Filter = " pb_id='" . $apAuth->userData['start_pb_id'] . "'";
         }
      }
      if($aclmanager->Role == 'admin')
      {
         $usermessage .= "<br><STRONG>Logged in as admin</STRONG>";
         //$this->Label17->Visible = false;
         if (isset($_REQUEST['field_searchterms']))
         {
            $field_searchterms=mysql_escape_string($_REQUEST['field_searchterms']);
            $_SESSION['field_searchterms']=$field_searchterms;
         }

         if (isset($_REQUEST['field_searchterms']) or isset($_SESSION['field_searchterms']) and (!($_REQUEST['field_searchterms']=='') or !($_SESSION['field_searchterms']=='')))
         {
            $apAuth->YpografontesTable->LimitStart=0;
            $apAuth->YpografontesTable->LimitCount=20;
            $apAuth->YpografontesTable->Filter =
            "  firstname LIKE '%".$_SESSION['field_searchterms']."%' OR ".
            "  lastname LIKE '%".$_SESSION['field_searchterms']."%' ";
            $this->Pager->current_page=1;
         }
         else
         {
            $apAuth->YpografontesTable->Filter = "";
         }
      }
      
      $usermessage .= "</small></div>";
      $this->Label1->Caption = $usermessage;
      $apAuth->YpografontesTable->Active = false;
      $apAuth->YpografontesTable->Active = true;
      $apAuth->YpografontesTable->refresh();
      if ($apAuth->YpografontesTable->RecordCount==0)
      {
          $this->Pager->DataSource=null;
          $this->Pager->Visible=false;
      }
      else
      {
          $this->Pager->DataSource=$this->dsRepeater;
      }
      $this->EditTable->Active = false;
      $this->EditTable->Active = true;
      $this->EditTable->Refresh();
   }

   function manage_ypografontesJSSubmit($sender, $params)
   {
?>
        var returnval;
        returnval=true;

   var si2=document.getElementById("monada_id").selectedIndex;
   var val2i=document.getElementById("monada_id").options[si2].value;
   if (val2i==0)
   {
      alert('Επιλέξτε μία μονάδα απο την λίστα πρώτα.');
      returnval=false;
   }
       else    if (document.getElementById("firstname").value.replace(/^\s+|\s+$/g, '')=='')
         {
               alert('Παρακαλούμε εισάγετε ένα όνομα.');
               returnval=false;

         }
       else    if (document.getElementById("lastname").value.replace(/^\s+|\s+$/g, '')=='')
         {
               alert('Παρακαλούμε εισάγετε ένα επώνυμο.');
               returnval=false;

         }
      else     if (document.getElementById("telephone").value.replace(/^\s+|\s+$/g, '')=='')
         {
               alert('Παρακαλούμε εισάγετε ένα τηλέφωνο.');
               returnval=false;

         }
      else     if (document.getElementById("email").value.replace(/^\s+|\s+$/g, '')=='')
         {
               alert('Παρακαλούμε εισάγετε ένα E-mail.');
               returnval=false;

         }
      else     if (document.getElementById("fax").value.replace(/^\s+|\s+$/g, '')=='')
         {
               alert('Παρακαλούμε εισάγετε ένα φαξ.');
               returnval=false;

         }
      else     if (document.getElementById("address").value.replace(/^\s+|\s+$/g, '')=='')
         {
               alert('Παρακαλούμε εισάγετε μία ταχ. διεύθυνση.');
               returnval=false;

         }
   return returnval;
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
      global $apAuth;
      //Setup a link to delete registers
      global $aclmanager;
      //if(($aclmanager->Role == 'admin_foreas')or($aclmanager->Role == 'user'))
      //{
            $query = "SELECT * FROM apofaseis where telikos_ypografwn='" . $apAuth->YpografontesTable->ID . "' limit 1";
            $apAuth->Query_General2->SQL = $query;
            $apAuth->Query_General2->LimitCount = "-1";
            $apAuth->Query_General2->LimitStart = "-1";
            $apAuth->Query_General2->Prepare();
            $apAuth->Query_General2->close();
            $apAuth->Query_General2->open();

        if ($apAuth->Query_General2->RecordCount==0)
        {
           $this->Label17->Enabled=true;
           $this->Label17->Link = "manage_ypografontes.php?action=delete&edit_id=" . md5($apAuth->YpografontesTable->ID);
           $this->Label17->Caption = "[Διαγραφή]";
        }
        else
        {
           $this->Label17->Enabled=false;
           $this->Label17->Link = "";
           $this->Label17->Caption = "";
        }


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

      //Append a new record
      $this->EditTable->Append();

      $this->Label14->Caption = "Δημιουργία νέου Υπογράφοντα";
      //Prompt the user for info
      $this->btnPost->Visible = true;
      $this->btnUpdate->Visible = false;
      $this->Panel1->Visible = true;
   }

   function fdClassesBeforeShow($sender, $params)
   {
      global $apAuth;
      global $aclmanager;
      //Before showing the label, set the Link property to the URL we want
      $query = "SELECT ypografontes.*,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE ypografontes.type_id=ypografontes_types.ID AND ypografontes.ID='" . $apAuth->YpografontesTable->ID . "'";
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();

      if(($aclmanager->Role == 'admin_foreas')or($aclmanager->Role == 'user'))
      {
          $this->LineLabel->Caption = $apAuth->Query_General->Fields['type_name'] . ' - ' . $apAuth->Query_General->Fields['firstname'] . ' ' . $apAuth->Query_General->Fields['lastname'] ;
      }
      else
      {
          $this->LineLabel->Caption = $apAuth->Query_General->Fields['type_name'] . ' - ' . $apAuth->Query_General->Fields['firstname'] . ' ' . $apAuth->Query_General->Fields['lastname'] . ' (' . $apAuth->Query_General->Fields['ypourgeio_table_name'] . ')';
      }

      $this->editLabel->Link = "manage_ypografontes.php?action=edit&edit_id=" . md5($apAuth->YpografontesTable->ID);
   }

   function Panel1AfterShow($sender, $params)
   {
      //This way, the panel is hidden so it's only shown when editing
      $sender->Visible = false;
   }

   function manage_ypografontesBeforeShow($sender, $params)
   {
      global $apAuth;
      $apAuth->initUserData();
      global $aclmanager;


      $this->type_id->Clear();
      //$this->field_thematiki_enotita->AddItem('',null,'0');
      //var_dump($apAuth->userData);
      if(($aclmanager->Role == 'admin_foreas')or($aclmanager->Role == 'user'))
      {
           if (($apAuth->userData['ypourgeio_table']=='yp_xwris_ypourgeio') or($apAuth->userData['ypourgeio_table']=='foreis_mt'))
           {    //user does NOT belong to a ministry
                $query = "SELECT * from ypografontes_types WHERE NOT servicetype='special' AND servicetype='other' ORDER BY name ASC;";
           }
           else
           {
                //user belongs to a ministry
                $query = "SELECT * from ypografontes_types WHERE NOT servicetype='special' ORDER BY name ASC;";
           }

           if ($apAuth->userData['username']=='23290_admin')
           {    //user is specifically: 23290_admin
                // 04-05-2012 Changed in order to add any signer from:
                //$query = "SELECT * from ypografontes_types WHERE type='PM' ORDER BY name ASC;";
                // To
                $query = "SELECT * from ypografontes_types ORDER BY name ASC;";
           }
      }
      else
      {    //user is super-admin
           $query = "SELECT * from ypografontes_types ORDER BY name ASC;";
      }

      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();
      for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
      {
         $this->type_id->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
         $apAuth->Query_General->next();
      }
      $this->en_energeia->ItemIndex = 1;
      //Get the action to perform

      if(($aclmanager->Role == 'admin_foreas')or($aclmanager->Role == 'user'))
      {
         $query = "SELECT monades.*,monades_types.name as type_name from monades,monades_types WHERE monades.type_id=monades_types.ID AND parent_pb_id='".$apAuth->userData['start_pb_id']."'";
      }
      else
      {
         $query = "SELECT monades.*,monades_types.name as type_name from monades,monades_types WHERE monades.type_id=monades_types.ID";
      }
      $this->monada_id->Clear();
      $this->monada_id->AddItem('', null ,'0');
      $this->monada_id->AddItem('O συγκεκριμένος  Υπογραφοντας μπορεί να υπογραφει για όλες τις μονάδες του Φορέα', null ,'1000000');
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();
      for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
      {
         $this->monada_id->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
         $apAuth->Query_General->next();
      }


      global $apAuth;
      global $aclmanager;
      $selected_pb_id = $apAuth->userData['start_pb_id'];
      $ypourgeio_table = $apAuth->userData['ypourgeio_table'];
      $this->ypourgeio_table->Value = $ypourgeio_table;
      if(($aclmanager->Role == 'admin_foreas')or($aclmanager->Role == 'user'))
      {
         $query = "SELECT * FROM " . $ypourgeio_table . " where pb_id=" . $selected_pb_id . " AND hidden=0 order by name asc";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();
         for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
         {
            $this->pb_id_value_label->Text = $apAuth->Query_General->Fields['name'];
            $this->pb_id->Value = $apAuth->Query_General->Fields['pb_id'];
            $apAuth->Query_General->next();
         }
      }


      $action = $this->input->action;
      if(is_object($action))
      {
         //If there is any edit_id on the input
         $edit_id = $this->input->edit_id;
         if(is_object($edit_id))
         {
            $query = "SELECT * FROM ypografontes where MD5(ID)='" . mysql_escape_string($_REQUEST['edit_id']) . "'";
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $edit_id->stream['edit_id'] = $apAuth->Query_General->Fields['ID'];
            //Filter the table
            $this->EditTable->Filter = " ID='" . $edit_id->asInteger() . "' ";
            $this->EditTable->Refresh();
            $this->ID->Value=$edit_id->asString();

            //If the user wants to edit a register
            if($action->asString() == 'edit')
            {
               $query = "SELECT * FROM ypografontes where ID='" . $edit_id->asInteger() . "'";
               $apAuth->Query_General->SQL = $query;
               $apAuth->Query_General->LimitCount = "-1";
               $apAuth->Query_General->LimitStart = "-1";
               $apAuth->Query_General->Prepare();
               $apAuth->Query_General->close();
               $apAuth->Query_General->open();
               $selected_type_id = $apAuth->Query_General->Fields['type_id'];
               $selected_pb_id = $apAuth->Query_General->Fields['pb_id'];
               $monada_id = $apAuth->Query_General->Fields['monada_id'];
               $selected_en_energeia = $apAuth->Query_General->Fields['en_energeia'];
               $this->type_id->ItemIndex = $selected_type_id;
               $this->en_energeia->ItemIndex = $selected_en_energeia;
               $ypourgeio_table = $apAuth->Query_General->Fields['ypourgeio_table_name'];
               $this->ypourgeio_table->Value = $ypourgeio_table;
               $this->monada_id->ItemIndex = $monada_id;

               $query = "SELECT * FROM " . $ypourgeio_table . " where pb_id=" . $selected_pb_id . " AND hidden=0 order by name asc";
               $apAuth->Query_General->SQL = $query;
               $apAuth->Query_General->LimitCount = "-1";
               $apAuth->Query_General->LimitStart = "-1";
               $apAuth->Query_General->Prepare();
               $apAuth->Query_General->close();
               $apAuth->Query_General->open();
               for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
               {
                  $this->pb_id_value_label->Text = $apAuth->Query_General->Fields['name'];
                  $this->pb_id->Value = $apAuth->Query_General->Fields['pb_id'];
                  $apAuth->Query_General->next();
               }


               $this->Label14->Caption = "Ενημέρωση Υπογράφοντα";
               $this->btnPost->Visible = false;
               $this->btnUpdate->Visible = true;
               //Make the panel visible
               $this->Panel1->Visible = true;

            }
            else if($action->asString() == 'delete')
            {
               //Delete the register and refresh the repeater table
               global $apAuth;
               $query = "DELETE FROM ypografontes WHERE ID=" . $edit_id->asInteger();
               $apAuth->DB_General->execute($query);
               $apAuth->YpografontesTable->Refresh();
               $this->lbMessages->Caption = "Η εγγραφή διαγράφηκε επιτυχώς";
                echo '<script language="JavaScript" type="text/javascript">
alert("'.$this->lbMessages->Caption.'");
</script>';

            }
         }

      }
   }

   function btnPostClick($sender, $params)
   {
      //Just post the modified contents so get stored
      try
      {

         global $apAuth;
         $yp_table = pb_idToTable(mysql_escape_string($_REQUEST['pb_id']));
         $query =
         "
         INSERT INTO `apofaseis`.`ypografontes` (
         `ID` ,
         `ypourgeio_table_name` ,
         `pb_id` ,
         `type_id` ,
         `monada_id` ,
         `firstname` ,
         `lastname` ,
         `telephone` ,
         `email` ,
         `fax` ,
         `address` ,
         `en_energeia`
         )
         VALUES (
         NULL ,
         '" . $yp_table . "',
         '" . mysql_escape_string($_REQUEST['pb_id']) . "',
         '" . mysql_escape_string($_REQUEST['type_id']) . "',
         '" . mysql_escape_string($_REQUEST['monada_id']) . "',
         '" . mysql_escape_string($_REQUEST['firstname']) . "',
         '" . mysql_escape_string($_REQUEST['lastname']) . "',
         '" . mysql_escape_string($_REQUEST['telephone']) . "',
         '" . mysql_escape_string($_REQUEST['email']) . "',
         '" . mysql_escape_string($_REQUEST['fax']) . "',
         '" . mysql_escape_string($_REQUEST['address']) . "',
         '" . mysql_escape_string($_REQUEST['en_energeia']) . "'
         );
         ";


         $apAuth->DB_General->execute($query);
         $apAuth->YpografontesTable->Refresh();
         $this->lbMessages->Caption = "Η εγγραφή καταχωρήθηκε επιτυχώς";
         $this->lbMessages->Visible = true;

      }
      catch(Exception $e)
      {
         echo $e->getMessage();
         $this->lbMessages->Caption = "Παρουσιάστικε σφάλμα κατά την καταχώριση.";
         $this->lbMessages->Visible = true;
         $this->Panel1->Visible = true;
      }


      echo '<script language="JavaScript" type="text/javascript">
alert("'.$this->lbMessages->Caption.'");
</script>';
   }

   function btnUpdateClick($sender, $params)
   {
      //Just post the modified contents so get stored
      try
      {
         global $apAuth;
         $yp_table = pb_idToTable(mysql_escape_string($_REQUEST['pb_id']));
         $query =
         "update ypografontes
         set
         ypourgeio_table_name = '" . $yp_table . "' ,
         pb_id = '" . mysql_escape_string($_REQUEST['pb_id']) . "' ,
         type_id = '" . mysql_escape_string($_REQUEST['type_id']) . "' ,
         monada_id = '" . mysql_escape_string($_REQUEST['monada_id']) . "' ,
         firstname = '" . mysql_escape_string($_REQUEST['firstname']) . "' ,
         lastname = '" . mysql_escape_string($_REQUEST['lastname']) . "' ,
         telephone = '" . mysql_escape_string($_REQUEST['telephone']) . "' ,
         email = '" . mysql_escape_string($_REQUEST['email']) . "' ,
         fax = '" . mysql_escape_string($_REQUEST['fax']) . "' ,
         address = '" . mysql_escape_string($_REQUEST['address']) . "' ,
         en_energeia = '" . mysql_escape_string($_REQUEST['en_energeia']) . "'
         where ID ='" . mysql_escape_string($_REQUEST['ID']) . "'";

         $apAuth->DB_General->execute($query);
         $apAuth->YpografontesTable->Refresh();
         $this->lbMessages->Caption = "Η εγγραφή ενημερώθηκε επιτυχώς";
         $this->lbMessages->Visible = true;


      }
      catch(Exception $e)
      {
         echo $e->getMessage();
         $this->lbMessages->Caption = "Παρουσιάστικε σφάλμα κατά την ενημέρωση.";
         $this->lbMessages->Visible = true;
         $this->Panel1->Visible = true;
      }


      echo '<script language="JavaScript" type="text/javascript">
alert("'.$this->lbMessages->Caption.'");
</script>';

   }
}

global $application;

global $manage_ypografontes;

//Creates the form
$manage_ypografontes = new manage_ypografontes($application);

//Read from resource file
$manage_ypografontes->loadResource(__FILE__);

//Shows the form
$manage_ypografontes->show();

?>