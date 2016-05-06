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
use_unit("Zend/zcommon.inc.php");
use_unit("classes.inc.php");
use_unit("cache.inc.php");

use_unit("Zend/framework/library/Zend/Cache.php");

define('cfCore', 'cfCore');
define('cfOutput', 'cfOutput');
define('cfFunction', 'cfFunction');
define('cfClass', 'cfClass');
define('cfFile', 'cfFile');
define('cfPage', 'cfPage');

define('cbFile', 'cbFile');
define('cbSQLite', 'cbSQLite');
define('cbMemcached', 'cbMemcached');
define('cbAPC', 'cbAPC');
define('cbZendPlatform', 'cbPlatform');

define('rctCRC32', 'rctCRC32');
define('rctMD5', 'rctMD5');
define('rctADLER32', 'rctADLER32');
define('rctSTRLEN', 'rctSTRLEN');

class ZCacheOptions extends Persistent
{
	protected $ZCache=null;

    function readOwner()
    {
    	return($this->ZCache);
    }

    function __construct($aowner)
    {
    	parent::__construct();

    	$this->ZCache=$aowner;
    }
}

class ZCacheFrontendFunctionOptions extends ZCacheOptions
{
      protected $_cachebydefault = "1";

      function getCacheByDefault() { return $this->_cachebydefault; }
      function setCacheByDefault($value) { $this->_cachebydefault = $value; }
      function defaultCacheByDefault() { return "1"; }

      protected $_cachedfunctions = array();

      function getCachedFunctions() { return $this->_cachedfunctions; }
      function setCachedFunctions($value) { $this->_cachedfunctions = $value; }
      function defaultCachedFunctions() { return array(); }

      protected $_noncachedfunctions = array();

      function getNonCachedFunctions() { return $this->_noncachedfunctions; }
      function setNonCachedFunctions($value) { $this->_noncachedfunctions = $value; }
      function defaultNonCachedFunctions() { return array(); }
}

class ZCacheFrontendClassOptions extends ZCacheOptions
{
    protected $_cachedentity="";

    function getCachedEntity() { return $this->_cachedentity; }
    function setCachedEntity($value) { $this->_cachedentity=$value; }
    function defaultCachedEntity() { return ""; }

    protected $_cachebydefault="1";

    function getCacheByDefault() { return $this->_cachebydefault; }
    function setCacheByDefault($value) { $this->_cachebydefault=$value; }
    function defaultCacheByDefault() { return "1"; }

    protected $_cachedmethods=array();

    function getCachedMethods() { return $this->_cachedmethods; }
    function setCachedMethods($value) { $this->_cachedmethods=$value; }
    function defaultCachedMethods() { return array(); }

    protected $_noncachedmethods=array();

    function getNonCachedMethods() { return $this->_noncachedmethods; }
    function setNonCachedMethods($value) { $this->_noncachedmethods=$value; }
    function defaultNonCachedMethods() { return array(); }
}

class ZCacheFrontendFileOptions extends ZCacheOptions
{
    protected $_masterfile="";

    function getMasterFile() { return $this->_masterfile; }
    function setMasterFile($value) { $this->_masterfile=$value; }
    function defaultMasterFile() { return ""; }


}

class ZCacheFrontendPageOptions extends ZCacheOptions
{
    protected $_httpconditional="0";

    function getHTTPConditional() { return $this->_httpconditional; }
    function setHTTPConditional($value) { $this->_httpconditional=$value; }
    function defaultHTTPConditional() { return "0"; }

    protected $_debugheader="0";

    function getDebugHeader() { return $this->_debugheader; }
    function setDebugHeader($value) { $this->_debugheader=$value; }
    function defaultDebugHeader() { return "0"; }

    protected $_enabled="1";

    function getEnabled() { return $this->_enabled; }
    function setEnabled($value) { $this->_enabled=$value; }
    function defaultEnabled() { return "1"; }

    protected $_cachewithget="0";

    function getCacheWithGET() { return $this->_cachewithget; }
    function setCacheWithGET($value) { $this->_cachewithget=$value; }
    function defaultCacheWithGET() { return "0"; }

    protected $_cachewithpost="0";

    function getCacheWithPOST() { return $this->_cachewithpost; }
    function setCacheWithPOST($value) { $this->_cachewithpost=$value; }
    function defaultCacheWithPOST() { return "0"; }

    protected $_cachewithsession="0";

    function getCacheWithSESSION() { return $this->_cachewithsession; }
    function setCacheWithSESSION($value) { $this->_cachewithsession=$value; }
    function defaultCacheWithSESSION() { return "0"; }

