<?php
require_once 'Pager/Pager.php';

//create dummy array of data
$myData = array();
for ($i=0; $i<200; $i++) {
    $myData[] = $i;
}

//set a string 
$test_strings_encoded = array(
    'encoded1' => '&#27979;&#35797;',
    'encoded2' => '&#50504;&#45397;',
);
$test_strings_plain = array(
    'plain1' => '안녕',
    'plain2' => '더보기',
//    'plain3' => '이젠 전화도
//로 걸면 무료',
);
$params = array(
    'itemData' => $myData,
    'perPage' => 10,
    'delta' => 2,
    'append' => true,
    'clearIfVoid' => false,
	'extraVars' => array_merge($test_strings_plain, $test_strings_encoded),
	'httpMethod' => 'POST',
    'path' => 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')),
    'fileName' => basename(__FILE__),
);
//var_dump($params['fileName']);exit;
$pager = & Pager::factory($params);
$page_data = $pager->getPageData();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0
Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pager Test: page <?php echo $pager->getCurrentPageID(); ?></title>
</head>
<body>
<?php echo $pager->links; ?>
<hr />
<pre><?php print_r($page_data); ?></pre>
</body>
</html>