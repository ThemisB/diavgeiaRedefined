<?php

require_once("vcl/vcl.inc.php");
require_once("utilClasses.php");
//Includes
use_unit("mysql.inc.php");
use_unit("Zend/zauthdb.inc.php");
use_unit("Zend/zauthdigest.inc.php");
use_unit("Zend/zauth.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

//Class definition
class apAuth extends DataModule
{
   public $oda_masterTable = null;
   public $ForeisAllView = null;
   public $ThematikesTable = null;
   public $MonadesTypesTable = null;
   public $YpografontesTypesTable = null;
   public $MonadesTable = null;
   public $YpografontesTable = null;
   public $Query_General2 = null;
   public $UserTable = null;
   public $DB_General = null;
   public $Query_General = null;
   public $ZAuthDB1 = null;
   public $ZAuth = null;


   var $userData = null;

   public function validate_captcha()
   {

      if(isset($_SESSION['captcha_ok'])) return true;
      require_once('securimage/securimage.php');
      $securimage = new Securimage();
      if($securimage->check(urldecode($_POST['captcha_code'])) == false)
      {
         return false;
      }
      $_SESSION['captcha_ok'] = true;
      return true;
   }


   public function get_captcha()
   {
      $retval = '';
      if(!($_SERVER['REQUEST_METHOD'] == 'POST'))
      {
         if(!isset($_SESSION['captcha_ok']))
         {

            $retval .= '<label class="description" style="width:60%;" for="captch">Για λόγους ασφαλείας, παρακαλώ εισάγετε τους αριθμούς της παρακάτω εικόνας στο σχετικό πεδίο.</label>  ';
            $retval .= '<br><br><img border="1px" id="captcha" src="securimage/securimage_show.php?apofaseisrandom=' . mt_rand(1000000, 9999999) . '" alt="CAPTCHA Image"/>';
            $retval .= '<br><br>';
            $retval .= '<input style="height: 20px; width: 121px;" type="text" name="captcha_code" id="captcha_code" maxlength="4"/>';
         }
      }
      else
      {
         if(!isset($_SESSION['captcha_ok']))
         {
            $retval .= '<label class="description validate" style="width:60%;" for="captch">Για λόγους ασφαλείας, παρακαλώ εισάγετε τους αριθμούς της παρακάτω εικόνας στο σχετικό πεδίο.</label>	';
            $retval .= '<br><br><img border="1px" id="captcha" src="securimage/securimage_show.php?apofaseisrandom=' . mt_rand(1000000, 9999999) . '" alt="CAPTCHA Image"/>';
            $retval .= '<br><br>';
            $retval .= '<input  style="height: 20px; width: 121px;" type="text" name="captcha_code" id="captcha_code" size="10" maxlength="6"/>';
         }
      }
      return $retval;
   }


   function ZAuthLogin($sender, $params)
   {
      redirect_withdetection("login.php");
   }



   public function initUserData()
   {

      $this->DB_General->DoConnect();
      $this->DB_General->execute("SET NAMES utf8");
      try
      {
         $query = "SELECT * FROM auth WHERE username ='" . $this->ZAuth->UserName . "'";

         $this->Query_General->SQL = $query;
         $this->Query_General->LimitCount = "-1";
         $this->Query_General->LimitStart = "-1";
         $this->Query_General->Prepare();
         $this->Query_General->close();
         $this->Query_General->open();
         if($this->Query_General->Fields['realm'] == 'admin')
         {
            $ypourgeio_table = 'ypes';
            $start_pb_id = '12';
            $ypourgeia_pb_id = '12';
         }
         else if ($this->Query_General->Fields['realm'] == 'disabled')
         {
            redirect_withdetection('login.php');
         }
         else
         {
            $ypourgeio_table = $this->Query_General->Fields['ypourgeio_table'];
            $start_pb_id = $this->Query_General->Fields['start_pb_id'];
            $ypourgeia_pb_id = $this->Query_General->Fields['ypourgeia_pb_id'];
         }


         $resultArray = array
         (
          "ypografontes_IDs" => $this->Query_General->Fields['ypografontes_IDs'],
          "ID" => $this->Query_General->Fields['ID'],
          "username" => $this->Query_General->Fields['username'],
          "password" => $this->Query_General->Fields['password'],
          "realm" => $this->Query_General->Fields['realm'],
          "ypourgeio_table" => $ypourgeio_table,
          "start_pb_id" => $start_pb_id,
          "ypourgeia_pb_id" => $ypourgeia_pb_id,
          "firstname" => $this->Query_General->Fields['firstname'],
          "lastname" => $this->Query_General->Fields['lastname'],
          "email" => $this->Query_General->Fields['email'],
          "telephone_yp" => $this->Query_General->Fields['telephone_yp'],
          "comments" => $this->Query_General->Fields['comments']
          );

         $l1 = get_level1_pb_id($resultArray['ypourgeio_table'], $start_pb_id);
         $query = "SELECT ypourgeio_label FROM ypourgeia WHERE pb_id ='" . $l1 . "'";
         $this->Query_General->SQL = $query;
         $this->Query_General->LimitCount = "-1";
         $this->Query_General->LimitStart = "-1";
         $this->Query_General->Prepare();
         $this->Query_General->close();
         $this->Query_General->open();
         $tempArray = array("ypourgeio_name" => $this->Query_General->Fields['ypourgeio_label']);
         $resultArray = array_merge($resultArray, $tempArray);

         $query = "SELECT * FROM " . $resultArray['ypourgeio_table'] . " WHERE pb_id ='" . $start_pb_id . "'";
         $this->Query_General->SQL = $query;
         $this->Query_General->LimitCount = "-1";
         $this->Query_General->LimitStart = "-1";
         $this->Query_General->Prepare();
         $this->Query_General->close();
         $this->Query_General->open();
         $tempArray = array("foreas_name" => $this->Query_General->Fields['name']);
         $resultArray = array_merge($resultArray, $tempArray);

         $this->userData = $resultArray;
         return true;
      }
      catch(Exception $e)
      {
         return false;
      }
   }

public function validatePassword($password) {
   $r1='/[A-Z]/';
   $r2='/[a-z]/';
   $r3='/[!@#$^&*()-_+{};:<>]/';
   $r4='/[0-9]/';

   if(preg_match_all($r1,$password, $o)<2) return FALSE;

   if(preg_match_all($r2,$password, $o)<2) return FALSE;

   if(preg_match_all($r3,$password, $o)<2) return FALSE;

   if(preg_match_all($r4,$password, $o)<2) return FALSE;

   if(strlen($password)<10) return FALSE;

   return TRUE;
}


}

global $application;

global $apAuth;

//Creates the form
$apAuth = new apAuth($application);

//Read from resource file
$apAuth->loadResource(__FILE__);
include('config.php');
$apAuth->DB_General->Host = $appDBHost;
$apAuth->ZAuthDB1->Host = $appDBHost;
function redirect_withdetection($file)
{


   /*
   if(isset($_SERVER["HTTPS"]))// works only with apache, IIS returns non empty value of "off", but thats no problem for us!!!
   {
      $protocol = 'https';
   }
   else
   {
      $protocol = 'http';
   }
   */
   if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        // no proxies, ssl on web server
        $protocol = 'https';
   }
   elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
   // a decent reverse proxy like nginx or pound uses this
   // microsoft proxy uses HTTP_FRONT_END_HTTPS.
        $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'];
   }
   else {
   // no headers, no ssl
        $protocol = 'http';
   }
   $host = $_SERVER['HTTP_HOST'];
   $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
   header('Location: ' . $protocol . '://' . $host . $uri . '/' . $file);
   exit();





}
?>