    protected $_cachewithcookie="0";

    function getCacheWithCOOKIE() { return $this->_cachewithcookie; }
    function setCacheWithCOOKIE($value) { $this->_cachewithcookie=$value; }
    function defaultCacheWithCOOKIE() { return "0"; }

    protected $_idwithget="1";

    function getIDWithGET() { return $this->_idwithget; }
    function setIDWithGET($value) { $this->_idwithget=$value; }
    function defaultIDWithGET() { return "1"; }

    protected $_idwithpost="1";

    function getIDWithPOST() { return $this->_idwithpost; }
    function setIDWithPOST($value) { $this->_idwithpost=$value; }
    function defaultIDWithPOST() { return "1"; }

    protected $_idwithsession="1";

    function getIDWithSESSION() { return $this->_idwithsession; }
    function setIDWithSESSION($value) { $this->_idwithsession=$value; }
    function defaultIDWithSESSION() { return "1"; }

    protected $_idwithfiles="1";

    function getIDWithFiles() { return $this->_idwithfiles; }
    function setIDWithFiles($value) { $this->_idwithfiles=$value; }
    function defaultIDWithFiles() { return "1"; }

    protected $_idwithcookie="1";

    function getIDWithCOOKIE() { return $this->_idwithcookie; }
    function setIDWithCOOKIE($value) { $this->_idwithcookie=$value; }
    function defaultIDWithCOOKIE() { return "1"; }





    protected $_regexps=array();

    function getRegExps() { return $this->_regexps; }
    function setRegExps($value) { $this->_regexps=$value; }
    function defaultRegExps() { return array(); }
}

class ZCacheBackendSQLiteOptions extends ZCacheOptions
{
    protected $_databasepath="";

    function getDatabasePath() { return $this->_databasepath; }
    function setDatabasePath($value) { $this->_databasepath=$value; }
    function defaultDatabasePath() { return ""; }

    protected $_vacuumfactor=10;

    function getVacuumFactor() { return $this->_vacuumfactor; }
    function setVacuumFactor($value) { $this->_vacuumfactor=$value; }
    function defaultVacuumFactor() { return 10; }
}

class ZCacheBackendMemcachedOptions extends ZCacheOptions
{
    protected $_servers=array();

    function getServers() { return $this->_servers; }
    function setServers($value) { $this->_servers=$value; }
    function defaultServers() { return array(); }

    protected $_compression="0";

    function getCompression() { return $this->_compression; }
    function setCompression($value) { $this->_compression=$value; }
    function defaultCompression() { return "0"; }


}

class ZCache extends Cache
{
      public $zend_cache=null;

      function startCache($control, $cachetype)
      {
      	$id=$control->readNamePath().'_'.$cachetype;
        $id=str_replace('.','_',$id);
      	return($this->start($id));
      }

      function endCache()
      {
      	$this->end();
      }

	  function load($id, $doNotTestCacheValidity = false, $doNotUnserialize = false)
      {
      	return($this->zend_cache->load($id, $doNotTestCacheValidity, $doNotUnserialize));
      }

      function save($data, $id = null, $tags = array(), $specificLifetime = false)
      {
      	return($this->zend_cache->save($data, $id, $tags, $specificLifetime));
      }

      function start($id, $doNotTestCacheValidity = false)
      {
      	return($this->zend_cache->start($id, $doNotTestCacheValidity));
      }

      function end($tags = array(), $specificLifetime = false)
      {
      	return($this->zend_cache->end($tags, $specificLifetime));
      }

      function remove($id)
      {
      	return($this->zend_cache->remove($id));
      }

      function cleanAll()
      {
      	return($this->zend_cache->clean(Zend_Cache::CLEANING_MODE_ALL));
      }

      function cleanOld()
      {
      	return($this->zend_cache->clean(Zend_Cache::CLEANING_MODE_OLD));
      }

