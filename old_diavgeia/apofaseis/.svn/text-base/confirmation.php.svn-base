<?php
if(!(isset($_REQUEST['id']))and !(isset($_REQUEST['cancel'])))
{
   header('Location:index.php?restore_session=1');
}
require_once("vcl/vcl.inc.php");
//Includes
require_once("apAuth.php");
require_once("extradbconnection.php");
require_once("fileStorage.php");
require_once("pdfToText.php");
use_unit("comctrls.inc.php");
use_unit("Zend/zacl.inc.php");
use_unit("jsval/formvalidator.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");


global $apAuth;
global $ExtraDBConnection;
global $aclmanager;
//if ($aclmanager->Role=='')
//{
$apAuth->ZAuth->Execute();
//}
$aclmanager->Role = $apAuth->ZAuth->UserRealm;
$apAuth->initUserData();
//Class definition
class confirmationForm extends Page
{
   public $Label_syntaktis_email = null;
   public $LabelBack = null;
   public $Label_thema = null;
   public $Label_telikos_ypografwn = null;
   public $Label_stoixeia = null;
   public $LabelCancel = null;
   public $ButtonSubmit = null;
   public $Label_user = null;
   public $Label_eidos_apofasis = null;
   public $Label_koin = null;
   public $Label_date = null;
   public $Label_prot = null;
   public $Label_ada = null;
   public $form_action = null;
   public $id = null;
   public $Label2 = null;
   public $LogoutLabel = null;
   public $FormValidator1 = null;

   function Button2Click($sender, $params)
   {



   }


   function ButtonSubmitJSClick($sender, $params)
   {

?>
       //Add your javascript code here
       var fa=document.getElementById("form_action");
       fa.value='finalsubmit';
       return true;
<?php

   }

