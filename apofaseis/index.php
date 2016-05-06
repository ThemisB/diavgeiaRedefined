<?php
require_once("vcl/vcl.inc.php");
//Includes
require_once("apAuth.php");
require_once("adaGenerator.php");
require_once("apofaseisUtilClass.php");
require_once("signingClass.php");
use_unit("Zend/zcache.inc.php");
use_unit("comctrls.inc.php");
use_unit("jsval/formvalidator.inc.php");
use_unit("mysql.inc.php");
use_unit("dbgrids.inc.php");
use_unit("Zend/zacl.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

global $apAuth;
global $aclmanager;
//if ($aclmanager->Role=='')
//{

$apAuth->ZAuth->Execute();
//}
$aclmanager->Role = $apAuth->ZAuth->UserRealm;
$apAuth->initUserData();

//Class definition
class Apofaseis_Operation_Selection extends Page
{
   public $EditUserLabel = null;
   public $Label_Manage_ode_Foreis = null;
   public $Label_edit_metadata = null;
   public $field_remove_reason = null;
   public $Label_remove_reason = null;
   public $Label_Manage_Foreis = null;
   public $Label_Manage_Activations = null;
   public $Label_Manage_Thematikes = null;
   public $Label_Manage_Monades_Types = null;
   public $Label_Manage_Ypografontes_Types = null;
   public $JSMessagePanel = null;
   public $Label_ada_delete_hr = null;
   public $Label_ada_delete = null;
   public $ButtonDelete = null;
   public $field_ada_delete = null;
   public $Label_Manage_Monades = null;
   public $Label_support = null;
   public $Label_ada = null;
   public $field_ada = null;
   public $ButtonEdit = null;
   public $Label_Manage_Apofaseis = null;
   public $ManageYpografontesLabel = null;
   public $ManageUserLabel = null;
   public $Label_ypourgeia = null;
   public $ApofaseisDatabase = null;
   public $LogoutLabel = null;
   public $Label2 = null;
   public $ZACL = null;

   function ButtonDeleteJSClick($sender, $params)
   {

   ?>
   //Add your javascript code here
  var vali=document.getElementById("field_ada_delete").value;
  var vali2=document.getElementById("field_remove_reason").value;
  if (!(vali2==''))
  {
     if (confirm("Είστε σίγουροι ότι θέλελε να διαγράψετε την πράξη?"))
     {
       window.open('index.php?action=delapp&ada='+vali+'&field_remove_reason='+vali2,"_self");
     }
  }
  else
  {
    alert('Το πεδίο τεκμηρίωσης είναι υποχρεωτικό.');
  }
  return false;
<?php

   }




   function ButtonEditJSClick($sender, $params)
   {

   ?>
   //Add your javascript code here
   var vali=document.getElementById("field_ada").value;
   window.open('apofaseis.php?ada='+vali,"_self");
   return false;
   <?php

   }





   function field_level4_textJSChange($sender, $params)
   {

   ?>
   //Add your javascript code here


   <?php

   }

   function field_level3_textJSChange($sender, $params)
   {

   ?>
   //Add your javascript code here


   <?php

   }

   function field_level2_textJSChange($sender, $params)
   {

   ?>
   //Add your javascript code here

   <?php

   }














   function SubmitButtonJSClick($sender, $params)
   {

?>

<?php


   }




   function Apofaseis_Operation_SelectionCreate($sender, $params)
   {
      global $apAuth;
      global $aclmanager;
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("UPDATE auth SET last_login_timestamp=now()  WHERE username='" . $apAuth->ZAuth->UserName . "'");

      if ($_REQUEST['action']=='delapp')
      {

         $delada=mysql_escape_string($_REQUEST['ada']);
         $delreason=mysql_escape_string($_REQUEST['field_remove_reason']);
         $thisapofaseisUtilClass= new apofaseisUtilClass();
         $apAuth->initUserData();
         $deladaresult=$thisapofaseisUtilClass->delete_apofasi($delada,$delreason,$apAuth->userData["start_pb_id"]);
         if ($deladaresult=="#success")
         {
         $this->JSMessagePanel->Caption = "
          <script language=javascript type='text/javascript'>
          alert('Η απο-ανάρτηση ολοκληρώθηκε επιτυχώς.');
          </script>";
         }
         elseif ($deladaresult=="#notfound")
         {
         $this->JSMessagePanel->Caption = "
          <script language=javascript type='text/javascript'>
          alert('Ο ΑΔΑ που εισάγατε δεν αντιστοιχεί σε αναρτημένη πράξη του Δι@ύγεια.');
          </script>";
         }
         elseif ($deladaresult=="#permissiondenied")
         {
         $this->JSMessagePanel->Caption = "
          <script language=javascript type='text/javascript'>
          alert('Ο ΑΔΑ που εισάγατε δεν αντιστοιχεί σε πράξη που έχει εκδοθεί από το φορέα σας.');
          </script>";
         }
         elseif ($deladaresult=="#revoked")
         {
         $this->JSMessagePanel->Caption = "
          <script language=javascript type='text/javascript'>
          alert('Ο ΑΔΑ που εισάγατε αντιστοιχεί σε πράξη η οποία έχει ήδη απο-αναρτηθεί.');
          </script>";
         }
         else
         {
         $this->JSMessagePanel->Caption = "
          <script language=javascript type='text/javascript'>
          alert('Παρουσιάστηκε σφάλμα κατά την απο - ανάρτηση της πράξης με ΑΔΑ:".$delada.". Κωδικός:".$deladaresult."');
          </script>";
         }

      } else
      {
         $this->JSMessagePanel->Caption = "";
      }



      $apAuth->initUserData();

      $this->EditUserLabel->Link="manage_current_user.php?action=edit&edit_id=" . md5(md5($apAuth->userData['ID']).md5('stav'));

      $support_url='http://www.url-domain.com.gr';
      $support_url.='foreas_id='.$apAuth->userData['start_pb_id'].'&';
      $support_url.='foreas_name='.urlencode($apAuth->userData['foreas_name']).'&';
      $support_url.='user_Fname='.urlencode($apAuth->userData['firstname']).'&';
      $support_url.='tel='.$apAuth->userData['telephone_yp'].'&';
      $support_url.='email='.$apAuth->userData['email'].'&';
      $support_url.='user_Surname='.urlencode($apAuth->userData['lastname']);
      $this->Label_support->Link=$support_url;

      $usermessage='<div align="left"><small> <a href="login.php?restore_session=1">ΕΞΟΔΟΣ</a>&nbsp;|&nbsp;<a href="index.php">ΕΠΙΛΟΓΕΣ</a>';
      $usermessage.='&nbsp;|&nbsp;<a href="index.php?restore_session=1">ΑΠΟΣΥΝΔΕΣΗ</a></font>';
      $usermessage .= "<br><STRONG> Χρήστης:</STRONG> ".$apAuth->ZAuth->UserName;
      if($aclmanager->Role == 'user')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Χρήστης Φορέα:</STRONG> ".$apAuth->userData['foreas_name']."";
         redirect_withdetection('apofaseis.php?newForm=1');
      }
      if($aclmanager->Role == 'admin_foreas')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Διαχειριστής Φορέα:</STRONG> ".$apAuth->userData['foreas_name']."";
      }
      /* if($aclmanager->Role == 'user-et')
      {
         $usermessage .= ", Logged in as ET user</STRONG></P>";
      }   */
      if($aclmanager->Role == 'admin')
      {
         $usermessage .= "<br></STRONG>Logged in as super-admin</STRONG>";
      }
      $usermessage .= "</small></div>";
      
      $this->Label2->Caption = $usermessage;


   }






}

global $application;

global $Apofaseis_Operation_Selection;

//Creates the form
$Apofaseis_Operation_Selection = new Apofaseis_Operation_Selection($application);

//Read from resource file
$Apofaseis_Operation_Selection->loadResource(__FILE__);

//Shows the form
$Apofaseis_Operation_Selection->show();

?>