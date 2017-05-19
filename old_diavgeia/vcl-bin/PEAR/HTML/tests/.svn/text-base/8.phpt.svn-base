--TEST--
8.phpt: testing taboffset
--FILE--
<?php
// $Id: 8.phpt,v 1.1 2005/10/25 15:18:47 dufuz Exp $
require_once 'HTML/Table.php';
$table =& new HTML_Table('', 1);

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
		</tr>
	</table>