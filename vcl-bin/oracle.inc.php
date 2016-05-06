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

use_unit("classes.inc.php");
use_unit("controls.inc.php");
use_unit("db.inc.php");

/**
 * OracleDatabase provides discrete control over a connection to a single Oracle database in a database application.
 *
 * Use OracleDatabase to specify the connection information so OracleDataset components can connect to the
 * database.
 *
 * @link http://www.php.net/manual/en/ref.Oracle.php
 */
class OracleDatabase extends CustomConnection
{
        public $_connection=null;
        protected $_debug=0;
        protected $_databasename="";
        protected $_host="";
        protected $_username="";
        protected $_userpassword="";
        protected $_connected="0";
        protected $_dictionary="";
        protected $_dictionaryproperties=false;

        var $_connectionID = false; /// The returned link identifier whenever a successful database connection is made. #unused on current version
        var $autoRollback = false; // autoRollback on connection
        //var $connectSID = false;
        var $connectSID = true;
        var $_initdate = true;
        var $NLS_DATE_FORMAT = 'YYYY-MM-DD';  // To include time, use 'RRRR-MM-DD HH24:MI:SS'

        var $firstrows = true; // enable first rows optimization on SelectLimit()
        var $selectOffsetAlg1 = 100; // when to use 1st algorithm of selectlimit.
        var $databaseType = 'oci8';

        //Charset property
        protected $_charset="";
        function getCharset() { return $this->_charset; }
        function setCharset($value) { $this->_charset=$value; }
        function defaultCharset() { return ""; }

        protected $_usesid = 0;
        function getUseSID()          { return $this->readUseSID(); }
        function setUseSID($value)    { $this->writeUseSID($value); }

        function readUseSID()           { return $this->_usesid; }
        function writeUseSID($value)    { $this->_usesid=$value; }
        function defaultUseSID()        { return 0; }


        //For Autocommit
        protected $autoCommit = true;
/*
        function getAutoCommit()          { return $this->readAutoCommit(); }
        function setAutoCommit($value)    { $this->writeAutoCommit($value); }

        function readAutoCommit()           { return $this->_autocommit; }
        function writeAutoCommit($value)    { $this->_autocommit=$value; }
        function defaultAutoCommit()        { return 1; }
*/
        function MetaFields($tablename)
        {
            $metaColumnsSQL = "SHOW COLUMNS FROM `%s`";

            $rs = $this->execute(sprintf($metaColumnsSQL,strtoupper($tablename)));
            $result=array();

            while ($row=oci_fetch_row($rs))
            {
                $result[$row[0]]='';
            }
            return($result);
        }

        function BeginTrans()
        {
          $this->autoCommit = false;
        }

        function CompleteTrans($ok=true)
        {
            if ($this->autoCommit) return true;

            if (!$ok)
            {
              $this->RollbackTrans();
              return;
            }

            $ret = oci_commit($this->_connection);

            if (!$ret)
            {
              $err = oci_error($this->_connection);
              DatabaseError('Commit failed: ' . $err['message']);
            }

            $this->autoCommit = true;
            return $ret;  //true = success / false = fail
        }


        function RollbackTrans()
        {
          if ($this->autoCommit) return true;

          $ret = oci_rollback($this->_connection);
          if (!$ret)
          {
            $err = oci_error($this->_connection);
            DatabaseError('Rollback failed: ' . $err['message']);
          }
          $this->autoCommit = true;
          return $ret;
        }

        function readConnected() { if ($this->_connection!=null) return("1"); else return("0"); }
        function getConnected() { return $this->readconnected(); }
        function setConnected($value) { $this->writeconnected($value); }

        /**
        * Sets the debug information provided by the component.
        *
        * Use this property, when set to true, to get more information about
        * the connection process to address any issue you get.
        *
        * @return boolean
        */
        function getDebug() { return $this->_debug; }
        function setDebug($value) { $this->_debug=$value; }
        function defaultDebug() { return 0; }

        /**
        * Specifies the tablename on this database that holds dictionary information
        *
        * A dictionary is a set of information about each field of each table, which
        * data-aware components use to show information about the table in a human-readable
        * format, for example, the title for each field, the width for a column, etc
        *
        * @return string
        */
        function getDictionary() { return $this->_dictionary;   }
        function setDictionary($value) { $this->_dictionary=$value; }

        /**
        * Specifies the name of the database to associate with this database component.
        *
        * Use DatabaseName to specify the name of the database to use with a database
        * component.
        *
        * Note: Setting DatabaseName when the Connected property is true requires you to close and reopen the database.
        *
        * @return string
        */
        function getDatabaseName() { return $this->_databasename;       }
        function setDatabaseName($value) { $this->_databasename=$value; }

        /**
        * This properties specifies where to find the server to connect to.
        *
        * Use this property to set the host that runs the server you want to connect to.
        *
        * @return string
        */
        function getHost() { return $this->_host;       }
        function setHost($value) { $this->_host=$value; }

        /**
        * The username you want to use to connect to the database server.
        *
        * Set this property with the name of the user you want to use to connect
        * to the database server.
        *
        * @return string
        */
        function getUserName() { return $this->_username;       }
        function setUserName($value) { $this->_username=$value; }

        /**
        * The password for the username you want to use to connect to the database server.
        *
        * Set this property with the password for the user you want to use to connect
        * to the database server.
        *
        * @return string
        */
        function getUserPassword() { return $this->_userpassword;       }
        function setUserPassword($value) { $this->_userpassword=$value; }

        function getOnAfterConnect() { return $this->readonafterconnect(); }
        function setOnAfterConnect($value) { $this->writeonafterconnect($value); }

        function getOnBeforeConnect() { return $this->readonbeforeconnect(); }
        function setOnBeforeConnect($value) { $this->writeonbeforeconnect($value); }

        function getOnAfterDisconnect() { return $this->readonafterdisconnect(); }
        function setOnAfterDisconnect($value) { $this->writeonafterdisconnect($value); }

        function getOnBeforeDisconnect() { return $this->readonbeforedisconnect(); }
        function setOnBeforeDisconnect($value) { $this->writeonbeforedisconnect($value); }

        protected $_dialect=3;

        /**
        * Specifies the dialect to be used when connecting to the server
        *
        * Reserved for future use.
        *
        * @return string
        */
        function getDialect() { return $this->_dialect; }
        function setDialect($value) { $this->_dialect=$value; }
        function defaultDialect() { return 3; }


