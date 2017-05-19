<?php

// provoke the VCL to kill the session
//$_GET['restore_session']="1";

require_once("vcl/vcl.inc.php");
//Includes
require_once("apAuth.php");
require_once("utilClasses.php");
require_once("extradbconnection.php");
require_once("extraFieldsArray.php");
require_once("extraFieldsJSGenerator.php");
require_once("adaGenerator.php");
require_once("signingClass.php");
use_unit("db.inc.php");
use_unit("Zend/zcache.inc.php");
use_unit("comctrls.inc.php");
use_unit("jsval/formvalidator.inc.php");
use_unit("mysql.inc.php");
use_unit("dbgrids.inc.php");
use_unit("Zend/zacl.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

global $apAuth;
global $ExtraDBConnection;
global $extraFieldsArray;
global $aclmanager;
//if ($aclmanager->Role=='')
//{
$apAuth->ZAuth->Execute();
//}
$aclmanager->Role = $apAuth->ZAuth->UserRealm;
$apAuth->initUserData();
if($apAuth->ZAuth->UserRealm == 'admin')
{
   redirect_withdetection("login.php");
}
//Class definition
class Apofaseis_Ypourgeiou extends Page
{
   public $JSMessagePanel = null;
   public $Label_monada = null;
   public $field_monades_text = null;
   public $Label_UserMessages = null;
   public $field_FEK_etos = null;
   public $field_FEK_tefxos = null;
   public $Label_FEK_etos = null;
   public $Label_FEK_tefxos = null;
   public $Label_FEK_FEK = null;
   public $field_related_ADAs = null;
   public $Label_related_ADAs = null;
   public $js_thematiki = null;
   public $Label_syntaktis_email = null;
   public $field_syntaktis_email = null;
   public $Label_FEK = null;
   public $field_FEK = null;
   public $isEditForm_ada = null;
   public $isEditForm_h = null;
   public $field_level8_text = null;
   public $field_level7_text = null;
   public $field_level6_text = null;
   public $is_orthi_epanalipsi_container = null;
   public $Label_old_ada = null;
   public $field_old_ada_message = null;
   public $field_is_orthi_epanalipsi = null;
   public $field_old_ada = null;
   public $Label_telikos_ypografwn = null;
   public $field_telikos_ypografwn = null;
   public $ExtraFieldsContainer = null;
   public $field_thematiki_enotita_values_text = null;
   public $thematikesRemoveButton = null;
   public $thematikesAddButton = null;
   public $field_thematiki_enotita = null;
   public $field_thematiki_enotita_values = null;
   public $field_apofasi_date = null;
   public $Label_apofasi_date = null;
   public $field_level1_text = null;
   public $field_level2_text = null;
   public $field_level3_text = null;
   public $field_level4_text = null;
   public $field_level5_text = null;
   public $field_thema = null;
   public $Label_thema = null;
   public $field_tags = null;
   public $Label_tags = null;
   public $Label_thematiki = null;
   public $Label_debug_messages = null;
   public $Label_file = null;
   public $Label_eidos_apofasis = null;
   public $Label_koinapoiiseis = null;
   public $Label_foreas_ekdosis = null;
   public $Label_arithmos_protokolou = null;
   public $Memo1 = null;
   public $SubmitButton = null;
   public $FormValidator1 = null;
   public $field_file = null;
   public $field_eidos_apofasis = null;
   public $field_koinapoiiseis = null;
   public $field_arithmos_protokolou = null;
   public $ApofaseisDatabase = null;
   public $LogoutLabel = null;
   public $Label2 = null;
   function Apofaseis_YpourgeiouShowHeader($sender, $params)
   {
      echo getExtraFieldsJavascript_global(0);//param is not used for now


   }





   function Apofaseis_YpourgeiouJSLoad($sender, $params)
   {



   }


   function field_monades_textJSChange($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

      document.getElementById("field_telikos_ypografwn").disabled=false;

 document.getElementById("field_telikos_ypografwn_outer").innerHTML='<?php
      echo '<select name="field_telikos_ypografwn" id="field_telikos_ypografwn" size="1" style=" font-family: Verdana; font-size: 10px;  height:16px;width:816px;"   tabindex="0"    >';
?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';

    }
  }


    var si=document.getElementById("field_monades_text").selectedIndex;
    var vali=document.getElementById("field_monades_text").options[si].value;
    document.getElementById("field_telikos_ypografwn").disabled=true;
    xmlhttp.open("GET","getYpografontes.php?pb_id="+vali+"&start_pb_id=<?php
      global $apAuth;
      $apAuth->initUserData();
      echo $apAuth->userData['start_pb_id'];
?>",true);
    xmlhttp.send();
    return false;
<?php

   }




   function field_level7_textJSChange($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

      document.getElementById("field_level8_text").disabled=false;

 document.getElementById("field_level8_text_outer").innerHTML='<?php
      echo '<select name="field_level8_text" id="field_level8_text" size="1" style=" font-family: Verdana; font-size: 10px;  height:16px;width:816px;"   tabindex="0"  onchange="return field_level8_textJSChange(event)"  >';
?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';

    }
  }


    var si=document.getElementById("field_level7_text").selectedIndex;
    var vali=document.getElementById("field_level7_text").options[si].value;
    document.getElementById("field_level8_text").disabled=true;

    xmlhttp.open("GET","getHierarchy.php?pb_id="+vali,true);
    xmlhttp.send();


   return false;
<?php

   }

   function field_level6_textJSChange($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

      document.getElementById("field_level7_text").disabled=false;
      document.getElementById("field_level8_text").disabled=false;

 document.getElementById("field_level7_text_outer").innerHTML='<?php
      echo '<select name="field_level7_text" id="field_level7_text" size="1" style=" font-family: Verdana; font-size: 10px;  height:16px;width:816px;"   tabindex="0"  onchange="return field_level7_textJSChange(event)"  >';
?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';

    }
  }


    var si=document.getElementById("field_level6_text").selectedIndex;
    var vali=document.getElementById("field_level6_text").options[si].value;
    document.getElementById("field_level7_text").disabled=true;
    document.getElementById("field_level8_text").disabled=true;

    xmlhttp.open("GET","getHierarchy.php?pb_id="+vali,true);
    xmlhttp.send();


   return false;
<?php

   }

   function field_level5_textJSChange($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

      document.getElementById("field_level6_text").disabled=false;
      document.getElementById("field_level7_text").disabled=false;
      document.getElementById("field_level8_text").disabled=false;

 document.getElementById("field_level6_text_outer").innerHTML='<?php
      echo '<select name="field_level6_text" id="field_level6_text" size="1" style=" font-family: Verdana; font-size: 10px;  height:16px;width:816px;"   tabindex="0"  onchange="return field_level6_textJSChange(event)"  >';
?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';

    }
  }


    var si=document.getElementById("field_level5_text").selectedIndex;
    var vali=document.getElementById("field_level5_text").options[si].value;
    document.getElementById("field_level6_text").disabled=true;
    document.getElementById("field_level7_text").disabled=true;
    document.getElementById("field_level8_text").disabled=true;

    xmlhttp.open("GET","getHierarchy.php?pb_id="+vali,true);
    xmlhttp.send();


   return false;
<?php

   }



   function field_old_adaJSBlur($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      if (xmlhttp.responseText=='0')
      {
          document.getElementById("field_old_ada_message").innerHTML='<font color=#FF0000>Ο εισαγμένος ΑΔΑ δεν ισχύει';
      }
      else
      {
          document.getElementById("field_old_ada_message").innerHTML='<font color=#00FF00>Ο εισαγμένος ΑΔΑ είναι σωστός και έχει θέμα:</font><br>'+xmlhttp.responseText;
      }
    }
  }
   var vali=document.getElementById("field_old_ada").value;

    if (!(vali==''))
    {
      //document.getElementById("field_old_ada_message").innerHTML='<font color=#0000FF>Γίνεται έλεγχος ΑΔΑ...</font> <img src="progress_loading.gif">';
      //xmlhttp.open("GET","checkADA.php?ada="+vali,true);
      //xmlhttp.send();
    }

   return false;
