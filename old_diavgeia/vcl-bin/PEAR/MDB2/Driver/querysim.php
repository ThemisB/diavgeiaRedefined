<?php
// vim: set et ts=4 sw=4 fdm=marker:
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Manuel Lemos, Tomas V.V.Cox,                 |
// | Stig. S. Bakken, Lukas Smith                                         |
// | All rights reserved.                                                 |
// +----------------------------------------------------------------------+
// | MDB2 is a merge of PEAR DB and Metabases that provides a unified DB  |
// | API as well as database abstraction for PHP applications.            |
// | This LICENSE is in the BSD license style.                            |
// |                                                                      |
// | Redistribution and use in source and binary forms, with or without   |
// | modification, are permitted provided that the following conditions   |
// | are met:                                                             |
// |                                                                      |
// | Redistributions of source code must retain the above copyright       |
// | notice, this list of conditions and the following disclaimer.        |
// |                                                                      |
// | Redistributions in binary form must reproduce the above copyright    |
// | notice, this list of conditions and the following disclaimer in the  |
// | documentation and/or other materials provided with the distribution. |
// |                                                                      |
// | Neither the name of Manuel Lemos, Tomas V.V.Cox, Stig. S. Bakken,    |
// | Lukas Smith nor the names of his contributors may be used to endorse |
// | or promote products derived from this software without specific prior|
// | written permission.                                                  |
// |                                                                      |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    |
// | FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE      |
// | REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,          |
// | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, |
// | BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS|
// |  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED  |
// | AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT          |
// | LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY|
// | WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE          |
// | POSSIBILITY OF SUCH DAMAGE.                                          |
// +----------------------------------------------------------------------+
// | Original QuerySim Concept & ColdFusion Author: Hal Helms             |
// | <hal.helms@teamallaire.com>                                          |
// | Bert Dawson <bdawson@redbanner.com>                                  |
// +----------------------------------------------------------------------+
// | Original PHP Author: Alan Richmond <arichmond@bigfoot.com>           |
// | David Huyck <b@bombusbee.com>                                        |
// +----------------------------------------------------------------------+
// | Special note concerning code documentation:                          |
// | QuerySim was originally created for use during development of        |
// | applications built using the Fusebox framework. (www.fusebox.org)    |
// | Fusebox uses an XML style of documentation called Fusedoc. (Which    |
// | is admittedly not well suited to documenting classes and functions.  |
// | This short-coming is being addressed by the Fusebox community.) PEAR |
// | uses a Javadoc style of documentation called PHPDoc. (www.phpdoc.de) |
// | Since this class extension spans two groups of users, it is asked    |
// | that the members of each respect the documentation standard of the   |
// | other.  So it is a further requirement that both documentation       |
// | standards be included and maintained. If assistance is required      |
// | please contact Alan Richmond.                                        |
// +----------------------------------------------------------------------+
//
// $Id: querysim.php,v 1.77 2006/10/20 20:14:28 lsmith Exp $
//

