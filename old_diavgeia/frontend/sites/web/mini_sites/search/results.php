<?php
$READ_DOMAIN_INFO = true; 
$RESULTS_PAGE = true;
include '../theme_header.php';
$args = get_search_args();
echo '<div id="content">';
print_search_results( $args );
echo '</div>';
include '../_right-sidebar.php' ; 
include '../theme_footer.php' ; 
?>
