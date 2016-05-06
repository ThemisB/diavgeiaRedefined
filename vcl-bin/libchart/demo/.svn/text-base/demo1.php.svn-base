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
	* Vertical bars demonstration
	*
	*/

	include "../libchart/libchart.php";

	$chart = new VerticalChart();

	$chart->addPoint(new Point("Jan 2005", 273));
	$chart->addPoint(new Point("Feb 2005", 421));
	$chart->addPoint(new Point("March 2005", 642));
	$chart->addPoint(new Point("April 2005", 800));
	$chart->addPoint(new Point("May 2005", 1200));
	$chart->addPoint(new Point("June 2005", 1500));
	$chart->addPoint(new Point("July 2005", 2600));

	$chart->setTitle("Monthly usage for www.example.com");
	$chart->render("generated/demo1.png");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Libcharts vertical bars demonstration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>
	<img alt="Vertical bars chart" src="generated/demo1.png" style="border: 1px solid gray;"/>
</body>
</html>
