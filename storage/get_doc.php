<?php
require_once("fileStorage.php");

//print 'mple.pdf';
$ada = $_REQUEST['ada'];

$type = urlencode($_REQUEST['type']);
$ada = htmlspecialchars($ada, ENT_COMPAT, 'UTF-8');
$ada = htmlspecialchars($ada, ENT_COMPAT, 'UTF-8');
if ($ada) {
	$fs= new fileStorage();
	$fileContent= $fs->readFile($ada,'signed.pdf');
	$filesize=strlen($fileContent);
	$signed_filename=$ada . '-signed.pdf';

	header( "Pragma: public");
	header( "Expires: 10");
	header( "Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header( "Cache-Control: private",false);
	header( "Content-type: application/pdf" );
	header( "Content-Disposition: attachment; filename=\"$signed_filename\"" );
	header( "Content-Length: " . $filesize );
	/* Memcached population for nginx.
	   $mcKeyName = '/files' . $signed_filename;
	   $mc = new Memcache();
	   $mc->addServer("localhost", 11211);
	   $mc->set($mcKeyName, $fileContent);
	*/
	echo $fileContent;
}
else {
	header("HTTP/1.0 404 Not Found");
	echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">
		<html><head>
		<title>404 Not Found</title>
		</head><body>
		<h1>404 Not Found</h1>
		The page that you have requested could not be found.
		</body></html>
		";

}
exit();
?>
