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
	* Direct PNG output demonstration (image not saved to disk)
	*
	*/

	include "../libchart/libchart.php";

	header("Content-type: image/png");

	$chart = new PieChart(500, 300);

	$chart->addPoint(new Point("Bleu d'Auvergne", 50));
	$chart->addPoint(new Point("Tomme de Savoie", 75));
	$chart->addPoint(new Point("Crottin de Chavignol", 30));

	$chart->setTitle("Preferred Cheese");
	$chart->render();
?>