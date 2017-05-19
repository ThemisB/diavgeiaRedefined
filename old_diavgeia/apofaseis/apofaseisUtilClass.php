<?php
require_once("vcl/vcl.inc.php");
//Includes
use_unit("mysql.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");
require_once("fileStorage.php");
require_once("apAuth.php");

//Class definition
class apofaseisUtilClass extends DataModule
{
   public $Query_General3 = null;

   function delete_apofasi($delada, $reason, $lastlevel)
   {
      global $apAuth;
      $apAuth->initUserData();
      $apAuth->DB_General->DoConnect();
      $apAuth->DB_General->execute("SET NAMES utf8");
      $deletion_user = $apAuth->userData["username"];
      if(!($apAuth->userData["realm"] == 'admin'))
      {
         $query = "SELECT ada FROM `apofaseis` where lastlevel='" . $lastlevel . "' AND ada='" . $delada . "';";
         //var_dump($query);
         $res = mysql_query($query, $apAuth->DB_General->_connection);
         if(mysql_num_rows($res) == 0)
         {
            $deladaresult = "#permissiondenied";
            return $deladaresult;
         }
      }

      $deladaresult = "";
      $query = "SELECT ada FROM `apofaseis` where ada='" . $delada . "';";
      //var_dump($query);

      $res = mysql_query($query, $apAuth->DB_General->_connection);
      /*
      $this->Query_General3= new MySQLQuery();
      $this->Query_General3->Database=$apAuth->DB_General;
      //
      $this->Query_General3->SQL = $query;
      $this->Query_General3->LimitCount = "-1";
      $this->Query_General3->LimitStart = "-1";
      $this->Query_General3->Prepare();
      $this->Query_General3->close();
      $this->Query_General3->open();

      */
      //var_dump($this->Query_General3);
      //mysql_num_rows($res)       $this->Query_General3->RecordCount

      if(mysql_num_rows($res) == 0)
      {
         $deladaresult = "#notfound";
      }
      else
      {
         try
         {

            $original_timezone = date_default_timezone_get();
            date_default_timezone_set('Europe/Athens');
            $deletion_time = time();
            $deletion_timestamp = date('Y-m-d H:i:s', $deletion_time);
            date_default_timezone_set($original_timezone);

            $insertquery = "
        INSERT INTO `apofaseis_deleted`
            select
            NULL,
            `ada`,
            `arithmos_protokolou`,
            `apofasi_date`,
            `koinopoiiseis`,
            `eidos_apofasis`,
            `thematiki`,
            `submission_timestamp`,
            `comments`,
            `thema`,
            `monada`,
            `lastlevel`,
            `levelsCSV`,
            `telikos_ypografwn`,
            `isET_Apofasi`,
            `ETURL`,
            `tags`,
            `user`,
            `ET_FEK`,
            `ET_FEK_tefxos`,
            `ET_FEK_etos`,
            `status`,
            `syntaktis_email`,
            `related_ADAs`,
            '" . $reason . "',
            '" . $deletion_timestamp . "',
            '" . $deletion_user . "'
            from apofaseis
            where apofaseis.ada ='" . $delada . "'
     ";

            //var_dump($insertquery);
            $apAuth->DB_General->execute($insertquery);

         }
         catch(Exception $e)
         {
            $deladaresult = "#errorwriting";
         }
         try
         {

            $updatequery = "UPDATE apofaseis
SET
`arithmos_protokolou`='' ,
`apofasi_date`='' ,
`koinopoiiseis`='' ,
`eidos_apofasis`='' ,
`thematiki`='' ,
`submission_timestamp`='' ,
`comments`='' ,
`thema`='' ,
`monada`='' ,
`lastlevel`='' ,
`levelsCSV`='' ,
`telikos_ypografwn`='' ,
`isET_Apofasi`='' ,
`is_orthi_epanalipsi`='' ,
`ETURL`='' ,
`tags`='' ,
`user`='' ,
`ET_FEK`='' ,
`ET_FEK_tefxos`='' ,
`ET_FEK_etos`='' ,
`status`='' ,
`syntaktis_email`='' ,
`related_ADAs`='' WHERE ada='" . $delada . "'";
            //var_dump($updatequery);
            $apAuth->DB_General->execute($updatequery);
            $fs = new fileStorage();
            $fs->renameFile($delada, 'original.pdf','original_deleted.pdf');
            $fs->renameFile($delada, 'signed.pdf','signed_deleted.pdf');
            $fs->renameFile($delada, 'signed.pdf.txt','signed_deleted.pdf.txt');


            $deladaresult = "#success";
         }
         catch(Exception $e)
         {
            $deladaresult = "#errordeleting";
         }
      }
      return $deladaresult;
   }





}

global $application;

global $apofaseisUtilClass;

//Creates the form
$apofaseisUtilClass = new apofaseisUtilClass($application);

//Read from resource file
$apofaseisUtilClass->loadResource(__FILE__);

?>