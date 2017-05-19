<?
	/** Libchart - PHP chart library
	*	
	* Copyright (C) 2005-2006 Jean-Marc Trémeaux (jm.tremeaux at gmail.com)
	* 	
	* This library is free software; you can redistribute it and/or
	* modify it under the terms of the GNU Lesser General Public
	* License as published by the Free Software Foundation; either
	* version 2.1 of the License, or (at your option) any later version.
	* 
	* This library is distributed in the hope that it will be useful,
	* but WITHOUT ANY WARRANTY; without even the implied warranty of
	* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	* Lesser General Public License for more details.
	* 
	* You should have received a copy of the GNU Lesser General Public
	* License along with this library; if not, write to the Free Software
	* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	* 
	*/
	
	/**
	* Line demonstration
	*
	*/

	include "../libchart/libchart.php";

	$chart = new LineChart();

	$chart->addPoint(new Point("06-01", 273));
	$chart->addPoint(new Point("06-02", 421));
	$chart->addPoint(new Point("06-03", 642));
	$chart->addPoint(new Point("06-04", 799));
	$chart->addPoint(new Point("06-05", 1009));
	$chart->addPoint(new Point("06-06", 1406));
	$chart->addPoint(new Point("06-07", 1820));
	$chart->addPoint(new Point("06-08", 2511));
	$chart->addPoint(new Point("06-09", 2832));
	$chart->addPoint(new Point("06-10", 3550));
	$chart->addPoint(new Point("06-11", 4143));
	$chart->addPoint(new Point("06-12", 4715));

	$chart->setTitle("Sales for 2006");
	$chart->render("generated/demo5.png");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Libcharts line demonstration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
	<img alt="Line chart" src="generated/demo5.png" style="border: 1px solid gray;"/>
</body>
</html>
