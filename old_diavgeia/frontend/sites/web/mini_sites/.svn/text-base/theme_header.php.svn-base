<?php require_once(__DIR__ . '/config.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Πρότυπες εφαρμογές - Δράση1</title>

    <link rel="icon" href="<?php echo $site_url; ?>/images/favicon.ico" />
    <link rel="shortcut icon" href="<?php echo $site_url; ?>/images/favicon.ico" />
    <link rel="alternate" title="<?php echo get_rss_title(); ?>" href="<?php echo $config['rss_url']; ?>" type="application/rss+xml" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="robots" content="noarchive" />
    <script type="text/javascript" src="<?php echo $site_url; ?>/js/jquery.js"></script> 
    <?php if ($PAGINATION_JS || true): ?>
      <script type="text/javascript" src="<?php echo $site_url; ?>/js/pagination.js"></script> 
      <?php init_ajax_pagination(); ?>
    <?php endif; ?>
  
  

    <link href="<?php echo $css_url; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $site_url; ?>/search/jscalendar/calendar-blue.css" rel="stylesheet" type="text/css" />

  </head>
  <body>

    <div id="wrapper">
      <br />
      <?php if ($config['site_type'] == 'et'): ?>
        <div align="right">
        </div>
      <?php endif; ?>


      <div id="header">
        <div id="logo">
          <!--<img src="<?php echo $site_url; ?>/images/logo.png" title="<?php echo $config['foreas']['name']; ?>" />-->
          <?php if ($config['site_type'] == 'sites'): ?>
            <h1><a href="<?php echo $config['site_url']; ?>/"><?php echo $config['foreas']['name']; ?></a></h1>
            <span class="address"> <?php if (false && !all_orgs()) echo get_foreas_address($config['foreas']['pb_id']); ?></span>
            <h2><a href="<?php echo $site_url; ?>/">Ανάρτηση  Αποφάσεων & Διοικητικών Πράξεων</a></h2>
          <?php elseif ($config['site_type'] == 'et'): ?>
            <br />
            <h1>ΔΙΚΤΥΑΚΟΣ ΤΟΠΟΣ ΠΡΟΒΟΛΗΣ ΠΡΑΞΕΩΝ</h1>
            <br />
            <br />
            <?php if (!all_orgs()): ?>
              <h1> <a href="<?php echo $config['site_url']; ?>/">
              Φορέας Χ
              <?php // echo $config['foreas']['name']; ?></a></h1>
              <span class="address"> <?php if (false && !all_orgs()) echo get_foreas_address($config['foreas']['pb_id']); ?></span>
            <?php elseif ($SEARCH_PAGE): ?>
          
            <?php elseif ($RESULTS_PAGE): ?>
                        <?php else: ?>
              <h2>Όλοι οι φορείς</h2>	
            <?php endif; ?>
          <?php endif; ?>
        </div>
        <!-- end div#logo -->
        <div id="allsite">
	
          <div style="clear:both;"></div>
          <!-- Search -->
      
                 </div>
      </div> <!-- end div#header -->
      <div id="page">
        <div id="page-bgtop">
