<?php 
$READ_DOMAIN_INFO = true;
$SEARCH_PAGE = true;
include '../theme_header.php' ; 
require_once '../queries.php'; 

$q = $_REQUEST[ 'q' ];

?>

<div id="content" class="searchpage">
	<div id="cse" style="width: 100%;">Loading</div>
	<script src="http://www.google.com/jsapi" type="text/javascript"></script>
	<script type="text/javascript"> 
	google.load('search', '1', {language : 'el'});
	google.setOnLoadCallback(function() {
		var customSearchControl = new google.search.CustomSearchControl('013342080388016102483:rsot08blwoa');
		customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
		customSearchControl.draw('cse');
		$('[name=search]' ).focus();
		$('[name=search]' ).val( '<?php echo $q; ?>' );
		$('[type=submit]' ).click();
	}, true);
</script>
<link rel="stylesheet" href="http://www.google.com/cse/style/look/default.css" type="text/css" />

</div>


<?php include '../theme_footer.php' ; ?>
