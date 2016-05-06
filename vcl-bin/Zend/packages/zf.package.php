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

setPackageTitle("VCL for PHP components for Zend Framework (tm)");
setIconPath("./icons");

addSplashBitmap("VCL for PHP components for Zend Framework (tm)", "zf.bmp");

registerComponents("Zend", array("ZACL"), "Zend/zacl.inc.php");
registerComponents("Zend", array("ZAuth"), "Zend/zauth.inc.php");
registerComponents("Zend", array("ZAuthDB"), "Zend/zauthdb.inc.php");
registerComponents("Zend", array("ZAuthDigest"), "Zend/zauthdigest.inc.php");
registerComponents("Zend", array("ZCache"), "Zend/zcache.inc.php");

registerPropertyValues("ZCache", "Frontend", array('cfCore','cfOutput', 'cfFunction', 'cfClass', 'cfFile', 'cfPage'));
registerPropertyValues("ZCache", "Backend", array('cbFile', 'cbSQLite', 'cbMemcached', 'cbAPC', 'cbPlatform'));
registerPropertyValues("ZCache", "ReadControlType", array('rctCRC32', 'rctMD5', 'rctADLER32', 'rctSTRLEN'));

registerBooleanProperty("ZCache", "Enabled");
registerBooleanProperty("ZCache", "Logging");
registerBooleanProperty("ZCache", "CheckWrite");
registerBooleanProperty("ZCache", "Serialization");
registerBooleanProperty("ZCache", "IgnoreUserAbort");
registerBooleanProperty("ZCache", "FileLocking");
registerBooleanProperty("ZCache", "CheckRead");

registerBooleanProperty("ZCache", "FrontendFunctionOptions.CacheByDefault");
registerBooleanProperty("ZCache", "FrontendClassOptions.CacheByDefault");
registerBooleanProperty("ZCache", "FrontendPageOptions.HTTPConditional");
registerBooleanProperty("ZCache", "FrontendPageOptions.DebugHeader");
registerBooleanProperty("ZCache", "FrontendPageOptions.Enabled");

registerBooleanProperty("ZCache", "FrontendPageOptions.CacheWithGET");
registerBooleanProperty("ZCache", "FrontendPageOptions.CacheWithPOST");
registerBooleanProperty("ZCache", "FrontendPageOptions.CacheWithSESSION");
registerBooleanProperty("ZCache", "FrontendPageOptions.CacheWithCOOKIE");

registerBooleanProperty("ZCache", "FrontendPageOptions.IDWithGET");
registerBooleanProperty("ZCache", "FrontendPageOptions.IDWithPOST");
registerBooleanProperty("ZCache", "FrontendPageOptions.IDWithSESSION");
registerBooleanProperty("ZCache", "FrontendPageOptions.IDWithFILES");
registerBooleanProperty("ZCache", "FrontendPageOptions.IDWithCOOKIE");

registerPropertyEditor("ZCache","FrontendClassOptions.CachedMethods","TStringListPropertyEditor","native");
registerPropertyEditor("ZCache","FrontendClassOptions.NonCachedMethods","TStringListPropertyEditor","native");
registerPropertyEditor("ZCache","FrontendFileOptions.MasterFile","TFilenamePropertyEditor","native");

registerPropertyEditor("ZCache","FrontendFunctionOptions.CachedFunctions","TStringListPropertyEditor","native");
registerPropertyEditor("ZCache","FrontendFunctionOptions.NonCachedFunctions","TStringListPropertyEditor","native");

registerPropertyEditor("ZCache","FrontendPageOptions.RegExps","TValueListPropertyEditor","native");

registerBooleanProperty("ZCache", "BackendMemcachedOptions.Compression");
registerPropertyEditor("ZCache","BackendMemcachedOptions.Servers","TStringListPropertyEditor","native");
registerPropertyEditor("ZCache","BackendSQLiteOptions.DatabasePath","TFilenamePropertyEditor","native");

registerPropertyEditor("ZACL", "ZAuth", "ZAuth", "native");

registerPropertyEditor("ZAuthDigest", "FileName", "TFilenamePropertyEditor", "native");


registerPropertyValues("ZAuth", "AuthAdapter", array("ZAuthAdapter"));
registerPropertyValues("ZAuthDB", "DriverName", array('mysql', 'sqlserver', 'postgre'));
registerPasswordProperty("ZAuth", "UserPassword");


?>