   function confirmationFormBeforeShow($sender, $params)
   {
      try
      {
         global $apAuth;
         global $ExtraDBConnection;

         $apAuth->DB_General->DoConnect();
         $apAuth->DB_General->execute("SET NAMES utf8");
         //try {
         //$ExtraDBConnection->DB_General->DoConnect();
         //$ExtraDBConnection->DB_General->execute("SET NAMES utf8");
         //} catch(Exception $e) {}

         if(isset($_REQUEST['cancel']))
         {
            $id = urlencode($_REQUEST['cancel']);
            $query = "SELECT * FROM apofaseis_temp WHERE id =" . $id;
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $ada = $apAuth->Query_General->Fields['ada'];
            $apAuth->DB_General->execute("
      DELETE FROM sha2_temp WHERE sha2_temp.ada ='" . $ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM files_temp WHERE files_temp.ada ='" . $ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM apofaseis_temp WHERE apofaseis_temp.ada ='" . $ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM apofaseis WHERE apofaseis.ada ='" . $ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM apofaseis_dynamic_fields_values_temp WHERE apofaseis_dynamic_fields_values_temp.ada ='" . $ada . "'
     ");
            /*
            try {
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM files_temp WHERE files_temp.ada ='".$ada."'
            ");
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM apofaseis_temp WHERE apofaseis_temp.ada ='".$ada."'
            ");
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM apofaseis WHERE apofaseis.ada ='".$ada."'
            ");
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM apofaseis_dynamic_fields_values_temp WHERE apofaseis_dynamic_fields_values_temp.ada ='".$ada."'
            ");
            } catch(Exception $e) {}
            */
            redirect_withdetection('index.php');

         }

         $id = urlencode($_REQUEST['id']);
         $this->id->Value = $id;
         $query = "SELECT * FROM apofaseis_temp WHERE id =" . $id;
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();
         $ada = $apAuth->Query_General->Fields['ada'];
         $pb_id = $apAuth->Query_General->Fields['lastlevel'];
         $eidos_apofasis = $apAuth->Query_General->Fields['eidos_apofasis'];
         $levelsCSV = $apAuth->Query_General->Fields['levelsCSV'];
         $arithmos_protokolou = $apAuth->Query_General->Fields['arithmos_protokolou'];
         $koinopoiiseis = $apAuth->Query_General->Fields['koinopoiiseis'];
         $apofasi_date = $apAuth->Query_General->Fields['apofasi_date'];
         $user = $apAuth->Query_General->Fields['user'];
         $isET = $apAuth->Query_General->Fields['isET_Apofasi'];
         $telikos_ypografwn_id = $apAuth->Query_General->Fields['telikos_ypografwn'];
         $thema = $apAuth->Query_General->Fields['thema'];
         $syntaktis_email = $apAuth->Query_General->Fields['syntaktis_email'];
         $related_ADAs = $apAuth->Query_General->Fields['related_ADAs'];





         if($_REQUEST['form_action'] == 'finalsubmit')
         {
            /*
            $query = "DELETE from apofaseis where ada ='" . $ada . "' ";
            try
            {
               $apAuth->DB_General->execute($query);
            }
            catch(Exception $e)
            {
            }



            */
            $apAuth->Query_General->SQL = "SELECT * FROM apofaseis_temp where ada='" . $ada . "'";
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();

                  $query = "
                  UPDATE apofaseis SET
                  arithmos_protokolou = '" . $apAuth->Query_General->Fields['arithmos_protokolou'] . "',
                  apofasi_date= '" . $apAuth->Query_General->Fields['apofasi_date'] . "',
                  koinopoiiseis = '" . $apAuth->Query_General->Fields['koinopoiiseis'] . "',
                  eidos_apofasis = '" . $apAuth->Query_General->Fields['eidos_apofasis'] . "',
                  thematiki= '" . $apAuth->Query_General->Fields['thematiki'] . "',
                  thema= '" . $apAuth->Query_General->Fields['thema'] . "',
                  monada= '" . $apAuth->Query_General->Fields['monada'] . "',
                  submission_timestamp= '" . $apAuth->Query_General->Fields['submission_timestamp'] . "',
                  lastlevel= '" . $apAuth->Query_General->Fields['lastlevel'] . "',
                  levelsCSV= '" . $apAuth->Query_General->Fields['levelsCSV'] . "',
                  telikos_ypografwn= '" . $apAuth->Query_General->Fields['telikos_ypografwn'] . "',
                  isET_Apofasi= '" . $apAuth->Query_General->Fields['isET_Apofasi'] . "',
                  is_orthi_epanalipsi= '" . $apAuth->Query_General->Fields['is_orthi_epanalipsi'] . "',
                  ETURL= '" . $apAuth->Query_General->Fields['ETURL'] . "',
                  tags= '" . $apAuth->Query_General->Fields['tags'] . "',
                  user= '" . $apAuth->Query_General->Fields['user'] . "',
                  ET_FEK= '" . $apAuth->Query_General->Fields['ET_FEK'] . "',
                  ET_FEK_tefxos= '" . $apAuth->Query_General->Fields['ET_FEK_tefxos'] . "',
                  ET_FEK_etos= '" . $apAuth->Query_General->Fields['ET_FEK_etos'] . "',
                  status= 'active',
                  comments= '" . $apAuth->Query_General->Fields['comments'] . "',
                  syntaktis_email= '" . $apAuth->Query_General->Fields['syntaktis_email'] . "',
                  related_ADAs= '" . $apAuth->Query_General->Fields['related_ADAs'] . "'
                  WHERE
                  ada = '" . $ada . "' ";


            try
            {
               $apAuth->DB_General->execute($query);
            }
            catch(Exception $thise)
            {
               $thise_message = $thise->getMessage();
               if(strpos($thise_message, 'Duplicate entry') > 0)
               {
                  redirect_withdetection('apofaseis.php?continueForm=' . $id . '&repeatDTE=1');
                  exit;
               }
               else
               {
                  Echo "Έγινε σφάλμα κατά την καταχώριση. Κωδικός: #364";
               }

            }
            /*
            try {
            $ExtraDBConnection->DB_General->execute($query);
            } catch(Exception $e) {}
            */
            $apAuth->Query_General->SQL = "SELECT id as max_count FROM apofaseis where ada='" . $ada . "'";
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $insert_ID = $apAuth->Query_General->Fields['max_count'];

            //$apAuth->Query_General->SQL = "SELECT * FROM files_temp where ada='" . $ada . "'";
            //$apAuth->Query_General->LimitCount = "-1";
            //$apAuth->Query_General->LimitStart = "-1";
            //$apAuth->Query_General->Prepare();
            //$apAuth->Query_General->close();
            //$apAuth->Query_General->open();
            $filename = '/tmp/sbmt_' . bin2hex(mHash(MHASH_SHA256, $ada)).'.ori';
            $fp = fopen($filename, 'r');
            $file_size = filesize($filename);
            $original_content = fread($fp, $file_size)or die("Error: cannot read file2-1");
            fclose($fp);

            $filename = '/tmp/sbmt_' . bin2hex(mHash(MHASH_SHA256, $ada)).'.signed';
            $fp = fopen($filename, 'r');
            $file_size = filesize($filename);
            $signed_content = fread($fp, $file_size)or die("Error: cannot read file2-1");
            fclose($fp);


            $fs = new fileStorage();
            $fs->writeFile($ada, 'original.pdf', $original_content);
            $fs->writeFile($ada, 'signed.pdf', $signed_content);

            $query = "
         INSERT INTO `files`
            select
            NULL,
            ada,
            original_filename,
            signed_filename
            from files_temp
            where files_temp.ada ='" . $ada . "'
     ";
            $apAuth->DB_General->execute($query);
            /*
            try {
            $ExtraDBConnection->DB_General->execute($query);
            } catch(Exception $e) {}
            */

            $query = "
         INSERT INTO `sha2`
            select
            NULL,
            ada,
            sha2
            from sha2_temp
            where sha2_temp.ada ='" . $ada . "'
     ";
     $apAuth->DB_General->execute($query);
            /*
            try {
            $ExtraDBConnection->DB_General->execute($query);
            } catch(Exception $e) {}
            */


            $pdfpath = $fs->getPathFromUID($ada) . 'signed.pdf';
            $ptt = new pdfToText();
            $signed_textcontent = $ptt->getTextFromPDF($pdfpath);
            $signed_textcontent = mysql_escape_string($signed_textcontent);
            $signed_textcontent = strip_tags($signed_textcontent);
            $signed_textcontent = preg_replace('/[\x00-\x08\x0B-\x1F]/', ' ', $signed_textcontent);

            $filename = '/tmp/sbmt_' . bin2hex(mHash(MHASH_SHA256, $ada)).'.ori';
            unlink($filename);
            $filename = '/tmp/sbmt_' . bin2hex(mHash(MHASH_SHA256, $ada)).'.signed';
            unlink($filename);
            /*
            $apAuth->DB_General->execute($query);
            $query = "
            INSERT INTO files_text
            (
            ada,
            content
            )
            VALUES ( '" .
            $ada . "','" .
            $signed_textcontent . "'" .
            " )";
            $apAuth->DB_General->execute($query);
            */

            /*
            try {
            $ExtraDBConnection->DB_General->execute($query);
            } catch(Exception $e) {}
            */
            $query = "

         INSERT INTO `apofaseis_dynamic_fields_values`
            select
            NULL,
            ada,
            dynamic_field_ID,
            field_value,
            field_value_number
            from apofaseis_dynamic_fields_values_temp
            where apofaseis_dynamic_fields_values_temp.ada ='" . $ada . "'
     ";
            $apAuth->DB_General->execute($query);
            /*
            try {
            $ExtraDBConnection->DB_General->execute($query);
            } catch(Exception $e) {}
            */
            $apAuth->DB_General->execute("
      DELETE FROM sha2_temp WHERE sha2_temp.ada ='" . $ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM files_temp WHERE files_temp.ada ='" . $ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM apofaseis_temp WHERE apofaseis_temp.ada ='" . $ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM apofaseis_dynamic_fields_values_temp WHERE apofaseis_dynamic_fields_values_temp.ada ='" . $ada . "'
     ");
            /*
            try {
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM files_temp WHERE files_temp.ada ='".$ada."'
            ");
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM apofaseis_temp WHERE apofaseis_temp.ada ='".$ada."'
            ");
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM apofaseis_dynamic_fields_values_temp WHERE apofaseis_dynamic_fields_values_temp.ada ='".$ada."'
            ");
            } catch(Exception $e) {}
            */
            //------------------------------------------------
            include('config.php');

            global $apAuth;

            $apAuth->DB_General->DoConnect();
            $apAuth->DB_General->execute("SET NAMES utf8");

            if(($apAuth->userData['ypourgeio_table'] == 'yp_xwris_ypourgeio')or($apAuth->userData['ypourgeio_table'] == 'foreis_mt'))
            {
               $query = "SELECT * FROM oda_members_master WHERE foreas_pb_id='" . $apAuth->userData['start_pb_id'] . "' AND NOT foreas_latin_name='' GROUP BY foreas_latin_name";
               $foreas_display_name = $apAuth->userData['foreas_name'];
            }
            else
            {
               $query = "SELECT * FROM oda_members_master WHERE foreas_pb_id='" . $apAuth->userData['ypourgeia_pb_id'] . "' AND NOT foreas_latin_name='' GROUP BY foreas_latin_name";
               $foreas_display_name = $apAuth->userData['ypourgeia_name'];
            }

            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $foreaslatin = $apAuth->Query_General->Fields['foreas_latin_name'];


            $link1_label = '<strong>1. Σελίδα Ηλεκτρονικής Εφημερίδας της Κυβέρνησης:</strong>';
            if($appIsDev == 'true')
            {
               $link1 = 'Mπορείτε να τη δείτε  εδώ στην ηλεκτρονική Εφημερίδα της Κυβέρνησης: <a target="_blank" href="../archive/search/apservice.php?ada=' . $ada . '" >Σύνδεσμος</a>';
            }
            else
            {
               
            }

            //$foreaslatin



            $link2_label = '<strong>2. Σελίδα  Ανάρτησης των Αποφάσεων του Υπουργείου:</strong>';
            if($appIsDev == 'true')
            {
               $link2 = 'Μπορείτε να τη δείτε εδώ στην σελίδα ειδικού σκοπού ανάρτησης αποφάσεων για το ' . $foreas_display_name . ' : <a target="_blank" href="http://193.105.109.111/xpapad/web/' . $foreaslatin . '/ada/' . $ada . '" >Σύνδεσμος</a>';
            }
            else
            {
            
            }

            $link3_label = '<strong>3. Άμεσο κατέβασμα:</strong>';
            if($appIsDev == 'true')
            {
               $link3 = 'Μπορείτε να τη δείτε εδώ στην σελίδα ειδικού σκοπού ανάρτησης αποφάσεων για το ' . $foreas_display_name . ' : <a target="_blank" href="get_doc.php?ada=' . $ada . '" >Μεταφόρτωση Απόφασης</a>';
            }
            else
            {
               $link3 = 'Μπορείτε να τη δείτε εδώ στην σελίδα ειδικού σκοπού ανάρτησης αποφάσεων για το ' . $foreas_display_name . ' : <a target="_blank" href="get_doc.php?ada=' . $ada . '" >Μεταφόρτωση Απόφασης</a>';
            }

            $email_to = $syntaktis_email;
            $email_from = 'noreply@info.onomaserver.gov.gr';
            $email_subject = ($appIsDev == 'true'? " TEST ENVIRONMENT - " : "")."Επιβεβαίωση ανάρτησης απόφασης με θέμα: ".$thema." (code:".$ada.")";
         
            $email_txt = ($appIsDev == 'true'? "<b><font color=\"red\">ΠΡΟΣΟΧΗ! Το παρόν προέρχεται από ανάρτηση στο δοκιμαστικό περιβάλλον .</font></b> <br /><br />" : "").
            "Επιβεβαίωση ανάρτησης απόφασης με ΑΔΑ: " . $ada . "<br>\r\n" .
            "Η απόφαση με θέμα: " . $thema . " έχει αναρτηθεί<br>\r\n" .
            "στους παρακάτω σύνδεσμους:<br>\r\n" .
            $link1_label . "<br>\r\n" .
            $link1 . "<br>\r\n" .
            $link2_label . "<br>\r\n" .
            $link2 . "<br>\r\n" .
            $link3_label . "<br>\r\n" .
            $link3 . "<br>\r\n" .
            "<br>\r\n" .
            "<br>\r\n";

            require_once('sendmail.php');
            $ok = mail_alt($email_from, $email_to, $email_subject, $email_txt);


            //------------------------------------------------

            redirect_withdetection('submission_complete.php?ada=' . $ada);// .'&pb_id='.$pb_id.'&isET='.$isET
         }
         else
         {

            $apAuth->Query_General->SQL = "SELECT * FROM eidi_apofaseon where ID='" . $eidos_apofasis . "'";
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $eidos_apofasisName = $apAuth->Query_General->Fields['name'];

            $apAuth->Query_General->SQL = "SELECT ypografontes.*, ypografontes_types.name as type_name FROM ypografontes,ypografontes_types where ypografontes.type_id=ypografontes_types.ID  AND ypografontes.ID='" . $telikos_ypografwn_id . "'";
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $telikos_ypografwn = $apAuth->Query_General->Fields['type_name'] . " - " . $apAuth->Query_General->Fields['firstname'] . " " . $apAuth->Query_General->Fields['lastname'];

            $levelsCSVArray = explode(',', $levelsCSV);
            $levelsText = '';
            for($levelsi = 0; $levelsi < count($levelsCSVArray); $levelsi++)
            {
               $this_pb_id = str_replace('#', '', $levelsCSVArray[$levelsi]);
               if(!($this_pb_id == '0'))
               {
                  $apAuth->Query_General->SQL = "SELECT * FROM " . $apAuth->userData['ypourgeio_table'] . " where hidden=0 AND  pb_id='" . $this_pb_id . "'";
                  $apAuth->Query_General->LimitCount = "-1";
                  $apAuth->Query_General->LimitStart = "-1";
                  $apAuth->Query_General->Prepare();
                  $apAuth->Query_General->close();
                  $apAuth->Query_General->open();
                  $levelName = $apAuth->Query_General->Fields['name'];
                  if(!($levelName == ''))
                  {
                     $levelsText .= '<li>' . $levelName . '</li>';
                  }
               }
            }
            $levelsText = '<ul>' . $levelsText . '</ul>';


            $this->Label_user->Caption = $user;
            $this->Label_ada->Caption = $ada;
            $this->Label_eidos_apofasis->Caption = $eidos_apofasisName;
            $this->Label_koin->Caption = $koinopoiiseis;
            $this->Label_date->Caption = $apofasi_date;
            $this->Label_prot->Caption = $arithmos_protokolou;
            $this->Label_stoixeia->Caption = $levelsText;
            $this->Label_telikos_ypografwn->Caption = $telikos_ypografwn;
            $this->Label_thema->Caption = $thema;
            $this->LabelCancel->Link = 'confirmation.php?cancel=' . $id;
            $this->LabelBack->Link = 'apofaseis.php?continueForm=' . $id;
            $this->Label_syntaktis_email->Caption = $syntaktis_email;
            /*
            `ada` varchar(255) NOT NULL,
            `arithmos_protokolou` varchar(255) NOT NULL,
            `apofasi_date` date NOT NULL,
            `koinopoiiseis` text NOT NULL,
            `eidos_apofasis` int(11) NOT NULL,
            `submission_timestamp` datetime NOT NULL,
            `comments` text NOT NULL,
            `thema` text NOT NULL,
            `lastlevel` int(11) NOT NULL,
            `tags` text NOT NULL,
            `user` varchar(255) NOT NULL,
            */

         }
      }
      catch(Exception $e)
      {
         $errormessage = $e->getMessage();
         //logErrorToDB($errormessage);
      }
   }

   function confirmationFormCreate($sender, $params)
   {


      global $aclmanager;
      global $apAuth;

      $usermessage = '';
      $usermessage = "<P><STRONG> User: " . $apAuth->ZAuth->UserName;
      if($aclmanager->Role == 'user')
      {
         $usermessage .= ", Logged in as user</STRONG></P>";
      }
      if($aclmanager->Role == 'admin')
      {
         $usermessage .= ", Logged in as admin</STRONG></P>";
      }
      $this->Label2->Caption = $usermessage;



   }


}

global $application;

global $confirmationForm;

//Creates the form
$confirmationForm = new confirmationForm($application);

//Read from resource file
$confirmationForm->loadResource(__FILE__);

//Shows the form
$confirmationForm->show();

?>