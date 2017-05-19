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

   setPackageTitle("Native Access Components for InterBase(R)");
   setIconPath("./icons");

   addSplashBitmap("Native Access Components for InterBase(R)","ib.ico");

   registerComponents("InterBase",array("IBDatabase"),"interbase.inc.php");
   registerComponents("InterBase",array("IBTable","IBQuery","IBStoredProc"),"interbase.inc.php");

   registerBooleanProperty("IBDatabase","Connected");
   registerBooleanProperty("IBTable","Active");
   registerBooleanProperty("IBQuery","Active");
   registerPasswordProperty("IBDatabase","Password");

   registerPropertyValues("IBTable","Database",array('IBDatabase'));
   registerPropertyValues("IBTable","MasterSource",array('Datasource'));
   registerPropertyValues("CustomIBQuery","Database",array('IBDatabase'));
   registerPropertyEditor("CustomIBQuery","Query","TStringListPropertyEditor","native");
   registerPropertyEditor("IBDatabase","DatabaseName","TAbsolutePathPropertyEditor","native");
   registerPropertyValues("IBDataset","Order",array('asc','desc'));

   registerPropertyEditor("IBQuery","SQL","TStringListPropertyEditor","native");
   registerPropertyEditor("IBDataSet","Params","TStringListPropertyEditor","native");

?>
