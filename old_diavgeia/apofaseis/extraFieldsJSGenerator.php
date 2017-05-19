<?php
require_once("apAuth.php");
function getExtraFieldsJavascript($eidi_apofaseon_ID)
{
   global $apAuth;

   $apAuth->DB_General->DoConnect();
   $apAuth->DB_General->execute("SET NAMES utf8");

   $newContent = "";
   $query = "SELECT * FROM apofaseis_dynamic_fields_list";//  WHERE eidi_apofaseon_ID='#".$eidi_apofaseon_ID."#'

   $apAuth->Query_General->SQL = $query;
   $apAuth->Query_General->LimitCount = "-1";
   $apAuth->Query_General->LimitStart = "-1";
   $apAuth->Query_General->Prepare();
   $apAuth->Query_General->close();
   $apAuth->Query_General->open();



   for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
   {
      $type = $apAuth->Query_General->Fields['type'];
      $label = $apAuth->Query_General->Fields['label'];
      $fieldname = $apAuth->Query_General->Fields['fieldname'];
      $required = $apAuth->Query_General->Fields['required'];
      $validation_type = $apAuth->Query_General->Fields['validation_type'];
      $voc_table = $apAuth->Query_General->Fields['voc_table'];

      if (($type == 'textfield') or ($type == 'textarea'))
      {
      if ($required=='1')
      {
       $newContent .='

    try
    {
       if (!(document.getElementById("extrafield_' . $fieldname.'")==null))
        {
            var val_extrafield_' . $fieldname.'=document.getElementById("extrafield_' . $fieldname.'").value;
            if ((val_extrafield_' . $fieldname.'=="") || (val_extrafield_' . $fieldname.'.replace(/ {1,}/g,"")==""))
            {
                 document.getElementById("extrafield_' . $fieldname.'").focus();
                 if (validated) {alert("Παρακαλούμε συμπληρώστε το πεδίο '.addslashes($label).'.");}
                 validated=validated && false;
            }
        }
    }
    catch (err)
    {
     //alert("Error name: " + err.name  + ". Error message: " + err.message);
     }

         ';
         }
    if ($validation_type=='money')
    {
         $newContent .='

    try
    {
       if (!(document.getElementById("extrafield_' . $fieldname.'")==null))
        {
            var val_extrafield_' . $fieldname.'=document.getElementById("extrafield_' . $fieldname.'").value;
            var regex = /^\$?[0-9][0-9]{0,2}(\.[0-9]{3})*(\,[0-9]{1,2})?$/;
            var regex_res=regex.test(val_extrafield_' . $fieldname.');
            if (!regex_res)
            {
                 document.getElementById("extrafield_' . $fieldname.'").focus();
                 if (validated) {alert("Παρακαλούμε σημειώσατε το πεδίο '.addslashes($label).' με σωστό τρόπο π.χ ώστε να χωρίζονται οι 1000 δες με τελεία (.) και τα λεπτά με κόμμα (,) π.χ 3.000 και 3.000,14 κλπ");}
                 validated=validated && false;
            }

        }
    }
    catch (err)
    {
     //alert("Error name: " + err.name  + ". Error message: " + err.message);
     }

         ';
   }

    if ($validation_type=='integer')
    {
         $newContent .='

    try
    {
       if (!(document.getElementById("extrafield_' . $fieldname.'")==null))
        {
            var val_extrafield_' . $fieldname.'=document.getElementById("extrafield_' . $fieldname.'").value;
            var val_extrafield_' . $fieldname.'_number=document.getElementById("extrafield_' . $fieldname.'").value;
            var val_extrafield_' . $fieldname.'_isNaN=isNaN(val_extrafield_' . $fieldname.'_number);
            if ((val_extrafield_' . $fieldname.'_isNaN) || (!(Math.round(val_extrafield_' . $fieldname.'_number)=val_extrafield_' . $fieldname.'_number)))
            {
                 document.getElementById("extrafield_' . $fieldname.'").focus();
                 if (validated) {alert("Παρακαλούμε σημειώσατε το πεδίο '.addslashes($label).' με σωστό τρόπο: Επτρέπεται μονο αρθμός");}
                 validated=validated && false;
            }

        }
    }
    catch (err)
    {
     //alert("Error name: " + err.name  + ". Error message: " + err.message);
     }

         ';
   }
      }



      if($type == 'dropdown')
      {


         $newContent .= '';
      }

      $apAuth->Query_General->next();
   }


   return $newContent;
}
?>