      function cleanMatching($tags)
      {
      	return($this->zend_cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, $tags));
      }

      function cleanNotMatching($tags)
      {
      	return($this->zend_cache->clean(Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG, $tags));
      }

	  function call($name, $parameters = array(), $tags = array(), $specificLifetime = false)
      {
      	return($this->zend_cache->call($name, $parameters, $tags, $specificLifetime));
      }


      function preinit()
      {
			$frontend='Output';
            $backend='File';

			$frontendOptions=array();
            $backendOptions=array();

            //Frontend common properties
            $frontendOptions['caching']=$this->_enabled;
            $frontendOptions['cache_id_prefix']=$this->_prefix;
            $frontendOptions['lifetime']=$this->_lifetime;
            $frontendOptions['logging']=$this->_logging;
            $frontendOptions['write_control']=$this->_checkwrite;
            $frontendOptions['automatic_serialization']=$this->_serialization;
            $frontendOptions['automatic_cleaning_factor']=$this->_cleaningfactor;
            $frontendOptions['ignore_user_abort']=$this->_ignoreuserabort;

            //Backend common properties
            $backendOptions['cache_dir']=$this->_cachedir;
            $backendOptions['file_locking']=$this->_filelocking;
            $backendOptions['read_control']=$this->_checkread;

            //Convert read control type
            $rct='crc32';
            switch ($this->_readcontroltype) {
                case rctCRC32:  $rct='crc32'; break;
                case rctADLER32:  $rct='adler32'; break;
                case rctMD5:  $rct='md5'; break;
                case rctSTRLEN:  $rct='strlen'; break;
            }
            $backendOptions['read_control_type']=$rct;
            $backendOptions['hashed_directory_level']=$this->_hasheddirectorylevel;
            $backendOptions['hashed_directory_umask']=$this->_hasheddirectoryumask;
            $backendOptions['file_name_prefix']=$this->_filenameprefix;
            $backendOptions['cache_file_umask']=$this->_cachefileumask;
            $backendOptions['metadatas_array_max_size']=$this->_metadatasize;

            switch ($this->_frontend)
            {
                case cfCore:
				$frontend='Core';
                break;

                case cfOutput:
				$frontend='Output';
                break;

                case cfFunction:
				$frontend='Function';
                break;

                case cfClass:
                $frontend='Class';
                break;

                case cfFile:
                $frontend='File';
                break;

                case cfPage:
                $frontend='Page';
                break;
            }

            switch ($this->_backend)
            {
                case cbFile:
				$backend='File';
                break;

                case cbSQLite:
				$backend='Sqlite';
                break;

                case cbMemcached:
                $backend='Memcached';
                break;

                case cbAPC:
                $backend='Apc';
                break;

                case cbZendPlatform:
                $backend='Zend Platform';
                break;
            }

            $this->zend_cache=Zend_Cache::factory($frontend, $backend, $frontendOptions, $backendOptions);

            //Clean all cache when session is restored
            if (isset($_GET['restore_session']))
            {
            	if (!isset($_POST['xajax']))
                {
                	$this->cleanAll();
                }
            }
      }

      function __construct($aowner = null)
      {
            //Calls inherited constructor
            parent::__construct($aowner);

            //Frontend properties
            $this->_frontendfunctionoptions= new ZCacheFrontendFunctionOptions($this);
            $this->_frontendclassoptions= new ZCacheFrontendClassOptions($this);
            $this->_frontendfileoptions= new ZCacheFrontendFileOptions($this);
            $this->_frontendpageoptions= new ZCacheFrontendPageOptions($this);

            //Backend properties
            $this->_backendsqliteoptions=new ZCacheBackendSQLiteOptions($this);
            $this->_backendmemcachedoptions=new ZCacheBackendMemcachedOptions($this);
      }

      protected $_frontend = cfOutput;

      function getFrontend() { return $this->_frontend; }
      function setFrontend($value) { $this->_frontend = $value; }
      function defaultFrontend() { return cfOutput; }

      protected $_backend = cbFile;

      function getBackend() { return $this->_backend; }
      function setBackend($value) { $this->_backend = $value; }
      function defaultBackend() { return cbFile; }

      //Frontend properties
      protected $_enabled = "1";

      function getEnabled() { return $this->_enabled; }
      function setEnabled($value) { $this->_enabled = $value; }
      function defaultEnabled() { return "1"; }

      protected $_prefix = "";

      function getPrefix() { return $this->_prefix; }
      function setPrefix($value) { $this->_prefix = $value; }
      function defaultPrefix() { return ""; }

      protected $_lifetime = 3600;

      function getLifetime() { return $this->_lifetime; }
      function setLifetime($value) { $this->_lifetime = $value; }
      function defaultLifetime() { return 3600; }

      protected $_logging = "0";

      function getLogging() { return $this->_logging; }
      function setLogging($value) { $this->_logging = $value; }
      function defaultLogging() { return "0"; }

      protected $_checkwrite = "1";

      function getCheckWrite() { return $this->_checkwrite; }
      function setCheckWrite($value) { $this->_checkwrite = $value; }
      function defaultCheckWrite() { return "1"; }

      protected $_serialization = "0";

      function getSerialization() { return $this->_serialization; }
      function setSerialization($value) { $this->_serialization = $value; }
      function defaultSerialization() { return "0"; }

      protected $_cleaningfactor = 10;

      function getCleaningFactor() { return $this->_cleaningfactor; }
      function setCleaningFactor($value) { $this->_cleaningfactor = $value; }
      function defaultCleaningFactor() { return 10; }

      protected $_ignoreuserabort = "0";

      function getIgnoreUserAbort() { return $this->_ignoreuserabort; }
      function setIgnoreUserAbort($value) { $this->_ignoreuserabort = $value; }
      function defaultIgnoreUserAbort() { return "0"; }

      //Backend properties
      protected $_cachedir = '/tmp/';

      function getCacheDir() { return $this->_cachedir; }
      function setCacheDir($value) { $this->_cachedir = $value; }
      function defaultCacheDir() { return '/tmp/'; }

      protected $_filelocking = "1";

      function getFileLocking() { return $this->_filelocking; }
      function setFileLocking($value) { $this->_filelocking = $value; }
      function defaultFileLocking() { return "1"; }

      protected $_checkread = "1";

      function getCheckRead() { return $this->_checkread; }
      function setCheckRead($value) { $this->_checkread = $value; }
      function defaultCheckRead() { return "1"; }

      protected $_readcontroltype = rctCRC32;

      function getReadControlType() { return $this->_readcontroltype; }
      function setReadControlType($value) { $this->_readcontroltype = $value; }
      function defaultReadControlType() { return rctCRC32; }

      protected $_hasheddirectorylevel = 0;

      function getHashedDirectoryLevel() { return $this->_hasheddirectorylevel; }
      function setHashedDirectoryLevel($value) { $this->_hasheddirectorylevel = $value; }
      function defaultHashedDirectoryLevel() { return 0; }

      protected $_hasheddirectoryumask = '700';

      function getHashedDirectoryUmask() { return $this->_hasheddirectoryumask; }
      function setHashedDirectoryUmask($value) { $this->_hasheddirectoryumask = $value; }
      function defaultHashedDirectoryUmask() { return '700'; }

      protected $_filenameprefix = 'zend_cache';

      function getFileNamePrefix() { return $this->_filenameprefix; }
      function setFileNamePrefix($value) { $this->_filenameprefix = $value; }
      function defaultFileNamePrefix() { return 'zend_cache'; }

      protected $_cachefileumask = '700';

      function getCacheFileUmask() { return $this->_cachefileumask; }
      function setCacheFileUmask($value) { $this->_cachefileumask = $value; }
      function defaultCacheFileUmask() { return '700'; }

      protected $_metadatasize = 100;

      function getMetadataSize() { return $this->_metadatasize; }
      function setMetadataSize($value) { $this->_metadatasize = $value; }
      function defaultMetadataSize() { return 100; }

      //Options for FrontEnds
      protected $_frontendfunctionoptions = null;

      function getFrontendFunctionOptions() { return $this->_frontendfunctionoptions; }
      function setFrontendFunctionOptions($value) { $this->_frontendfunctionoptions = $value; }
      function defaultFrontendFunctionOptions() { return null; }

    protected $_frontendclassoptions=null;

    function getFrontendClassOptions() { return $this->_frontendclassoptions; }
    function setFrontendClassOptions($value) { $this->_frontendclassoptions=$value; }
    function defaultFrontendClassOptions() { return null; }

    protected $_frontendfileoptions=null;

    function getFrontendFileOptions() { return $this->_frontendfileoptions; }
    function setFrontendFileOptions($value) { $this->_frontendfileoptions=$value; }
    function defaultFrontendFileOptions() { return null; }

    protected $_frontendpageoptions=null;

    function getFrontendPageOptions() { return $this->_frontendpageoptions; }
    function setFrontendPageOptions($value) { $this->_frontendpageoptions=$value; }
    function defaultFrontendPageOptions() { return null; }

    protected $_backendsqliteoptions=null;

    function getBackendSQLiteOptions() { return $this->_backendsqliteoptions; }
    function setBackendSQLiteOptions($value) { $this->_backendsqliteoptions=$value; }
    function defaultBackendSQLiteOptions() { return null; }

    protected $_backendmemcachedoptions=null;

    function getBackendMemcachedOptions() { return $this->_backendmemcachedoptions; }
    function setBackendMemcachedOptions($value) { $this->_backendmemcachedoptions=$value; }
    function defaultBackendMemcachedOptions() { return null; }

}

?>