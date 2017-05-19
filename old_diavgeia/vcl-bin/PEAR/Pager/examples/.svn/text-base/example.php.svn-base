<?php
require_once 'Pager/Pager.php';

//create dummy array of data
$myData = array();
for ($i=0; $i<200; $i++) {
    $myData[] = $i;
}

$params = array(
    'itemData' => $myData,
    'perPage' => 10,
    'delta' => 8,             // for 'Jumping'-style a lower number is better
    'append' => true,
    //'separator' => ' | ',
    'clearIfVoid' => false,
    'urlVar' => 'entrant',
    'useSessions' => true,
    'closeSession' => true,
    //'mode'  => 'Sliding',    //try switching modes
    'mode'  => 'Jumping',

);
$pager = & Pager::factory($params);
$page_data = $pager->getPageData();
$links = $pager->getLinks();

$selectBox = $pager->getPerPageSelectBox();
?>

<html>
<head>
<title>new PEAR::Pager example</title>
</head>
<body>

<table border="1" width="500" summary="example 1">
	<tr>
		<td colspan="3" align="center">
		<?php echo $links['all']; ?>
		</td>
	</tr>


	<tr>
		<td colspan="3">
			<pre><?php print_r($page_data); ?></pre>
		</td>
	</tr>
</table>

<h4>Results from methods:</h4>

<pre>
getCurrentPageID()...: <?php var_dump($pager->getCurrentPageID()); ?>
getNextPageID()......: <?php var_dump($pager->getNextPageID()); ?>
getPreviousPageID()..: <?php var_dump($pager->getPreviousPageID()); ?>
numItems()...........: <?php var_dump($pager->numItems()); ?>
numPages()...........: <?php var_dump($pager->numPages()); ?>
isFirstPage()........: <?php var_dump($pager->isFirstPage()); ?>
isLastPage().........: <?php var_dump($pager->isLastPage()); ?>
isLastPageComplete().: <?php var_dump($pager->isLastPageComplete()); ?>
$pager->range........: <?php var_dump($pager->range); ?>
</pre>


<hr />

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
Select how many items per page should be shown:<br />
<?php echo $selectBox; ?> &nbsp;
<input type="submit" value="submit" />
</form>

<hr />

</body>
</html>