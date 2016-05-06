<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head profile="http://gmpg.org/xfn/11">
<title>stats</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="el" />
<meta name="author" content="OpenGov.gr">
<meta name="keywords" content="">
<meta name="description" content="">
</head>
<body>
<h3>Εμφανίζονται οι φορείς που έχουν καταχωρίσει αποφάσεις</h3><br>
<?php
include("config.php");

$total_count=0;

	echo '<table border="1">';
	echo '<tr><td><b>Ονομα Φορέα</b></td><td><b>Ημερομηνία Τελευταίας Καταχώρισης</b></td><td><b>Αριθμός αποφάσεων</b></td></tr>';
	$query=
	"SELECT lastlevel,count(apofaseis.id) as count, max(apofasi_date) as max_apofasi_date FROM apofaseis WHERE NOT lastlevel='99206922' GROUP by lastlevel";
	
    $res = mysql_query( $query );
    if (mysql_num_rows($res)>0) {
		while ( ($row1 = mysql_fetch_assoc( $res ) ) !== false ) {
		
		$table_name=get_foreas_table( $row1['lastlevel'] );
	$query2=
	"SELECT ".$table_name['table_name'].".name as ".$table_name['table_name']."_name, lastlevel FROM apofaseis,".$table_name['table_name']." WHERE NOT lastlevel='99206922' AND ".$table_name['table_name'].".pb_id=".$row1['lastlevel']." ";
    $res2 = mysql_query( $query2 );
    if (mysql_num_rows($res2)>0) {
		$row2 = mysql_fetch_assoc( $res2 );
       	echo "<tr>";
		echo '<td>'.$row2[$table_name['table_name'].'_name'].'</td><td>'.$row1['max_apofasi_date'].'</td><td>'.$row1['count'].'</td>';
		echo "</tr>";
		$total_count=$total_count+$row1['count'];
		}	
   
	}	
 	}


		echo '<td></td><td>Σύνολο:</td><td>'.$total_count.'</td>';


	echo "</table>";	



?>
</body>
</html>