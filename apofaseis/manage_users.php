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
use_unit("pager.inc.php");
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

if((!($apAuth->ZAuth->UserRealm == 'admin'))and(!($apAuth->ZAuth->UserRealm == 'admin_foreas')))
{
   redirect_withdetection("login.php");
}

//$_SESSION[MY_SESSION_VAR_NAME]=$_MYSESSION;

//Class definition
class manage_users extends Page
{
   public $Label21 = null;
   public $Button_searchterms = null;
   public $field_searchterms = null;
   public $Label_searchterms = null;
   public $Label20 = null;
   public $Label19 = null;
   public $user_id = null;
   public $password_feedback = null;
   public $password_verification = null;
   public $Label16 = null;
   public $Pager = null;
   public $pb_id = null;
   public $ID = null;
   public $telephone_yp = null;
   public $Label3 = null;
   public $field_results = null;
   public $field_search_terms = null;
   public $Button_search = null;
   public $Button2 = null;
   public $Label7 = null;
   public $pb_id_value_label = null;
   public $ypourgeio_table = null;
   public $email = null;
   public $Label18 = null;
   public $Label15 = null;
   public $Label13 = null;
   public $Label12 = null;
   public $LogoutLabel = null;
   public $Label1 = null;
   public $realm = null;
   public $comments = null;
   public $lastname = null;
   public $firstname = null;
   public $password = null;
   public $username = null;
   public $btnUpdate = null;
   public $EditUsersTableDs = null;
   public $EditUsersTable = null;
   public $Label11 = null;
   public $Label10 = null;
   public $Label9 = null;
   public $Label8 = null;
   public $Label6 = null;
   public $Label5 = null;
   public $fdClasses = null;
   public $Label17 = null;
   public $lbMessages = null;
   public $btnAdd = null;
   public $Label14 = null;
   public $Label4 = null;
   public $dsRepeater = null;
   public $Label2 = null;
   public $DBRepeater1 = null;
   public $Panel1 = null;
   public $btnPost = null;
   function btnUpdateJSClick($sender, $params)
   {

?>
   //Add your javascript code here
   var retval=false;
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = document.getElementById("email").value;

      function validatePassword(password)
 {
   var regex = /[^0-9a-zA-Z!@#$]/g;
   r1=/[A-Z]/g;
   r2=/[a-z]/g;
   r3=/[!@#$]/g;
   r4=/[0-9]/g;

   r1_len = password.match(r1);
   r1_len = (r1_len) ? r1_len.length : 0;

   r2_len = password.match(r2);
   r2_len = (r2_len) ? r2_len.length : 0;

   r3_len = password.match(r3);
   r3_len = (r3_len) ? r3_len.length : 0;

   r4_len = password.match(r4);
   r4_len = (r4_len) ? r4_len.length : 0;

   if (!(password.replace(regex,'')==password)) return false;

  // if(r1_len<2) return false;

  // if(r2_len<2) return false;

   if(r3_len<1) return false;

   if(r4_len<1) return false;

   if(password.length<8) return false;

   return true;
}


   if (!validatePassword(document.getElementById("password").value))
   {
      alert("Ο κωδικός σας πρέπει να έχει μέγεθος τουλάχιστο 8 χαρακτήρες. Yποχρεωτικά θα πρέπει να περιλαμβάνεται ένα σύμβολο από τα:  !,@,#,$ και ένας αριθμός από το 0 έως το 9 . Οι χαρακτήρες θα  πρέπει να ειναι στα λατινικά! ");
       retval=false;
   }
   else
   if (!(document.getElementById("password").value==document.getElementById("password_verification").value))
   {
       alert("Οι κωδικοί των πεδίων πρέπει να συμπίπτουν.");
       retval= false;
   }
   else
   if (document.getElementById("email").value=='')
   {
       alert("Το πεδίο E-mail είναι υποχρεωτικό.");
       retval= false;
   }
   else
   if (document.getElementById("username").value=='')
   {
       alert("Το πεδίο Χρήστης (Username) είναι υποχρεωτικό.");
       retval= false;
   }
   else
   if (document.getElementById("password").value=='')
   {
       alert("Το πεδίο Κωδικός (Password) είναι υποχρεωτικό.");
       retval= false;
   }
   else
   if (document.getElementById("pb_id_value_label").value=='')
   {
       alert("Το πεδίο Φορέας Έκδοσης είναι υποχρεωτικό.");
       retval= false;
   }
   else
   if (document.getElementById("firstname").value=='')
   {
       alert("Το πεδίο Όνομα είναι υποχρεωτικό.");
       retval= false;
   }
   else
   if (document.getElementById("lastname").value=='')
   {
       alert("Το πεδίο Επώνυμο είναι υποχρεωτικό.");
       retval= false;
   }
   else
   if (document.getElementById("telephone_yp").value=='')
   {
       alert("Το πεδίο Υπηρεσιακό Τηλέφωνο είναι υποχρεωτικό.");
       retval= false;
   }
   else
   if (reg.test(address) == false)
   {
       alert("Το πεδίο E-mail δεν είναι έγκυρο.");
       retval= false;
   }
   else
   {
       retval= true;
   }






   return retval;
<?php

   }

   function passwordJSBlur($sender, $params)
   {

?>
   //Add your javascript code here
   function validatePassword(password)
 {
   var regex = /[^0-9a-zA-Z!@#$]/g;
   r1=/[A-Z]/g;
   r2=/[a-z]/g;
   r3=/[!@#$]/g;
   r4=/[0-9]/g;

   r1_len = password.match(r1);
   r1_len = (r1_len) ? r1_len.length : 0;

   r2_len = password.match(r2);
   r2_len = (r2_len) ? r2_len.length : 0;

   r3_len = password.match(r3);
   r3_len = (r3_len) ? r3_len.length : 0;

   r4_len = password.match(r4);
   r4_len = (r4_len) ? r4_len.length : 0;

   if (!(password.replace(regex,'')==password)) return false;

  // if(r1_len<2) return false;

  // if(r2_len<2) return false;

   if(r3_len<1) return false;

   if(r4_len<1) return false;

   if(password.length<8) return false;

   return true;
}


   if (!validatePassword(document.getElementById("password").value))
   {
      document.getElementById("password_feedback").innerHTML='<small><FONT COLOR="red">Ο κωδικός σας πρέπει να έχει μέγεθος τουλάχιστο 8 χαρακτήρες. Yποχρεωτικά θα πρέπει να περιλαμβάνεται ένα σύμβολο από τα:  !,@,#,$ και ένας αριθμός από το 0 έως το 9 . Οι χαρακτήρες θα  πρέπει να ειναι στα λατινικά!</FONT></small>';
       retval=false;
   }
   else
   if (!(document.getElementById("password").value==document.getElementById("password_verification").value))
   {
       document.getElementById("password_feedback").innerHTML='<small><FONT COLOR="red"> Οι κωδικοί των πεδίων πρέπει να συμπίπτουν.</FONT></small>';
   }
   else
   {
       document.getElementById("password_feedback").innerHTML='';
   }
<?php

   }





   function usernameBeforeShow($sender, $params)
   {
      $action = $this->input->action;
      if(!(is_object($action)))
      {
         global $apAuth;
         $apAuth->initUserData();
         $this->username->DataField = '';
         $this->username->Text = getNewUniqueUserName($apAuth->userData['start_pb_id']);
      }
      else
      {
         $this->username->DataField = 'username';
      }
      global $aclmanager;
      if(($aclmanager->Role == 'admin_foreas')or($aclmanager->Role == 'user'))
      {
         $this->username->ReadOnly = true;
      }
      else
      {
         $this->username->ReadOnly = false;
      }


   }


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







   function yp_tableJSChange($sender, $params)
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

      document.getElementById("pb_id").disabled=false;
      document.getElementById("pb_id_outer").innerHTML='<?php
      echo '<input type="hidden" name="pb_id_key[username]" value="admin" />';
      echo '<select name="pb_id" id="pb_id" size="1" style=" font-family: Verdana; font-size: 10px;  height:16px;width:597px;"   tabindex="0"   >';
?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';
    }
  }


    document.getElementById("pb_id").disabled=true;

    var si=document.getElementById("yp_table").selectedIndex;
    var vali=document.getElementById("yp_table").options[si].value;
    xmlhttp.open("GET","getMinistryData.php?ministry="+vali,true);
    xmlhttp.send();


   return false;
<?php

   }




   function manage_usersCreate($sender, $params)
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
      if($aclmanager->Role == 'user')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Χρήστης Φορέα:</STRONG> " . $apAuth->userData['foreas_name'] . "";
         $this->field_results->Visible = false;
         $this->field_search_terms->Visible = false;
         $this->Button2->Visible = false;
         $this->Button_search->Visible = false;
         $this->Label7->Visible = false;
         //$this->Label17->Visible = false;
         if(isset($_REQUEST['field_searchterms']))
         {
            $field_searchterms = mysql_escape_string($_REQUEST['field_searchterms']);
            $_SESSION['field_searchterms'] = $field_searchterms;
         }

         if(isset($_REQUEST['field_searchterms'])or isset($_SESSION['field_searchterms'])and(!($_REQUEST['field_searchterms'] == '')or !($_SESSION['field_searchterms'] == '')))
         {
            $apAuth->UserTable->LimitStart = 0;
            $apAuth->UserTable->LimitCount = 20;
            $apAuth->UserTable->Filter =
            "(username LIKE '%" . $_SESSION['field_searchterms'] . "%' OR " .
            "firstname LIKE '%" . $_SESSION['field_searchterms'] . "%' OR " .
            "lastname LIKE '%" . $_SESSION['field_searchterms'] . "%') AND " .
            " (realm='admin_foreas' OR realm='user' OR realm='disabled') AND start_pb_id='" . $apAuth->userData['start_pb_id'] . "'";
            $this->Pager->current_page = 1;
         }
         else
         {
            $apAuth->UserTable->Filter = " (realm='admin_foreas' OR realm='user' OR realm='disabled') AND start_pb_id='" . $apAuth->userData['start_pb_id'] . "'";
         }
         $this->realm->Clear();
         $this->realm->AddItem('Διαχειριστής Φορέα', null , '2');
         $this->realm->AddItem('Χρήστης Φορέα', null , '3');
         $this->realm->AddItem('', null , '0');
      }
      if($aclmanager->Role == 'admin_foreas')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Διαχειριστής Φορέα:</STRONG> " . $apAuth->userData['foreas_name'] . "";
         $this->field_results->Visible = false;
         $this->field_search_terms->Visible = false;
         $this->Button2->Visible = false;
         $this->Button_search->Visible = false;
         $this->Label7->Visible = false;
         //$this->Label17->Visible = false;
         if(isset($_REQUEST['field_searchterms']))
         {
            $field_searchterms = mysql_escape_string($_REQUEST['field_searchterms']);
            $_SESSION['field_searchterms'] = $field_searchterms;
         }