        /**
        * Prepares a query to be executed and performs parameter optimizations
        *
        * Example of usage:
        * <code>
        * $stmt = $this->Prepare('insert into emp (empno, ename) values (:empno, :ename)');
        * </code>
        */
        function Prepare($query, $cursor=false)
        {
          if (!$this->_connection) { return null; }

          static $BINDNUM = 0;

          $stmt = oci_parse($this->_connection,$query);

          if (!$stmt) return false;

          $BINDNUM += 1;

          $sttype = @oci_statement_type($stmt);

          if ($sttype == 'BEGIN' || $sttype == 'DECLARE')
          {
            return array($query,$stmt,0,$BINDNUM, ($cursor) ? oci_new_cursor($this->_connection) : false);
          }
          return array($query,$stmt,0,$BINDNUM);

        }

        function PrepareSP($query)
        {
            // Not implemented
            // ibase_prepare($this->_connection, $query);
        }

        function DBDate($input)
        {
            return(date('%Y-%m-%d',strtotime($input)));
        }

        function Param($input)
        {
            return($this->QuoteStr($input));
        }

        function QuoteStr($input)
        {
            return("'$input'");
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function Checkbind($sql,$params)
        {
         //check bind here

        }

        function Dobind($rset, &$params)
        {
          foreach($params as $k => $v)
          {
            $len = -1;
            if ($v === ' ') $len = 1;
            oci_bind_by_name($rset,":$k",$params[$k],$len);

          }

        }


        /**
         * Executes a query on the database
         *
         * Use this method to execute an SQL sentence on the database server
         *
         * @param string $query Query to execute
         * @param array $params Not used
         * @return object
         */
        function execute($query,&$params=array())
        {
                $this->open();

                $rs = oci_parse($this->_connection,$query);

                if (!empty($params))
                {
                  //bind
                  $this->Dobind($rs,$params);
                }
                if (!$this->autoCommit)
                {
                  oci_execute($rs,OCI_DEFAULT);
                }
                else
                {
                  oci_execute($rs);
                }

                if ($rs===false)
                {
                        DatabaseError("Error executing query: $query [".oci_error($this->_connection)."]");
                }

                $tmp = strtoupper($query);
                if (substr($tmp,0,6) == 'SELECT')
                {
                  return($rs);
                }
                else { return; }
        }

        /**
         * Executes a limited query on the database
         *
         * Use this method to execute an SQL sentence on the database server using LIMIT clause.
         *
         * @param string $query Query to execute
         * @param integer $lmtcount Rows to get
         * @param integer $lmtstart First row to start counting
         * @param array $params Parameters to use on the query
         * @return object
         */
        function executelimit($query,$lmtcount,$lmtstart,$params=array())
        {
                $this->open();
                $rs=$this->ExecuteSelectLimit($query,$lmtcount,$lmtstart, $params);
                if ($rs==null)
                {
                        DatabaseError("Error executing query: $query [".$this->_connection->ErrorMsg()."]");
                }
                return($rs);
        }


        /// Algorithm by adodb-oci8.inc.php(SelectLimit function)
        function &ExecuteSelectLimit($sql,$lmtcount=-1,$lmtstart=-1, $inputarr=false)
        {

          if ($this->firstrows)
          {
            if (strpos($sql,'/*+') !== false)
              $sql = str_replace('/*+ ','/*+FIRST_ROWS ',$sql);
            else
              $sql = preg_replace('/^[ \t\n]*select/i','SELECT /*+FIRST_ROWS*/',$sql);
          }

          // Algorithm by Tomas V V Cox, from PEAR DB oci8.php
          // Let Oracle return the name of the columns
          $q_fields = "SELECT * FROM (".$sql.") WHERE NULL = NULL";

          $false = false;
          if (! $stmt_arr = $this->Prepare($q_fields))
          {
            return $false;
          }
          $stmt = $stmt_arr[1];


          if (is_array($inputarr))
          {

            $this->Dobind($stmt,$inputarr);

          }
          if (!oci_execute($stmt, OCI_DEFAULT))
          {
            oci_free_statement($stmt);
            return $false;
          }

          $ncols = oci_num_fields($stmt);
          for ( $i = 1; $i <= $ncols; $i++ )
          {
            $cols[] = '"'.oci_field_name($stmt, $i).'"';
          }
          $result = false;

          oci_free_statement($stmt);
          $fields = implode(',', $cols);
          $lmtcount += $lmtstart;
          $lmtstart += 1; // in Oracle rownum starts at 1

          if ($this->databaseType == 'oci8po')
          {
            $sql = "SELECT $fields FROM".
                   "(SELECT rownum as orcl_rownum, $fields FROM".
                   " ($sql) WHERE rownum <= ?".
                   ") WHERE orcl_rownum >= ?";
          }
          else
          {
            $sql = "SELECT $fields FROM".
                   "(SELECT rownum as orcl_rownum, $fields FROM".
                   " ($sql) WHERE rownum <= :orcl_lmtcount".
                   ") WHERE orcl_rownum >= :orcl_lmtstart";
          }
          $inputarr['orcl_lmtcount'] = $lmtcount;
          $inputarr['orcl_lmtstart'] = $lmtstart;
          $rs = $this->execute($sql,$inputarr);
          return $rs;

        }


        function executecursor($query,&$par=array(),$cursorname)
        {
          $procbind = false;
          $this->open();

          //procedure type
          $curs = oci_new_cursor($this->_connection);
          $stmt = oci_parse($this->_connection,$query);
          foreach($par as $k => $v)
          {
            $len = -1;
            if ($v === ' ') $len = 1;
            if ($par[$k] === $cursorname)
            {
              //cursor bind
              oci_bind_by_name($stmt, ":$k", $curs, $len, OCI_B_CURSOR);
              $procbind = true;
            }
            else
            {
              oci_bind_by_name($stmt,":$k",$par[$k],$len);
            }
          }

          //function type
          if ($procbind == false)
          {
            oci_bind_by_name($stmt,$cursorname, $curs, $len, OCI_B_CURSOR);
          }

          oci_execute($stmt);
          oci_execute($curs);

          if ($stmt == false || $curs == false)
          {
            DatabaseError("Error executing query: $query [".oci_error($this->_connection)."]");
          }
          oci_free_statement($stmt);
          return($curs);

        }

        function DoConnect()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                //$this->_connection = oci_connect($this->UserName, $this->UserPassword,$this->DatabaseName);
                $this->connect_oci8($this->Host, $this->UserName, $this->UserPassword, $this->DatabaseName);

                if (!$this->_connection)
                {
                    DatabaseError("Cannot connect to database server");
                }
            }
        }
        //There are 3 connection modes, 0 = non-persistent, 1 = persistent, 2 = force new connection
        function connect_oci8($argHostname, $argUsername, $argPassword, $argDatabasename,$mode=0)
        {
          //Algorithm by adodb-oci8.inc.php

          if($argHostname)
          { // added by Jorma Tuomainen <jorma.tuomainen@ppoy.fi>
            if (empty($argDatabasename)) $argDatabasename = $argHostname;
            else
            {
              if(strpos($argHostname,":"))
              {
                $argHostinfo=explode(":",$argHostname);
                $argHostname=$argHostinfo[0];
                $argHostport=$argHostinfo[1];
              }
              else
              {
                $argHostport = empty($this->port)?  "1521" : $this->port;
              }

              if ($this->_usesid)
              {
                $argDatabasename="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=".$argHostname
                .")(PORT=$argHostport))(CONNECT_DATA=(SID=$argDatabasename)))";
              }
              else
                $argDatabasename="(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=".$argHostname
                .")(PORT=$argHostport))(CONNECT_DATA=(SERVICE_NAME=$argDatabasename)))";
            }
          }

          //if ($argHostname) print "<p>Connect: 1st argument should be left blank for $this->databaseType</p>";
          if ($mode==1)
          {
            //if(trim($this->Charset)!='') $this->_connection->charSet=$this->Charset;

            //$this->_connection = ($this->Charset) ?
            if(trim($this->Charset)!='')
            {
              $this->_connection = oci_connect($argUsername,$argPassword, $argDatabasename, $this->Charset);
            }
            else
            {
              $this->_connection = oci_connect($argUsername,$argPassword, $argDatabasename);
            }
            if ($this->_connection && $this->autoRollback)  oci_rollback($this->_connection);
          }
          else if ($mode==2)
          {
            if(trim($this->Charset)!='')
            {
              $this->_connection = oci_connect($argUsername,$argPassword, $argDatabasename, $this->Charset);
            }
            {
              $this->_connection = oci_connect($argUsername,$argPassword, $argDatabasename);
            }
          }
          else
          {
            if(trim($this->Charset)!='')
            {
              $this->_connection = oci_connect($argUsername,$argPassword, $argDatabasename, $this->Charset);
            }
            else
            {
              $this->_connection = oci_connect($argUsername,$argPassword, $argDatabasename);
            }
          }
          if (!$this->_connection) return false;
          if ($this->_initdate)
          {
            $this->Execute("ALTER SESSION SET NLS_DATE_FORMAT='".$this->NLS_DATE_FORMAT."'");
          }

        // looks like:
        // Oracle8i Enterprise Edition Release 8.1.7.0.0 - Production With the Partitioning option JServer Release 8.1.7.0.0 - Production
        // $vers = OCIServerVersion($this->_connectionID);
        // if (strpos($vers,'8i') !== false) $this->ansiOuter = true;
          return true;
        }


        function DoDisconnect()
        {

                if ($this->_connection!=null)
                {       oci_free_statement($this->_rs);
                        oci_close($this->_connection);
                }
        }


        /**
         * Return properties for a field
         *
         * @param string $table
         * @param string $field
         * @return array
         */
        function readFieldDictionaryProperties($table, $field)
        {
                $table=trim($table);
                $field=trim($field);
                if ($this->_connected)
                {
                        if ($this->_dictionary!='')
                        {
                                $q="select * from $this->_dictionary where dict_tablename='$table' and dict_fieldname='$field'";
                                $r=$this->execute($q);
                                $props=array();
                                while ($arow=oci_fetch_assoc($r))
                                {
                                        $row=array();
                                        reset($arow);
                                        while (list($k,$v)=each($arow))
                                        {
                                                $row[strtolower($k)]=$v;
                                        }

                                        $props[$row['dict_property']]=array($row['dict_value1'],$row['dict_value2']);
                                }
                                if (!empty($props)) $result=$props;
                        }
                        else
                        {
                                if ($this->_dictionaryproperties!=false)
                                {
                                        $result=$this->_dictionaryproperties[$table][$field];
                                }
                        }
                }
                return($result);
        }

        /**
         * Return indexes for a table
         *
         * This method extract the indexes from the table and returns an array
         * with that information.
         *
         * @param string $table Table name to look for
         * @param boolean $primary If false, only non-primary keys will be returned
         * @return array
         */
        function &extractIndexes($table, $primary = FALSE)
        {
           return($this->GetIndexesFromTable($table,$primary));
        }


        // Mark Newnham
        function GetIndexesFromTable ($table, $primary = FALSE, $owner=false)
        {

          // get index details
          $table = strtoupper($table);
          $false = false;
          $rs = $this->execute(sprintf("SELECT * FROM ALL_CONSTRAINTS WHERE TABLE_NAME=UPPER('%s') AND CONSTRAINT_TYPE='P'",$table));

          if ($row = oci_fetch_row($rs))
            $primary_key = $row[1]; //constraint_name

          if ($primary==TRUE && $primary_key=='')
          {

            return $false; //There is no primary key
          }
          $rs = $this->execute(sprintf("SELECT ALL_INDEXES.INDEX_NAME, ALL_INDEXES.UNIQUENESS, ALL_IND_COLUMNS.COLUMN_POSITION, ALL_IND_COLUMNS.COLUMN_NAME FROM ALL_INDEXES,ALL_IND_COLUMNS WHERE ALL_INDEXES.TABLE_NAME=UPPER('%s') AND ALL_IND_COLUMNS.INDEX_NAME=ALL_INDEXES.INDEX_NAME",$table));

          /*
          if (!is_object($rs))
          {
            return $false;
          }
          */

          $rscnt = false;

          $indexes = array ();
          // parse index data into array

          while ($row = oci_fetch_row($rs))
          {
            $rscnt = true;
            if ($primary && $row[0] != $primary_key) continue;

            if (!isset($indexes[$row[0]]))
            {
              $indexes[$row[0]] = array(
                                  'unique' => ($row[1] == 'UNIQUE'),
                                  'columns' => array()
                                  );

            }

            $indexes[$row[0]]['columns'][$row[2] - 1] = $row[3];
          }

          // sort columns by order in the index
          foreach ( array_keys ($indexes) as $index )
          {
            ksort ($indexes[$index]['columns']);
          }
          if ($rscnt)
          { return $indexes; }
          else { return $false; }


        }


        /**
        * Array containing all the information in array format about the dictionary
        *
        * Use this property to provide information about the dictionary but using a
        * PHP array instead a database table.
        *
        * @return array
        */
        function readDictionaryProperties() { return $this->_dictionaryproperties;   }
        function writeDictionaryProperties($value) { $this->_dictionaryproperties=$value; }


        /**
         * Creates the dictionary table on the database
         *
         * Use this method to create the dictionary table on the database you
         * are connection. This method issues the create table command and creates
         * the table with the right structure. You have to connect to the database
         * before use this method and Dictionary property must be set to the tablename.
         *
         * @return boolean
         */
        function createDictionaryTable()
        {
                $result=false;
                if ($this->_connected)
                {
                        if ($this->_dictionary!='')
                        {
                         $q="CREATE TABLE $this->_dictionary (\n";
                         $q.="  DICT_ID INTEGER NOT NULL,\n";
                         $q.="  DICT_TABLENAME VARCHAR(60) CHARACTER SET NONE COLLATE NONE,\n";
                         $q.="  DICT_FIELDNAME VARCHAR(60) CHARACTER SET NONE COLLATE NONE,\n";
                         $q.="  DICT_PROPERTY VARCHAR(60) CHARACTER SET NONE COLLATE NONE,\n";
                         $q.="  DICT_VALUE1 VARCHAR(60) CHARACTER SET NONE COLLATE NONE,\n";
                         $q.="  DICT_VALUE2 VARCHAR(200) CHARACTER SET NONE COLLATE NONE);\n";
                         $this->execute($q);

                         $q="ALTER TABLE $this->_dictionary ADD PRIMARY KEY (DICT_ID);\n";
                         $this->execute($q);
                        }
                }
                return($result);
        }

        /**
         * Return all the databases using the connection information
         *
         * @return array
         */
        function databases()
        {
            return false;
        }

        /**
         * Return tables on this database
         *
         * This method returns an array containing all the table names stored in
         * the database.
         *
         * @return array
         */
        function tables($ttype=false,$showSchema=false,$mask=false)
        {
                $metaTablesSQL = "select rdb\$relation_name from rdb\$relations where rdb\$relation_name not like 'RDB\$%'";
                $false = false;
                if ($mask)
                {
                        return $false;
                }

                if ($metaTablesSQL)
                {
                        $rs = $this->execute($metaTablesSQL);
                        if ($rs === false) return $false;

                        $rr=array();
                        while ($arr = oci_fetch_row($rs))
                        {



                         $rr[]=$arr[0];
                        }
                        return $rr;
                }
                return $false;
        }
}

