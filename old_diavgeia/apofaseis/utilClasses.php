<?php

require_once("apAuth.php");

function checkDuplicateADA($ada)
{
   global $apAuth;
   $retval=0;
   $apAuth->DB_General->DoConnect();
   $apAuth->DB_General->execute("SET NAMES utf8");
   sleep(1);
   $query = "SELECT ada FROM sha2_temp WHERE ada='" . $ada . "'";
   $apAuth->Query_General->SQL = $query;
   $apAuth->Query_General->LimitCount = "-1";
   $apAuth->Query_General->LimitStart = "-1";
   $apAuth->Query_General->Prepare();
   $apAuth->Query_General->close();
   $apAuth->Query_General->open();
   $retval=$retval+$apAuth->Query_General->RecordCount;

   $query = "SELECT ada FROM apofaseis_dynamic_fields_values_temp WHERE ada='" . $ada . "'";
   $apAuth->Query_General->SQL = $query;
   $apAuth->Query_General->LimitCount = "-1";
   $apAuth->Query_General->LimitStart = "-1";
   $apAuth->Query_General->Prepare();
   $apAuth->Query_General->close();
   $apAuth->Query_General->open();
   $retval=$retval+$apAuth->Query_General->RecordCount;

   $query = "SELECT ada FROM files_temp WHERE ada='" . $ada . "'";
   $apAuth->Query_General->SQL = $query;
   $apAuth->Query_General->LimitCount = "-1";
   $apAuth->Query_General->LimitStart = "-1";
   $apAuth->Query_General->Prepare();
   $apAuth->Query_General->close();
   $apAuth->Query_General->open();
   $retval=$retval+$apAuth->Query_General->RecordCount;

   $query = "SELECT ada FROM files WHERE ada='" . $ada . "'";
   $apAuth->Query_General->SQL = $query;
   $apAuth->Query_General->LimitCount = "-1";
   $apAuth->Query_General->LimitStart = "-1";
   $apAuth->Query_General->Prepare();
   $apAuth->Query_General->close();
   $apAuth->Query_General->open();
   $retval=$retval+$apAuth->Query_General->RecordCount;

   $query = "SELECT ada FROM apofaseis_dynamic_fields_values WHERE ada='" . $ada . "'";
   $apAuth->Query_General->SQL = $query;
   $apAuth->Query_General->LimitCount = "-1";
   $apAuth->Query_General->LimitStart = "-1";
   $apAuth->Query_General->Prepare();
   $apAuth->Query_General->close();
   $apAuth->Query_General->open();
   $retval=$retval+$apAuth->Query_General->RecordCount;

   return $retval;
}
function getNewUniqueUserName($pb_id)
{
   global $apAuth;
   $apAuth->DB_General->DoConnect();
   $apAuth->DB_General->execute("SET NAMES utf8");

   $query = "SELECT username as username FROM auth WHERE username LIKE '%" . $pb_id . "%'";

   $foundUID = false;
   $counterUI = 0;
   do
   {
      $counterUI++;
      $apAuth->Query_General->SQL = $query;
      $apAuth->Query_General->LimitCount = "-1";
      $apAuth->Query_General->LimitStart = "-1";
      $apAuth->Query_General->Prepare();
      $apAuth->Query_General->close();
      $apAuth->Query_General->open();

      $foundDuplicate = false;
      for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
      {
         //    if ($apAuth->Query_General->Fields['ada']==$apofasi_date.'-'.$ypourgeio.'-'.$lastlevel.'-'.$counterUI)
         if($apAuth->Query_General->Fields['username'] == $pb_id . '_' . $counterUI)
         {
            $foundDuplicate = true;
            break;
         }
         $apAuth->Query_General->next();
      }
      if($foundDuplicate == false)
      {
         //    $returnval=$apofasi_date.'-'.$ypourgeio.'-'.$lastlevel.'-'.$counterUI;
         $returnval = $pb_id . '_' . $counterUI;
         $foundUID = true;
      }
   }
   while(!$foundUID) ;
   return $returnval;

}