<?php

   }



   function field_is_orthi_epanalipsiJSChange($sender, $params)
   {

?>
   //Add your javascript code here

   if (document.getElementById("field_is_orthi_epanalipsi").checked)
   {

    document.getElementById("is_orthi_epanalipsi_container_outer").innerHTML='<?php
      echo '<div id="Label_old_ada_outer">';
      echo '<div style="font-family: Verdana; font-size: 10px; height: 13px; width: 403px;" id="Label_old_ada">Συμπληρώστε τον ΑΔΑ Προηγούμενης Απόφασης</i>';
      echo '<br><small><font color="red">Η επιλογή αφορά ορθή επανάληψη (συμπλήρωση κλπ) άλλης απόφασης που ήδη έχει αναρτηθεί . Η πρώτη απόφαση θα παραμείνει στην ΔΙΑΥΓΕΙΑ</font></small></div>';
      echo '</div>';
      echo '<div id="field_old_ada_message_outer">';
      echo '<div style="font-family: Verdana; font-size: 10px; height: 13px; width: 179px;" id="field_old_ada_message"></div>';
      echo '</div>';
      echo '<div id="field_old_ada_outer">';
      echo '<input type="text" onblur="return field_old_adaJSBlur(event)" tabindex="0" style="font-family: Verdana; font-size: 10px; height: 20px; width: 225px;" value="" name="field_old_ada" onchange="return field_old_ada_updatehidden(event)" id="field_old_ada">';
      echo '</div>';
?>';
   } else
   {
    document.getElementById("is_orthi_epanalipsi_container_outer").innerHTML='';

   }
<?php

   }





   function field_eidos_apofasisJSChange($sender, $params)
   {

?>
   //Add your javascript code here

   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("ExtraFieldsContainer_outer").innerHTML=xmlhttp.responseText;
    }
  }
   var si=document.getElementById("field_eidos_apofasis").selectedIndex;
   var vali=document.getElementById("field_eidos_apofasis").options[si].value;



    xmlhttp.open("GET","extraFieldsGenerator.php?eid="+vali,true);
    xmlhttp.send();


   return true;


<?php

   }

   function thematikesRemoveButtonJSClick($sender, $params)
   {

?>
   //Add your javascript code here
    var si=document.getElementById("field_thematiki_enotita_values").selectedIndex;
    var toval=document.getElementById("field_thematiki_enotita_values");
    toval.remove(si);
    var val_hidden="";
    val_hidden="";
    for (x in document.getElementById("field_thematiki_enotita_values").options)
    {
    try
    {
       if (!(document.getElementById("field_thematiki_enotita_values").options[x].value==null))
       {
         val_hidden=val_hidden+"#"+document.getElementById("field_thematiki_enotita_values").options[x].value+"#";
         if (!(x==document.getElementById("field_thematiki_enotita_values").length-1))
         {
           val_hidden=val_hidden+",";
         }
       }
    }
    catch(err)
    {

    }
    }
    document.getElementById("field_thematiki_enotita_values_text").value=val_hidden;

<?php

   }

   function thematikesAddButtonJSClick($sender, $params)
   {

?>
   //Add your javascript code here

   function AddSelectOption(selectObj, text, value, isSelected)
  {
    if (selectObj != null && selectObj.options != null)
    {
        selectObj.options[selectObj.options.length] =
            new Option(text, value, false, isSelected);
    }
  }
   var si=document.getElementById("field_thematiki_enotita").selectedIndex;
   if (si>0)
   {
    var vali=document.getElementById("field_thematiki_enotita").options[si].value;
    var opti=document.getElementById("field_thematiki_enotita").options[si].innerHTML;
    var toval=document.getElementById("field_thematiki_enotita_values");
    var valfound="false";
    var i;

     for (x=0;x<toval.options.length;x=x+1)
     {
     var xx;
     xx=x>0;
      if (toval.options[x].value==vali)
      {
         valfound="true";
      }
     }

    if (valfound=="false")
    {
      AddSelectOption(toval,opti,vali,true);

      var val_hidden="";
      val_hidden="";
     for (x=0;x<toval.options.length;x=x+1)
     {
     var xx;
     xx=x>0;
       if (!(toval.options[x].value==null))
       {
        val_hidden=val_hidden+"#"+toval.options[x].value+"#";
         if (!(x==toval.length-1))
         {
           val_hidden=val_hidden+",";
         }
       }
       document.getElementById("field_thematiki_enotita_values_text").value=val_hidden;
     }

    }
   }

<?php

   }






   function field_level4_textJSChange($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
<?php
      /*
      document.getElementById("field_level5_text").disabled=false;
      document.getElementById("field_level6_text").disabled=false;
      document.getElementById("field_level7_text").disabled=false;
      document.getElementById("field_level8_text").disabled=false;
      document.getElementById("field_level5_text_outer").innerHTML='<?php
      echo '<select name="field_level5_text" id="field_level5_text" size="1" style=" font-family: Verdana; font-size: 10px;  height:16px;width:816px;"   tabindex="0"  onchange="return field_level5_textJSChange(event)"  >';
      ?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';      */
?>


    }
  }


    var si=document.getElementById("field_level4_text").selectedIndex;
    var vali=document.getElementById("field_level4_text").options[si].value;
<?php
      /*
      document.getElementById("field_level5_text").disabled=true;
      document.getElementById("field_level6_text").disabled=true;
      document.getElementById("field_level7_text").disabled=true;
      document.getElementById("field_level8_text").disabled=true;
      */
?>
    xmlhttp.open("GET","getHierarchy.php?pb_id="+vali,true);
    xmlhttp.send();


   return false;

<?php

   }

   function field_level3_textJSChange($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

      document.getElementById("field_level4_text").disabled=false;
<?php
      /*
      document.getElementById("field_level5_text").disabled=false;
      document.getElementById("field_level6_text").disabled=false;
      document.getElementById("field_level7_text").disabled=false;
      document.getElementById("field_level8_text").disabled=false;
      */
?>
 document.getElementById("field_level4_text_outer").innerHTML='<?php
      echo '<select name="field_level4_text" id="field_level4_text" size="1" style=" font-family: Verdana; font-size: 10px;  height:16px;width:816px;"   tabindex="0"   onchange="return field_level4_textJSChange(event)" >';
?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';

      field_level4_textJSChange();
    }
  }


    var si=document.getElementById("field_level3_text").selectedIndex;
    var vali=document.getElementById("field_level3_text").options[si].value;
    document.getElementById("field_level4_text").disabled=true;
<?php
      /*
      document.getElementById("field_level5_text").disabled=true;
      document.getElementById("field_level6_text").disabled=true;
      document.getElementById("field_level7_text").disabled=true;
      document.getElementById("field_level8_text").disabled=true;
      */
?>
    xmlhttp.open("GET","getHierarchy.php?pb_id="+vali,true);
    xmlhttp.send();


   return false;

<?php

   }

   function field_level2_textJSChange($sender, $params)
   {

?>
   //Add your javascript code here
   if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

      document.getElementById("field_level3_text").disabled=false;
      document.getElementById("field_level4_text").disabled=false;
<?php
      /*
      document.getElementById("field_level5_text").disabled=false;
      document.getElementById("field_level6_text").disabled=false;
      document.getElementById("field_level7_text").disabled=false;
      document.getElementById("field_level8_text").disabled=false;
      */
?>
 document.getElementById("field_level3_text_outer").innerHTML='<?php
      echo '<select name="field_level3_text" id="field_level3_text" size="1" style=" font-family: Verdana; font-size: 10px;  height:16px;width:816px;"   tabindex="0"  onchange="return field_level3_textJSChange(event)"   >';
?>'+xmlhttp.responseText+'<?php echo '</select>';  ?>';

      field_level3_textJSChange();
    }
  }


    var si=document.getElementById("field_level2_text").selectedIndex;
    var vali=document.getElementById("field_level2_text").options[si].value;
    document.getElementById("field_level3_text").disabled=true;
    document.getElementById("field_level4_text").disabled=true;
<?php
      /*
      document.getElementById("field_level5_text").disabled=true;
      document.getElementById("field_level6_text").disabled=true;
      document.getElementById("field_level7_text").disabled=true;
      document.getElementById("field_level8_text").disabled=true;
      */
?>
    xmlhttp.open("GET","getHierarchy.php?pb_id="+vali,true);
    xmlhttp.send();


   return false;