/**
 * OracleDataSet encapsulates database connectivity for descendant dataset objects.
 *
 * OracleDataSet defines database-related connectivity properties and methods for a dataset.
 * Applications never use OracleDataSet objects directly. Instead they use the descendants of OracleDataSet,
 * such as OracleQuery, OracleStoredProc, and OracleTable, which inherit its database-related properties and methods.
 *
 * Developers who create custom Oracle dataset components may want to derive them from OracleDataSet to inherit
 * to the database-specific properties of OracleDataSet in addition to all the functionality of DataSet.
 * In this case, developers should examine the source code to study the protected methods of OracleDataSet
 * that are not documented for this object.
 */
class OracleDataSet extends DataSet
{
    public $_rs=null;
    public $_lastsql;

    protected $_eof=false;
    public $_buffer=array();

    protected $_database=null;
    protected $_params=array();

    /**
    * Specifies the database object to be used to connect to the server
    *
    * Use this property to set the database to which this table will connect to.
    *
    * @return OracleDatabase
    */
    function readDatabase() { return $this->_database; }
    function writeDatabase($value) { $this->_database=$this->fixupProperty($value); }
    function defaultDatabase() { return null; }

    //For ParamByNames
    protected $_parambynames = array();
    function getParamByNames() { return $this->_parambynames; }
    function setParamByNames($value) { $this->_parambynames=$value; }
    function defaultParamByNames() { return array();}

