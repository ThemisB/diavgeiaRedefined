<?php
/*
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
require_once("fileStorage.php");

global $apAuth;
global $aclmanager;
//if ($aclmanager->Role=='')
//{

$apAuth->ZAuth->Execute();
//}
$aclmanager->Role = $apAuth->ZAuth->UserRealm;
$apAuth->initUserData();



      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("UPDATE auth SET last_login_timestamp=now()  WHERE username='" . $apAuth->ZAuth->UserName . "'");
      $apAuth->initUserData();

      $thisapofaseisUtilClass= new apofaseisUtilClass();
$query="SELECT * FROM todelete where status=0";

$apAuth->Query_General2->SQL = $query;
$apAuth->Query_General2->LimitCount = "-1";
$apAuth->Query_General2->LimitStart = "-1";
$apAuth->Query_General2->Prepare();
$apAuth->Query_General2->close();
$apAuth->Query_General2->open();

for ($i=0;$i<$apAuth->Query_General2->RecordCount;$i++)
{
         $delada=$apAuth->Query_General2->Fields['ada'];
      $fs = new fileStorage();
      $fn=$fs->getPathFromUID($delada). 'original.pdf';
      $fs='';
      echo "file: ".$fn."<br>";
      if (!file_exists($fn)) {
         echo "#filenotfound:";

      } else  {
try {
         echo "deleting: ".$delada." count:".$apAuth->Query_General2->RecordCount."<BR>";
         $delreason="Η απόφαση απο-αναρτήθηκε και αντικαταστάθηκε για τεχνικούς λόγους. Ομάδα υποστήριξης.";
         $deladaresult=$thisapofaseisUtilClass->delete_apofasi($delada,$delreason,$apAuth->userData["start_pb_id"]);
         if ($deladaresult=='#success')
              $apAuth->DB_General->execute("UPDATE todelete SET status=1  WHERE ada='" . $delada . "'");
         if ($deladaresult=='#filenotfound')
              $apAuth->DB_General->execute("UPDATE todelete SET status=2  WHERE ada='" . $delada . "'");
         echo "deletion result: ".$deladaresult."<BR>";

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "<br>";
}}
echo "<br>";
$apAuth->Query_General2->next();
}
   */
?>