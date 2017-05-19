<?php
// provoke the VCL to kill the session

if(!($_SERVER['REQUEST_METHOD'] == 'POST'))
{
  $_GET['restore_session']="1";
}


require_once("vcl/vcl.inc.php");
require_once("no_captcha_ips.php");
//Includes
require_once("apAuth.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

//Class definition
class frmLogin extends Page
{
   public $secureinfo = null;
   public $Panel_captcha = null;
   public $Label_user = null;
   public $Label_pass = null;
   public $btnLogin = null;
   public $edPassword = null;
   public $edUser = null;
   function no_captcha_ip( $ip )
   {
      global $NO_CAPTCHA_IPS;
	  if ( !array_key_exists( $ip, $NO_CAPTCHA_IPS ) ) return false;
      return $NO_CAPTCHA_IPS[ $ip ];
   }
   function btnLoginClick($sender, $params)
   {

      //Clicking the login button, we set the username and userpassword
      //properties of the ZAuth component to the values entered by the user.
      //After that, redirect to the entry page, so the credentials are validated

      global $apAuth;
//if (($this->edUser->Text=='admin_foreasstav') || ($this->edUser->Text=='adminstav'))
//{ 
      $captchaDisabled=($_REQUEST['secureinfo']==sha1($_SERVER[ 'REMOTE_ADDR' ].'off'.$this->edUser->Text));

      if (!($apAuth->validate_captcha()) && !$this->no_captcha_ip( $_SERVER[ 'REMOTE_ADDR' ] ) && !($captchaDisabled) )
      {

         redirect_withdetection('login.php');
      }

      if(get_magic_quotes_gpc()) {
        $thisusername=stripslashes($this->edUser->Text);
        $thispassword=stripslashes($this->edPassword->Text);
      }
      else
      {
        $thisusername=$this->edUser->Text;
        $thispassword=$this->edPassword->Text;
      }

      $stripchars = array(" ","&","*","(",")","+","{",
      "}","|","[","]","\\","=","`","\"",":",";","'","<",">",",",".","/");
      $thisusername = str_replace($stripchars, "", $thisusername);
      $thispassword = str_replace($stripchars, "", $thispassword);


      $apAuth->ZAuth->UserName = $thisusername;
      $apAuth->ZAuth->UserPassword = $thispassword;

      $apAuth->initUserData();
      $apAuth->ZAuth->UserRealm=$apAuth->userData['realm'];

      redirect_withdetection("index.php");

//}

   }





   function frmLoginBeforeShow($sender, $params)
   {
     global $apAuth;
     $this->Panel_captcha->Caption=$apAuth->get_captcha();

      $this->secureinfo->Value=sha1($_SERVER[ 'REMOTE_ADDR' ].$_REQUEST['captcha'].$_REQUEST['true']);
     //$this->Panel_captcha->Caption="";
      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {

      }
   }


}

global $application;

global $frmLogin;

//Creates the form
$frmLogin = new frmLogin($application);

//Read from resource file
$frmLogin->loadResource(__FILE__);

//Shows the form
$frmLogin->show();

?>