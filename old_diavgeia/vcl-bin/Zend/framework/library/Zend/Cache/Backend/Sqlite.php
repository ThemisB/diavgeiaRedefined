<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Cache
 * @subpackage Zend_Cache_Backend
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */


/**
 * @see Zend_Cache_Backend_Interface
 */
require_once 'Zend/Cache/Backend/Interface.php';

/**
 * @see Zend_Cache_Backend
 */
require_once 'Zend/Cache/Backend.php';

/**
 * @package    Zend_Cache
 * @subpackage Zend_Cache_Backend
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Cache_Backend_Sqlite extends Zend_Cache_Backend implements Zend_Cache_Backend_Interface
{
    /**
     * Available options
     *
     * =====> (string) cache_db_complete_path :
     * - the complete path (filename included) of the SQLITE database
     *
     * ====> (int) automatic_vacuum_factor :
     * - Disable / Tune the automatic vacuum process
     * - The automatic vacuum process defragment the database file (and make it smaller)
     *   when a clean() or delete() is called
     *     0               => no automatic vacuum
     *     1               => systematic vacuum (when delete() or clean() methods are called)
     *     x (integer) > 1 => automatic vacuum randomly 1 times on x clean() or delete()
     *
     * @var array Available options
     */
    protected $_options = array(
        'cache_db_complete_path' => null,
        'automatic_vacuum_factor' => 1
    );

    /**
     * DB ressource
     *
     * @var mixed $_db
     */
    private $_db = null;

    /**
     * Constructor
     *
     * @param  array $options Associative array of options
     * @throws Zend_cache_Exception
     * @return void
     */
    public function __construct($options = array())
    {
        parent::__construct($options);
        if (is_null($this->_options['cache_db_complete_path'])) {
            Zend_Cache::throwException('cache_db_complete_path option has to set');
        }
        if (!extension_loaded('sqlite')) {
            Zend_Cache::throwException("Cannot use SQLite storage because the 'sqlite' extension is not loaded in the current PHP environment");
        }
        $this->_getConnection();
    }

    /**
     * Destructor
     *
     * @return void
     */
    public function __destruct()
    {
        @sqlite_close($this->_getConnection());
    }

    /**
     * Test if a cache is available for the given id and (if yes) return it (false else)
     *
     * @param  string  $id                     Cache id
     * @param  boolean $doNotTestCacheValidity If set to true, the cache validity won't be tested
     * @return string|false Cached datas
     */
    public function load($id, $doNotTestCacheValidity = false)
    {
        $sql = "SELECT content FROM cache WHERE id='$id'";
        if (!$doNotTestCacheValidity) {
            $sql = $sql . " AND (expire=0 OR expire>" . time() . ')';
        }
        $result = $this->_query($sql);
        $row = @sqlite_fetch_array($result);
        if ($row) {
            return $row['content'];
        }
        return false;
    }

    /**
     * Test if a cache is available or not (for the given id)
     *
     * @param string $id Cache id
     * @return mixed|false (a cache is not available) or "last modified" timestamp (int) of the available cache record
     */
    public function test($id)
    {
        $sql = "SELECT lastModified FROM cache WHERE id='$id' AND (expire=0 OR expire>" . time() . ')';
        $result = $this->_query($sql);
        $row = @sqlite_fetch_array($result);
        if ($row) {
            return ((int) $row['lastModified']);
        }
        return false;
    }

    /**
     * Save some string datas into a cache record
     *
     * Note : $data is always "string" (serialization is done by the
     * core not by the backend)
     *
     * @param  string $data             Datas to cache
     * @param  string $id               Cache id
     * @param  array  $tags             Array of strings, the cache record will be tagged by each string entry
     * @param  int    $specificLifetime If != false, set a specific lifetime for this cache record (null => infinite lifetime)
     * @throws Zend_Cache_Exception
     * @return boolean True if no problem
     */
    public function save($data, $id, $tags = array(), $specificLifetime = false)
    {
        if (!$this->_checkStructureVersion()) {
            $this->_buildStructure();
            if (!$this->_checkStructureVersion()) {
                Zend_Cache::throwException("Impossible to build cache structure in " . $this->_options['cache_db_complete_path']);
            }
        }
        $lifetime = $this->getLifetime($specificLifetime);
        $data = @sqlite_escape_string($data);
        $mktime = time();
        if (is_null($lifetime)) {
            $expire = 0;
        } else {
            $expire = $mktime + $lifetime;
        }
        $this->_query("DELETE FROM cache WHERE id='$id'");
        $sql = "INSERT INTO cache (id, content, lastModified, expire) VALUES ('$id', '$data', $mktime, $expire)";
        $res = $this->_query($sql);
        if (!$res) {
            $this->_log("Zend_Cache_Backend_Sqlite::save() : impossible to store the cache id=$id");
            return false;
        }
        $res = true;
        foreach ($tags as $tag) {
            $res = $res && $this->_registerTag($id, $tag);
        }
        return $res;
    }

    /**
     * Remove a cache record
     *
     * @param  string $id Cache id
     * @return boolean True if no problem
     */
    public function remove($id)
    {
        $res = $this->_query("SELECT COUNT(*) AS nbr FROM cache WHERE id='$id'");
        $result1 = @sqlite_fetch_single($res);
        $result2 = $this->_query("DELETE FROM cache WHERE id='$id'");
        $result3 = $this->_query("DELETE FROM tag WHERE id='$id'");
        $this->_automaticVacuum();
        return ($result1 && $result2 && $result3);
    }

    /**
     * Clean some cache records
     *
     * Available modes are :
     * Zend_Cache::CLEANING_MODE_ALL (default)    => remove all cache entries ($tags is not used)
     * Zend_Cache::CLEANING_MODE_OLD              => remove too old cache entries ($tags is not used)
     * Zend_Cache::CLEANING_MODE_MATCHING_TAG     => remove cache entries matching all given tags
     *                                               ($tags can be an array of strings or a single string)
     * Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG => remove cache entries not {matching one of the given tags}
     *                                               ($tags can be an array of strings or a single string)
     *
     * @param  string $mode Clean mode
     * @param  array  $tags Array of tags
     * @return boolean True if no problem
     */
    public function clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array())
    {
        $return = $this->_clean($mode, $tags);
        $this->_automaticVacuum();
        return $return;
    }

    /**
     * PUBLIC METHOD FOR UNIT TESTING ONLY !
     *
     * Force a cache record to expire
     *
     * @param string $id Cache id
     */
    public function ___expire($id)
    {
        $time = time() - 1;
        $this->_query("UPDATE cache SET lastModified=$time, expire=$time WHERE id='$id'");
    }

    /**
     * Return the connection resource 
     * 
     * If we are not connected, the connection is made
     *
     * @throws Zend_Cache_Exception  
     * @return resource Connection resource
     */
    private function _getConnection()
    {
        if (is_resource($this->_db)) {
            return $this->_db;
        } else {
            $this->_db = @sqlite_open($this->_options['cache_db_complete_path']);
            if (!(is_resource($this->_db))) {
                Zend_Cache::throwException("Impossible to open " . $this->_options['cache_db_complete_path'] . " cache DB file");
            }
            return $this->_db;
        }       
    }
    
    /**
     * Execute an SQL query silently
     * 
     * @param string $query SQL query
     * @return mixed|false query results
     */ 
    private function _query($query)
    {
        $db = $this->_getConnection();
        if (is_resource($db)) {
            $res = @sqlite_query($db, $query);
            if ($res === false) {
                return false;
            } else {
                return $res;
            }           
        }
        return false;
    }

    /**
     * Deal with the automatic vacuum process
     *
     * @return void
     */
    private function _automaticVacuum()
    {
        if ($this->_options['automatic_vacuum_factor'] > 0) {
            $rand = rand(1, $this->_options['automatic_vacuum_factor']);
            if ($rand == 1) {
                $this->_query('VACUUM');
                @sqlite_close($this->_getConnection());
            }
        }
    }

    /**
     * Register a cache id with the given tag
     *
     * @param  string $id  Cache id
     * @param  string $tag Tag
     * @return boolean True if no problem
     */
    private function _registerTag($id, $tag) {
        $res = $this->_query("DELETE FROM TAG WHERE name='$tag' AND id='$id'");
        $res = $this->_query("INSERT INTO tag (name, id) VALUES ('$tag', '$id')");
        if (!$res) {
            $this->_log("Zend_Cache_Backend_Sqlite::_registerTag() : impossible to register tag=$tag on id=$id");
            return false;
        }
        return true;
    }

    /**
     * Build the database structure
     *
     * @return false
     */
    private function _buildStructure()
    {
        $this->_query('DROP INDEX tag_id_index');
        $this->_query('DROP INDEX tag_name_index');
        $this->_query('DROP INDEX cache_id_expire_index');
        $this->_query('DROP TABLE version');
        $this->_query('DROP TABLE cache');
        $this->_query('DROP TABLE tag');
        $this->_query('CREATE TABLE version (num INTEGER PRIMARY KEY)');
        $this->_query('CREATE TABLE cache (id TEXT PRIMARY KEY, content BLOB, lastModified INTEGER, expire INTEGER)');
        $this->_query('CREATE TABLE tag (name TEXT, id TEXT)');
        $this->_query('CREATE INDEX tag_id_index ON tag(id)');
        $this->_query('CREATE INDEX tag_name_index ON tag(name)');
        $this->_query('CREATE INDEX cache_id_expire_index ON cache(id, expire)');
        $this->_query('INSERT INTO version (num) VALUES (1)');
    }

    /**
     * Check if the database structure is ok (with the good version)
     *
     * @return boolean True if ok
     */
    private function _checkStructureVersion()
    {
        $result = $this->_query("SELECT num FROM version");
        if (!$result) return false;
        $row = @sqlite_fetch_array($result);
        if (!$row) {
            return false;
        }
        if (((int) $row['num']) != 1) {
            // old cache structure
            $this->_log('Zend_Cache_Backend_Sqlite::_checkStructureVersion() : old cache structure version detected => the cache is going to be dropped');
            return false;
        }
        return true;
    }

    /**
     * Clean some cache records
     *
     * Available modes are :
     * Zend_Cache::CLEANING_MODE_ALL (default)    => remove all cache entries ($tags is not used)
     * Zend_Cache::CLEANING_MODE_OLD              => remove too old cache entries ($tags is not used)
     * Zend_Cache::CLEANING_MODE_MATCHING_TAG     => remove cache entries matching all given tags
     *                                               ($tags can be an array of strings or a single string)
     * Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG => remove cache entries not {matching one of the given tags}
     *                                               ($tags can be an array of strings or a single string)
     *
     * @param  string $mode Clean mode
     * @param  array  $tags Array of tags
     * @return boolean True if no problem
     */
    private function _clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array())
    {
        if ($mode==Zend_Cache::CLEANING_MODE_ALL) {
            $res1 = $this->_query('DELETE FROM cache');
            $res2 = $this->_query('DELETE FROM tag');
            return $res1 && $res2;
        }
        if ($mode==Zend_Cache::CLEANING_MODE_OLD) {
            $mktime = time();
            $res1 = $this->_query("DELETE FROM tag WHERE id IN (SELECT id FROM cache WHERE expire>0 AND expire<=$mktime)");
            $res2 = $this->_query("DELETE FROM cache WHERE expire>0 AND expire<=$mktime");
            return $res1 && $res2;
        }
        if ($mode==Zend_Cache::CLEANING_MODE_MATCHING_TAG) {
            $first = true;
            $ids = array();
            foreach ($tags as $tag) {
                $res = $this->_query("SELECT DISTINCT(id) AS id FROM tag WHERE name='$tag'");
                if (!$res) {
                    return false;
                }
                $rows = @sqlite_fetch_all($res, SQLITE_ASSOC);
                $ids2 = array();
                foreach ($rows as $row) {
                    $ids2[] = $row['id'];
                }
                if ($first) {
                    $ids = $ids2;
                    $first = false;
                } else {
                    $ids = array_intersect($ids, $ids2);
                }
            }
            $result = true;
            foreach ($ids as $id) {
                $result = $result && ($this->remove($id));
            }
            return $result;
        }
        if ($mode==Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG) {
            $res = $this->_query("SELECT id FROM cache");
            $rows = @sqlite_fetch_all($res, SQLITE_ASSOC);
            $result = true;
            foreach ($rows as $row) {
                $id = $row['id'];
                $matching = false;
                foreach ($tags as $tag) {
                    $res = $this->_query("SELECT COUNT(*) AS nbr FROM tag WHERE name='$tag' AND id='$id'");
                    if (!$res) {
                        return false;
                    }
                    $nbr = (int) @sqlite_fetch_single($res);
                    if ($nbr > 0) {
                        $matching = true;
                    }
                }
                if (!$matching) {
                    $result = $result && $this->remove($id);
                }
            }
            return $result;
        }
        return false;
    }

}
