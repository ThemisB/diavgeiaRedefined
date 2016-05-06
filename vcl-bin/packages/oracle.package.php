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

   setPackageTitle("Native Access Components for Oracle(R)");
   setIconPath("./icons");

   addSplashBitmap("Native Access Components for Oracle(R)","oracle.bmp");

   registerComponents("Oracle",array("OracleDatabase"),"oracle.inc.php");
   registerComponents("Oracle",array("OracleTable","OracleQuery","OracleStoredProc"),"oracle.inc.php");

   registerBooleanProperty("OracleDatabase","Connected");
   registerBooleanProperty("OracleTable","Active");
   registerBooleanProperty("OracleQuery","Active");
   registerPasswordProperty("OracleDatabase","Password");

   registerPropertyValues("OracleTable","Database",array('OracleDatabase'));
   registerPropertyValues("OracleTable","MasterSource",array('Datasource'));
   registerPropertyValues("CustomOracleQuery","Database",array('OracleDatabase'));
   registerPropertyEditor("CustomOracleQuery","Query","TStringListPropertyEditor","native");
   registerPropertyValues("OracleDataset","Order",array('asc','desc'));

   registerPropertyEditor("OracleQuery","SQL","TStringListPropertyEditor","native");
   registerPropertyEditor("OracleDataSet","Params","TStringListPropertyEditor","native");
   registerBooleanProperty("OracleDataSet","LOBMode");
   registerPropertyValues("OracleDataSet","FieldCaption",array('fdName','fdNumber'));

   registerPropertyValues("OracleStoredProc","StoredType",array('stSingleValue','stCursor','stNone'));
   registerPropertyValues("OracleStoredProc","CursorName",array('CursorName'));

   registerPropertyEditor("OracleDataSet","ParamByNames","TValueListPropertyEditor","native");
   registerPropertyValues("OracleDataSet","ParamBindMode",array('pbByName','pbByNumber'));

   registerPropertyValues("OracleDatabase","Charset",array(""));
   registerBooleanProperty("OracleDatabase","UseSID");

?>