    //For ParamBindMode
    protected $_parambindmode = 'pbByName';
    function getParamBindMode() { return $this->_parambindmode; }
    function setParamBindMode($value) { $this->_parambindmode=$value; }
    function defaultParamBindMode() { return 'pbByName';}

    //LOBMode for BLOB CLOB
    protected $_lobmode = 0;
    function getLOBMode()          { return $this->readLOBMode(); }
    function setLOBMode($value)    { $this->writeLOBMode($value); }

    function readLOBMode()           { return $this->_lobmode; }
    function writeLOBMode($value)    { $this->_lobmode=$value; }
    function defaultLOBMode()        { return 0; }

    //FieldName or FieldIndex
    protected $_fieldcaption = 'fdName';
    function getFieldCaption()          { return $this->readFieldCaption(); }
    function setFieldCaption($value)    { $this->writeFieldCaption($value); }

    function readFieldCaption()           { return $this->_fieldcaption; }
    function writeFieldCaption($value)    { $this->_fieldcaption=$value; }
    function defaultFieldCaption()        { return 'fdName';}





    function loaded()
    {
        $this->writeDatabase($this->_database);
        parent::loaded();
    }

    function readFields() { return($this->_buffer); }
    function readFieldCount() { return count($this->_buffer); }

    function readRecordCount()
    {
        if (assigned($this->_rs))
        {
            return(-1);
        }
        else return(parent::readRecordCount());
    }

    function MoveBy($distance)
    {
        parent::MoveBy($distance);

        for($i=0;$i<=$distance-1;$i++)
        {
            if ($this->FieldCaption == 'fdName')
            {
              $buff=oci_fetch_assoc($this->_rs);
            }
            else
            {
              $buff=oci_fetch_row($this->_rs);
            }

            if (!$buff)
            {
              $this->_eof = true;
              break;
            }
            else
            {
              $this->_eof = false;

              if ($this->LOBMode)
              {
                $i = 1;
                foreach($buff as $k => $v)
                {
                  $dtype = oci_field_type($this->_rs,$i);

                  if (eregi('LOB',$dtype))
                  {
                    $len = oci_field_size($this->_rs,$i);
                    if ($buff[$k])
                    {
                      $tmp = $buff[$k]->read($len);
                    }
                    else
                    {
                      $tmp = '';
                    }
                    $buff[$k]=$tmp;
                  }
                  $i++;
                }
              }

            }

        }

      if (!$this->_eof) $this->_buffer=$buff;
    }

    function readEOF()
    {
        return($this->_eof);
    }

