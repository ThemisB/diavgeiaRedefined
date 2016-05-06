<?php
require_once("vcl/vcl.inc.php");
//Includes
use_unit("mysql.inc.php");
use_unit("forms.inc.php");
use_unit("extctrls.inc.php");
use_unit("stdctrls.inc.php");

//Class definition
class ExtraDBConnection extends DataModule
{
   public $DB_General = null;
   public $Query_General = null;
}

global $application;

global $ExtraDBConnection;

//Creates the form
$ExtraDBConnection = new ExtraDBConnection($application);

//Read from resource file
$ExtraDBConnection->loadResource(__FILE__);

?>