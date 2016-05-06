<?php

//ini_set("display_errors",1);
//error_reporting(E_ALL);

// phpBB 2.x auto-generated config file
// Do not change anything in this file!

//Get the include file that holds the forum component
$include=$_COOKIE['phpbb_vcl_include'];
$form=$_COOKIE['phpbb_vcl_form'];
$object=$_COOKIE['phpbb_vcl_object'];

$ocwd=getcwd();
$script=$_SERVER['SCRIPT_FILENAME'];
chdir(dirname($include));
$_SERVER['SCRIPT_FILENAME']=$include;
//echo dirname($include);
//echo "<hr>";

include_once("vcl/vcl.inc.php");
use_unit("classes.inc.php");
//Disables output
global $output_enabled;
$output_enabled=false;

require_once($include);
//echo "eee";
global $output_enabled;
$output_enabled=true;


global $$form;

$phpbbobject=$$form->$object;


chdir($ocwd);
$_SERVER['SCRIPT_FILENAME']=$script;

$dbms = $phpbbobject->DatabaseType;

$dbhost = $phpbbobject->Host;
$dbname = $phpbbobject->DatabaseName;
$dbuser = $phpbbobject->User;
$dbpasswd = $phpbbobject->Password;


$table_prefix = 'phpbb_';

define('PHPBB_INSTALLED', true);

?>
