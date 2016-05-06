<?php
require_once("apAuth.php");
require_once("fileStorage.php");

global $apAuth;
$apAuth->DB_General->DoConnect();
$apAuth->DB_General->execute("SET NAMES utf8");
$ada = mysql_escape_string($_REQUEST['ada']);
$query="SELECT * FROM apofaseis WHERE ada='".$ada."'";
$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();
$id=$apAuth->Query_General->Fields['id'];

$query="SELECT * FROM files WHERE ada='".$ada."'";
$apAuth->Query_General->SQL = $query;
$apAuth->Query_General->LimitCount = "-1";
$apAuth->Query_General->LimitStart = "-1";
$apAuth->Query_General->Prepare();
$apAuth->Query_General->close();
$apAuth->Query_General->open();
$original_filename=$apAuth->Query_General->Fields['original_filename'];

$fs= new fileStorage();
$fileContent= $fs->readFile($ada,'original.pdf');
$filesize=strlen($fileContent);

header( "Pragma: public");
header( "Expires: 0");
header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
header( "Cache-Control: private",false);
header( "Content-type: application/octet-stream" );
header( "Content-Disposition: attachment; filename=\"$original_filename\"" );
header( "Content-Length: " . $filesize );
echo $fileContent;
exit();
?>