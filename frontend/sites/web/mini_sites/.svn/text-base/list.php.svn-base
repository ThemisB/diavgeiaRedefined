<?php 
	$READ_DOMAIN_INFO = true;
	include 'theme_header.php' ; 
	$type = $_GET["l"];
	$subtitle = '';
?>
<div id="content">

	<?php 
			echo '<div class="latest_docs">';
			if ($type == 'themes') {
				echo 'Θεματικές Οργάνωσης Περιεχομένου';
			}
			else if ( $type == 'signer' ) {
				echo 'Τελικοί Υπογράφοντες των αποφάσεων';
			} 
			else if ( $type == 'allsigner' ) {
				echo 'Τελικοί Υπογράφοντες των αποφάσεων';
			} 
			else if ( $type == 'monades' ) {
				echo 'Μονάδες - Με βάση εσωτερική δομή του φορέα';
				
			}
			else {
				echo 'Τύποι Εγγράφων';
			}
			echo '</div>';
			if ( $subtitle ) {
				echo '<div class="subtitle">', $subtitle, '</div>';
			}
			echo get_listed_items($type);
	?>
	
</div>
<!-- end div#content -->

<?php include('_right-sidebar.php'); ?>

<?php 
	// Get the Generic Sidebar
	include 'theme_footer.php' ; 
?>
