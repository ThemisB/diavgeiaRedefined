<?php
header( "Content-Type: text/xml" );
$READ_DOMAIN_INFO = true;
require_once( 'config.php' );

$limit = get_rss_limit();
$arr = apofaseis_latest( $config[ 'foreas' ], 0, $limit );
$xml = get_rss_envelope( $arr[ 'rows' ] );
$xml = get_rss_items( $xml, $arr[ 'rows' ] );

echo $xml->asXML();

?>
