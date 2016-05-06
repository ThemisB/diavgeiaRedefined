<?php
$READ_DOMAIN_INFO = true;
require_once( 'config.php' );
require_once( 'queries.php' );

if ( !array_key_exists( 'type', $_REQUEST ) ) exit();
$type = $_REQUEST[ 'type' ];
$from = array_key_exists( 'from', $_REQUEST ) ? $_REQUEST[ 'from' ] : 0;
$limit = array_key_exists( 'limit', $_REQUEST ) ? $_REQUEST[ 'limit' ] : false;
$ret = array();

switch ( $type ) {
	case 'thema':
		$pagination = '';
		$ret[ 'html' ] = get_per_thema( $from, $limit, $pagination );
		$ret[ 'pagination' ] = $pagination;
		break;
	case 'type':
		$pagination = '';
		$ret[ 'html' ] = get_per_type( $from, $limit, $pagination );
		$ret[ 'pagination' ] = $pagination;
		break;
	case 'signer':
		$pagination = '';
		$ret[ 'html' ] = get_per_signers( true, $from, $limit, $pagination );
		$ret[ 'pagination' ] = $pagination;
		break;
	case 'allsigner':
		$pagination = '';
		$ret[ 'html' ] = get_per_signers( false, $from, $limit, $pagination );
		$ret[ 'pagination' ] = $pagination;
		break;
	default: 
		exit();
}

echo json_encode( $ret );
exit();
?>
