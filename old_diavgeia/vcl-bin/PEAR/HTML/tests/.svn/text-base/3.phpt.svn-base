--TEST--
3.phpt: addRow 2 row 2 column with no extra options
--FILE--
<?php
// $Id: 3.phpt,v 1.2 2005/10/26 16:28:59 dufuz Exp $
require_once 'HTML/Table.php';
$table =& new HTML_Table();

$data[0][] = 'Test';
$data[0][] = 'Test';
$data[1][] = 'Test';
$data[1][] = 'Test';

foreach($data as $key => $value) {
    $table->addRow($value);
}

// output
echo $table->toHTML();
?>
--EXPECT--
<table>
	<tr>
		<td>Test</td>
		<td>Test</td>
	</tr>
	<tr>
		<td>Test</td>
		<td>Test</td>
	</tr>
</table>