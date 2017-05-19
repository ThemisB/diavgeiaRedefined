<?php
require_once("apAuth.php");

global $apAuth;
$apAuth->initUserData();


function dec2any_nonreversible($num)
{
   $base = 34;
   $index = array("m", "n", "4", "b", "7", "v", "6", "c", "9", "x", "z", "q", "k", "j", "1", "h", "0", "g", "f", "d", "s", "a", "p", "3", "o", "2", "i", "u", "5", "y", "t", "r", "8", "e");
   srand((float)microtime() * 1000000);
   shuffle($index);

   $out = "";
   for($t = floor(log10($num) / log10($base)); $t >= 0; $t--)
   {
      $a = floor($num / pow($base, $t));
      $out = $out . $index[$a];
      $num = $num - ($a * pow($base, $t));
   }

   return $out;
}

function dec2any_mixed($num)
{
   $base = 34;
   $index = array("m", "n", "4", "b", "7", "v", "6", "c", "9", "x", "z", "q", "k", "j", "1", "h", "0", "g", "f", "d", "s", "a", "p", "3", "o", "2", "i", "u", "5", "y", "t", "r", "8", "e");
   $out = "";
   for($t = floor(log10($num) / log10($base)); $t >= 0; $t--)
   {
      $a = floor($num / pow($base, $t));
      $out = $out . $index[$a];
      $num = $num - ($a * pow($base, $t));
   }

   return $out;
}

function any2dec_mixed($num)
{
   $base = 34;
   $index = array("m", "n", "4", "b", "7", "v", "6", "c", "9", "x", "z", "q", "k", "j", "1", "h", "0", "g", "f", "d", "s", "a", "p", "3", "o", "2", "i", "u", "5", "y", "t", "r", "8", "e");

   $out = 0;
   $len = strlen($num) - 1;
   for($t = 0; $t <= $len; $t++)
   {
      $out = $out + array_search(substr($num, $t, 1), $index) * pow($base, $len - $t);
   }
   return $out;
}



class adaGenerator
{


   function getNewUniqueADAv5($apofasi_date, $ypourgeio, $lastlevel)
   {
      global $apAuth;
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");

      $query = "SELECT apofaseis.ada as ada FROM apofaseis WHERE ada LIKE '" . dec2any_mixed(substr(str_replace('-', '', $apofasi_date), - 6, 6)) . dec2any_mixed($lastlevel) . '-' . "%' " .
      "UNION
SELECT apofaseis_temp.ada as ada FROM apofaseis_temp WHERE ada LIKE '" . dec2any_mixed(substr(str_replace('-', '', $apofasi_date), - 6, 6)) . dec2any_mixed($lastlevel) . '-' . "%' ;";
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
         srand (microtime(false) );
         $newADA = 'drasi1-'.dec2any_mixed(substr(str_replace('-', '', $apofasi_date), - 6, 6)) . dec2any_mixed($lastlevel) . '-' . dec2any_nonreversible($counterUI).dec2any_mixed(rand(35,1100));

         $foundDuplicate = false;
         for($i = 0; $i < $apAuth->Query_General->RecordCount; $i++)
         {
            //    if ($apAuth->Query_General->Fields['ada']==$apofasi_date.'-'.$ypourgeio.'-'.$lastlevel.'-'.$counterUI)
            //            $newADA = dec2any_mixed(substr(str_replace('-', '', $apofasi_date), - 6, 6)) . dec2any_mixed($lastlevel) . '-' . dec2any_nonreversible($counterUI);
            if($apAuth->Query_General->Fields['ada'] == $newADA)
            {
               $foundDuplicate = true;
               break;
            }
            $apAuth->Query_General->next();
         }
         if($foundDuplicate == false)
         {
            //    $returnval=$apofasi_date.'-'.$ypourgeio.'-'.$lastlevel.'-'.$counterUI;
            $returnval = $newADA;
            $foundUID = true;
         }
      }
      while(!$foundUID) ;

      return $returnval;

   }

   function getADAUID($apofasi_date, $ypourgeio, $lastlevel)
   {
      return $this->getNewUniqueADAv5(mysql_escape_string($apofasi_date), mysql_escape_string($ypourgeio), mysql_escape_string($lastlevel));
   }

}
/*
//TESTING all 4 first encoded digits for the next 99 years
for ($y=11;$y<=99;$y++)
{
for ($m=1;$m<=12;$m++)
{
for ($d=1;$d<=31;$d++)
{

$date=$y.str_pad($m,2,"0",STR_PAD_LEFT).str_pad($d,2,"0",STR_PAD_LEFT);

echo $date.":".dec2any_mixed($date)."<br>";
}
}
}
*/
/*
$ag= new adaGenerator();
echo $ag->getADAUID("2013-05-22", 12, 12);
*/
?>