    /**
    * Checks if the Database property is assigned and is an object.
    *
    * This method checks for the right setting of the Database property, if is
    * not an object, it will raise a Database exception.
    */
    function CheckDatabase()
    {
        if (!is_object($this->_database)) DatabaseError(_("No Database assigned or is not an object"));
    }

    public $_keyfields=array();



    function InternalOpen($lquery="")
    {
        if (($this->ControlState & csDesigning)!=csDesigning)
        {
            //ParamByName
            $arryparam = array();
            $arryparam = $this->BindValues();

            if ($lquery!="") $query=$lquery;
            else $query=$this->buildQuery();
            if (trim($query)=='') DatabaseError(_("Missing query to execute"));
            $this->CheckDatabase();
            $this->_eof=false;

            //check query type
            $tmp = strtoupper($query);
            if (substr($tmp,0,6) == 'SELECT')
            {
              $select = true;
            }
            else
            {
              $select = false;
              $this->_limitstart = -1;
              $this->_limitcount = -1;
            }

            if ((trim($this->_limitstart)=='-1') && (trim($this->_limitcount)=='-1'))
            {
              $this->_rs=$this->Database->execute($query,$arryparam);
              $this->_buffer=array();

              if ($select) $this->MoveBy(1);
            }
            else
            {
              $limitstart=trim($this->_limitstart);

              if ($limitstart=='') $limitstart=-1;

              $limitcount=trim($this->_limitcount);

              if ($limitcount=='') $limitcount=-1;

              $this->_rs=$this->Database->ExecuteLimit($query,$limitcount,$limitstart, $arryparam);

              $this->_buffer=array();

              if ($select) $this->MoveBy(1);
            }


            if ((!is_array($this->_buffer)) || (count($this->_buffer)==0))
            {
                if ($this->_tablename!='')
                {
                    $fd=$this->Database->MetaFields($this->_tablename);
                    $this->_buffer=$fd;
                }
            }
            $this->_keyfields=$this->readKeyFields();
            $this->fieldbuffer=$this->_buffer;
        }

    }

    function BindValues()
    {
      $param = array();
      if ($this->_parambindmode == 'pbByName') $param = $this->_parambynames;
      else $param = $this->_params;
      return($param);

    }



    function InternalFirst()
    {
        $this->InternalClose();
        $this->InternalOpen($this->_lastquery);
    }

    /**
    * Returns the value of a field on the dataset
    *
    * This method returns the value of the field specified in $fieldname, if not
    * found, an EPropertyNotFound exception is raised
    *
    * @param string $fieldname Name of the field to get
    * @return mixed
    */
    function fieldget($fieldname)
    {
    	if ($this->_rs!=null)
        {
        	if ($this->Active)
            {
            	if ((is_array($this->_buffer)) && (array_key_exists($fieldname,$this->_buffer)))
                {
                	if ($this->State==dsBrowse)
                    {
                    	return ($this->_buffer[$fieldname]);
                    }
                    else if (array_key_exists($fieldname,$this->fieldbuffer))
                    {
                    	return($this->fieldbuffer[$fieldname]);
                    }
                    else return('');
                }
                else if ((is_array($this->fieldbuffer)) && (array_key_exists($fieldname,$this->fieldbuffer)))
                {
                	return($this->fieldbuffer[$fieldname]);
                }
            }
        }

		throw new EPropertyNotFound($this->ClassName().'->'.$fieldname);
    }

    /**
    * Sets the value of a field on the dataset
    *
    * This method sets the value of the field specified in $fieldname, to the value
    * specified in $value. If not found, an EPropertyNotFound exception is raised
    *
    * @param string $fieldname Name of the field to set
    * @param mixed $value Value for the field
    * @return mixed
    */
    function fieldset($fieldname, $value)
    {
    	if ($this->_rs!=null)
        {
        	if ($this->Active)
            {
            	if ((is_array(($this->_buffer))) && (array_key_exists($fieldname,$this->_buffer)))
                {
                	$this->fieldbuffer[$fieldname]=$value;
                    $this->Modified=true;
                    if ($this->State==dsBrowse)
                    {
                    	$this->State=dsEdit;
                    }
                    return;
                }
            }
        }
		throw new EPropertyNotFound($this->ClassName().'->'.$fieldname);
    }

    /**
    * Overriden to allow get field values as properties
    *
    * @param string $nm
    * @return mixed
    */
    //
    function __get($nm)
    {
        if ($this->_rs!=null)
        {
            if ($this->Active)
            {
                if ((is_array($this->_buffer)) && (array_key_exists($nm,$this->_buffer)))
                {
                    if ($this->State==dsBrowse)
                    {
                        return ($this->_buffer[$nm]);
                    }
                    else if (array_key_exists($nm,$this->fieldbuffer))
                    {
                        return($this->fieldbuffer[$nm]);
                    }
                    else return('');
                }
                else if ((is_array($this->fieldbuffer)) && (array_key_exists($nm,$this->fieldbuffer)))
                {
                    return($this->fieldbuffer[$nm]);
                }
                else return(parent::__get($nm));

            }
            else
            {
                return(parent::__get($nm));
            }
         }
         else
         {
            return(parent::__get($nm));
         }
    }

    /**
    * Overriden to allow get field values as properties
    *
    * @param string $nm Name of the property/field to set
    * @param mixed $val Value to set this property/field
    * @return mixed
    */
    function __set($nm,$val)
    {
        if ($this->_rs!=null)
        {
            if ($this->Active)
            {
                if ((is_array(($this->_buffer))) && (array_key_exists($nm,$this->_buffer)))
                {
                    $this->fieldbuffer[$nm]=$val;
                    $this->Modified=true;
                    if ($this->State==dsBrowse)
                    {
                        $this->State=dsEdit;
                    }
                }
                else parent::__set($nm, $val);
            }
            else
            {
                parent::__set($nm, $val);
            }
         }
         else
         {
            parent::__set($nm, $val);
         }
    }


}

/**
 * CustomOracleTable is the base class for OracleTable
 *
 * Use OracleTable to access data in a single database table using Oracle native access in PHP.
 * Table provides direct access to every record and field in an underlying database table.
 * A table component can also work with a subset of records within a database table using
 * ranges and filters.
 *
 */
class CustomOracleTable extends OracleDataSet
{
        protected $_tablename="";
        protected $_lastquery="";