/*
<fusedoc fuse="querysim.php" language="PHP">
    <responsibilities>
        I take information and turn it into a recordset that can be accessed
        through the PEAR MDB2 API.  Based on Hal Helms' QuerySim.cfm ColdFusion
        custom tag available at halhelms.com.
    </responsibilities>
    <properties>
        <property name="API" value="PEAR MDB2" />
        <property name="version" value="0.2.1" />
        <property name="status" value="beta" />
        <history author="Hal Helms" email="hal.helms@teamallaire.com" type="Create" />
        <history author="Bert Dawson" email="bdawson@redbanner.com" type="Update">
            Extensive revision that is backwardly compatible but eliminates the
            need for a separate .sim file.
        </history>
        <history author="Alan Richmond" email="arichmond@bigfoot.com" type="Create" date="10-July-2002">
            Rewrote in PHP as an extention to the PEAR DB API.
            Functions supported:
                connect, disconnect, query, fetchRow, freeResult,
                numCols, numRows, getSpecialQuery
            David Huyck (bombusbee.com) added ability to escape special
                characters (i.e., delimiters) using a '\'.
            Extended PEAR DB options[] for adding incoming parameters.  Added
                options:  columnDelim, dataDelim, eolDelim
        </history>
        <history author="David Huyck" email="b@bombusbee.com" type="Update" date="19-July-2002">
            Added the ability to set the QuerySim options at runtime.
            Default options are:
                'columnDelim' => ',',            // Commas split the column names
                'dataDelim'   => '|',            // Pipes split the data fields
                'eolDelim'    => chr(13).chr(10) // Carriage returns split the
                                                 // lines of data
            Affected functions are:
                DB_querysim():          set the default options when the
                                        constructor method is called
                _parseQuerySim($query): altered the parsing of lines, column
                                        names, and data fields
                _empty2null:            altered the way this function is called
                                        to simplify calling it
        </history>
        <history author="Alan Richmond" email="arichmond@bigfoot.com" type="Update" date="24-July-2002">
            Added error catching for malformed QuerySim text.
            Bug fix _empty2null():  altered version was returning unmodified
                                    lineData.
            Cleanup:
                PEAR compliant formatting, finished PHPDocs and added 'out' to
                Fusedoc 'io'.
                Broke up _parseQuerySim() into _buildResult() and _parseOnDelim()
                to containerize duplicate parse code.
        </history>
        <history author="David Huyck" email="b@bombusbee.com" type="Update" date="25-July-2002">
            Edited the _buildResult() and _parseOnDelim() functions to improve
            reliability of special character escaping.
            Re-introduced a custom setOption() method to throw an error when a
            person tries to set one of the delimiters to '\'.
        </history>
        <history author="Alan Richmond" email="arichmond@bigfoot.com" type="Update" date="27-July-2002">
            Added '/' delimiter param to preg_quote() in _empty2null() and
            _parseOnDelim() so '/' can be used as a delimiter.
            Added error check for columnDelim == eolDelim or dataDelim == eolDelim.
            Renamed some variables for consistancy.
        </history>
        <history author="Alan Richmond" email="arichmond@bigfoot.com" type="Update" date="30-July-2002">
            Removed protected function _empty2null().  Turns out preg_split()
            deals with empty elemants by making them zero length strings, just
            what they ended up being anyway.  This should speed things up a little.
            Affected functions:
                _parseOnDelim()     perform trim on line here, instead of in
                                    _empty2null().
                _buildResult()      remove call to _empty2null().
                _empty2null()       removed function.
        </history>
        <history author="Alan Richmond" email="arichmond@bigfoot.com" type="Update" date="1-Jan-2003">
            Ported to PEAR MDB2.
            Methods supported:
                connect, query, getColumnNames, numCols, valid, fetch,
                numRows, free, fetchRow, nextResult, setLimit
                (inherited).
        </history>
        <history
            Removed array_change_key_case() work around for <4.2.0 in
            getColumnNames(), found it already done in MDB2/Common.php.
        </history>
        <history author="Alan Richmond" email="arichmond@bigfoot.com" type="Update" date="3-Feb-2003">
            Changed default eolDelim to a *nix file eol, since we're trimming
            the result anyway, it makes no difference for Windows.  Now only
            Mac file eols should need to be set (and other kinds of chars).
        </history>
        <note author="Alan Richmond">
            Got WAY too long.  See querysim_readme.txt for instructions and some
            examples.
            io section only documents elements of DB_result that DB_querysim uses,
            adds or changes; see MDB2 and MDB2_Driver_Common for more info.
            io section uses some elements that are not Fusedoc 2.0 compliant:
            object and resource.
        </note>
    </properties>
    <io>
        <in>
            <file path="MDB2/Common.php" action="require_once" />
        </in>
        <out>
            <object name="MDB2_querysim" extends="MDB2_Driver_Common" instantiatedby="MDB2::connect()">
                <resource type="file" name="connection" oncondition="source is external file" scope="class" />
                <string name="phptype" default="querysim" />
                <string name="dbsyntax" default="querysim" />
                <array name="supported" comments="most of these don't actually do anything, they are enabled to simulate the option being available if checked">
                    <boolean name="sequences" default="true" />
                    <boolean name="indexes" default="true" />
                    <boolean name="affected_rows" default="true" />
                    <boolean name="summary_functions" default="true" />
                    <boolean name="order_by_text" default="true" />
                    <boolean name="current_id" default="true" />
                    <boolean name="limit_querys" default="true" comments="this one is functional" />
                    <boolean name="LOBs" default="true" />
                    <boolean name="replace" default="true" />
                    <boolean name="sub_selects" default="true" />
                    <boolean name="transactions" default="true" />
                </array>
                <string name="last_query" comments="last value passed in with query()" />
                <array name="options" comments="these can be changed at run time">
                    <string name="columnDelim" default="," />
                    <string name="dataDelim" default="|" />
                    <string name="eolDelim" default="chr(13).chr(10)" />
                </array>
            </object>
            <array name="result" comments="the simulated record set returned by ::query()">
                <array comments="columns">
                    <string comments="column name" />
                </array>
                <array comments="data">
                    <array comments="row">
                        <string comments="data element" />
                    </array>
                </array>
            </array>
        </out>
    </io>
</fusedoc>
*/