function pb_idToTable($pb_id)
{

   global $apAuth;

   $apAuth->DB_General->DoConnect();
   $apAuth->DB_General->execute("SET NAMES utf8");

   $query = "SELECT table_name FROM ypourgeia GROUP BY table_name";
   $apAuth->Query_General->SQL = $query;
   $apAuth->Query_General->LimitCount = "-1";
   $apAuth->Query_General->LimitStart = "-1";
   $apAuth->Query_General->Prepare();
   $apAuth->Query_General->close();
   $apAuth->Query_General->open();
   $pb_id_ypourgeio_table = false;
   for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
   {
      $ypourgeio = $apAuth->Query_General->Fields['table_name'];
      $query2 = "SELECT pb_id FROM " . $ypourgeio . " WHERE pb_id='" . $pb_id . "'";
      $apAuth->Query_General2->SQL = $query2;
      $apAuth->Query_General2->LimitCount = "-1";
      $apAuth->Query_General2->LimitStart = "-1";
      $apAuth->Query_General2->Prepare();
      $apAuth->Query_General2->close();
      $apAuth->Query_General2->open();
      if($apAuth->Query_General2->RecordCount > 0)
      {
         $pb_id_ypourgeio_table = $ypourgeio;
      }


      $apAuth->Query_General->next();
   }
   return $pb_id_ypourgeio_table;
}

function get_level1_pb_id($ypourgeio, $pb_id)
{

   global $apAuth;
   // if(!($ypourgeio == 'foreis_mt'))
   // {
   $apAuth->DB_General->DoConnect();
   $apAuth->DB_General->execute("SET NAMES utf8");
   $pb_id_level1 = false;
   $query = "SELECT * FROM " . $ypourgeio . " WHERE pb_id='" . $pb_id . "'";
   ;
   $apAuth->Query_General->SQL = $query;
   $apAuth->Query_General->LimitCount = "-1";
   $apAuth->Query_General->LimitStart = "-1";
   $apAuth->Query_General->Prepare();
   $apAuth->Query_General->close();
   $apAuth->Query_General->open();
   $current_level = $apAuth->Query_General->Fields['level'];
   $previous_pb_id = $apAuth->Query_General->Fields['pb_supervisor_id'];
   if($apAuth->Query_General->Fields['level'] == '1')
   {
      $pb_id_level1 = $apAuth->Query_General->Fields['pb_id'];
   }
   else
   {
      for($i = 1; $i < $current_level; $i++)
      {
         $query = "SELECT * FROM " . $ypourgeio . " WHERE pb_id='" . $previous_pb_id . "'";
         $apAuth->Query_General->SQL = $query;
         $apAuth->Query_General->LimitCount = "-1";
         $apAuth->Query_General->LimitStart = "-1";
         $apAuth->Query_General->Prepare();
         $apAuth->Query_General->close();
         $apAuth->Query_General->open();
         $previous_pb_id = $apAuth->Query_General->Fields['pb_supervisor_id'];
         if($apAuth->Query_General->Fields['level'] == '2')
         {
            $pb_id_level1 = $apAuth->Query_General->Fields['pb_supervisor_id'];
            break;
         }
         if($apAuth->Query_General->Fields['level'] == '1')
         {
            $pb_id_level1 = $apAuth->Query_General->Fields['pb_id'];
            break;
         }
      }
   }
   return $pb_id_level1;
   // }
   // else
   // {
   //    return '99300001';
   // }
}


    function validateAFM($afm)
    {

        if (strlen($afm)==8) $afm='0'.$afm;
        if (strlen($afm)==7) $afm='00'.$afm;
        if (!preg_match('/^(EL){0,1}[0-9]{9}$/i', $afm))
            return false;
        if (strlen($afm) > 9)
            $afm = substr($afm, 2);

        $remainder = 0;
        $sum = 0;

        for ($nn = 2, $k = 7, $sum = 0; $k >= 0; $k--, $nn += $nn)
            $sum += $nn * ($afm[$k]);
        $remainder = $sum % 11;

        return ($remainder == 10) ? $afm[8] == '0'
                                  : $afm[8] == $remainder;
    }

