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
if(!($apAuth->ZAuth->UserRealm == 'admin'))
{
   redirect_withdetection("login.php");
}

//$_SESSION[MY_SESSION_VAR_NAME]=$_MYSESSION;

//Class definition
class manage_foreis_edit extends Page
{
   public $Pager = null;
   public $Label3 = null;
   public $field_level0_text = null;
   public $table_name = null;
   public $field_name = null;
   public $Label_searchterms = null;
   public $Button_searchterms = null;
   public $field_searchterms = null;
   public $ID = null;
   public $pb_id = null;
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
   public $btnAdd = null;
   public $Label14 = null;
   public $dsRepeater = null;
   public $Label2 = null;
   public $DBRepeater1 = null;
   public $Panel1 = null;
   public $btnPost = null;
   function btnUpdateJSClick($sender, $params)
   {

   ?>
   //Add your javascript code here
        var returnval;
        returnval=true;
        if (document.getElementById("field_level0_text").value=='0')
         {
               alert('Παρακαλούμε Επιλέξτε Κατηγορία Φορέα.');
               returnval=false;

         }
        if (document.getElementById("field_name").value=='')
         {
               alert('Παρακαλούμε εισάγετε ένα όνομα φορέα.');
               returnval=false;

         }
        return returnval;
   <?php

   }

   function btnPostJSClick($sender, $params)
   {

   ?>
   //Add your javascript code here
        var returnval;
        returnval=true;
        if (document.getElementById("field_level0_text").value=='0')
         {
               alert('Παρακαλούμε Επιλέξτε Κατηγορία Φορέα.');
               returnval=false;

         }
        if (document.getElementById("field_name").value=='')
         {
               alert('Παρακαλούμε εισάγετε ένα όνομα φορέα.');
               returnval=false;

         }
        return returnval;
   <?php

   }





   function ypografontesCSVAddJSClick($sender, $params)
   {

?>
   //Add your javascript code here


<?php

   }