         if(isset($_REQUEST['field_searchterms'])or isset($_SESSION['field_searchterms'])and(!($_REQUEST['field_searchterms'] == '')or !($_SESSION['field_searchterms'] == '')))
         {
            $apAuth->UserTable->LimitStart = 0;
            $apAuth->UserTable->LimitCount = 20;
            $apAuth->UserTable->Filter =
            "(username LIKE '%" . $_SESSION['field_searchterms'] . "%' OR " .
            "firstname LIKE '%" . $_SESSION['field_searchterms'] . "%' OR " .
            "lastname LIKE '%" . $_SESSION['field_searchterms'] . "%') AND " .
            " (realm='admin_foreas' OR realm='user' OR realm='disabled') AND start_pb_id='" . $apAuth->userData['start_pb_id'] . "'";
            $this->Pager->current_page = 1;
         }
         else
         {
            $apAuth->UserTable->Filter = " (realm='admin_foreas' OR realm='user' OR realm='disabled') AND start_pb_id='" . $apAuth->userData['start_pb_id'] . "'";
         }
         $this->realm->Clear();
         $this->realm->AddItem('Διαχειριστής Φορέα', null , '2');
         $this->realm->AddItem('Χρήστης Φορέα', null , '3');
         $this->realm->AddItem('Απενεργοποιημένος', null , '4');
         $this->realm->AddItem('', null , '0');
         $this->realm->ItemIndex = 0;
      }
      if($aclmanager->Role == 'admin')
      {
         $usermessage .= "<br><STRONG>Logged in as admin</STRONG>";
      }
      $usermessage .= "</small></div>";
      
      $this->Label1->Caption = $usermessage;
      if($aclmanager->Role == 'admin')
      {
         //$this->Label17->Visible = false;
         $apAuth->UserTable->LimitStart = "-1";
         $apAuth->UserTable->LimitCount = "-1";
         if(isset($_REQUEST['field_searchterms']))
         {
            $field_searchterms = mysql_escape_string($_REQUEST['field_searchterms']);
            $_SESSION['field_searchterms'] = $field_searchterms;
         }

         if(isset($_REQUEST['field_searchterms'])or isset($_SESSION['field_searchterms'])and(!($_REQUEST['field_searchterms'] == '')or !($_SESSION['field_searchterms'] == '')))
         {
            $apAuth->UserTable->LimitStart = 0;
            $apAuth->UserTable->LimitCount = 20;
            $apAuth->UserTable->Filter =
            "username LIKE '%" . $_SESSION['field_searchterms'] . "%' OR " .
            "firstname LIKE '%" . $_SESSION['field_searchterms'] . "%' OR " .
            "lastname LIKE '%" . $_SESSION['field_searchterms'] . "%' ";
            $this->Pager->current_page = 1;
         }
         else
         {
            $apAuth->UserTable->Filter = "";
         }
      }
      $apAuth->UserTable->Active = false;
      $apAuth->UserTable->Active = true;
      $apAuth->UserTable->refresh();

      if($apAuth->UserTable->RecordCount == 0)
      {
         $this->Pager->DataSource = null;
         $this->Pager->Visible = false;
      }
      else
      {
         $this->Pager->DataSource = $this->dsRepeater;
      }
      $this->EditUsersTable->Active = false;
      $this->EditUsersTable->Active = true;
      $this->EditUsersTable->Refresh();
      $this->realm->ItemIndex = 0;

   }

   function manage_usersJSSubmit($sender, $params)
   {
?>
      msg="";
      result=true;
      //Simple JS validation
      if ((document.manage_users.realm) && (document.manage_users.realm.value=="0"))
      {
        result=false;
        msg+="Παρακαλούμε επιλέξτε τον ρόλο του χρήστη.";
      }

   var regex = /[^0-9a-zA-Z#%!$]/g;
   if (!(document.getElementById("password").value==document.getElementById("password_verification").value))
   {
       document.getElementById("password_feedback").innerHTML='<small><FONT COLOR="red"> Οι κωδικοί των πεδίων πρέπει να συμπίπτουν.</FONT></small>';
       msg+='Οι κωδικοί των πεδίων πρέπει να συμπίπτουν.';
       result=false;
   }

   if (!(document.getElementById("password").value.replace(regex,'')==document.getElementById("password").value))
   {
       document.getElementById("password_feedback").innerHTML='<small><FONT COLOR="red">Μπορείτε να χρησιμοποιήσετε συνδυασμούς λατινικών γραμμάτων αριθμών και ΜΟΝΟ των συμβόλων: #,$,%,!</FONT></small>';
       msg+='Μπορείτε να χρησιμοποιήσετε συνδυασμούς λατινικών γραμμάτων αριθμών και ΜΟΝΟ των συμβόλων: #,$,%,!';
       result=false;
   }
      if (!result)
      {
        alert(msg);
      }
      return(result);
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
    $query = "SELECT * FROM apofaseis where user='" . $apAuth->UserTable->username . "'";
      $apAuth->Query_General2->SQL = $query;
      $apAuth->Query_General2->LimitCount = "-1";
      $apAuth->Query_General2->LimitStart = "-1";
      $apAuth->Query_General2->Prepare();
      $apAuth->Query_General2->close();
      $apAuth->Query_General2->open();
      if(($apAuth->Query_General2->RecordCount == 0)and(!($apAuth->UserTable->username == 'admin'))and(!($apAuth->UserTable->username == 'admin_foreas')))
      {
         $this->Label17->Enabled = true;
         $this->Label17->Link = "manage_users.php?action=delete&edit_id=" . md5($apAuth->UserTable->ID);
         $this->Label17->Caption = "[Διαγραφή]";
      }
      else
      {
         $this->Label17->Enabled = false;
         $this->Label17->Link = "";
         $this->Label17->Caption = "";
      }

      /* }
      else
      {
      $this->Label17->Link = "manage_users.php?action=delete&edit_id=" . $apAuth->UserTable->ID;
      }   /* */
   }

   function lbMessagesAfterShow($sender, $params)
   {
      //This is a simple message label, so must show and be hidden for next operations
      $sender->Visible = false;
   }

   function btnAddClick($sender, $params)
   {
      //Cancel any pending change
      $this->EditUsersTable->Cancel();

      //Append a new record
      $this->EditUsersTable->Append();
      $this->realm->ItemIndex = 3;
      $this->Label14->Caption = "Δημιουργία νέου χρήστη";
      //Prompt the user for info
      $this->btnPost->Visible = true;
      $this->btnUpdate->Visible = false;
      $this->Panel1->Visible = true;
   }

   function fdClassesBeforeShow($sender, $params)
   {
      global $apAuth;
      //Before showing the label, set the Link property to the URL we want
      $this->fdClasses->Link = "manage_users.php?action=edit&edit_id=" . md5($apAuth->UserTable->ID);
   }

   function Panel1AfterShow($sender, $params)
   {
      //This way, the panel is hidden so it's only shown when editing
      $sender->Visible = false;
   }

   function manage_usersBeforeShow($sender, $params)
   {
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
      //echo 'a2' . date("D M j G:i:s T Y") . "<BR>";flush();ob_flush();
      //Get the action to perform
      $action = $this->input->action;
      if(is_object($action))
      {



         //If there is any edit_id on the input
         $edit_id = $this->input->edit_id;


         if(is_object($edit_id))
         {

            $this->password->Text = '!!!!!!';
            $this->password_verification->Text = '!!!!!!';
            $query = "SELECT * FROM auth where MD5(ID)='" . mysql_escape_string($_REQUEST['edit_id']) . "'";
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $edit_id->stream['edit_id'] = $apAuth->Query_General->Fields['ID'];
            //Filter the table
            $this->EditUsersTable->Filter = " ID='" . $edit_id->asInteger() . "' ";
            $this->EditUsersTable->Refresh();
            $this->ID->Value = $edit_id->asString();
            $this->user_id->Value = $edit_id->asString();


            $query = "SELECT * FROM auth where ID='" . mysql_escape_string($edit_id->asInteger()) . "'";
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $readrealm = $apAuth->Query_General->Fields['realm'];
            $selected_pb_id = $apAuth->Query_General->Fields['start_pb_id'];
            $ypourgeio_table = $apAuth->Query_General->Fields['ypourgeio_table'];


            if($readrealm == '0')
            {
               $thisrealm = '0';
            }
            if($readrealm == 'admin')
            {
               $thisrealm = '1';
            }
            if($readrealm == 'admin_foreas')
            {
               $thisrealm = '2';
            }
            if($readrealm == 'user')
            {
               $thisrealm = '3';
            }
            if($readrealm == 'disabled')
            {
               $thisrealm = '4';
            }
            $this->realm->ItemIndex = $thisrealm;

            $this->ypourgeio_table->Value = $ypourgeio_table;

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


            //If the user wants to edit a register
            if($action->asString() == 'edit')
            {

               $this->Label14->Caption = "Ενημέρωση Χρήστη";
               $this->btnPost->Visible = false;
               $this->btnUpdate->Visible = true;
               //Make the panel visible
               $this->Panel1->Visible = true;


            }
            else if($action->asString() == 'delete')
            {

               //Delete the register and refresh the repeater table
               global $apAuth;
               $query = "DELETE FROM auth WHERE ID=" . $edit_id->asInteger();
               $apAuth->DB_General->execute($query);
               $apAuth->UserTable->Refresh();
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

         $password = mysql_escape_string($_REQUEST['password']);
         $passwordhash = md5(md5($password) . 'stavsalt');
         $yp_table = pb_idToTable(mysql_escape_string($_REQUEST['pb_id']));
         $level1_pb_id = get_level1_pb_id($yp_table, mysql_escape_string($_REQUEST['pb_id']));
         if($_REQUEST['realm'] == '0')
         {
            $saverealm = '0';
         }
         if($_REQUEST['realm'] == '1')
         {
            $saverealm = 'admin';
         }
         if($_REQUEST['realm'] == '2')
         {
            $saverealm = 'admin_foreas';
         }
         if($_REQUEST['realm'] == '3')
         {
            $saverealm = 'user';
         }
         if($_REQUEST['realm'] == '4')
         {
            $saverealm = 'disabled';
         }

         $query =
         "
         INSERT INTO `auth`
         (`ID`,
         `ypografontes_IDs`,
         `username`,
         `password`,
         `realm`,
         `ypourgeio_table`,
         `start_pb_id`,
         `ypourgeia_pb_id`,
         `firstname`,
         `lastname`,
         `email`,
         `telephone_yp`,
         `comments`)
         VALUES
         (NULL,
         '',
         '" . mysql_escape_string($_REQUEST['username']) . "',
         '" . $passwordhash . "',
         '" . mysql_escape_string($saverealm) . "',
         '" . $yp_table . "',
         '" . mysql_escape_string($_REQUEST['pb_id']) . "',
         '" . $level1_pb_id . "',
         '" . mysql_escape_string($_REQUEST['firstname']) . "',
         '" . mysql_escape_string($_REQUEST['lastname']) . "',
         '" . mysql_escape_string($_REQUEST['email']) . "',
         '" . mysql_escape_string($_REQUEST['telephone_yp']) . "',
         '" . mysql_escape_string($_REQUEST['comments']) . "')
         ";


         $apAuth->DB_General->execute($query);
         $apAuth->UserTable->Refresh();
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
         $yp_table = pb_idToTable(mysql_escape_string($_REQUEST['pb_id']));
         $level1_pb_id = get_level1_pb_id($yp_table, mysql_escape_string($_REQUEST['pb_id']));
         $query = "SELECT * FROM auth where ID='" . mysql_escape_string($_REQUEST['user_id']) . "'";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();

         if($_REQUEST['realm'] == '0')
         {
            $saverealm = '0';
         }
         if($_REQUEST['realm'] == '1')
         {
            $saverealm = 'admin';
         }
         if($_REQUEST['realm'] == '2')
         {
            $saverealm = 'admin_foreas';
         }
         if($_REQUEST['realm'] == '3')
         {
            $saverealm = 'user';
         }
         if($_REQUEST['realm'] == '4')
         {
            $saverealm = 'disabled';
         }

         $old_pass = $apAuth->Query_General->Fields['password'];

         $password = mysql_escape_string($_REQUEST['password']);
         $passwordhash = md5(md5($password) . 'stavsalt');
         if(!($password == '!!!!!!'))
         {
            $query =
            "update auth
         set
         ypografontes_IDs = '' ,
         username = '" . mysql_escape_string($_REQUEST['username']) . "' ,
         password = '" . $passwordhash . "' ,
         realm = '" . mysql_escape_string($saverealm) . "' ,
         ypourgeio_table = '" . $yp_table . "' ,
         start_pb_id = '" . mysql_escape_string($_REQUEST['pb_id']) . "' ,
         ypourgeia_pb_id = '" . $level1_pb_id . "' ,
         firstname = '" . mysql_escape_string($_REQUEST['firstname']) . "' ,
         lastname = '" . mysql_escape_string($_REQUEST['lastname']) . "' ,
         email = '" . mysql_escape_string($_REQUEST['email']) . "' ,
         telephone_yp = '" . mysql_escape_string($_REQUEST['telephone_yp']) . "' ,
         comments = '" . mysql_escape_string($_REQUEST['comments']) . "'
         where ID ='" . mysql_escape_string($_REQUEST['user_id']) . "'";
         }
         else
         {
            $query =
            "update auth
         set
         ypografontes_IDs = '' ,
         username = '" . mysql_escape_string($_REQUEST['username']) . "' ,
         realm = '" . mysql_escape_string($saverealm) . "' ,
         ypourgeio_table = '" . $yp_table . "' ,
         start_pb_id = '" . mysql_escape_string($_REQUEST['pb_id']) . "' ,
         ypourgeia_pb_id = '" . $level1_pb_id . "' ,
         firstname = '" . mysql_escape_string($_REQUEST['firstname']) . "' ,
         lastname = '" . mysql_escape_string($_REQUEST['lastname']) . "' ,
         email = '" . mysql_escape_string($_REQUEST['email']) . "' ,
         telephone_yp = '" . mysql_escape_string($_REQUEST['telephone_yp']) . "' ,
         comments = '" . mysql_escape_string($_REQUEST['comments']) . "'
         where ID ='" . mysql_escape_string($_REQUEST['user_id']) . "'";
         }

         $apAuth->DB_General->execute($query);
         $apAuth->UserTable->Refresh();
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

global $manage_users;

//Creates the form
$manage_users = new manage_users($application);

//Read from resource file
$manage_users->loadResource(__FILE__);

//Shows the form
$manage_users->show();
?>