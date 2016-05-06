<?php

require_once("vcl/vcl.inc.php");
//Includes
require_once("apAuth.php");
global $apAuth;
global $aclmanager;

$apAuth->ZAuth->Execute();

$aclmanager->Role = $apAuth->ZAuth->UserRealm;
$apAuth->initUserData();

if((!($apAuth->ZAuth->UserRealm == 'admin'))and(!($apAuth->ZAuth->UserRealm == 'admin_foreas')))
{
   redirect_withdetection("login.php");
}

use_unit("db.inc.php");
use_unit("Zend/zcache.inc.php");
use_unit("comctrls.inc.php");
use_unit("jsval/formvalidator.inc.php");
use_unit("mysql.inc.php");
use_unit("dbgrids.inc.php");
use_unit("Zend/zacl.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");


//Class definition
class Manage_Foreis extends Page
{
   public $Label2 = null;
   public $Panel_JS_Message = null;
   public $Label_foreas_name = null;
   public $field_foreas_name = null;
   public $Label1 = null;
   public $Panel_Error = null;
   public $field_level0_text = null;
   public $SubmitButton = null;
   public $FormValidator1 = null;
   public $ApofaseisDatabase = null;
   function Manage_ForeisCreate($sender, $params)
   {
      global $apAuth;
      global $aclmanager;

      $apAuth->initUserData();
      $support_url='http://wwww.domain-support-url.gr';
      $support_url.='foreas_id='.$apAuth->userData['start_pb_id'].'&';
      $support_url.='foreas_name='.urlencode($apAuth->userData['foreas_name']).'&';
      $support_url.='user_Fname='.urlencode($apAuth->userData['firstname']).'&';
      $support_url.='tel='.$apAuth->userData['telephone_yp'].'&';
      $support_url.='email='.$apAuth->userData['email'].'&';
    
      $support_url.='user_Surname='.urlencode($apAuth->userData['lastname']);

      $usermessage='<div align="left"><small> <a href="login.php?restore_session=1">ΕΞΟΔΟΣ</a>&nbsp;|&nbsp;<a href="index.php">ΕΠΙΛΟΓΕΣ</a>';
      $usermessage.='&nbsp;|&nbsp;<a href="index.php?restore_session=1">ΑΠΟΣΥΝΔΕΣΗ</a></font>';
      $usermessage .= "<br><STRONG> Χρήστης:</STRONG> ".$apAuth->ZAuth->UserName;
      if($aclmanager->Role == 'user')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Χρήστης Φορέα:</STRONG> ".$apAuth->userData['foreas_name']."";
         redirect_withdetection('apofaseis.php');
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




   function Button_searchJSClick($sender, $params)
   {

?>
   //Add your javascript code here

<?php

   }



   function ValidationRulefield_fileValidate($sender, $params)
   {
?>

<?php

   }

   function Panel_captchaBeforeShow($sender, $params)
   {
   }

   function field_perifereia_textJSChange($sender, $params)
   {

?>
   //Add your javascript code here

<?php

   }



   function meliRemoveButtonJSClick($sender, $params)
   {

?>
   //Add your javascript code here

<?php

   }

   function meliAddButtonJSClick($sender, $params)
   {

?>
   //Add your javascript code here



<?php

   }







   function Manage_ForeisBeforeShow($sender, $params)
   {
      global $apAuth;
      if(isset($_REQUEST['errormsg']))
      {
         if($_REQUEST['errormsg'] == '1')
         {
            $this->Panel_Error->Caption = "
<script language=javascript type='text/javascript'>
alert('Σφάλμα κατά την καταχώρηση. Παρακαλούμε δοκιμάστε ξανά, σύμφωνα με τις οδηγείες της φόρμας.');
</script>
     ";
         }
      }
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");

      $this->field_level0_text->Clear();
      $this->field_level0_text->AddItem("", null , "0");
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


      $success = true;
      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {
         /*
         var_dump($_REQUEST);
         var_dump($_SESSION);
         var_dump($_FILES);
         exit;   */
            $this->Panel_JS_Message->Caption = "
<script language=javascript type='text/javascript'>
alert('Ο νέος φορέας κατακωρήθηκε.');
</script>
     ";
      $this->field_foreas_name->Text='';
      $this->field_level0_text->ItemIndex=0;
      $query = "SELECT max( pb_id ) +1 AS new_pb_id FROM `foreis_mt` WHERE pb_id >50000 AND pb_id <60000 ";
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();
      $ffield_new_pb_id=$apAuth->Query_General->Fields['new_pb_id'];

      $ffield_level0_text = mysql_escape_string($_REQUEST["field_level0_text"]);
      $ffield_foreas_name = mysql_escape_string($_REQUEST["field_foreas_name"]);



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
         //echo $query."<br>";
            $apAuth->DB_General->execute($query);

         if($success)
         {
        //    $this->Memo1->Add("Form Submitted.");
         //   $this->Memo1->Add('Insert ID:' . $insert_ID);
         //   $this->Memo1->Add("File Uploaded to " . $this->field_file->FileTmpName);
        //    redirect('submission_complete.php?uid=' . $ffield_uid);
         }
         else
         {
         //   $this->Memo1->Add("Error during submission:" . $errormessage);
         }
      }
   }








   function SubmitButtonJSClick($sender, $params)
   {

      // echo $this->SubmitButton->ajaxCall("SubmitButtonClick");
?>
      String.prototype.reverse = function(){
        splitext = this.split("");
        revertext = splitext.reverse();
        reversed = revertext.join("");
        return reversed;
      }
       //Add your javascript code here

      if (FormValidator1_validate())
      {


        if (document.getElementById("field_level0_text").value=='0')
         {
               alert('Παρακαλούμε Επιλέξτε Κατηγορία Φορέα.');
               return false;

         }

       }
       else
       {
        return false;
       }

<?php


   }










}

global $application;

global $Manage_Foreis;

//Creates the form
$Manage_Foreis = new Manage_Foreis($application);

//Read from resource file
$Manage_Foreis->loadResource(__FILE__);

//Shows the form
$Manage_Foreis->show();

?>