        /**
        * Name of the table you want to access
        *
        * Use this property to specify the tablename you want to access.
        *
        * @return string
        */
        function readTableName() { return $this->_tablename; }
        function writeTableName($value) { $this->_tablename=$value; }
        function defaultTableName() { return ""; }



        /**
        * Updates or Inserts a record, depending on the current state of the dataset
        */
        function Post()
        {
          $this->InternalPost();
        }

        function Delete()
        {
          $this->InternalDelete();
        }

        function InternalDelete()
        {

        }

        /**
         * Get field properties
         *
         * @param string $fieldname Name of the field to get properties from dictionary
         * @return mixed
         */
        function readFieldProperties($fieldname)
        {
                if ($this->_database!=null)
                {
                        return($this->_database->readFieldDictionaryProperties($this->_tablename,$fieldname));
                }
                else return(false);
        }

        function InternalPost()
        {
            if ($this->State == dsEdit)
            {
                $where='';
                $buffer=$this->fieldbuffer;
                reset($this->_keyfields);
                while(list($key, $fname)=each($this->_keyfields))
                {
                    $val=$this->fieldbuffer[$fname];
                    unset($buffer[$fname]);
                    if (trim($val)=='') continue;
                    if ($where!='') $where.=" and ";
                    $where.=" $fname = ".$this->Database->QuoteStr($val);
                }

                $set="";
                reset($buffer);
                while(list($key, $fname)=each($buffer))
                {
                    if ($set!="") $set.=", ";
                    $set.=" $key = '$fname' ";
                }


                try
                {
                    $updateSQL="update $this->TableName set $set where $where";
                    $this->Database->execute($updateSQL);
                    $this->_buffer=array_merge($this->_buffer,$this->fieldbuffer);
                }
                catch (Exception $e)
                {
                    $this->_buffer=array_merge($this->_buffer,$this->fieldbuffer);
                    throw $e;
                }

                //TODO: Handle errors
            }
            else
            {
                $fields='';
                $values='';

                reset($this->fieldbuffer);
                while(list($key, $val)=each($this->fieldbuffer))
                {
                        if ($fields!='') $fields.=',';
                        $fields.="$key";

                        if ($values!='') $values.=',';
                        $values.=$this->Database->QuoteStr($val);
                }

                try
                {
                    $insertSQL="insert into $this->TableName($fields) values ($values)";
                    $this->Database->execute($insertSQL);
                    $this->_buffer=array_merge($this->_buffer,$this->fieldbuffer);
                }
                catch (Exception $e)
                {
                    $this->_buffer=array_merge($this->_buffer,$this->fieldbuffer);
                    throw $e;
                }
            }
        }


        /**
        * This method is used internally to build the query to send to the server.
        *
        * Don't use this method when using this component.
        */
        function buildQuery()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                if (trim($this->_tablename)=='')
                {
                    if ($this->Active)
                    {
                        DatabaseError(_("Missing TableName property"));
                    }
                }
                $qu="select * from $this->_tablename";

                $order="";
                if ($this->_orderfield!="") $order="order by $this->_orderfield $this->_order";

                $where="";
                if ($this->Filter!="") $where.=" $this->Filter ";

                if ($this->MasterSource!="")
                {
                    $this->writeMasterSource($this->_mastersource);
                    if (is_object($this->_mastersource))
                    {
                        if (is_array($this->_masterfields))
                        {
                            $this->_mastersource->DataSet->open();

                            $ms="";
                            reset($this->_masterfields);

                            while(list($key, $val)=each($this->_masterfields))
                            {
                                $thisfield=$key;
                                $msfield=$val;

                                if ($ms!="") $ms.=" and ";

                                $ms.=" $thisfield=".$this->Database->QuoteStr($this->_mastersource->DataSet->$msfield)." ";

                            }

                            if ($ms!="")
                            {
                                if ($where!="") $where.=" and ";
                                $where.=" ($ms) ";
                            }
                        }
                    }
                }


                if ($where!="") $where=" where $where ";

                $result=$qu." $where $order ";

                $this->_lastquery=$result;
                return($result);
            }
            else return('');
        }

          /**
           * Return an array containg the row values
           *
           * This property is an array of the current row values using fieldnames
           * as the key for the values.
           *
           * @return array
           */
  function readAssociativeFieldValues()
  {
        $result=array();

        if ($this->Active)
        {
                return($this->_buffer);
        }

        return($result);
  }

        /**
        * Return an array with Key fields for the table
        *
        * This property returns an array in which each value is a field which belong
        * to the primary key of the table.
        *
        * @return array
        */
        function readKeyFields()
        {
                //TODO: Check here for another indexes
                $result="";
                if ($this->_tablename!='')
                {
                $indexes=$this->Database->extractIndexes($this->_tablename,true);
                if (is_array($indexes))
                {
                    list(,$primary)=each($indexes);

                    $result=$primary['columns'];
                    if (is_array($result))
                    {
                        while (list($k,$v)=each($result))
                        {
                                $result[$k]=trim($v);
                        }
                    }
                }
                }
                return($result);
        }

        function dumpHiddenKeyFields($basename, $values=array())
        {
                $keyfields=$this->readKeyFields();

                if (empty($values))
                {
                        $values=$this->readAssociativeFieldValues();
                }

                if (is_array($keyfields))
                {
                    reset($keyfields);
                    while (list($k,$v)=each($keyfields))
                    {
                            echo "<input type=\"hidden\" name=\"".$basename."[$v]\" value=\"$values[$v]\" />";
                    }
                }
        }

    protected $_orderfield="";

    /**
    * Specifies the field by which the dataset will be ordered
    *
    * Use this property to specify the field(s) which will be used to order
    * the data for the query.
    *
    * @return string
    */
    function readOrderField() { return $this->_orderfield; }
    function writeOrderField($value) { $this->_orderfield=$value; }
    function defaultOrderField() { return ""; }

    protected $_order="asc";

    /**
    * Specifies the order (ascending/descending) to order the dataset
    *
    * This property specifies the order in which to get the data for the query.
    *
    * @return string
    */
    function readOrder() { return $this->_order; }
    function writeOrder($value) { $this->_order=$value; }
    function defaultOrder() { return "asc"; }
}
//**************************************************************

//TODO: Abstract more this class into Dataset (i.e. active, open, etc)
/**
 * OracleTable encapsulates a database table in a Oracle server.
 *
 * Use OracleTable to access data in a single database table using Oracle native access in PHP.
 * Table provides direct access to every record and field in an underlying database table.
 * A table component can also work with a subset of records within a database table using
 * ranges and filters.
 *
 */
