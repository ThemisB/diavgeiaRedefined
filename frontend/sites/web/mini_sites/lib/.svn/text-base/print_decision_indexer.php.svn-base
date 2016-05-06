<?php 
	$row = mysql_fetch_assoc( $res );	
	if ( trim( $row[ 'ada' ] ) == '' ) exit(); 
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $row[ 'thema' ]; ?></title>
</head>
<body>
<?php 	
	$queryAuth="SELECT * from auth where username='".$row['user']."'";
	$resAuth = mysql_query( $queryAuth );
    if (mysql_num_rows($resAuth)>0) {
	  $rowAuth = mysql_fetch_assoc( $resAuth );  
    }
	
	 $latin_name = '';
	 $foreas_name = get_foreas_name( $row[ 'lastlevel' ], $latin_name );	
     $thematikesCSVArray=explode(',',$row["thematiki"]);
     $thematikesText='';
     for ($thematikesi=0;$thematikesi<count($thematikesCSVArray);$thematikesi++)
     {
        $this_th_id= str_replace('#','',$thematikesCSVArray[$thematikesi]);
        if (!($this_th_id=='0')) {
          $queryLCSV = "SELECT * FROM thematikes where ID='".$this_th_id."'";
          $resLCSV = mysql_query( $queryLCSV );
          if (mysql_num_rows($resLCSV)>0) {
	        $rowLCSV = mysql_fetch_assoc( $resLCSV );
  		    $thematikiName=$rowLCSV['name'];
            $thematikesText.='<li>'.$thematikiName.'</li>';
		  }
        }
     }
     $thematikesText='<ul>'.$thematikesText.'</ul>';

	 
	$dyn_fields = array();
	if ( !$row[ 'deleted' ] ) {
		$queryDF = "SELECT apofaseis_dynamic_fields_list.label as ex_label, apofaseis_dynamic_fields_values.field_value as ex_value
FROM apofaseis_dynamic_fields_values, apofaseis_dynamic_fields_list
WHERE dynamic_field_ID = apofaseis_dynamic_fields_list.ID AND apofaseis_dynamic_fields_list.type<> 'dropdown' AND apofaseis_dynamic_fields_values.ada='".$row[ 'ada' ] ."'";
		$resDF = mysql_query( $queryDF );
		while ($rowDF = mysql_fetch_assoc( $resDF )) {
			$dyn_fields[] = array( 'label' => $rowDF['ex_label' ],
								'value' => $rowDF[ 'ex_value' ] );
		} 
		mysql_free_result( $resDF );
	}

	$queryOLD = "SELECT ada FROM apofaseis WHERE is_orthi_epanalipsi='" .
				mysql_escape_string( $row[ 'ada' ] ) . "'";
	$resOLD = mysql_query( $queryOLD );
	$old_adas = mysql_fetch_assoc( $resOLD );
	
	// include navigation berfore ada single view //
	echo get_single_breadcrump($row["thema"]) ;
	//include 'navigation-single.php' ; 
	if ( $old_adas !== false ) {
		echo '<div class="orthi_epanalipsi">';
		echo '<strong>Ορθή Επανάληψη:</strong> Η παρούσα έχει αντικατασταθεί από την απόφαση με ΑΔΑ ',
			 get_decision_url( $old_adas[ 'ada' ] ); 
		echo '</div>';
	}

	if ( $row[ 'deleted' ] ) {
		echo '<div class="deleted">';
		echo '<strong>Η απόφαση έχει ανακληθεί.<br/>Αιτιολογία: </strong>',
			hh( $row[ 'deletion_reason' ] );
		echo '</div>';
	}
	
	echo '<div class="single_doc"><ul>';
		echo '<li><span>ΑΔΑ: </span>'.$row["ada"].'</li>'; 
		$replaces_ada = $row[ 'is_orthi_epanalipsi' ];
		$replaces_ada = trim( $replaces_ada );
		if ( $replaces_ada != '' ) {
			echo '<li><span>Ορθή Επανάληψη Πράξης με ΑΔΑ: </span>';
			echo get_decision_url( $replaces_ada );
			echo '</li>';
		}
        echo '<li><span>Αριθμός Πρωτοκόλλου: </span>'.hh( $row["arithmos_protokolou"] ).'</li>';   
	if ( strlen( trim( $row[ 'ET_FEK' ] ) ) > 0 ) {
		echo '<li><span>Στοιχεία ΦΕΚ: </span>';
		echo hh( $row[ 'ET_FEK' ] . '/' . get_fek_issue_name( $row[ 'ET_FEK_tefxos' ] ) . '/' .  $row[ 'ET_FEK_etos' ] );
	}

        echo '<li><span>Θέμα: </span>'. hh( $row["thema"] ).'</li>'; 
		echo '<li><span>Τελικός Υπογράφων: </span>' ; 
		echo hh( get_signer_name($row["telikos_ypografwn"], true) ) ; 
		echo'</li>'; 
		
        echo '<li><span>Ημερομηνία Απόφασης: </span>'.format_date($row["apofasi_date"]).'</li>'; 
        echo '<li><span>Ημερομηνία Ανάρτησης: </span>'.format_date($row["submission_timestamp"]).'</li>'; 
        echo '<li><span>Είδος Απόφασης: </span>'.hh($row["eidos_apofasis"]).'</li>'; 
		if ( $INDEXER || is_null( $latin_name ) ) {
			echo '<li><span>Φορέας: </span>'.hh( $foreas_name ).'</li>'; 
		}
		else {
			$url = $config[ 'base_url' ] . '/' . $latin_name;
			echo "<li><span>Φορέας: </span><a href=\"$url\">". hh( $foreas_name ).'</a></li>'; 
		}
		if ( $row[ 'monada_name' ] ) {
        	echo '<li><span>Μονάδα: </span>'.hh($row[ 'monada_name' ] ).'</li>'; 
		}
        echo '<li><span>Θεματική: </span>'.$thematikesText.'</li>'; 
		foreach ( $dyn_fields as $dyn_field ) {
			echo '<li><span>', $dyn_field[ 'label' ], ': </span>', hh( $dyn_field[ 'value' ] ), '</li>';
		}
		if ( $row[ 'related_ADAs' ] ) {
        	echo '<li><span>Σχετικές Πράξεις: </span>'.hh($row[ 'related_ADAs' ] ).'</li>'; 
		}
	echo '</ul></div>';
	echo '<div class="content">';
	$content = trim( $row[ 'pdf_text' ] );
	if ( $content != '' ) echo hh( $content );
	echo '</div>';
	?>
</body>
</html>
