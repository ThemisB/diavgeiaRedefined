<?php

require_once('db.php');
require_once( 'site.php');
require_once('queries.php');

$INDEXER = false;
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mnogosearch') !== false) {
    $INDEXER = true;
}
$headers = apache_request_headers();
if (array_key_exists('Indexer-Request', $headers))
    $INDEXER = true;


/* Database Configuration */
setlocale(LC_ALL, "el_GR.UTF-8");
mysql_connect($db['host'], $db['username'], $db['password']);
mysql_select_db($db['database']);
mysql_query("SET NAMES utf8");


/* Read domain info */
if (isset($READ_DOMAIN_INFO) && $READ_DOMAIN_INFO) {
    $config = array();
    $fid = get_foreas_latin_name_from_url();
    $config['foreas'] = read_foreas_info($fid);
    if (foreas_not_found()) {
        $logger->logError("Foreas not found and you will receive 404!");
        header('HTTP/1.0 404 Not Found');
        exit();
    }
    $config['site_type'] = $SITE_TYPE; // one of 'et', 'sites'
    $config['base_url'] = $SITE_URL;
    $config['site_url'] = $SITE_URL . '/' . $config['foreas']['latin_name'];
    $config['rss_url'] = $config['site_url'] . '/rss';
    $config['xsl_stats_url'] = $config['site_url'] . '/xsl/stats.xsl';
    $config['xsl_spending_url'] = $config['site_url'] . '/xsl/spending.xsl';
    $config['search_url'] = $config['site_url'] . '/find';
    $config['ajax_pagination'] = true;
    $site_url = $config['site_url'];
} else {
    $site_url = $SITE_URL;
}

/* Site Configuration */
$site_name = "Δικτυακός τόπος εμφάνισης";
$et_site_url = "http://83.212.121.173/drasi1/frontend";
$search_url = $site_url . '/search';
if (isset($SITE_DL_URL)) {
    $get_doc_url = $SITE_DL_URL;
} else {
    $get_doc_url = "http://83.212.121.173/drasi1/storage/doc";
}
if (isset($config)) {
    $css_url = $site_url . '/css/' . $config['site_type'] . '.css';
}

/* Configuration */

$show_notice = false;

include_once('functions.php');
?>