   function manage_foreis_editCreate($sender, $params)
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
            if (!(isset($_REQUEST['action'])))
            {
               $apAuth->ForeisAllView->LimitStart=0;
               $apAuth->ForeisAllView->LimitCount=20;
               $apAuth->ForeisAllView->Filter =
               "  name LIKE '%".$_SESSION['field_searchterms']."%' OR pb_id LIKE '%".$_SESSION['field_searchterms']."%' ";
               $this->Pager->current_page=1;
               $apAuth->ForeisAllView->Active = false;
               $apAuth->ForeisAllView->Active = true;
               $apAuth->ForeisAllView->refresh();
            }
            else
            {
               $apAuth->ForeisAllView->LimitStart=0;
               $apAuth->ForeisAllView->LimitCount=20;
               $apAuth->ForeisAllView->Filter =
               "  name LIKE '-1234567890987654321' OR pb_id LIKE '-1234567890987654321' ";
               $this->Pager->current_page=1;
               $apAuth->ForeisAllView->Active = false;
               $apAuth->ForeisAllView->Active = true;
               $this->field_searchterms->Text='';
            }
         }
         else
         {
            $apAuth->ForeisAllView->LimitStart=0;
            $apAuth->ForeisAllView->LimitCount=20;
            $apAuth->ForeisAllView->Filter =
            "  name LIKE '-1234567890987654321' OR pb_id LIKE '-1234567890987654321' ";
            $this->Pager->current_page=1;
             $apAuth->ForeisAllView->Active = false;
             $apAuth->ForeisAllView->Active = true;
         }
      }
      
      $usermessage .= "</small></div>";
      $this->Label1->Caption = $usermessage;

      /*      */
      if ($apAuth->ForeisAllView->RecordCount==0)
      {
          $this->Pager->DataSource=null;
          $this->Pager->Visible=false;
      }
      else
      {
          $this->Pager->DataSource=$this->dsRepeater;
      }


      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");

      $this->field_level0_text->Clear();
      $this->field_level0_text->AddItem("", null , "0");
      $query = "SELECT * FROM `foreis_mt` WHERE pb_supervisor_id=5000 OR (`pb_supervisor_id`>=5001 AND `pb_supervisor_id`<5014 AND `pb_id`>=6001 AND `pb_id`<6500) ORDER BY pb_id ASC";
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
      $query = "SELECT * FROM `foreis_mt` WHERE `pb_id` LIKE '991%' and level=2 ORDER BY pb_supervisor_id ASC";
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
      $this->field_level0_text->AddItem("Τίποτα από τα παραπάνω", null , "99300001");
      $this->field_level0_text->Enabled=true;
      $this->field_level0_text->ItemIndex=0;


   }

   function manage_foreis_editJSSubmit($sender, $params)
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
  //    $this->Label17->Link = "manage_foreis_edit.php?action=delete&edit_id=" . md5($apAuth->ForeisAllView->Fields['pb_id']);
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
      $this->btnPost->Visible = true;
      $this->btnUpdate->Visible = false;
      $this->Panel1->Visible = true;
   }

   function fdClassesBeforeShow($sender, $params)
   {
      global $apAuth;
      global $aclmanager;
      //Before showing the label, set the Link property to the URL we want
      $this->LineLabel->Caption =$apAuth->ForeisAllView->Fields['name'];
      $this->editLabel->Link = "manage_foreis_edit.php?action=edit&edit_id=" . md5($apAuth->ForeisAllView->Fields['pb_id']);
   }

   function Panel1AfterShow($sender, $params)
   {
      //This way, the panel is hidden so it's only shown when editing
      $sender->Visible = false;
   }

   function manage_foreis_editBeforeShow($sender, $params)
   {
      global $apAuth;
      $apAuth->initUserData();
      global $aclmanager;
      $action = $this->input->action;
      if(is_object($action))
      {
         //If there is any edit_id on the input
         $edit_id = $this->input->edit_id;
         if(is_object($edit_id))
         {
            $apAuth->DB_General->DoConnect();
            $apAuth->DB_General->execute("SET NAMES utf8");
            $query = "SELECT * FROM foreis_all_editable_VIEW where MD5(pb_id)='" . mysql_escape_string($_REQUEST['edit_id']) . "'";
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $this->table_name->Value=$apAuth->Query_General->Fields['table_name'];
            $edit_id->stream['edit_id'] = $apAuth->Query_General->Fields['pb_id'];
            //Filter the table
            $this->EditTable->Filter = " pb_id='" . $edit_id->asInteger() . "' ";
            $this->EditTable->Active = false;
            $this->EditTable->Active = true;
            $this->EditTable->Refresh();
            $this->ID->Value=$edit_id->asString();



            //If the user wants to edit a register
            if($action->asString() == 'edit')
            {
               $query = "SELECT * FROM foreis_all_editable_VIEW where pb_id='" . $edit_id->asInteger() . "'";
               $apAuth->Query_General->SQL = $query;
               $apAuth->Query_General->LimitCount = "-1";
               $apAuth->Query_General->LimitStart = "-1";
               $apAuth->Query_General->Prepare();
               $apAuth->Query_General->close();
               $apAuth->Query_General->open();
               if ($this->field_level0_text->Items[$apAuth->Query_General->Fields['pb_supervisor_id']]==NULL)
               {
                 $this->field_level0_text->AddItem("Μη ενημερώσιμο πεδίο", null ,   "111111111");
                 $this->field_level0_text->ItemIndex=111111111;
                 $this->field_level0_text->Enabled=false;
               }
               else
               {
                 $this->field_level0_text->ItemIndex=$apAuth->Query_General->Fields['pb_supervisor_id'];
               }
               $this->Label14->Caption = "Ενημέρωση Φορέα";
               $this->btnPost->Visible = false;
               $this->btnUpdate->Visible = true;
               //Make the panel visible
               $this->Panel1->Visible = true;

            }
            else if($action->asString() == 'delete')
            {
               //Delete the register and refresh the repeater table
               global $apAuth;
               $query = "DELETE FROM foreis_all_editable_VIEW WHERE pb_id=" . $edit_id->asInteger();
               $apAuth->DB_General->execute($query);
               $apAuth->ForeisAllView->Refresh();
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


      $query = "SELECT max( CONVERT(pb_id, UNSIGNED) ) +1 AS new_pb_id FROM `foreis_mt` WHERE pb_id >50000 AND pb_id <600000 ";
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();
      $ffield_new_pb_id=$apAuth->Query_General->Fields['new_pb_id'];

      $ffield_level0_text = mysql_escape_string($_REQUEST["field_level0_text"]);
      $ffield_foreas_name = mysql_escape_string($_REQUEST["field_name"]);



            $query = "
INSERT INTO `apofaseis`.`foreis_mt` (
`pb_id` ,
`name` ,
`pb_supervisor_id` ,
`level`
)
VALUES (
'" . $ffield_new_pb_id . "',
'" . $ffield_foreas_name . "',
'". $ffield_level0_text ."',
'3'
);
         ";


         $apAuth->DB_General->execute($query);
            $query = "
INSERT INTO `apofaseis`.`foreis` (
`pb_id` ,
`name` ,
`pb_supervisor_id` ,
`level`
)
VALUES (
'" . $ffield_new_pb_id . "',
'" . $ffield_foreas_name . "',
'". $ffield_level0_text ."',
'3'
);
         ";


         $apAuth->DB_General->execute($query);
         //$apAuth->ForeisAllView->Refresh();
         $this->lbMessages->Caption = "Record saved succesfully";
         $this->lbMessages->Visible = true;

      }
      catch(Exception $e)
      {
         echo $e->getMessage();
         $this->lbMessages->Caption = "Error saving the record, please, check required fields";
         $this->lbMessages->Visible = true;
         $this->Panel1->Visible = true;
      }
   }

   function btnUpdateClick($sender, $params)
   {
      //Just post the modified contents so get stored
      try
      {
         global $apAuth;
         if (($_REQUEST['field_level0_text']=='111111111') || ($_REQUEST['field_level0_text']==''))
         {
           $query =
           "update ".mysql_escape_string($_REQUEST["table_name"])."
           set
           name = '" . mysql_escape_string($_REQUEST['field_name']) . "'
           where pb_id ='" . mysql_escape_string($_REQUEST['ID']) . "'";
         }
           else
         {
           $query =
           "update ".mysql_escape_string($_REQUEST["table_name"])."
           set
           name = '" . mysql_escape_string($_REQUEST['field_name']) . "' ,
           pb_supervisor_id = '" . mysql_escape_string($_REQUEST['field_level0_text']) . "'
           where pb_id ='" . mysql_escape_string($_REQUEST['ID']) . "'";
         }

         $apAuth->DB_General->execute($query);
         if (($_REQUEST['field_level0_text']=='111111111') || ($_REQUEST['field_level0_text']==''))
         {
           $query =
           "update foreis
           set
           name = '" . mysql_escape_string($_REQUEST['field_name']) . "'
           where pb_id ='" . mysql_escape_string($_REQUEST['ID']) . "'";
         }
           else
         {
           $query =
           "update foreis
           set
           name = '" . mysql_escape_string($_REQUEST['field_name']) . "' ,
           pb_supervisor_id = '" . mysql_escape_string($_REQUEST['field_level0_text']) . "'
           where pb_id ='" . mysql_escape_string($_REQUEST['ID']) . "'";
         }

         $apAuth->DB_General->execute($query);

               $apAuth->ForeisAllView->LimitStart=0;
               $apAuth->ForeisAllView->LimitCount=20;
               $apAuth->ForeisAllView->Filter =
               "  name LIKE '-1234567890987654321' OR pb_id LIKE '-1234567890987654321' ";
               $this->Pager->current_page=1;
               $apAuth->ForeisAllView->Active = false;
               $apAuth->ForeisAllView->Active = true;

         $this->lbMessages->Caption = "Record saved succesfully";
         $this->lbMessages->Visible = true;


      }
      catch(Exception $e)
      {
         echo $e->getMessage();
         $this->lbMessages->Caption = "Error saving the record, please, check required fields";
         $this->lbMessages->Visible = true;
         $this->Panel1->Visible = true;
      }


   }
}

global $application;

global $manage_foreis_edit;

//Creates the form
$manage_foreis_edit = new manage_foreis_edit($application);

//Read from resource file
$manage_foreis_edit->loadResource(__FILE__);

//Shows the form
$manage_foreis_edit->show();

?>