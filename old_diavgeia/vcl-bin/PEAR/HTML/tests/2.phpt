--TEST--
2.phpt: addRow 1 row 2 column with no extra options
--FILE--
<?php
// $Id: 2.phpt,v 1.2 2005/10/26 16:28:59 dufuz Exp $
require_once 'HTML/Table.php';
$table =& new HTML_Table();

$data[0][] = 'Test';
$data[0][] = 'Test';

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
</table>