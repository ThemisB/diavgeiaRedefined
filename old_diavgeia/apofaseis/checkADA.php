<?php
require_once("apAuth.php");

global $apAuth;
$apAuth->initUserData();

$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");

$ada  = mysql_escape_string($_REQUEST['ada']);
$query="SELECT ada,thema FROM apofaseis WHERE ada='".$ada."'";

$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();
if ($apAuth->Query_General->RecordCount>0)
 {
   echo $apAuth->Query_General->Fields['thema'];
 }
 else
 {
   echo '0';
 }
?>