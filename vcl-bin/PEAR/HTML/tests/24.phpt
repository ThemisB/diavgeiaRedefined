--TEST--
24.phpt: thead, tfoot and addRow (tbody not in output)
--FILE--
<?php
// $Id: 24.phpt,v 1.1 2005/11/27 19:25:03 wiesemann Exp $
require_once 'HTML/Table.php';
$table =& new HTML_Table();

$thead =& $table->getHeader();
$tfoot =& $table->getFooter();

$data[0][] = 'Test';
$data[1][] = 'Test';

foreach($data as $key => $value) {
    $thead->addRow($value);
    $tfoot->addRow($value);
}

// output
echo $table->toHTML();
?>
--EXPECT--
<table>
	<thead>
		<tr>
			<td>Test</td>
		</tr>
		<tr>
			<td>Test</td>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td>Test</td>
		</tr>
		<tr>
			<td>Test</td>
		</tr>
	</tfoot>
</table>