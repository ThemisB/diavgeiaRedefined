<?php
require_once("apAuth.php");

global $apAuth;

$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");

$ministry  = urlencode($_REQUEST['ministry']);
$eid  = urlencode($_REQUEST['eid']);
$query="SELECT * FROM apofaseis_dynamic_fields_list  WHERE `eidi_apofaseon_ID` LIKE '%#".$eid."#%'";

$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();

$newContent="";
for ($i=0;$i<$apAuth->Query_General->RecordCount;$i++)
 {
  $type=$apAuth->Query_General->Fields['type'];
  $label=$apAuth->Query_General->Fields['label'];
  $extra_label=$apAuth->Query_General->Fields['extra_label'];
  $fieldname=$apAuth->Query_General->Fields['fieldname'];
  $voc_table=$apAuth->Query_General->Fields['voc_table'];
  if ($type=='textfield')
  {
   $newContent.='<div>';
   $newContent.='<div id="Label_extrafield_'.$fieldname.'_outer">';
   $newContent.='<div id="Label_extrafield_'.$fieldname.'" style=';
   $newContent.='"font-family: Verdana; font-size: 10px; height:13px;width:251px;">';
   $newContent.=$label;
   if (!($extra_label=='')) {$newContent.='<br>'.$extra_label;}
   $newContent.='</div></div>';
   $newContent.='<div id="extrafield_'.$fieldname.'_outer"><input type="text" id=';
   $newContent.='"extrafield_'.$fieldname.'"  name=';
   $newContent.='"extrafield_'.$fieldname.'" value="" style=';
   $newContent.='" font-family: Verdana; font-size: 10px; height:20px;width:297px;"';
   if ($fieldname=='cpv'){$newContent .= ' onClick="setExtraFieldAutocomplete(\''.$fieldname.'\')" '; }
   $newContent.=' /></div>';
   $newContent.='</div>';

  }

  if ($type=='textarea')
  {
   $newContent.='<div>';
   $newContent.='<div id="Label_extrafield_'.$fieldname.'_outer">';
   $newContent.='<div id="Label_extrafield_'.$fieldname.'" style=';
   $newContent.='"font-family: Verdana; font-size: 10px; height:13px;width:251px;">';
   $newContent.=$label;
   if (!($extra_label=='')) {$newContent.='<br>'.$extra_label;}
   $newContent.='</div></div>';
   $newContent.='<div id="extrafield_'.$fieldname.'_outer">';
   $newContent.='<textarea id="extrafield_'.$fieldname.'" name="extrafield_'.$fieldname.'" style="font-family: Verdana;'.
   ' font-size: 10px; height: 64px; width: 817px;" maxlength="300" tabindex="0" wrap="virtual"'.
   ' onkeyup="return checkMaxLength(this, event, null)"></textarea>';
   $newContent.='</div>';
   $newContent.='</div>';
  }

  if ($type=='dropdown')
  {


   $newContent.='<div>';
   $newContent.='<div id="Label_extrafield_'.$fieldname.'_outer">';
   $newContent.='<div id="Label_extrafield_'.$fieldname.'" style=';
   $newContent.='"font-family: Verdana; font-size: 10px; height:13px;width:251px;">';
   $newContent.=$label;
   if (!($extra_label=='')) {$newContent.='<br>'.$extra_label;}
   $newContent.='</div></div>';
   $newContent.='<div id="extrafield_'.$fieldname.'_outer">';
   $newContent.='<select name="extrafield_'.$fieldname.'" id="extrafield_'.$fieldname.'" size="1" style=" font-family: ';
   $newContent.='Verdana; font-size: 10px;  height:16px;width:817px;"   tabindex="0" >';

   $query2="SELECT * FROM ".$voc_table."";
   $apAuth->Query_General2->SQL = $query2;
   $apAuth->Query_General2->LimitCount = "-1";
   $apAuth->Query_General2->LimitStart = "-1";
   $apAuth->Query_General2->Prepare();
   $apAuth->Query_General2->close();
   $apAuth->Query_General2->open();
   for ($ii=0;$ii<$apAuth->Query_General2->RecordCount;$ii++)
   {
      $itemname=$apAuth->Query_General2->Fields['itemname'];
      $itemvalue=$apAuth->Query_General2->Fields['itemvalue'];
      $isSelected=$apAuth->Query_General2->Fields['isSelected'];
      if ($isSelected=='1')
      {
        $newContent.='<option selected value="'.$itemvalue.'">'.$itemname.'</option>';
      }
      else
      {
        $newContent.='<option value="'.$itemvalue.'">'.$itemname.'</option>';
      }
      $apAuth->Query_General2->next();
   }
   $newContent.='</select>';
   $newContent.='</div>';
   $newContent.='</div>';
  }

  $apAuth->Query_General->next();
 }


   echo $newContent;

?>