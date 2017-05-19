<?php
require_once("apAuth.php");

global $apAuth;
$apAuth->initUserData();

$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");

$pb_id  = urlencode($_REQUEST['pb_id']);
$query="SELECT * FROM ".$apAuth->userData['ypourgeio_table']." WHERE hidden=0 AND  pb_supervisor_id='".$pb_id."' ORDER BY name ASC";

$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();
echo '<OPTION selected value="0"></OPTION>';
for ($i=0;$i<$apAuth->Query_General->RecordCount;$i++)
 {
   echo '<OPTION value="'.$apAuth->Query_General->Fields['pb_id'].'" >'.$apAuth->Query_General->Fields['name'].'</OPTION>';
   $apAuth->Query_General->next();
 }

?>