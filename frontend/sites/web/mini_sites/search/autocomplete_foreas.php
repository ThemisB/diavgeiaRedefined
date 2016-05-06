<?php
require_once '../config.php';
require_once '../db.php';
require_once '../queries.php';

$q = $_REQUEST['q'];
if (!$q)
    return;

//$query = "SELECT * FROM foreis WHERE name LIKE '%" . $q . "%'";
$query = "SELECT * FROM oda_members_master,foreis 
          WHERE oda_members_master.foreas_pb_id = foreis.pb_id 
          AND oda_members_master.status = 1 
          AND foreis.name LIKE '%" . $q . "%'";

$res = mysql_query($query) or die(mysql_error());

while (( $row = mysql_fetch_assoc($res) ) !== false) {
    echo $row['name'] . '|' . $row['pb_id'];
    echo "\n";
}

?>