/**
 * MDB2 QuerySim driver
 *
 * @package MDB2
 * @category Database
 * @author  Alan Richmond <arichmond@bigfoot.com>
 */
class MDB2_Driver_querysim extends MDB2_Driver_Common
{
    // }}}
    // {{{ constructor

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->phptype  = 'querysim';
        $this->dbsyntax = 'querysim';

        // Most of these are dummies to simulate availability if checked
        $this->supported['sequences'] = false;
        $this->supported['indexes'] = false;
        $this->supported['affected_rows'] = false;
        $this->supported['summary_functions'] = false;
        $this->supported['order_by_text'] = false;
        $this->supported['current_id'] = false;
        $this->supported['limit_queries'] = true;// this one is real
        $this->supported['LOBs'] = true;
        $this->supported['replace'] = false;
        $this->supported['sub_selects'] = false;
        $this->supported['transactions'] = false;
        $this->supported['savepoints'] = false;
        $this->supported['auto_increment'] = false;
        $this->supported['primary_key'] = false;
        $this->supported['result_introspection'] = false; // not implemented
        $this->supported['prepared_statements'] = false;
        $this->supported['identifier_quoting'] = false;
        $this->supported['pattern_escaping'] = false;
        $this->supported['new_link'] = false;

        $this->options['columnDelim'] = ',';
        $this->options['dataDelim'] = '|';
        $this->options['eolDelim'] = "\n";
    }

    // }}}
    // {{{ connect()

    /**
     * Open a file or simulate a successful database connect
     *
     * @access public
     *
     * @return mixed MDB2_OK string on success, a MDB2 error object on failure
     */
    function connect()
    {
        if (is_resource($this->connection)) {
            if ($this->connected_database_name == $this->database_name
                && ($this->opened_persistent == $this->options['persistent'])
            ) {
                return MDB2_OK;
            }
            if ($this->connected_database_name) {
                $this->_close($this->connection);
            }
            $this->disconnect();
        }

        $connection = 1;// sim connect
        // if external, check file...
        if ($this->database_name) {
            $file = $this->database_name;
            if (!file_exists($file)) {
                return $this->raiseError(MDB2_ERROR_NOT_FOUND, null, null,
                    'file not found', __FUNCTION__);
            }
            if (!is_file($file)) {
                return $this->raiseError(MDB2_ERROR_INVALID, null, null,
                    'not a file', __FUNCTION__);
            }
            if (!is_readable($file)) {
                return $this->raiseError(MDB2_ERROR_ACCESS_VIOLATION, null, null,
                    'could not open file - check permissions', __FUNCTION__);
            }
            // ...and open if persistent
            if ($this->options['persistent']) {
                $connection = @fopen($file, 'r');
            }
        }

        if (!empty($this->dsn['charset'])) {
            $result = $this->setCharset($this->dsn['charset'], $connection);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        $this->connection = $connection;
        $this->connected_database_name = $this->database_name;
        $this->opened_persistent = $this->options['persistent'];
        $this->dbsyntax = $this->dsn['dbsyntax'] ? $this->dsn['dbsyntax'] : $this->phptype;

        return MDB2_OK;
    }

    // }}}
    // {{{ disconnect()

    /**
     * Log out and disconnect from the database.
     *
     * @param  boolean $force if the disconnect should be forced even if the
     *                        connection is opened persistently
     * @return mixed true on success, false if not connected and error
     *                object on error
     * @access public
     */
    function disconnect($force = true)
    {
        if (is_resource($this->connection)) {
            if ($this->opened_persistent) {
                @fclose($this->connection);
            }
        }
        return parent::disconnect($force);
    }

    // }}}
    // {{{ _doQuery()

    /**
     * Execute a query
     * @param string $query  query
     * @param boolean $is_manip  if the query is a manipulation query
     * @param resource $connection
     * @param string $database_name
     * @return result or error object
     * @access protected
     */
    function &_doQuery($query, $is_manip = false, $connection = null, $database_name = null)
    {
        if ($this->database_name) {
            $query = $this->_readFile();
        }
        $this->last_query = $query;
        $result = $this->debug($query, 'query', array('is_manip' => $is_manip, 'when' => 'pre'));
        if ($result) {
            if (PEAR::isError($result)) {
                return $result;
            }
            $query = $result;
        }
        if ($is_manip) {
            $err =& $this->raiseError(MDB2_ERROR_UNSUPPORTED, null, null,
                'Manipulation statements are not supported', __FUNCTION__);
            return $err;
        }
        if ($this->options['disable_query']) {
            $result = $is_manip ? 0 : null;
            return $result;
        }

        $result = $this->_buildResult($query);
        if (PEAR::isError($result)) {
            return $result;
        }

        if ($this->next_limit > 0) {
            $result[1] = array_slice($result[1], $this->next_offset, $this->next_limit);
        }

        $this->debug($query, 'query', array('is_manip' => $is_manip, 'when' => 'post', 'result' => $result));
        return $result;
    }

    // }}}
    // {{{ _modifyQuery()

    /**
     * Changes a query string for various DBMS specific reasons
     *
     * @param string $query  query to modify
     * @param boolean $is_manip  if it is a DML query
     * @param integer $limit  limit the number of rows
     * @param integer $offset  start reading from given offset
     * @return string modified query
     * @access protected
     */
    function _modifyQuery($query, $is_manip, $limit, $offset)
    {
        $this->next_limit = $limit;
        $this->next_offset = $offset;
        return $query;
    }

    // }}}
    // {{{ _readFile()

    /**
     * Read an external file
     *
     * @param string filepath/filename
     *
     * @access protected
     *
     * @return string the contents of a file
     */
    function _readFile()
    {
        $buffer = '';
        if ($this->opened_persistent) {
            $connection = $this->getConnection();
            if (PEAR::isError($connection)) {
                return $connection;
            }
            while (!feof($connection)) {
                $buffer.= fgets($connection, 1024);
            }
            rewind($connection);
        } else {
            $connection = @fopen($this->connected_database_name, 'r');
            while (!feof($connection)) {
                $buffer.= fgets($connection, 1024);
            }
            @fclose($connection);
        }
        return $buffer;
    }

    // }}}
    // {{{ _buildResult()

    /**
     * Convert QuerySim text into an array
     *
     * @param string Text of simulated query
     *
     * @access protected
     *
     * @return multi-dimensional array containing the column names and data
     *                                 from the QuerySim
     */
    function _buildResult($query)
    {
        $eolDelim    = $this->options['eolDelim'];
        $columnDelim = $this->options['columnDelim'];
        $dataDelim   = $this->options['dataDelim'];

        $columnNames = array();
        $data        = array();

        if ($columnDelim == $eolDelim) {
            return $this->raiseError(MDB2_ERROR_INVALID, null, null,
                'columnDelim and eolDelim must be different', __FUNCTION__);
        } elseif ($dataDelim == $eolDelim){
            return $this->raiseError(MDB2_ERROR_INVALID, null, null,
                'dataDelim and eolDelim must be different', __FUNCTION__);
        }

        $query = trim($query);
        //tokenize escaped slashes
        $query = str_replace('\\\\', '[$double-slash$]', $query);

        if (!strlen($query)) {
            return $this->raiseError(MDB2_ERROR_SYNTAX, null, null,
                'empty querysim text', __FUNCTION__);
        }
        $lineData = $this->_parseOnDelim($query, $eolDelim);
        //kill the empty last row created by final eol char if it exists
        if (!strlen(trim($lineData[count($lineData) - 1]))) {
            unset($lineData[count($lineData) - 1]);
        }
        //populate columnNames array
        $thisLine = each($lineData);
        $columnNames = $this->_parseOnDelim($thisLine[1], $columnDelim);
        if ((in_array('', $columnNames)) || (in_array('NULL', $columnNames))) {
            return $this->raiseError(MDB2_ERROR_SYNTAX, null, null,
                'all column names must be defined', __FUNCTION__);
        }
        //replace double-slash tokens with single-slash
        $columnNames = str_replace('[$double-slash$]', '\\', $columnNames);
        $columnCount = count($columnNames);
        $rowNum = 0;
        //loop through data lines
        if (count($lineData) > 1) {
            while ($thisLine = each($lineData)) {
                $thisData = $this->_parseOnDelim($thisLine[1], $dataDelim);
                $thisDataCount = count($thisData);
                if ($thisDataCount != $columnCount) {
                    $fileLineNo = $rowNum + 2;
                    return $this->raiseError(MDB2_ERROR_SYNTAX, null, null,
                        "number of data elements ($thisDataCount) in line $fileLineNo not equal to number of defined columns ($columnCount)", __FUNCTION__);
                }
                //loop through data elements in data line
                foreach ($thisData as $thisElement) {
                    if (strtoupper($thisElement) == 'NULL'){
                        $thisElement = '';
                    }
                    //replace double-slash tokens with single-slash
                    $data[$rowNum][] = str_replace('[$double-slash$]', '\\', $thisElement);
                }//end foreach
                ++$rowNum;
            }//end while
        }//end if
        return array($columnNames, $data);
    }

    // }}}
    // {{{ _parseOnDelim()

    /**
     * Split QuerySim string into an array on a delimiter
     *
     * @param string $thisLine Text of simulated query
     * @param string $delim    The delimiter to split on
     *
     * @access protected
     *
     * @return array containing parsed string
     */
    function _parseOnDelim($thisLine, $delim)
    {
        $delimQuoted = preg_quote($delim, '/');
        $thisLine = trim($thisLine);

        $parsed = preg_split('/(?<!\\\\)' .$delimQuoted. '/', $thisLine);
        //replaces escaped delimiters
        $parsed = preg_replace('/\\\\' .$delimQuoted. '/', $delim, $parsed);
        if ($delim != $this->options['eolDelim']) {
            //replaces escape chars
            $parsed = preg_replace('/\\\\/', '', $parsed);
        }
        return $parsed;
    }

    // }}}
    // {{{ exec()

    /**
     * Execute a manipulation query to the database and return any the affected rows
     *
     * @param string $query the SQL query
     * @return mixed affected rows on success, a MDB2 error on failure
     * @access public
     */
    function exec($query)
    {
        return $this->raiseError(MDB2_ERROR_UNSUPPORTED, null, null,
            'Querysim only supports reading data', __FUNCTION__);
    }

    // }}}
    // {{{ getServerVersion()

    /**
     * return version information about the server
     *
     * @param string     $native  determines if the raw version string should be returned
     * @return mixed array/string with version information or MDB2 error object
     * @access public
     */
    function getServerVersion($native = false)
    {
        $server_info = '0.6.0';
        // cache server_info
        $this->connected_server_info = $server_info;
        if (!$native) {
            $tmp = explode('.', $server_info, 3);
            if (!isset($tmp[2]) || !preg_match('/(\d+)(.*)/', $tmp[2], $tmp2)) {
                $tmp2[0] = isset($tmp[2]) ? $tmp[2] : null;
                $tmp2[1] = null;
            }
            $server_info = array(
                'major' => isset($tmp[0]) ? $tmp[0] : null,
                'minor' => isset($tmp[1]) ? $tmp[1] : null,
                'patch' => isset($tmp2[0]) ? $tmp2[0] : null,
                'extra' => isset($tmp2[1]) ? $tmp2[1] : null,
                'native' => $server_info,
            );
        }
        return $server_info;
    }
}

