<?php
require_once("fileStorage.php");

//print 'mple.pdf';
$ada = $_REQUEST['ada'];
$type = urlencode($_REQUEST['type']);
$ada = htmlspecialchars($ada, ENT_COMPAT, 'UTF-8');
$ada = htmlspecialchars($ada, ENT_COMPAT, 'UTF-8');
if ($ada) {
	$fs= new fileStorage();
	$filepath= $fs->getPathFromUID($ada);


	echo $filepath;
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