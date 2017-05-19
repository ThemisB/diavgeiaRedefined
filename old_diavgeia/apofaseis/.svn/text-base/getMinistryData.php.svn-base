<?php
require_once("apAuth.php");

global $apAuth;

$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");

$ministry  = urlencode($_REQUEST['ministry']);
$query="SELECT * FROM ".$ministry." WHERE hidden=0 ORDER BY name ASC";

$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();
//echo '<option value="0"></option>';
for ($i=0;$i<$apAuth->Query_General->RecordCount;$i++)
 {
   if ($apAuth->Query_General->Fields['level']=='1')
   {
      echo '<option selected value="'.$apAuth->Query_General->Fields['pb_id'].'">'.$apAuth->Query_General->Fields['name'].'</option>';
   } else
   {
      echo '<option value="'.$apAuth->Query_General->Fields['pb_id'].'">'.$apAuth->Query_General->Fields['name'].'</option>';
   }
   $apAuth->Query_General->next();
 }

?>