/**
 * MDB2 QuerySim result driver
 *
 * @package MDB2
 * @category Database
 * @author  Alan Richmond <arichmond@bigfoot.com>
 */
class MDB2_Result_querysim extends MDB2_Result_Common
{
    // }}}
    // {{{ fetchRow()

    /**
     * Fetch a row and insert the data into an existing array.
     *
     * @param int       $fetchmode  how the array data should be indexed
     * @param int    $rownum    number of the row where the data can be found
     * @return int data array on success, a MDB2 error on failure
     * @access public
     */
    function &fetchRow($fetchmode = MDB2_FETCHMODE_DEFAULT, $rownum = null)
    {
        if ($this->result === false) {
            $err =& $this->db->raiseError(MDB2_ERROR_NEED_MORE_DATA, null, null,
                'resultset has already been freed', __FUNCTION__);
            return $err;
        } elseif (is_null($this->result)) {
            return null;
        }
        if (!is_null($rownum)) {
            $seek = $this->seek($rownum);
            if (PEAR::isError($seek)) {
                return $seek;
            }
        }
        $target_rownum = $this->rownum + 1;
        if ($fetchmode == MDB2_FETCHMODE_DEFAULT) {
            $fetchmode = $this->db->fetchmode;
        }
        if (!isset($this->result[1][$target_rownum])) {
            $null = null;
            return $null;
        }
        $row = $this->result[1][$target_rownum];
        // make row associative
        if ($fetchmode & MDB2_FETCHMODE_ASSOC) {
            $column_names = $this->getColumnNames();
            foreach ($column_names as $name => $i) {
                $column_names[$name] = $row[$i];
            }
            $row = $column_names;
        }
        $mode = $this->db->options['portability'] & MDB2_PORTABILITY_EMPTY_TO_NULL;
        $rtrim = false;
        if ($this->db->options['portability'] & MDB2_PORTABILITY_RTRIM) {
            if (empty($this->types)) {
                $mode += MDB2_PORTABILITY_RTRIM;
            } else {
                $rtrim = true;
            }
        }
        if ($mode) {
            $this->db->_fixResultArrayValues($row, $mode);
        }
        if (!empty($this->types)) {
            $row = $this->db->datatype->convertResultRow($this->types, $row, $rtrim);
        }
        if (!empty($this->values)) {
            $this->_assignBindColumns($row);
        }
        if ($fetchmode === MDB2_FETCHMODE_OBJECT) {
            $object_class = $this->db->options['fetch_class'];
            if ($object_class == 'stdClass') {
                $row = (object) $row;
            } else {
                $row = &new $object_class($row);
            }
        }
        ++$this->rownum;
        return $row;
    }