<?php

   }



   function logErrorToDB($exceptionMessage)
   {

   }


   function Apofaseis_YpourgeiouBeforeShow($sender, $params)
   {

      global $apAuth;
      global $ExtraDBConnection;
      $this->Label_UserMessages->Visible = false;
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");
      //try
      //{
      //$ExtraDBConnection->DB_General->DoConnect();
      //$ExtraDBConnection->DB_General->execute("SET NAMES utf8");
      //}
      //catch(Exception $e)
      //{
      //}

      if(isset($_REQUEST['ada']))
      {
         $isEditForm_ada = mysql_escape_string($_REQUEST['ada']);
         $isEditForm_ada = mb_convert_encoding($isEditForm_ada, "UTF-8", "UTF-8, ISO-8859-7");
         $isEditForm = true;
         $query = "SELECT * FROM apofaseis WHERE ada='" . $isEditForm_ada . "'";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();

         $edit_lastlevel = $apAuth->Query_General->Fields['lastlevel'];
         if(($apAuth->Query_General->RecordCount > 0) && (!($edit_lastlevel == '0')))
         {
            $edit_ypourgeio_table = pb_idToTable($edit_lastlevel);
            $edit_ypourgeia_pb_id = get_level1_pb_id($edit_ypourgeio_table, $edit_lastlevel);
            $apAuth->initUserData();
            if(($edit_ypourgeio_table == 'yp_xwris_ypourgeio')or($edit_ypourgeio_table == 'foreis_mt'))
            {
               if((!($edit_lastlevel == $apAuth->userData['start_pb_id']))AND($apAuth->userData['realm'] == 'admin_foreas'))
               {

                  redirect_withdetection("index.php");
               }
            }
            else
            {
               if((!($edit_ypourgeia_pb_id == $apAuth->userData['start_pb_id']))AND($apAuth->userData['realm'] == 'admin_foreas'))
               {

                  redirect_withdetection("index.php");
               }
            }
         }
         else
         {

            redirect_withdetection("index.php");
         }
      }
      else
      {
         $isEditForm = false;
      }



      if(isset($_REQUEST['continueForm']))
      {
         if(isset($_REQUEST['repeatDTE']))
         {
            $this->Label_UserMessages->Visible = true;
            $repeatDTE_id = mysql_escape_string($_REQUEST['repeatDTE']);
            if($repeatDTE_id == '1')
            {
               $this->Label_UserMessages->Caption = 'Παρακαλούμε ελέγξετε πάλι τα στοιχεία και πατήστε υποβολή.';
            }
            if($repeatDTE_id == '2')
            {
               $this->Label_UserMessages->Caption = 'Παρακαλούμε ελέγξετε πάλι τα στοιχεία και πατήστε υποβολή.';
            }
         }
         $isContForm_id = mysql_escape_string($_REQUEST['continueForm']);
         $isContForm = true;
         $isEditForm = false;
         $query = "SELECT * FROM apofaseis_temp WHERE id='" . $isContForm_id . "'";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();

         if($apAuth->Query_General->RecordCount > 0)
         {
            $cont_lastlevel = $apAuth->Query_General->Fields['lastlevel'];
            $cont_ypourgeio_table = pb_idToTable($cont_lastlevel);
            $cont_ypourgeia_pb_id = get_level1_pb_id($cont_ypourgeio_table, $cont_lastlevel);
            $apAuth->initUserData();
            if(($cont_ypourgeio_table == 'yp_xwris_ypourgeio')or($cont_ypourgeio_table == 'foreis_mt'))
            {
               if((!($cont_lastlevel == $apAuth->userData['start_pb_id']))AND($apAuth->userData['realm'] == 'admin_foreas'))
               {
                  redirect_withdetection("index.php");
               }
            }
            else
            {
               if((!($cont_ypourgeia_pb_id == $apAuth->userData['start_pb_id']))AND($apAuth->userData['realm'] == 'admin_foreas'))
               {
                  redirect_withdetection("index.php");
               }
            }
         }
         else
         {
            $isContForm = false;
            $isContForm_ada = '';
            $cont_lastlevel = '';
            $cont_ypourgeio_table = '';
            $cont_ypourgeia_pb_id = '';
         }
      }
      else
      {
         $isContForm = false;
      }

      if(isset($_REQUEST['newForm']))
      {
         $isNewForm = true;
         $isEditForm = false;
      }
      else
      {
         $isNewForm = false;
      }


      $start_pb_id = $apAuth->userData['start_pb_id'];
      $ypourgeia_pb_id = $apAuth->userData['ypourgeia_pb_id'];
      $ypourgeio_table = $apAuth->userData['ypourgeio_table'];
      if($isEditForm)
      {
         $start_pb_id = $edit_lastlevel;
         $ypourgeia_pb_id = $edit_ypourgeia_pb_id;
         $ypourgeio_table = $edit_ypourgeio_table;
      }

      if($isContForm)
      {
         $start_pb_id = $cont_lastlevel;
         $ypourgeia_pb_id = $cont_ypourgeia_pb_id;
         $ypourgeio_table = $cont_ypourgeio_table;
      }

      if(!($_SERVER['REQUEST_METHOD'] == 'POST'))
      {

         $this->field_level1_text->Clear();

         $query = "SELECT * FROM " . $ypourgeio_table . " WHERE  pb_id='" . $start_pb_id . "'";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();


         for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
         {
            $this->field_level1_text->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['pb_id']);
            $apAuth->Query_General->next();
         }
         $this->field_level1_text->ItemIndex = $ypourgeia_pb_id;

         $this->field_level1_text->Visible = true;
         $this->field_level2_text->Visible = false;
         $this->field_level3_text->Visible = false;
         $this->field_level4_text->Visible = false;
         $this->field_level5_text->Visible = false;
         $this->field_level6_text->Visible = false;
         $this->field_level7_text->Visible = false;
         $this->field_level8_text->Visible = false;

         if($isEditForm)
         {


            $this->isEditForm_h->Value = 'true';
            $this->isEditForm_ada->Value = $isEditForm_ada;
            $this->field_apofasi_date->Visible = true;
            $this->Label_apofasi_date->Visible = true;
            $this->field_file->Visible = false;
            $this->Label_file->Visible = false;
            $this->SubmitButton->Caption = 'Επεξεργασία';
            $this->SubmitButton->Width = 95;

            // SK: removal of hidden fields from validator control
            // if they are not removed, then the javascript part of the component
            // throws a javascript exception, thus breaking the whole validation process.
            $newRules = array();
            for($i = 0; $i < count($this->FormValidator1->Rules); $i++)
            {

               if(!(($this->FormValidator1->Rules[$i]['Control'] == 'field_apofasi_date')
               or
               ($this->FormValidator1->Rules[$i]['Control'] == 'field_file')
               ))
               {
                  array_push($newRules, $this->FormValidator1->Rules[$i]);
               }
            }
            $this->FormValidator1->Rules = $newRules;

            $query = "SELECT * FROM apofaseis WHERE ada='" . $isEditForm_ada . "'";
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $edit_ET_FEK = $apAuth->Query_General->Fields['ET_FEK'];
            $edit_ET_FEK_tefxos = $apAuth->Query_General->Fields['ET_FEK_tefxos'];
            $edit_ET_FEK_etos = $apAuth->Query_General->Fields['ET_FEK_etos'];
            $edit_arithmos_protokolou = $apAuth->Query_General->Fields['arithmos_protokolou'];
            $edit_thema = $apAuth->Query_General->Fields['thema'];
            $edit_monada = $apAuth->Query_General->Fields['monada'];
            $edit_eidos_apofasis = $apAuth->Query_General->Fields['eidos_apofasis'];
            global $edit_eidos_apofasis_g;
            $edit_eidos_apofasis_g = $apAuth->Query_General->Fields['eidos_apofasis'];
            $edit_thematiki = $apAuth->Query_General->Fields['thematiki'];
            $edit_telikos_ypografwn = $apAuth->Query_General->Fields['telikos_ypografwn'];
            $edit_related_ADAs = $apAuth->Query_General->Fields['related_ADAs'];
            $edit_apofasi_date = $apAuth->Query_General->Fields['apofasi_date'];
            $edit_syntaktis_email = $apAuth->Query_General->Fields['syntaktis_email'];

            $this->field_FEK->Text = $edit_ET_FEK;
            $this->field_FEK_tefxos->ItemIndex = $edit_ET_FEK_tefxos;
            $this->field_FEK_etos->ItemIndex = $edit_ET_FEK_etos;
            $this->field_arithmos_protokolou->Text = $edit_arithmos_protokolou;
            $this->field_thema->Text = $edit_thema;
            $this->field_monades_text->ItemIndex = $edit_monada;
            $this->field_related_ADAs->Text = $edit_related_ADAs;
            $this->field_eidos_apofasis->ItemIndex = $edit_eidos_apofasis;
            $this->field_apofasi_date->Text = $edit_apofasi_date;
            $this->field_syntaktis_email->Text = $edit_syntaktis_email;

            $this->field_thematiki_enotita_values->Clear();
            $edit_thematikiCSVArray = explode(',', $edit_thematiki);
            $edit_thematikiText = '';
            for($edit_thematikii = 0; $edit_thematikii < count($edit_thematikiCSVArray); $edit_thematikii++)
            {
               $this_edit_thematiki = str_replace('#', '', $edit_thematikiCSVArray[$edit_thematikii]);
               if(!($this_edit_thematiki == '0'))
               {
                  $apAuth->Query_General->SQL = "SELECT * FROM thematikes where ID='" . $this_edit_thematiki . "'";
                  $apAuth->Query_General->LimitCount = "-1";
                  $apAuth->Query_General->LimitStart = "-1";
                  $apAuth->Query_General->Prepare();
                  $apAuth->Query_General->close();
                  $apAuth->Query_General->open();
                  $this->field_thematiki_enotita_values->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
               }
            }

            $this->field_thematiki_enotita_values_text->Value = $edit_thematiki;
            $this->field_telikos_ypografwn->ItemIndex = $edit_telikos_ypografwn;
            global $extraFieldsArray;
            $this->ExtraFieldsContainer->Caption = $extraFieldsArray->getPopulatedExtraFields($isEditForm_ada, false);
         }
         else
         {

            $this->isEditForm_h->Value = false;
            $this->isEditForm_ada->Value = '';
            $this->field_file->Visible = true;
            $this->Label_file->Visible = true;
            $this->SubmitButton->Caption = 'Υποβολή';
            $this->SubmitButton->Width = 75;
         }

         if($isContForm)
         {

            $query = "SELECT * FROM apofaseis_temp WHERE id='" . $isContForm_id . "'";
            $apAuth->Query_General->SQL = $query;
            $apAuth->Query_General->LimitCount = "-1";
            $apAuth->Query_General->LimitStart = "-1";
            $apAuth->Query_General->Prepare();
            $apAuth->Query_General->close();
            $apAuth->Query_General->open();
            $isContForm_ada = $apAuth->Query_General->Fields['ada'];

            $cont_ET_FEK = $apAuth->Query_General->Fields['ET_FEK'];
            $cont_ET_FEK_tefxos = $apAuth->Query_General->Fields['ET_FEK_tefxos'];
            $cont_ET_FEK_etos = $apAuth->Query_General->Fields['ET_FEK_etos'];
            $cont_arithmos_protokolou = $apAuth->Query_General->Fields['arithmos_protokolou'];
            $cont_thema = $apAuth->Query_General->Fields['thema'];
            $cont_monada = $apAuth->Query_General->Fields['monada'];
            $cont_eidos_apofasis = $apAuth->Query_General->Fields['eidos_apofasis'];
            $cont_thematiki = $apAuth->Query_General->Fields['thematiki'];
            $cont_telikos_ypografwn = $apAuth->Query_General->Fields['telikos_ypografwn'];
            $cont_related_ADAs = $apAuth->Query_General->Fields['related_ADAs'];
            $cont_apofasi_date = $apAuth->Query_General->Fields['apofasi_date'];
            $cont_syntaktis_email = $apAuth->Query_General->Fields['syntaktis_email'];

            $this->field_FEK->Text = $cont_ET_FEK;
            $this->field_FEK_tefxos->ItemIndex = $cont_ET_FEK_tefxos;
            $this->field_FEK_etos->ItemIndex = $cont_ET_FEK_etos;
            $this->field_arithmos_protokolou->Text = $cont_arithmos_protokolou;
            $this->field_thema->Text = $cont_thema;
            $this->field_monades_text->ItemIndex = $cont_monada;
            $this->field_related_ADAs->Text = $cont_related_ADAs;
            $this->field_eidos_apofasis->ItemIndex = $cont_eidos_apofasis;
            $this->field_apofasi_date->Text = $cont_apofasi_date;
            $this->field_syntaktis_email->Text = $cont_syntaktis_email;

            $this->field_thematiki_enotita_values->Clear();
            $cont_thematikiCSVArray = explode(',', $cont_thematiki);
            $cont_thematikiText = '';
            for($cont_thematikii = 0; $cont_thematikii < count($cont_thematikiCSVArray); $cont_thematikii++)
            {
               $this_cont_thematiki = str_replace('#', '', $cont_thematikiCSVArray[$cont_thematikii]);
               if(!($this_cont_thematiki == '0'))
               {
                  $apAuth->Query_General->SQL = "SELECT * FROM thematikes where ID='" . $this_cont_thematiki . "'";
                  $apAuth->Query_General->LimitCount = "-1";
                  $apAuth->Query_General->LimitStart = "-1";
                  $apAuth->Query_General->Prepare();
                  $apAuth->Query_General->close();
                  $apAuth->Query_General->open();
                  $this->field_thematiki_enotita_values->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
               }
            }

            $this->field_thematiki_enotita_values_text->Value = $cont_thematiki;
            $this->field_telikos_ypografwn->ItemIndex = $cont_telikos_ypografwn;
            global $extraFieldsArray;
            $this->ExtraFieldsContainer->Caption = $extraFieldsArray->getPopulatedExtraFields($isContForm_ada, true);
            $apAuth->DB_General->execute("
      DELETE FROM sha2_temp WHERE sha2_temp.ada ='" . $isContForm_ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM files_temp WHERE files_temp.ada ='" . $isContForm_ada . "'
     ");
            $filename = '/tmp/sbmt_' . bin2hex(mHash(MHASH_SHA256, $isContForm_ada)).'.ori';
            unlink($filename);
            $filename = '/tmp/sbmt_' . bin2hex(mHash(MHASH_SHA256, $isContForm_ada)).'.signed';
            unlink($filename);
            $apAuth->DB_General->execute("
      DELETE FROM apofaseis_temp WHERE apofaseis_temp.ada ='" . $isContForm_ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM apofaseis WHERE apofaseis.ada ='" . $isContForm_ada . "'
     ");
            $apAuth->DB_General->execute("
      DELETE FROM apofaseis_dynamic_fields_values_temp WHERE apofaseis_dynamic_fields_values_temp.ada ='" . $isContForm_ada . "'
     ");
            /*
            try
            {
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM files_temp WHERE files_temp.ada ='" . $isContForm_ada . "'
            ");
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM apofaseis_temp WHERE apofaseis_temp.ada ='" . $isContForm_ada . "'
            ");
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM apofaseis WHERE apofaseis.ada ='" . $isContForm_ada . "'
            ");
            $ExtraDBConnection->DB_General->execute("
            DELETE FROM apofaseis_dynamic_fields_values_temp WHERE apofaseis_dynamic_fields_values_temp.ada ='" . $isContForm_ada . "'
            ");
            }
            catch(Exception $e)
            {
            }
            */
         }

         if($isNewForm)
         {

            $this->field_FEK->Text = '';
            $this->field_FEK_tefxos->ItemIndex = 0;
            $this->field_FEK_etos->ItemIndex = 0;
            $this->field_arithmos_protokolou->Text = '';
            $this->field_thema->Text = '';
            $this->field_monades_text->ItemIndex = 0;
            $this->field_related_ADAs->Text = '';
            $this->field_eidos_apofasis->ItemIndex = 0;
            $this->field_apofasi_date->Text = '';
            $this->field_syntaktis_email->Text = '';
            $this->js_thematiki->Text = '';
            $this->field_is_orthi_epanalipsi->Checked = false;
            $this->field_thematiki_enotita_values->Clear();
            $cont_thematikiCSVArray = explode(',', $cont_thematiki);
            $cont_thematikiText = '';

            $this->field_thematiki_enotita_values_text->Value = '';
            $this->field_telikos_ypografwn->ItemIndex = 0;
            $this->ExtraFieldsContainer->Caption = '';
         }

         $this->field_telikos_ypografwn->Clear();

         $query = "SELECT ypografontes.*,ypografontes.ID as ypID,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE NOT monada_id='0' AND en_energeia='1' AND ypografontes.type_id=ypografontes_types.ID AND ypografontes.monada_id=1000000  AND ypografontes.pb_id='" . $apAuth->userData['start_pb_id'] . "'";

         if($isEditForm)
         {
            $query = "(SELECT ypografontes.*,ypografontes.ID as ypID,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE  NOT monada_id='0' AND en_energeia='1' AND ypografontes.type_id=ypografontes_types.ID AND ypografontes.monada_id=1000000 AND ypografontes.pb_id='" . $apAuth->userData['start_pb_id'] . "')
   UNION
   (SELECT ypografontes.*,ypografontes.ID as ypID,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE  NOT monada_id='0' AND en_energeia='1' AND ypografontes.type_id=ypografontes_types.ID AND ypografontes.monada_id='" . $edit_monada . "')";
         }
         if($isContForm)
         {
            $query = "(SELECT ypografontes.*,ypografontes.ID as ypID,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE  NOT monada_id='0' AND en_energeia='1' AND ypografontes.type_id=ypografontes_types.ID AND ypografontes.monada_id=1000000 AND ypografontes.pb_id='" . $apAuth->userData['start_pb_id'] . "')
   UNION
   (SELECT ypografontes.*,ypografontes.ID as ypID,ypografontes_types.name as type_name from ypografontes,ypografontes_types WHERE  NOT monada_id='0' AND en_energeia='1' AND ypografontes.type_id=ypografontes_types.ID AND ypografontes.monada_id='" . $cont_monada . "')";
         }




         $this->field_telikos_ypografwn->AddItem('', null , '0');

         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();
         for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
         {
            $this->field_telikos_ypografwn->AddItem($apAuth->Query_General->Fields['type_name'] . " - " . $apAuth->Query_General->Fields['firstname'] . " " . $apAuth->Query_General->Fields['lastname'], null , $apAuth->Query_General->Fields['ID']);
            $apAuth->Query_General->next();
         }

         $this->field_telikos_ypografwn->ItemIndex = 0;
         if($isEditForm)
         {
            $this->field_telikos_ypografwn->ItemIndex = $edit_telikos_ypografwn;
         }
         if($isContForm)
         {
            $this->field_telikos_ypografwn->ItemIndex = $cont_telikos_ypografwn;
         }

         $this->field_monades_text->Clear();
         $this->field_monades_text->AddItem('', null , '0');
         $query = "SELECT monades.*,monades_types.name as type_name from monades,monades_types WHERE monades.type_id=monades_types.ID AND monades.parent_pb_id='" . $apAuth->userData['start_pb_id'] . "' ORDER BY name ASC;";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();
         for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
         {
            $this->field_monades_text->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
            $apAuth->Query_General->next();
         }



         $this->field_thematiki_enotita->Clear();
         $this->field_thematiki_enotita->AddItem('', null , '0');
         $query = "SELECT * from thematikes ORDER BY name ASC;";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();
         for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
         {
            $this->field_thematiki_enotita->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
            $apAuth->Query_General->next();
         }
         $this->field_thematiki_enotita->ItemIndex = 0;

         $this->field_eidos_apofasis->Clear();
         $this->field_eidos_apofasis->AddItem('', null , '0');
         $query = "SELECT * from eidi_apofaseon WHERE NOT INSTR(name,'(')=1 AND hidden='0' ORDER BY name ASC;";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();
         for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
         {
            if($apAuth->Query_General->Fields['description'] == '')
            {
               $this->field_eidos_apofasis->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
            }
            else
            {
               $this->field_eidos_apofasis->AddItem($apAuth->Query_General->Fields['name'] . ' (' . $apAuth->Query_General->Fields['description'] . ')', null , $apAuth->Query_General->Fields['ID']);
            }
            $apAuth->Query_General->next();
         }
         $query = "SELECT * from eidi_apofaseon WHERE INSTR(name,'(')=1 AND hidden='0' ORDER BY name ASC;";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();
         for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
         {
            $this->field_eidos_apofasis->AddItem($apAuth->Query_General->Fields['name'], null , $apAuth->Query_General->Fields['ID']);
            $apAuth->Query_General->next();
         }
      }
      $success = true;
      $afm_error = false;
      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {

         try
         {
            $arithmos_protokolou = mysql_escape_string($this->field_arithmos_protokolou->Text);

            $levels = array();
            $maxlevel = 4;//Change to increase/decrease levels saved to db
            for($maxlevel_i = 1; $maxlevel_i <= $maxlevel; $maxlevel_i++)
            {
               array_push($levels, mysql_escape_string($_POST['field_level' . $maxlevel_i . '_text']));
            }

            for($maxlevel_i = 0; $maxlevel_i <= $maxlevel; $maxlevel_i++)
            {
               if($levels[$maxlevel_i] > 0)
               {
                  $lastlevel = $levels[$maxlevel_i];
               }
            }
            $levelsHash = array();

            for($maxlevel_i = 1; $maxlevel_i <= $maxlevel; $maxlevel_i++)
            {
               array_push($levelsHash, '#' . $levels[$maxlevel_i - 1] . '#');
            }
            $start_pb_id = $apAuth->userData['start_pb_id'];
            if (($start_pb_id!=$lastlevel))
            {
                  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head profile="http://gmpg.org/xfn/11">

	<title>Σύστημα Ανάρτησης Αποφάσεων - Σφάλμα</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Language" content="el" />
	<meta name="author" content="OpenGov.gr">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div id="wrapper">
<font color="red">
Σφάλμα κατά την ανάρτηση απόφασης. Παρακαλώ προσπαθήστε αργότερα. Κωδικός λάθους: #480.
</font>
</div>
</body>
</html>';
                  exit;
                  $success = false;
                  $errormessage = 'Foreas ID and User Foread Id missmatch';
            }
            $levelsCSV = implode(',', $levelsHash);

            $tags = mysql_escape_string($_POST['field_tags']);
            $koinopoiiseis = mysql_escape_string($this->field_koinapoiiseis->Text);
            $eidos_apofasis = mysql_escape_string($_POST['field_eidos_apofasis']);
            $thema = mysql_escape_string(strip_tags($_POST['field_thema']));
            $monades = mysql_escape_string(strip_tags($_POST['field_monades_text']));
            $FEK = mysql_escape_string(strip_tags($_POST['field_FEK']));
            $FEK_tefxos = mysql_escape_string(strip_tags($_POST['field_FEK_tefxos']));
            $FEK_etos = mysql_escape_string(strip_tags($_POST['field_FEK_etos']));
            $original_timezone = date_default_timezone_get();
            date_default_timezone_set('Europe/Athens');
            $submission_time = time();
            $submission_timestamp_Ymd = date('Y-m-d', $submission_time);
            $submission_timestamp = date('Y-m-d H:i:s', $submission_time);
            date_default_timezone_set($original_timezone);
            $apofasi_date = mysql_escape_string($_POST['field_apofasi_date']);
            $thematiki = mysql_escape_string($_POST['field_thematiki_enotita_values_text']);
            $telikos_ypografwn = mysql_escape_string($_POST['field_telikos_ypografwn']);
            $syntaktis_email = mysql_escape_string($_POST['field_syntaktis_email']);
            $related_ADAs = mysql_escape_string($_POST['field_related_ADAs']);
            $is_orthi_epanalipsi = mysql_escape_string($_POST['field_old_ada']);
            $user = $apAuth->ZAuth->UserName;


            $firstLevel_pb_id = get_level1_pb_id($ypourgeio_table, $lastlevel);

            $ypourgeio = $firstLevel_pb_id;
            //$isET_Apofasi = "0";
            $ETURL = '';

            if($_REQUEST['isEditForm_h'] == 'true')
            {
               $isEditForm_ada = mysql_escape_string($_REQUEST['isEditForm_ada']);

               $query = "
               UPDATE apofaseis SET
               ET_FEK = '" . $FEK . "',
               ET_FEK_tefxos = '" . $FEK_tefxos . "',
               ET_FEK_etos = '" . $FEK_etos . "',
               apofasi_date= '" . $apofasi_date . "',
               arithmos_protokolou = '" . $arithmos_protokolou . "',
               thema = '" . $thema . "',
               monada = '" . $monades . "',
               eidos_apofasis = '" . $eidos_apofasis . "',
               thematiki = '" . $thematiki . "',
               telikos_ypografwn = '" . $telikos_ypografwn . "',
               lastlevel = '" . $lastlevel . "',
               levelsCSV = '" . $levelsCSV . "',
               is_orthi_epanalipsi= '" . $is_orthi_epanalipsi . "',
               related_ADAs = '" . $related_ADAs . "'
               WHERE ada = '" . $isEditForm_ada . "'
               ";

               $apAuth->DB_General->execute($query);
               /*
               try
               {
               $ExtraDBConnection->DB_General->execute($query);
               }
               catch(Exception $e)
               {
               }
               */


               $query = "DELETE FROM apofaseis_dynamic_fields_values WHERE ada='" . $isEditForm_ada . "'";

               $apAuth->DB_General->execute($query);
               /*
               try
               {
               $ExtraDBConnection->DB_General->execute($query);
               }
               catch(Exception $e)
               {
               }
               */

               global $extraFieldsArray;
               $efArray = $extraFieldsArray->getExtraFieldArray($eidos_apofasis);

               for($efi = 0; $efi < count($efArray); $efi++)
               {
                  $query = "
                  INSERT INTO apofaseis_dynamic_fields_values
                  (

                  ada,
                  dynamic_field_ID,
                  field_value
                  )
                  VALUES ( '" .

                  $isEditForm_ada . "','" .
                  $efArray[$efi]["ID"] . "','" .
                  mysql_escape_string($_REQUEST[$efArray[$efi]["fieldname"]]) . "'" .
                  " )";



                  $apAuth->DB_General->execute($query);
                  /*
                  try
                  {
                  $ExtraDBConnection->DB_General->execute($query);
                  }
                  catch(Exception $e)
                  {
                  }
                  */

               }
               redirect_withdetection('submission_complete.php?ada=' . $isEditForm_ada . '&pb_id=' . $edit_lastlevel);
            }
            else
            {

               $thisadaGenerator = new adaGenerator();
               $writesuccess = true;
               do
               {
                  $newADA = $thisadaGenerator->getADAUID($submission_timestamp_Ymd, $ypourgeio, $lastlevel);
                  $query = "INSERT INTO apofaseis_temp (ada) VALUES ('" . $newADA . "');";
                  try
                  {
                     $apAuth->DB_General->execute($query);
                  }
                  catch(Exception $thise)
                  {
                     $thise_message = $thise->getMessage();
                     if(strpos($thise_message, 'Duplicate entry') > 0)
                     {
                        $writesuccess = false;
                     }

                  }
                  /*
                  try
                  {
                  $ExtraDBConnection->DB_General->execute($query);
                  }
                  catch(Exception $e)
                  {
                  }
                  */
                  $query = "INSERT INTO apofaseis (ada) VALUES ('" . $newADA . "');";
                  try
                  {
                     $apAuth->DB_General->execute($query);
                  }
                  catch(Exception $thise)
                  {
                     $thise_message = $thise->getMessage();
                     if(strpos($thise_message, 'Duplicate entry') > 0)
                     {
                        $writesuccess = false;
                     }

                  }
                  /*
                  try
                  {
                  $ExtraDBConnection->DB_General->execute($query);
                  }
                  catch(Exception $e)
                  {
                  }
                  */
                  if(checkDuplicateADA($newADA) > 0) $writesuccess = false;
               }
               while($writesuccess = false) ;



               $thisSinging = new signingClass();
               $thisSinging->original_temp_filename = $this->field_file->FileTmpName;
               $thisSinging->original_filename = $this->field_file->FileName;
               $thisSinging->ada = $newADA;
               if($thisSinging->signFile())
               {

                  $thisSinging_signed_temp_filename = $thisSinging->signed_temp_filename;
                  $thisSinging_signed_filename = $thisSinging->signed_filename;
                  $thisSigning_sha2 = $thisSinging->pdf_sha2;
                  unset($thisSinging);
                  $query = "
                  UPDATE apofaseis_temp SET
                  arithmos_protokolou = '" . $arithmos_protokolou . "',
                  apofasi_date= '" . $apofasi_date . "',
                  koinopoiiseis = '" . $koinopoiiseis . "',
                  eidos_apofasis = '" . $eidos_apofasis . "',
                  thematiki= '" . $thematiki . "',
                  thema= '" . $thema . "',
                  monada= '" . $monades . "',
                  submission_timestamp= '" . $submission_timestamp . "',
                  lastlevel= '" . $lastlevel . "',
                  levelsCSV= '" . $levelsCSV . "',
                  telikos_ypografwn= '" . $telikos_ypografwn . "',
                  isET_Apofasi= '" . $isET_Apofasi . "',
                  is_orthi_epanalipsi= '" . $is_orthi_epanalipsi . "',
                  ETURL= '" . $ETURL . "',
                  tags= '" . $tags . "',
                  user= '" . $user . "',
                  ET_FEK= '" . $FEK . "',
                  ET_FEK_tefxos= '" . $FEK_tefxos . "',
                  ET_FEK_etos= '" . $FEK_etos . "',
                  status= 'active',
                  syntaktis_email= '" . $syntaktis_email . "',
                  related_ADAs= '" . $related_ADAs . "'
                  WHERE
                  ada = '" . $newADA . "' ";
                  $apAuth->DB_General->execute($query);
                  /*
                  try
                  {
                  $ExtraDBConnection->DB_General->execute($query);
                  }
                  catch(Exception $e)
                  {
                  }
                  */

                  global $extraFieldsArray;
                  $efArray = $extraFieldsArray->getExtraFieldArray($eidos_apofasis);


                  for($efi = 0; $efi < count($efArray); $efi++)
                  {

                     if($efArray[$efi]["type"] == 'afm')
                     {
                        $afm_value = $_REQUEST[$efArray[$efi]["fieldname"]];

                        $afm_error = !(validateAFM($afm_value));
                        if($afm_error)
                        {
                           $success = false;

                           $this->JSMessagePanel->Caption = "
          <script language=javascript type='text/javascript'>
          alert('Παρακαλούμε εισάγετε ένα εγκυρο ΑΦΜ στο πεδίο: `" . $efArray[$efi]["label"] . "`.');
          document.Apofaseis_Ypourgeiou." . $efArray[$efi]["fieldname"] . ".focus();
          document.Apofaseis_Ypourgeiou." . $efArray[$efi]["fieldname"] . ".select();
          </script>";

                           $this->ExtraFieldsContainer->Caption = $extraFieldsArray->getPopulatedExtraFields($newADA, true);
                        }
                     }


                     if($efArray[$efi]["type"] == 'money')
                     {
                        $number_value = $_REQUEST[$efArray[$efi]["fieldname"]];
                        $valid_chars_array = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ',', '.');
                        $number_value_filtered = '';
                        for($chari = 1; $chari <= strlen($number_value); $chari++)
                        {
                           if(in_array($number_value[$chari - 1], $valid_chars_array))
                           {
                              $number_value_filtered = $number_value_filtered . $number_value[$chari - 1];
                           }
                        }
                        $number_value = $number_value_filtered;
                        $found_first_separator = false;
                        $number_value_stripped = '';
                        for($chari = strlen($number_value); $chari > 0; $chari--)
                        {
                           if(($number_value[$chari - 1] == ',')or($number_value[$chari - 1] == '.'))
                           {
                              if(($found_first_separator == false) && ($chari < strlen($number_value)))
                              {
                                 $number_value_stripped = '.' . $number_value_stripped;
                              }
                              $found_first_separator = true;
                           }
                           else
                           {
                              $number_value_stripped = $number_value[$chari - 1] . $number_value_stripped;
                           }
                        }
                        $number_value = $number_value_stripped;
                        if(($number_value == '') || ($number_value == ',') || ($number_value == '.'))
                        {
                           $number_value = 0;
                        }
                     }
                     else
                     {
                        $number_value = 0;
                     }

                     $query = "
                  INSERT INTO apofaseis_dynamic_fields_values_temp
                  (

                  ada,
                  dynamic_field_ID,
                  field_value,
                  field_value_number
                  )
                  VALUES ( '" .

                     $newADA . "','" .
                     $efArray[$efi]["ID"] . "','" .
                     mysql_escape_string($_REQUEST[$efArray[$efi]["fieldname"]]) . "','" .
                     $number_value . "'" .
                     " )";
                     $apAuth->DB_General->execute($query);
                     /*
                     try
                     {
                     $ExtraDBConnection->DB_General->execute($query);
                     }
                     catch(Exception $e)
                     {
                     }
                     */
                  }


                  $apAuth->Query_General->SQL = "SELECT id as max_count FROM apofaseis_temp where ada='" . $newADA . "'";
                  $apAuth->Query_General->LimitCount = "-1";
                  $apAuth->Query_General->LimitStart = "-1";
                  $apAuth->Query_General->Prepare();
                  $apAuth->Query_General->close();
                  $apAuth->Query_General->open();
                  $insert_ID = $apAuth->Query_General->Fields['max_count'];

                  $query = "
                  INSERT INTO sha2_temp
                  (

                  ada,
                  sha2
                  )
                  VALUES ( '" .

                  $newADA . "','" .
                  $thisSigning_sha2 . "'" .
                  " )";
                  $apAuth->DB_General->execute($query);
                  /*
                  try
                  {
                  $ExtraDBConnection->DB_General->execute($query);
                  }
                  catch(Exception $e)
                  {
                  }
                  */



                  $original_filename = $this->field_file->FileName;
                  $original_filename = mysql_real_escape_string($original_filename);
                  $fp = fopen($this->field_file->FileTmpName, 'r');
                  $file_size = filesize($this->field_file->FileTmpName);
                  $original_content = fread($fp, $file_size)or die("Error: cannot read file1-1");
                  //$original_content = mysql_real_escape_string($file_content)or die("Error: cannot read file1-2");
                  unset($file_content);
                  fclose($fp);

                  $fp = fopen($thisSinging_signed_temp_filename, 'r');
                  $file_size = filesize($thisSinging_signed_temp_filename);
                  $signed_content = fread($fp, $file_size)or die("Error: cannot read file2-1");
                  //$signed_content = mysql_real_escape_string($signed_content)or die("Error: cannot read file2-2");
                  fclose($fp);

                  $filename = '/tmp/sbmt_' . bin2hex(mHash(MHASH_SHA256, $newADA)).'.ori';
                  if(!$handle = fopen($filename, 'w+'))
                  {
                     //echo "Error while writing : Cannot open file<br>";
                     //exit;
                  }

                  if(fwrite($handle, $original_content) === FALSE)
                  {
                     //echo "Error while writing : Cannot write to file<br>";
                     //exit;
                  }
                  fclose($handle);

                  $filename = '/tmp/sbmt_' . bin2hex(mHash(MHASH_SHA256, $newADA)).'.signed';
                  if(!$handle = fopen($filename, 'w+'))
                  {
                     //echo "Error while writing : Cannot open file<br>";
                     //exit;
                  }

                  if(fwrite($handle, $signed_content) === FALSE)
                  {
                     //echo "Error while writing : Cannot write to file<br>";
                     //exit;
                  }
                  fclose($handle);

                  $query = "
                  INSERT INTO files_temp
                  (

                  ada,
                  original,
                  original_filename,
                  signed,
                  signed_filename
                  )
                  VALUES ( '" .

                  $newADA . "','','" .
                  $original_filename . "','','" .
                  $thisSinging_signed_filename . "'" .
                  " )";
                  $apAuth->DB_General->execute($query);
                  /*
                  try
                  {
                  $ExtraDBConnection->DB_General->execute($query);
                  }
                  catch(Exception $e)
                  {
                  }
                  */
                  unset($original_content);
                  unset($signed_content);

               }

               else
               {

                  $errormessage = 'File signing failed';
                  //-----------------------------------------------------
                  global $apAuth;
                  $apAuth->DB_General->DoConnect();
                  $apAuth->DB_General->execute("SET NAMES utf8");
                  $query = "INSERT INTO apofaseis_errors (ada) VALUES ('" . $newADA . "');";

                  $apAuth->DB_General->execute($query);
                  $original_timezone = date_default_timezone_get();
                  date_default_timezone_set('Europe/Athens');
                  $error_time = time();
                  $error_timestamp = date('Y-m-d H:i:s', $error_time);
                  date_default_timezone_set($original_timezone);
                  $query = "
                  UPDATE apofaseis_errors SET
                  arithmos_protokolou = '" . $arithmos_protokolou . "',
                  apofasi_date= '" . $apofasi_date . "',
                  koinopoiiseis = '" . $koinopoiiseis . "',
                  eidos_apofasis = '" . $eidos_apofasis . "',
                  thematiki= '" . $thematiki . "',
                  thema= '" . $thema . "',
                  monada= '" . $monades . "',
                  submission_timestamp= '" . $submission_timestamp . "',
                  lastlevel= '" . $lastlevel . "',
                  levelsCSV= '" . $levelsCSV . "',
                  telikos_ypografwn= '" . $telikos_ypografwn . "',
                  isET_Apofasi= '" . $isET_Apofasi . "',
                  ETURL= '" . $ETURL . "',
                  tags= '" . $tags . "',
                  user= '" . $user . "',
                  ET_FEK= '" . $FEK . "',
                  ET_FEK_tefxos= '" . $FEK_tefxos . "',
                  ET_FEK_etos= '" . $FEK_etos . "',
                  status= 'active',
                  syntaktis_email= '" . $syntaktis_email . "',
                  related_ADAs= '" . $related_ADAs . "',
                  error_location= '" . $_SERVER['PHP_SELF'] . "',
                  error_exception_message= '" . $errormessage . "',
                  error_headers= '" . mysql_escape_string(implode("\r\n", $_SERVER)) . "',
                  error_timestamp= '" . $error_timestamp . "'
                  WHERE
                  ada = '" . $newADA . "' ";
                  $apAuth->DB_General->execute($query);
                  $original_filename = $_FILES["field_file"]["name"];
                  $original_filename = mysql_real_escape_string($original_filename);
                  $fp = fopen($this->field_file->FileTmpName, 'r');
                  if($fp)
                  {
                     $file_size = filesize($this->field_file->FileTmpName);
                     $file_content = fread($fp, $file_size)or die("Error: cannot read file1-1");
                     $original_content = mysql_real_escape_string($file_content)or die("Error: cannot read file1-2");
                     unset($file_content);
                     fclose($fp);
                  }

                  $signed_content = "-";
                  $original_content = "-";
                  $query = "
                  INSERT INTO files_errors
                  (

                  ada,
                  original,
                  original_filename,
                  signed,
                  signed_filename
                  )
                  VALUES ( '" .

                  $newADA . "','" .
                  $original_content . "','" .
                  $original_filename . "','" .
                  $signed_content . "','" .
                  $thisSinging_signed_filename . "'" .
                  " )";
                  $apAuth->DB_General->execute($query);
                  unset($original_content);

                  //--------------------------------------------------------

                  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head profile="http://gmpg.org/xfn/11">

	<title>Σύστημα Ανάρτησης Αποφάσεων - Σφάλμα</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Language" content="el" />
	<meta name="author" content="OpenGov.gr">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div id="wrapper">
<font color="red">
Σφάλμα κατά την ανάρτηση απόφασης. Παρακαλώ προσπαθήστε αργότερα. Κωδικός λάθους: #470.
</font>
</div>
</body>
</html>';
                  exit;
                  $success = false;
                  $errormessage = 'File signing failed';
               }
               unlink($thisSinging_signed_temp_filename);
            }
         }
         catch(Exception $e)
         {
            $success = false;
            $errormessage = $e->getMessage();
            //-----------------------------------------------------



            global $apAuth;
            $apAuth->DB_General->DoConnect();
            $apAuth->DB_General->execute("SET NAMES utf8");
            $query = "INSERT INTO apofaseis_errors (ada) VALUES ('" . $newADA . "');";
            try
            {
               $apAuth->DB_General->execute($query);
            }
            catch(Exception $ee)
            {
            }
            $original_timezone = date_default_timezone_get();
            date_default_timezone_set('Europe/Athens');
            $error_time = time();
            $error_timestamp = date('Y-m-d H:i:s', $error_time);
            date_default_timezone_set($original_timezone);
            $query = "
                  UPDATE apofaseis_errors SET
                  arithmos_protokolou = '" . $arithmos_protokolou . "',
                  apofasi_date= '" . $apofasi_date . "',
                  koinopoiiseis = '" . $koinopoiiseis . "',
                  eidos_apofasis = '" . $eidos_apofasis . "',
                  thematiki= '" . $thematiki . "',
                  thema= '" . $thema . "',
                  monada= '" . $monades . "',
                  submission_timestamp= '" . $submission_timestamp . "',
                  lastlevel= '" . $lastlevel . "',
                  levelsCSV= '" . $levelsCSV . "',
                  telikos_ypografwn= '" . $telikos_ypografwn . "',
                  isET_Apofasi= '" . $isET_Apofasi . "',
                  ETURL= '" . $ETURL . "',
                  tags= '" . $tags . "',
                  user= '" . $user . "',
                  ET_FEK= '" . $FEK . "',
                  ET_FEK_tefxos= '" . $FEK_tefxos . "',
                  ET_FEK_etos= '" . $FEK_etos . "',
                  status= 'active',
                  syntaktis_email= '" . $syntaktis_email . "',
                  related_ADAs= '" . $related_ADAs . "',
                  error_location= '" . $_SERVER['PHP_SELF'] . "',
                  error_exception_message= '" . mysql_escape_string($errormessage) . "',
                  error_headers= '" . mysql_escape_string(implode("\r\n", $_SERVER)) . "',
                  error_timestamp= '" . $error_timestamp . "'
                  WHERE
                  ada = '" . $newADA . "' ";


            $apAuth->DB_General->execute($query);
            $original_filename = $_FILES["field_file"]["name"];
            $original_filename = mysql_real_escape_string($original_filename);
            $fp = fopen($this->field_file->FileTmpName, 'r');
            if($fp)
            {
               $file_size = filesize($this->field_file->FileTmpName);
               $file_content = fread($fp, $file_size)or die("Error: cannot read file1-1");
               $original_content = mysql_real_escape_string($file_content)or die("Error: cannot read file1-2");
               unset($file_content);
               fclose($fp);
            }

            $signed_content = "-";

            $query = "
                  INSERT INTO files_errors
                  (

                  ada,
                  original,
                  original_filename,
                  signed,
                  signed_filename
                  )
                  VALUES ( '" .

            $newADA . "','" .
            $original_content . "','" .
            $original_filename . "','" .
            $signed_content . "','" .
            $thisSinging_signed_filename . "'" .
            " )";
            $apAuth->DB_General->execute($query);
            unset($original_content);
            //--------------------------------------------------------

         }


         //echo "'".$_REQUEST['continueForm']."'";

         if($thematiki == "")
         {
            $success = false;
         }

         if($success)
         {
            $this->Memo1->Add("Form Submitted.");
            $this->Memo1->Add('Insert ID:' . $insert_ID);
            $this->Memo1->Add("File Uploaded to " . $this->field_file->FileTmpName);
            redirect_withdetection('confirmation.php?id=' . $insert_ID);
         }
         elseif($thematiki == "")
         {

            $this->JSMessagePanel->Caption = "
          <script language=javascript type='text/javascript'>
          alert('Παρακαλούμε επιλέξτε τουλάχιστον μία θεματική.');
          </script>";

         }
         else
         {
            $this->Memo1->Add("Error during submission:" . $errormessage);
         }
      }
   }








   function SubmitButtonJSClick($sender, $params)
   {

      // echo $this->SubmitButton->ajaxCall("SubmitButtonClick");
?>
      String.prototype.reverse = function(){
        splitext = this.split("");
        revertext = splitext.reverse();
        reversed = revertext.join("");
        return reversed;
      }

       //Add your javascript code here
       if (FormValidator1_validate())
      {
    var validated;
    validated=true;


    try
    {
       if (!(document.getElementById("f-calendar-field-1")==null))
        {
            var vald=document.getElementById("f-calendar-field-1").value;

            if ((vald.indexOf('0000')>-1) || (vald.indexOf('-00-')>-1) || (vald.indexOf('-00')>-1))
            {
                 document.getElementById("f-calendar-field-1").focus();
                 if (validated) {alert('Παρακαλούμε εισάγετε μία σωστή ημερομηνία.'); }
                 validated=validated && false;
            }
        }
    }
    catch (err)
    {
     //alert("Error name: " + err.name  + ". Error message: " + err.message);
     }


    try
    {
       if (!(document.getElementById("field_thematiki_enotita_values")==null))
        {
            var valeia=document.getElementById("field_thematiki_enotita_values").value;
            if (valeia==0)
            {
                 document.getElementById("field_thematiki_enotita_values").focus();
                 if (validated) {alert('Παρακαλούμε επιλέξτε τουλάχιστον μία θεματική.'); }
                 validated=validated && false;
            }
        }
    }
    catch (err)
    {
     //alert("Error name: " + err.name  + ". Error message: " + err.message);
     }



    try
    {
       if (!(document.getElementById("field_eidos_apofasis")==null))
        {
            var sieia=document.getElementById("field_eidos_apofasis").selectedIndex;
            var valeia=document.getElementById("field_eidos_apofasis").options[sieia].value;
            if (valeia==0)
            {
                 document.getElementById("field_eidos_apofasis").focus();
                 if (validated) {alert('Παρακαλούμε επιλέξτε ένα είδος πράξης.'); }
                 validated=validated && false;
            }
        }
    }
    catch (err)
    {
     //alert("Error name: " + err.name  + ". Error message: " + err.message);
     }

    try
    {
       if (!(document.getElementById("field_telikos_ypografwn")==null))
       {
            var sity=document.getElementById("field_telikos_ypografwn").selectedIndex;
            var valty=document.getElementById("field_telikos_ypografwn").options[sity].value;
            if (valty==0)
            {
                 document.getElementById("field_telikos_ypografwn").focus();
                 if (validated) {alert('Παρακαλούμε επιλέξτε ένα τελικό υπογράφοντα.');}
                 validated=validated && false;
            }
       }
    }
    catch(err)
    {
     //alert("Error name: " + err.name  + ". Error message: " + err.message);
     }

<?php
      global $edit_eidos_apofasis_g;
      echo getExtraFieldsJavascript($edit_eidos_apofasis_g);
?>


    try
    {
       if (!(document.getElementById("field_file").value==null))
       {
         var filename=document.getElementById("field_file").value.toString().toLowerCase();
         var revext= filename.reverse().substr(0,4);
         if (revext=='fdp.') {
           validated=validated && true;
         }
         else
         {
           document.getElementById("field_file").focus();
           if (validated) {alert('Επιτρέπονται μόνο αρχεία PDF. Παρακαλούμε επιλέξτε άλλο αρχείο.');}
           validated=validated && false;
         }
       }
     }
     catch(err)
     {
     //alert("Error name: " + err.name  + ". Error message: " + err.message);
     }

       return validated;
       }
       else
       {
        return false;
       }
<?php


   }




   function Apofaseis_YpourgeiouCreate($sender, $params)
   {
      global $aclmanager;
      global $apAuth;

      $apAuth->initUserData();
      $usermessage = '<div align="left"><small> <a href="login.php?restore_session=1">ΕΞΟΔΟΣ</a>&nbsp;|&nbsp;<a href="index.php">ΕΠΙΛΟΓΕΣ</a>';
      $usermessage .= '&nbsp;|&nbsp;<a href="manage_current_user.php?action=edit&edit_id=' . md5(md5($apAuth->userData['ID']).md5('stav')).'">ΑΛΛΑΓΗ ΚΩΔΙΚΟΥ</a></a>&nbsp;|&nbsp;<a href="index.php?restore_session=1">ΑΠΟΣΥΝΔΕΣΗ</a></font>';
      $usermessage .= "<br><br><STRONG> Χρήστης:</STRONG> " . $apAuth->ZAuth->UserName;
      if($aclmanager->Role == 'user')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Χρήστης Φορέα:</STRONG> " . $apAuth->userData['foreas_name'] . "";
      }
      if($aclmanager->Role == 'admin_foreas')
      {
         $usermessage .= "<br><STRONG>Σύνδεση ως Διαχειριστής Φορέα: </STRONG>" . $apAuth->userData['foreas_name'] . "";
      }
      if($aclmanager->Role == 'admin')
      {
         $usermessage .= "<br><STRONG>Logged in as admin</STRONG>";
      }
      $usermessage .= "</small></div>";
      
      $this->Label2->Caption = $usermessage;
      $this->JSMessagePanel->Caption = "";
   }

}

global $application;

global $Apofaseis_Ypourgeiou;

//Creates the form
$Apofaseis_Ypourgeiou = new Apofaseis_Ypourgeiou($application);

//Read from resource file
$Apofaseis_Ypourgeiou->loadResource(__FILE__);

//Shows the form
$Apofaseis_Ypourgeiou->show();


?>