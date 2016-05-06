<?php
if (!(isset($_REQUEST['ada'])))
{
 header('Location:index.php?restore_session=1');
}
require_once("vcl/vcl.inc.php");
//Includes
require_once("apAuth.php");
use_unit("webservices.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

//Class definition
class SubmissionComplete extends Page
{
       public $Label_email_notification = null;
       public $LabelADA = null;
       public $Label_syndesmoi = null;
       public $Label3 = null;
       public $Label2 = null;
       public $Label1 = null;
       public $LinkLabel3 = null;
       public $LinkLabel2 = null;
       public $LinkLabel1 = null;
       function SubmissionCompleteBeforeShow($sender, $params)
       {
         global $apAuth;
         $apAuth->initUserData();
         include('config.php');
       //  if (urlencode($_REQUEST['isET'])=='0')
        // {
global $apAuth;
$ada=mb_convert_encoding(trim($_REQUEST['ada']), "UTF-8","UTF-8, ISO-8859-7" );
$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");
     $query = "SELECT * FROM apofaseis WHERE ada ='".mysql_escape_string($ada)."'";
     $apAuth->Query_General->SQL = $query;
     $apAuth->Query_General->LimitCount = "-1";
     $apAuth->Query_General->LimitStart = "-1";
     $apAuth->Query_General->Prepare();
     $apAuth->Query_General->close();
     $apAuth->Query_General->open();

     $syntaktis_email=$apAuth->Query_General->Fields['syntaktis_email'];
            $this->Label_email_notification->Caption='<b>Έχει ενημερωθεί για την καταχώρηση  ο συντάκτης με λογαριασμό: </b>'.$syntaktis_email;


 //           $this->LabelADA->Caption='<b>ΑΔΑ: </b>'.mb_convert_encoding($_REQUEST['ada'], "UTF-8","UTF-8, ISO-8859-7" );
            $this->LabelADA->Caption='<b>Μοναδικός αριθμός πράξης στην εφαρμογή: </b>'.$ada;
            //$this->Label_ET->Visible=false;

            $this->Label_syndesmoi->Visible=false;

            $this->Label1->Visible=true;
            $this->LinkLabel1->Visible=true;

            $this->Label2->Visible=true;
            $this->LinkLabel2->Visible=true;

            $this->Label3->Visible=true;
            $this->LinkLabel3->Visible=true;

if (($apAuth->userData['ypourgeio_table']=='yp_xwris_ypourgeio') or ($apAuth->userData['ypourgeio_table']=='foreis_mt'))
{
   $query="SELECT * FROM oda_members_master WHERE foreas_pb_id='".$apAuth->userData['start_pb_id']."' AND NOT foreas_latin_name='' GROUP BY foreas_latin_name";
   $foreas_display_name=$apAuth->userData['foreas_name'];
}
else
{
   $query="SELECT * FROM oda_members_master WHERE foreas_pb_id='".$apAuth->userData['ypourgeia_pb_id']."' AND NOT foreas_latin_name='' GROUP BY foreas_latin_name";
   $foreas_display_name=$apAuth->userData['ypourgeia_name'];
}

$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();
$foreaslatin=$apAuth->Query_General->Fields['foreas_latin_name'];
/*
(1) Η πράξη έχει δημοσιευθεί <a href=",,,του φορεα ">εδώ </a>
<br>
(2) Επιλέον μπορείτε να την κατεβάσετε εδώ (download pdf)*/
            $this->Label1->visible=false;
            $this->Label1->Caption='<strong>1. Κεντρική Σελίδα του Προγράμματος Διαύγεια στο Εθνικό Τυπογραφείο:</strong>';
            if ($appIsDev=='true')
            {
              //$this->LinkLabel1->Caption='Mπορείτε να τη δείτε εδώ στην κεντρική σελίδα του προγράμματος ΔΙΑΥΓΕΙΑ στο Εθνικό Τυπογραφείο: <a target="_blank" href="../archive/search/apservice.php?ada='.urlencode($_REQUEST['ada']).'" >Σύνδεσμος</a>';
            }
            else
            {
              $this->LinkLabel1->Caption='Η πράξη έχει δημοσιευθεί στον ακόλουθο σύνδεσμο : <a target="_blank" href="http://83.212.121.173/drasi1/frontend/f/'.$foreaslatin.'/ada/'.urlencode($_REQUEST['ada']).'" >Διεπαφή φορέα</a>';
            }

            //$foreaslatin



            $this->Label2->visible=false;
            $this->Label2->Caption='<strong>2. Σελίδα  Ανάρτησης των Αποφάσεων του Υπουργείου:</strong>';
            if ($appIsDev=='true')
            {
              //$this->LinkLabel2->Caption='Μπορείτε να τη δείτε εδώ στην σελίδα ειδικού σκοπού ανάρτησης του Φορέα '.$foreas_display_name.' : <a target="_blank" href="http://193.105.109.111/xpapad/web/'.$foreaslatin.'/ada/'.urlencode($_REQUEST['ada']).'" >Σύνδεσμος</a>';
            }
            else
            {
			  $this->LinkLabel2->visible=false;
              $this->LinkLabel2->Caption='Μπορείτε να τη δείτε εδώ στην σελίδα ειδικού σκοπού ανάρτησης του Φορέα '.$foreas_display_name.' : <a target="_blank" href="http://83.212.121.173/drasi1/frontend/f/'.$foreaslatin.'/ada/'.urlencode($_REQUEST['ada']).'" >Σύνδεσμος</a>';
            }

            $this->Label3->Caption='<strong>3. Άμεσο κατέβασμα:</strong>';
			$this->Label3->visible=false;
            if ($appIsDev=='true')
            {
              //$this->LinkLabel3->Caption='Μπορείτε να την καταβάσετε εδώ: <a target="_blank" href="get_doc.php?ada='.urlencode($_REQUEST['ada']).'" >Μεταφόρτωση Απόφασης</a>';
            }
            else
            {
              $this->LinkLabel3->Caption='Μπορείτε να την καταβάσετε εδώ: <a target="_blank" href="http://83.212.121.173/drasi1/storage/get_doc.php?ada='.urlencode($_REQUEST['ada']).'" >Αρχείο Πράξης</a>';
            }
			$this->Label_email_notification->visible=false;
       }

}

global $application;

global $SubmissionComplete;

//Creates the form
$SubmissionComplete=new SubmissionComplete($application);

//Read from resource file
$SubmissionComplete->loadResource(__FILE__);

//Shows the form
$SubmissionComplete->show();

?>