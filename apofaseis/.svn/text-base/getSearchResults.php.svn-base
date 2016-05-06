<?php
    require_once("apAuth.php");

global $apAuth;

$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");

if (isset($_REQUEST['search_terms']))
{
   $search_terms  = mysql_escape_string($_REQUEST['search_terms']);
}
else
{
   $search_terms='%';
}
if ($search_terms=='') {$search_terms='%';}

          $query="
SELECT name,pb_id FROM foreis WHERE hidden=0 AND pb_id='".$search_terms."' OR name LIKE '%".$search_terms."%'
ORDER BY name ASC";


$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();

if ($apAuth->Query_General->RecordCount<=300)
{
if ($apAuth->Query_General->RecordCount==0)
{
echo '<option selected value="0">Δεν βρέθηκε κανένα αποτέλεσμα</option>';
}
for ($i=0;$i<$apAuth->Query_General->RecordCount;$i++)
 {
   echo '<option value="'.$apAuth->Query_General->Fields['pb_id'].'">'.$apAuth->Query_General->Fields['pb_id'].' - '.$apAuth->Query_General->Fields['name'].'</option>';
   $apAuth->Query_General->next();
}
}
else
{
   echo  '<option selected value="-10">Παρακαλούμε περιορίστε την αναζήτησή σας συμπληρώνοντας τα αρχικά του φορέα στο παραπάνω πεδίο.</option>';
}
?>