    // }}}
    // {{{ _getColumnNames()

    /**
     * Retrieve the names of columns returned by the DBMS in a query result.
     *
     * @return  mixed   Array variable that holds the names of columns as keys
     *                  or an MDB2 error on failure.
     *                  Some DBMS may not return any columns when the result set
     *                  does not contain any rows.
     * @access private
     */
    function _getColumnNames()
    {
        if ($this->result === false) {
            return $this->db->raiseError(MDB2_ERROR_NEED_MORE_DATA, null, null,
                'resultset has already been freed', __FUNCTION__);
        } elseif (is_null($this->result)) {
            return array();
        }
        $columns = array_flip($this->result[0]);
        if ($this->db->options['portability'] & MDB2_PORTABILITY_FIX_CASE) {
            $columns = array_change_key_case($columns, $this->db->options['field_case']);
        }
        return $columns;
    }

    // }}}
    // {{{ numCols()

    /**
     * Count the number of columns returned by the DBMS in a query result.
     *
     * @access public
     * @return mixed integer value with the number of columns, a MDB2 error
     *                       on failure
     */
    function numCols()
    {
        if ($this->result === false) {
            return $this->db->raiseError(MDB2_ERROR_NEED_MORE_DATA, null, null,
                'resultset has already been freed', __FUNCTION__);
        } elseif (is_null($this->result)) {
            return count($this->types);
        }
        $cols = count($this->result[0]);
        return $cols;
    }
}

