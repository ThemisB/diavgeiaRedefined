<?php
/**
 * PEAR::DB SQL Query Data Source Driver
 * 
 * PHP versions 4 and 5
 *
 * LICENSE:
 * 
 * Copyright (c) 1997-2007, Andrew Nagy <asnagy@webitecture.org>,
 *                          Olivier Guilyardi <olivier@samalyse.com>,
 *                          Mark Wiesemann <wiesemann@php.net>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *    * Redistributions of source code must retain the above copyright
 *      notice, this list of conditions and the following disclaimer.
 *    * Redistributions in binary form must reproduce the above copyright
 *      notice, this list of conditions and the following disclaimer in the 
 *      documentation and/or other materials provided with the distribution.
 *    * The names of the authors may not be used to endorse or promote products 
 *      derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
 * IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY
 * OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * CSV file id: $Id: DBQuery.php,v 1.27 2007/03/11 14:33:13 wiesemann Exp $
 * 
 * @version  $Revision: 1.27 $
 * @category Structures
 * @package  Structures_DataGrid_DataSource_DBQuery
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 */

require_once 'DB.php';
require_once 'Structures/DataGrid/DataSource.php';

/**
 * PEAR::DB SQL Query Data Source Driver
 *
 * This class is a data source driver for the PEAR::DB object
 *
 * SUPPORTED OPTIONS:
 * 
 * - dbc:         (object) A PEAR::DB instance that will be used by this
 *                         driver. Either this or the 'dsn' option is required.
 * - dsn:         (string) A PEAR::DB dsn string. The DB connection will be
 *                         established by this driver. Either this or the 'dbc'
 *                         option is required.
 * - count_query: (string) Query that calculates the number of rows. See below
 *                         for more information about when such a count query
 *                         is needed.
 * 
 * GENERAL NOTES:
 *
 * You need to specify either a DB instance or a DB compatible dsn string as
 * an option to use this driver.
 * 
 * If you use complex queries (e.g. with complex joins or with aliases),
 * $datagrid->getRecordCount() might return a wrong result. For the case of
 * GROUP BY, UNION, or DISTINCT in your queries, and for the case of subqueries,
 * this driver already has special handling. However, if you observe wrong
 * record counts, you need to specify a special query that returns only the
 * number of records (e.g. 'SELECT COUNT(*) FROM ...') as an additional option
 * 'count_query' to the bind() call.
 * 
 * You can specify an ORDER BY statement in your query. Please be aware that this
 * sorting statement is then used in *every* query before the sorting options
 * that come from a renderer (e.g. by clicking on the column header when using
 * the HTML_Table renderer which is sent in the HTTP request).
 * If you want to give a default sorting statement that is only used if there is
 * no sorting query in the HTTP request, then use $datagrid->setDefaultSort().
 *
 * @version  $Revision: 1.27 $
 * @author   Andrew S. Nagy <asnagy@php.net>
 * @author   Mark Wiesemann <wiesemann@php.net>
 * @author   Olivier Guilyardi <olivier@samalyse.com>
 * @access   public
 * @package  Structures_DataGrid_DataSource_DBQuery
 * @category Structures
 */
