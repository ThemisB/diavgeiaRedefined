<?php
require_once("apAuth.php");

global $apAuth;

$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");

$q = $_REQUEST['q'];
if(!$q) return;

$query = "SELECT * FROM thematikes WHERE name LIKE '%" . $q . "%'";

$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();

$newContent = "";
for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
{
   echo $apAuth->Query_General->Fields['name'] . '|' . $apAuth->Query_General->Fields['ID'];
   echo "\n";
   $apAuth->Query_General->next();
}
?>