/**
 * MDB2 QuerySim buffered result driver
 *
 * @package MDB2
 * @category Database
 * @author  Alan Richmond <arichmond@bigfoot.com>
 */
class MDB2_BufferedResult_querysim extends MDB2_Result_querysim
{
    // }}}
    // {{{ seek()

    /**
     * Seek to a specific row in a result set
     *
     * @param int    $rownum    number of the row where the data can be found
     * @return mixed MDB2_OK on success, a MDB2 error on failure
     * @access public
     */
    function seek($rownum = 0)
    {
        if ($this->result === false) {
            return $this->db->raiseError(MDB2_ERROR_NEED_MORE_DATA, null, null,
                'resultset has already been freed', __FUNCTION__);
        }
        $this->rownum = $rownum - 1;
        return MDB2_OK;
    }

    // }}}
    // {{{ valid()

    /**
     * Check if the end of the result set has been reached
     *
     * @return mixed true or false on sucess, a MDB2 error on failure
     * @access public
     */
    function valid()
    {
        $numrows = $this->numRows();
        if (PEAR::isError($numrows)) {
            return $numrows;
        }
        return $this->rownum < ($numrows - 1);
    }

    // }}}
    // {{{ numRows()

    /**
     * Returns the number of rows in a result object
     *
     * @return mixed MDB2 Error Object or the number of rows
     * @access public
     */
    function numRows()
    {
        if ($this->result === false) {
            return $this->db->raiseError(MDB2_ERROR_NEED_MORE_DATA, null, null,
                'resultset has already been freed', __FUNCTION__);
        } elseif (is_null($this->result)) {
            return 0;
        }
        $rows = count($this->result[1]);
        return $rows;
    }
}

/**
 * MDB2 QuerySim statement driver
 *
 * @package MDB2
 * @category Database
 * @author  Alan Richmond <arichmond@bigfoot.com>
 */
class MDB2_Statement_querysim extends MDB2_Statement_Common
{

}

?>