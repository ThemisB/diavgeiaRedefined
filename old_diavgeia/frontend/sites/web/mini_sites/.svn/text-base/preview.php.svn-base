<?php
$READ_DOMAIN_INFO = true;
require_once( 'config.php' );

function gotoPage( &$im, $page ) {
	$pages = $im->getNumberImages();
	for ( $i = 0; $i < $pages - $page + 1; $i++ ) {
		$im->previousImage();
	}
}

function get_image_path( $ada, $page ) {
	global $SITE_PATH;
	return $SITE_PATH . '/' . $ada . '-' . $page . '.jpg';
}

function get_image_url( $ada, $page ) {
	global $SITE_PREVIEW_URL;
	return $SITE_PREVIEW_URL . '/' . $ada . '-' . $page . '.jpg';
}

function make_image( $ada, $page ) {

}

if ( !$SITE_PREVIEW ) exit();
if ( !array_key_exists( 'ada', $_REQUEST ) ) exit();
$page = ( array_key_exists( 'p', $_REQUEST ) ) ? $_REQUEST[ 'p' ] : 1;
$ada = $_REQUEST[ 'ada' ];
if ( strpos( $ada, '/' ) !== false || strpos( $ada, '.' ) !== false ) exit();
$img_path = get_image_path( $ada, $page );
if ( !file_exists( $img_path ) ) {
	if ( strpos( $get_doc_url, '.php' ) !== false ) {
		$url = $get_doc_url . "?ada=$ada";
	}
	else {
		$url = $get_doc_url . '/' . $ada;
	}
	$handle = fopen( $url, 'rb' );
	$im = new Imagick();
	$im->setResolution( 100, 100 );
	$im->readImageFile( $handle );
	$pages = $im->getNumberImages();
	if ( $page > $pages ) {
		header( "Location: " . $config[ 'site_url' ] . '/images/end.jpg' );
		exit();
	}
	gotoPage( $im, $page );
	$im->setImageFileName( $img_path );
	$im->scaleImage( 480, 640 );
	$im->writeImage();
}

header( "Location: " . get_image_url( $ada, $page ) );
exit();
?>
