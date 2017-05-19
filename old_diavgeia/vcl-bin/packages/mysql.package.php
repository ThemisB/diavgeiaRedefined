<?php
/**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2008 qadram software S.L. <support@qadram.com>
*
*  Checkout AUTHORS file for more information on the developers
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
*  USA
*
*/
   require_once("vcl/vcl.inc.php");
   use_unit("designide.inc.php");

   setPackageTitle("Native Access Components for MySQL(R)");
   setIconPath("./icons");

   addSplashBitmap("Native Access Components for MySQL(R)","mysql.bmp");

   registerComponents("MySQL",array("MySQLDatabase"),"mysql.inc.php");
   registerComponents("MySQL",array("MySQLTable","MySQLQuery","MySQLStoredProc"),"mysql.inc.php");

   registerBooleanProperty("MySQLDatabase","Connected");
   registerBooleanProperty("MySQLTable","Active");
   registerBooleanProperty("MySQLQuery","Active");
   registerPasswordProperty("MySQLDatabase","Password");

   registerPropertyValues("MySQLTable","Database",array('MySQLDatabase'));
   registerPropertyValues("MySQLTable","MasterSource",array('Datasource'));
   registerPropertyValues("CustomMySQLQuery","Database",array('MySQLDatabase'));
   registerPropertyEditor("CustomMySQLQuery","Query","TStringListPropertyEditor","native");
   registerPropertyValues("MySQLDataset","Order",array('asc','desc'));

   registerPropertyEditor("MySQLQuery","SQL","TStringListPropertyEditor","native");
   registerPropertyEditor("MySQLDataSet","Params","TStringListPropertyEditor","native");

?>
