--TEST--
21.phpt: addCol with indexed rows (row 2, col 1; row 3, col 0)
--FILE--
<?php
// $Id: 21.phpt,v 1.1 2005/11/23 11:21:27 wiesemann Exp $
require_once 'HTML/Table.php';
$table =& new HTML_Table();

$data[0][3] = 'Test';
$data[1][2] = 'Test';

foreach($data as $key => $value) {
    $table->addCol($value);
}

// output
echo $table->toHTML();
?>
--EXPECT--
<table>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Test</td>
	</tr>
	<tr>
		<td>Test</td>
		<td>&nbsp;</td>
	</tr>
</table>