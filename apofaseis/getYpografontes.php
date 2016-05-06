<?php
require_once("apAuth.php");

global $apAuth;
$apAuth->initUserData();
$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");

$pb_id  = urlencode($_REQUEST['pb_id']);
$start_pb_id  = urlencode($_REQUEST['start_pb_id']);
if ($pb_id=='0')
{
   $query=" SELECT ypografontes.*,ypografontes.ID as ypID,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE  NOT monada_id='0' AND en_energeia='1' AND ypografontes.type_id=ypografontes_types.ID AND ypografontes.monada_id=1000000  AND ypografontes.pb_id='".$start_pb_id."'";
}
else
{
   $query="(SELECT ypografontes.*,ypografontes.ID as ypID,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE  NOT monada_id='0' AND en_energeia='1' AND ypografontes.type_id=ypografontes_types.ID AND ypografontes.monada_id=1000000 AND ypografontes.pb_id='".$start_pb_id."')
   UNION
           (SELECT ypografontes.*,ypografontes.ID as ypID,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE  NOT monada_id='0' AND en_energeia='1' AND ypografontes.type_id=ypografontes_types.ID AND ypografontes.monada_id='".$pb_id."')";
}

$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();
echo '<option selected value="0"></option>';
for ($i=0;$i<$apAuth->Query_General->RecordCount;$i++)
 {
   echo '<option value="'.$apAuth->Query_General->Fields['ypID'].'">'.$apAuth->Query_General->Fields['type_name'].' - '.$apAuth->Query_General->Fields['firstname'].' '.$apAuth->Query_General->Fields['lastname'].'</option>';
   $apAuth->Query_General->next();
 }

?>