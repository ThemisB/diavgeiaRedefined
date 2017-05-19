<?php
// Get the Generic Header
$READ_DOMAIN_INFO = true;
$PAGINATION_JS = true;
include './theme_header.php';
?>

<div id="content">
    <?php if ($show_notice) { ?>
        <div id="notice">
           
         
        </div>
    <?php } ?>


    <div class="latest_docs">
        <span class="title">
          Βλέπετε τις τελευταίες διοικητικές πράξεις
        </span>
        <span class="rss">
            <a href="<?php echo $config['rss_url'] ?>" target="_blank">
                Προβολή σε XML (RSS2.0)
        </span>
    </div>

    <?php echo get_latest_decisions(get_pages_size()); ?>
    
</div>
<!-- end div#content -->

<?php include('_right-sidebar.php'); ?>


<?php
// Get the Generic Sidebar
//include 'theme_sidebar.php' ; 
include 'theme_footer.php';
?>