class OracleTable extends CustomOracleTable
{
    function getMasterSource() { return $this->readmastersource(); }
    function setMasterSource($value) { $this->writemastersource($value); }

    function getMasterFields() { return $this->readmasterfields(); }
    function setMasterFields($value) { $this->writemasterfields($value); }

    function getTableName() { return $this->readtablename(); }
    function setTableName($value) { $this->writetablename($value); }

    function getActive() { return $this->readactive(); }
    function setActive($value) { $this->writeactive($value); }

    function getDatabase() { return $this->readdatabase(); }
    function setDatabase($value) { $this->writedatabase($value); }

    function getFilter() { return $this->readfilter(); }
    function setFilter($value) { $this->writefilter($value); }

    function getOrderField() { return $this->readorderfield(); }
    function setOrderField($value) { $this->writeorderfield($value); }

    function getOrder() { return $this->readorder(); }
    function setOrder($value) { $this->writeorder($value); }


    function getOnBeforeOpen() { return $this->readonbeforeopen(); }
    function setOnBeforeOpen($value) { $this->writeonbeforeopen($value); }

    function getOnAfterOpen() { return $this->readonafteropen(); }
    function setOnAfterOpen($value) { $this->writeonafteropen($value); }

    function getOnBeforeClose() { return $this->readonbeforeclose(); }
    function setOnBeforeClose($value) { $this->writeonbeforeclose($value); }


    function getOnAfterClose() { return $this->readonafterclose(); }
    function setOnAfterClose($value) { $this->writeonafterclose($value); }

    function getOnBeforeInsert() { return $this->readonbeforeinsert(); }
    function setOnBeforeInsert($value) { $this->writeonbeforeinsert($value); }

    function getOnAfterInsert() { return $this->readonafterinsert(); }
    function setOnAfterInsert($value) { $this->writeonafterinsert($value); }

    function getOnBeforeEdit() { return $this->readonbeforeedit(); }
    function setOnBeforeEdit($value) { $this->writeonbeforeedit($value); }


    function getOnAfterEdit() { return $this->readonafteredit(); }
    function setOnAfterEdit($value) { $this->writeonafteredit($value); }

    function getOnBeforePost() { return $this->readonbeforepost(); }
    function setOnBeforePost($value) { $this->writeonbeforepost($value); }

    function getOnAfterPost() { return $this->readonafterpost(); }
    function setOnAfterPost($value) { $this->writeonafterpost($value); }

    function getOnBeforeCancel() { return $this->readonbeforecancel(); }
    function setOnBeforeCancel($value) { $this->writeonbeforecancel($value); }

    function getOnAfterCancel() { return $this->readonaftercancel(); }
    function setOnAfterCancel($value) { $this->writeonaftercancel($value); }

    function getOnBeforeDelete() { return $this->readonbeforedelete(); }
    function setOnBeforeDelete($value) { $this->writeonbeforedelete($value); }

    function getOnAfterDelete() { return $this->readonafterdelete(); }
    function setOnAfterDelete($value) { $this->writeonafterdelete($value); }

    function getOnDeleteError() { return $this->readondeleteerror(); }
    function setOnDeleteError($value) { $this->writeondeleteerror($value); }
}

class CustomOracleQuery extends CustomOracleTable
{
        function Post()
        {
        }

        protected $_sql=array();

        /**
         * Contains the text of the SQL statement to execute for the query.
         *
         * Use SQL to provide the SQL statement that a query component executes
         * when its Open method is called. At design time the SQL property can be
         * edited by invoking the String List editor in the Object Inspector.
         *
         * The SQL property may contain only one complete SQL statement at a time.
         * In general, multiple batch statements are not allowed unless a particular
         * server supports them.
         *
         * @return string
         */
        function readSQL() { return $this->_sql;     }
        function writeSQL($value)
        {
                if (!is_array($value)) $clean=unserialize($value);
                else $clean=$value;

                if ($clean===false)
                {
                        $this->_sql=$value;
                }
                else
                {
                        $this->_sql=$clean;
                }
        }

        //Did override RecordCount in OracleDataSet.
        //Check "RecordCount" for SELECT
        function readRecordCount()
        {
          if (assigned($this->_rs))
          {
            $num = -1;
            $query = str_replace("\0",'', $this->_lastquery);
            if (eregi('^select',$query))
            {
              while ($row = oci_fetch($this->_rs)){}
              $num = oci_num_rows($this->_rs);
              $query = str_replace("\0",'', $this->_lastquery);
              if (eregi('^select',$query))
              {
                $this->InternalOpen($this->_lastquery);
              }
            }

            return($num);
          }
          else return(parent::readRecordCount());
        }




        function defaultSQL() { return "";     }

        /**
         * Sends a query to the server for optimization prior to execution.
         *
         * Call Prepare to have a remote database server allocate resources for
         * the query and to perform additional optimizations.
         *
         * If the query will only be executed once, the application does not need
         * to explicitly call Prepare. Executing an unprepared query generates
         * these calls automatically. However, if the same query is to be executed
         * repeatedly, it is more efficient to prevent these automatic calls by
         * calling Prepare explicitly.
         *
         * Note: When you change the text of a query at runtime, the query is automatically closed and unprepared.
         */
        function Prepare()
        {
            $this->Database->Prepare($this->buildQuery());
        }

        /**
         * Contains the parameters for a querys SQL statement.
         *
         * Access Params at runtime to view and set parameter names and values
         * dynamically (at design time use the editor for the Params property to
         * set parameter information). Index specifies the array element to access.
         *
         * @return array
         */
        function readParams() { return $this->_params; }
        function writeParams($value) { $this->_params=$value; }
        function defaultParams() { return ""; }

        /**
        * This method is used internally to build the query to send to the server.
        *
        * Don't use this method when using this component.
        */
        function buildQuery()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                if (is_array($this->_sql))
                {
                    if (!empty($this->_sql))
                    {
                        $use_query_string=true;
                        $qu=implode(' ',$this->_sql);
                    }
                }
                else
                {
                    if ($this->_sql!="")
                    {
                        $qu=$this->_sql;
                    }
                }

                $order="";
                if ($this->_orderfield!="") $order="order by $this->_orderfield $this->_order";

                $filter="";
                if ($this->_filter!="") $filter=" where $this->_filter ";

                $result=$qu." $filter $order ";

                $this->_lastquery=$result;

                return($result);
            }
            else return('');
        }
}