/*
//AFMs for testing
echo "<pre>";
echo "Giwrgos AFM: 110096852"." : ".validateAFM("110096852")."<BR>";
echo "999577679"." : ".validateAFM("999577679")."<BR>";
echo "094450895"." : ".validateAFM("94450895")."<BR>";
echo "95052971"." : ".validateAFM("95052971")."<BR>";
echo "997982917"." : ".validateAFM("997982917")."<BR>";
echo "94447320"." : ".validateAFM("94447320")."<BR>";
echo "998161977"." : ".validateAFM("998161977")."<BR>";
echo "999438460"." : ".validateAFM("999438460")."<BR>";
echo "94183868"." : ".validateAFM("94183868")."<BR>";
echo "94150192"." : ".validateAFM("94150192")."<BR>";
echo "998306507"." : ".validateAFM("998306507")."<BR>";
echo "38081280"." : ".validateAFM("38081280")."<BR>";
echo "998134662"." : ".validateAFM("998134662")."<BR>";
echo "997687781"." : ".validateAFM("997687781")."<BR>";
echo "94372028"." : ".validateAFM("94372028")."<BR>";
echo "999256823"." : ".validateAFM("999256823")."<BR>";
echo "106498094"." : ".validateAFM("106498094")."<BR>";
echo "94372028"." : ".validateAFM("94372028")."<BR>";
echo "0"." : ".validateAFM("0")."<BR>";
echo "17171131"." : ".validateAFM("17171131")."<BR>";
echo "999438956"." : ".validateAFM("999438956")."<BR>";
echo "46695529"." : ".validateAFM("46695529")."<BR>";
echo "24033431"." : ".validateAFM("24033431")."<BR>";
echo "999169832"." : ".validateAFM("999169832")."<BR>";
echo "999039029"." : ".validateAFM("999039029")."<BR>";
echo "999818756"." : ".validateAFM("999818756")."<BR>";
echo "90085651"." : ".validateAFM("90085651")."<BR>";
echo "999818756"." : ".validateAFM("999818756")."<BR>";
echo "1487099"." : ".validateAFM("1487099")."<BR>";
echo "999818756"." : ".validateAFM("999818756")."<BR>";
echo "999169832"." : ".validateAFM("999169832")."<BR>";
echo "999169832"." : ".validateAFM("999169832")."<BR>";
echo "1487099"." : ".validateAFM("1487099")."<BR>";
echo "94414116"." : ".validateAFM("94414116")."<BR>";
echo "999169832"." : ".validateAFM("999169832")."<BR>";
echo "999169832"." : ".validateAFM("999169832")."<BR>";
echo "999169832"." : ".validateAFM("999169832")."<BR>";
echo "95498944"." : ".validateAFM("95498944")."<BR>";
echo "999999999"." : ".validateAFM("999999999")."<BR>";
echo "43469557"." : ".validateAFM("43469557")."<BR>";
echo "32130600"." : ".validateAFM("32130600")."<BR>";
echo "94264251"." : ".validateAFM("94264251")."<BR>";
echo "94537720"." : ".validateAFM("94537720")."<BR>";
echo "23754040"." : ".validateAFM("23754040")."<BR>";
echo "55248567"." : ".validateAFM("55248567")."<BR>";
echo "998881631"." : ".validateAFM("998881631")."<BR>";
echo "40895172"." : ".validateAFM("40895172")."<BR>";
echo "94025031"." : ".validateAFM("94025031")."<BR>";
echo "23352689"." : ".validateAFM("23352689")."<BR>";
echo "55248567"." : ".validateAFM("55248567")."<BR>";
echo "82002106"." : ".validateAFM("82002106")."<BR>";
echo "999781039"." : ".validateAFM("999781039")."<BR>";
echo "661270"." : ".validateAFM("661270")."<BR>";
echo "42564993"." : ".validateAFM("42564993")."<BR>";
echo "998342580"." : ".validateAFM("998342580")."<BR>";
echo "24988801"." : ".validateAFM("24988801")."<BR>";
echo "998342580"." : ".validateAFM("998342580")."<BR>";
echo "999982974"." : ".validateAFM("999982974")."<BR>";
echo "6144481"." : ".validateAFM("6144481")."<BR>";
echo "999999999"." : ".validateAFM("999999999")."<BR>";
echo "999999999"." : ".validateAFM("999999999")."<BR>";
echo "999098306"." : ".validateAFM("999098306")."<BR>";
echo "94472918"." : ".validateAFM("94472918")."<BR>";
echo "94512503"." : ".validateAFM("94512503")."<BR>";
echo "94032140"." : ".validateAFM("94032140")."<BR>";
echo "94372028"." : ".validateAFM("94372028")."<BR>";
echo "80837763201"." : ".validateAFM("80837763201")."<BR>";
echo "15355133"." : ".validateAFM("15355133")."<BR>";
echo "999940934"." : ".validateAFM("999940934")."<BR>";
echo "999999999"." : ".validateAFM("999999999")."<BR>";
echo "94394659"." : ".validateAFM("94394659")."<BR>";
echo "999646481"." : ".validateAFM("999646481")."<BR>";
echo "99034502"." : ".validateAFM("99034502")."<BR>";
echo "22276390"." : ".validateAFM("22276390")."<BR>";
echo "32521844"." : ".validateAFM("32521844")."<BR>";
echo "94396063"." : ".validateAFM("94396063")."<BR>";
echo "11651035"." : ".validateAFM("11651035")."<BR>";
echo "94412995"." : ".validateAFM("94412995")."<BR>";
echo "94263900"." : ".validateAFM("94263900")."<BR>";
echo "94501826"." : ".validateAFM("94501826")."<BR>";
echo "94429990"." : ".validateAFM("94429990")."<BR>";
echo "94412995"." : ".validateAFM("94412995")."<BR>";
echo "45123161"." : ".validateAFM("45123161")."<BR>";
echo "998936321"." : ".validateAFM("998936321")."<BR>";
echo "82487142"." : ".validateAFM("82487142")."<BR>";
echo "94429390"." : ".validateAFM("94429390")."<BR>";
echo "95580045"." : ".validateAFM("95580045")."<BR>";
echo "0"." : ".validateAFM("0")."<BR>";
echo "47319915"." : ".validateAFM("47319915")."<BR>";
echo "94147403"." : ".validateAFM("94147403")."<BR>";
echo "998570797"." : ".validateAFM("998570797")."<BR>";
echo "0"." : ".validateAFM("0")."<BR>";
echo "999999999"." : ".validateAFM("999999999")."<BR>";
echo "99955849"." : ".validateAFM("99955849")."<BR>";
echo "0"." : ".validateAFM("0")."<BR>";
echo "999779498"." : ".validateAFM("999779498")."<BR>";
echo "102861007"." : ".validateAFM("102861007")."<BR>";
echo "999379651"." : ".validateAFM("999379651")."<BR>";
echo "0"." : ".validateAFM("0")."<BR>";
echo "0"." : ".validateAFM("0")."<BR>";
echo "</pre>";
*/

/*
echo pb_idToTable(10304319);
echo "<br>";
echo get_level1_pb_id('yperg', 10304319);
echo "<br>";
echo pb_idToTable(99221022);
echo "<br>";
echo get_level1_pb_id('foreis_mt', 99221022);
echo "<br>";
echo pb_idToTable(366);
echo "<br>";
echo get_level1_pb_id(pb_idToTable(366), 366);
echo "<br>";
echo pb_idToTable(99206911);
echo "<br>";
echo get_level1_pb_id('foreis_mt', 99206911);
echo "<br>";
echo pb_idToTable(8);
echo "<br>";
echo get_level1_pb_id('ypepth', 8);
echo "<br>";
echo pb_idToTable(21);
echo "<br>";
echo get_level1_pb_id('ypothyn', 21);
*/
?>