class Structures_DataGrid_DataSource_DBQuery
    extends Structures_DataGrid_DataSource
{   
    /**
     * Reference to the PEAR::DB object
     *
     * @var object DB
     * @access private
     */
    var $_db;

    /**
     * The query string
     *
     * @var string
     * @access private
     */
    var $_query;

    /**
     * Fields/directions to sort the data by
     *
     * @var array Structure: array(fieldName => direction, ....)
     * @access private
     */
    var $_sortSpec = array();

    /**
     * Total number of rows 
     * 
     * This property caches the result of count() to avoid running the same
     * database query multiple times.
     *
     * @var int
     * @access private
     */
     var $_rowNum = null;    

    /**
     * Constructor
     *
     * @access public
     */
    function Structures_DataGrid_DataSource_DBQuery()
    {
        parent::Structures_DataGrid_DataSource();
        $this->_addDefaultOptions(array('dbc' => null,
                                        'dsn' => null));
        $this->_setFeatures(array('multiSort' => true));
    }
  
    /**
     * Bind
     *
     * @param   string    $query     The query string
     * @param   mixed     $options   array('dbc' => [PEAR::DB object])
     *                               or
     *                               array('dsn' => [PEAR::DB dsn string])
     * @access  public
     * @return  mixed                True on success, PEAR_Error on failure
     */
    function bind($query, $options = array())
    {
        if ($options) {
            $this->setOptions($options); 
        }

        if (isset($this->_options['dbc']) &&
            DB::isConnection($this->_options['dbc'])) {
            $this->_db = &$this->_options['dbc'];
        } elseif (isset($this->_options['dsn'])) {
            $dbOptions = array();
            if (array_key_exists('db_options', $options)) {
                $dbOptions = $options['db_options'];
            }
            $this->_db =& DB::connect($this->_options['dsn'], $dbOptions);
            if (PEAR::isError($this->_db)) {
                return PEAR::raiseError('Could not create connection: ' .
                                        $this->_db->getMessage() . ', ' .
                                        $this->_db->getUserInfo());
            }
        } else {
            return PEAR::raiseError('No DB object or dsn string specified');
        }

        if (is_string($query)) {
            $this->_query = $query;
            return true;
        } else {
            return PEAR::raiseError('Query parameter must be a string');
        }
    }

    /**
     * Fetch
     *
     * @param   integer $offset     Offset (starting from 0)
     * @param   integer $limit      Limit
     * @access  public
     * @return  mixed               The 2D Array of the records on success,
                                    PEAR_Error on failure
    */
    function &fetch($offset = 0, $limit = null)
    {
        if (!empty($this->_sortSpec)) {
            foreach ($this->_sortSpec as $field => $direction) {
                $sortArray[] = "$field $direction";
            }
            $sortString = join(', ', $sortArray);
        } else {
            $sortString = '';
        }

        $query = $this->_query;

        // drop LIMIT statement
        $query = preg_replace('#\sLIMIT\s.*$#isD', ' ', $query);

        // if we have a sort string, we need to add it to the query string
        if ($sortString != '') {
            // if there is an existing ORDER BY statement, we can just add the
            // sort string
            $result = preg_match('#ORDER\s*BY#is', $query);
            if ($result === 1) {
                $query .= ', ' . $sortString;
            } else {  // otherwise we need to specify 'ORDER BY'
                $query .= ' ORDER BY ' . $sortString;
            }
        }

        if (is_null($limit)) {
            $result = $this->_db->query($query);
        } else {
            $result = $this->_db->limitQuery($query, $offset, $limit);
        }

        if (PEAR::isError($result)) {
            return $result;
        }

        $recordSet = array();

        // Fetch the Data
        if ($numRows = $result->numRows()) {
            while ($result->fetchInto($record, DB_FETCHMODE_ASSOC)) {
                $recordSet[] = $record;
            }
        }

        $result->free();

        // Determine fields to render
        if (!$this->_options['fields'] && count($recordSet)) {
            $this->setOptions(array('fields' => array_keys($recordSet[0])));
        }                

        return $recordSet;
    }

    /**
     * Count
     *
     * @access  public
     * @return  mixed       The number or records (int),
                            PEAR_Error on failure
    */
    function count()
    {
        // do we already have the cached number of records? (if yes, return it)
        if (!is_null($this->_rowNum)) {
            return $this->_rowNum;
        }
        // try to fetch the number of records
        if (array_key_exists('count_query', $this->_options)) {
            // complex queries might require special queries to get the
            // right row count
            $count = $this->_db->getOne($this->_options['count_query']);
            // $count has an integer value with number of rows or is a
            // PEAR_Error instance on failure
        }
        elseif (preg_match('#GROUP\s*BY#is', $this->_query) === 1 ||
                preg_match('#SELECT.*SELECT#is', $this->_query) === 1 ||
                preg_match('#\sUNION\s#is', $this->_query) === 1 ||
                preg_match('#SELECT.*DISTINCT.*FROM#is', $this->_query) === 1
            ) {
            // GROUP BY, DISTINCT, UNION and subqueries are special cases
            // ==> use the normal query and then numRows()
            $result = $this->_db->query($this->_query);
            if (PEAR::isError($result)) {
                return $result;
            }
            $count = $result->numRows();
        } else {
            // don't query the whole table, just get the number of rows
            $query = preg_replace('#SELECT\s.*\sFROM#is',
                                  'SELECT COUNT(*) FROM',
                                  $this->_query);
            $count = $this->_db->getOne($query);
            // $count has an integer value with number of rows or is a
            // PEAR_Error instance on failure
        }
        // if we've got a number of records, save it to avoid running the same
        // query multiple times
        if (!PEAR::isError($count)) {
            $this->_rowNum = $count;
        }
        return $count;
    }
    
    /**
     * This can only be called prior to the fetch method.
     *
     * @access  public
     * @param   mixed   $sortSpec   A single field (string) to sort by, or a 
     *                              sort specification array of the form:
     *                              array(field => direction, ...)
     * @param   string  $sortDir    Sort direction: 'ASC' or 'DESC'
     *                              This is ignored if $sortDesc is an array
     */
    function sort($sortSpec, $sortDir = 'ASC')
    {
        if (is_array($sortSpec)) {
            $this->_sortSpec = $sortSpec;
        } else {
            $this->_sortSpec[$sortSpec] = $sortDir;
        }
    }


}

/* vim: set expandtab tabstop=4 shiftwidth=4: */
?>