/**
 * OracleQuery represents a dataset with a result set that is based on an SQL statement.
 *
 * Use OracleQuery to access one or more tables in a Oracle database using SQL statements.
 *
 * Query components are useful because they can:
 *
 * Access more than one table at a time (called a join in SQL).
 *
 * Automatically access a subset of rows and columns in its underlying table(s),
 * rather than always returning all rows and columns.
 *
 */
class OracleQuery extends CustomOracleQuery
{
        function getSQL() { return $this->readsql(); }
        function setSQL($value) { $this->writesql($value); }

        function getParams() { return $this->readparams(); }
        function setParams($value) { $this->writeparams($value); }

        function getTableName() { return $this->readtablename(); }
        function setTableName($value) { $this->writetablename($value); }

        function getActive() { return $this->readactive(); }
        function setActive($value) { $this->writeactive($value); }

        function getDatabase() { return $this->readdatabase(); }
        function setDatabase($value) { $this->writedatabase($value); }

        function getFilter() { return $this->readfilter(); }
        function setFilter($value) { $this->writefilter($value); }

        function getOrderField() { return $this->readorderfield(); }
        function setOrderField($value) { $this->writeorderfield($value); }

        function getOrder() { return $this->readorder(); }
        function setOrder($value) { $this->writeorder($value); }
}

/**
 * OracleStoredProc encapsulates a stored procedure in an application.
 *
 * Use a OracleStoredProc object in applications to use a stored procedure on a Oracle database server.
 * A stored procedure is a grouped set of statements, stored as part of a database servers
 * metadata (just like tables, indexes, and domains), that performs a frequently repeated,
 * database-related task on the server and passes results to the client.
 *
 * Note:   Not all Oracle versions support stored procedures. See a specific servers
 * documentation to determine if it supports stored procedures.
 *
 * Many stored procedures require a series of input arguments, or parameters, that are used
 * during processing. OracleStoredProc provides a Params property that enables an application
 * to set these parameters before executing the stored procedure.
 *
 */

class CustomOracleStoredProc extends CustomOracleQuery
{



        function Prepare()
        {
            $arryparam = array();
            $arryparam = $this->BindValues();
            if ($this->StoredType == 'stCursor') {
                $this->Database->Prepare($this->buildQuery($arryparam),true);
            }
            else {
                $this->Database->Prepare($this->buildQuery($this->buildQuery($arryparam)),false);
            }

        }

        function ExecStoredProc()
        {
            $this->InternalOpen();
        }

        function InternalOpen($lquery="")
        {
          if (($this->ControlState & csDesigning)!=csDesigning)
          {

            $arryparam = array();
            $arryparam = $this->BindValues();

            if ($lquery!="") $query=$lquery;
            else $query=$this->buildQuery($arryparam);
            if (trim($query)=='') DatabaseError(_("Missing query to execute"));
            $this->CheckDatabase();
            $this->_eof=false;

            if ((strlen($this->_cursorname)>0)&&($this->_storedtype== 'stCursor'))
            {
              //for cursor
              $this->Database->DoConnect();
              $this->_rs=$this->Database->executecursor($query,$arryparam,$this->CursorName);
               $this->_buffer=array();
              $this->MoveBy(1);

              if ($this->_rs->fields)
                $this->fieldbuffer=$this->_rs->fields;
            }
            else if($this->_storedtype=== 'stSingleValue')
            {
              $this->_rs=$this->Database->Execute($query,$arryparam);
              $this->_buffer=array();
              $this->MoveBy(1);
              $this->fieldbuffer=$this->_rs->fields;
            }
            else if ($this->_storedtype== 'stNone')
            {
              $this->Database->Execute($query,$arryparam);
            }

            if ($this->ParamBindMode == 'pbByName'){
              $this->ParamByNames = $arryparam;      //add
            }else{
              $this->Params = $arryparam;
            }

            if ((!is_array($this->_buffer)) || (count($this->_buffer)==0))
            {
              if ($this->_tablename!='')
              {
                $fd=$this->Database->MetaFields($this->_tablename);
                $this->_buffer=$fd;
              }
            }

            $this->_keyfields=$this->readKeyFields();
           // $this->fieldbuffer=$this->_buffer;

          }

        }


        function buildQuery($par=array())
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
              $checkfunc = true;

              $result= $this->makeQuery($par);
              $this->_lastquery=$result;
              $this->_limitstart = -1;
              $this->_limitcount = -1;
              return($result);
            }

            else return('');
        }

        function makeQuery($par=array())
        {
          $func = true;

          if ($this->_storedtype== 'stCursor' && $this->_cursorname === ''){
            $this->_cursorname = 'cursorname';
          }

          foreach($par as $k => $v)
          {
            if ($par[$k] === $this->_cursorname)
            {
              $func = false;
              break;
            }
          }

          if ($this->_storedtype== 'stSingleValue')
          {
            $result="select " . $this->_storedprocname . " from dual";
          }
          else if (($this->_storedtype== 'stCursor')&&($func))
          {
            $result="Begin :" . $this->_cursorname . " := " . $this->_storedprocname . "; end;";
          }
          else
          {
            $result="Begin ".$this->_storedprocname . "; end;";
          }
          return($result);

        }

}


class OracleStoredProc extends CustomOracleStoredProc
{

        ///for CursorName
        protected $_cursorname = '';

        function getCursorName() { return $this->_cursorname; }
        function setCursorName($value) { $this->_cursorname=$value; }
        function defaultCursorName() { return '';}
        ////////////

        ///for StoredType
        protected $_storedtype= 'stNone';
        function getStoredType() { return $this->_storedtype; }
        function setStoredType($value) { $this->_storedtype=$value; }
        function defaultStoredType() { return 'stNone';}
        ////////////

        protected $_storedprocname="";
        function getStoredProcName() { return $this->_storedprocname; }
        function setStoredProcName($value) { $this->_storedprocname=$value; }
        function defaultStoredProcName() { return ""; }

        function getActive() {return $this->readactive();}
        function setActive($value) {$this->writeactive($value);}

        function getDatabase() { return $this->readdatabase(); }
        function setDatabase($value) { $this->writedatabase($value); }

        function getFilter() { return $this->readfilter(); }
        function setFilter($value) { $this->writefilter($value); }

        function getOrderField() { return $this->readorderfield(); }
        function setOrderField($value) { $this->writeorderfield($value); }

        function getOrder() { return $this->readorder(); }
        function setOrder($value) { $this->writeorder($value); }

        function getParams() { return $this->readparams(); }
        function setParams($value) { $this->writeparams($value); }

}

?>