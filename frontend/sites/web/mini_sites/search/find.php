<?php
$READ_DOMAIN_INFO = true; 
require_once( '../config.php' );
$args = get_rest_args();
if ( array_key_exists( 'out', $args ) ) {
	switch ( $args[ 'out' ] ) {
		case 'xml':
			print_xml_results( $args );
			exit();
		case 'rss':
			print_rss_results( $args );
			exit();
		default:
			break;
	}
}
if ( !$INDEXER ) {
	require_once( '../theme_header.php' );
	echo '<div id="content">';
}
print_search_results( $args );
if ( !$INDEXER ) {
	echo '</div>';
	include '../_right-sidebar.php' ; 
	include '../theme_footer.php' ; 
}
?>
