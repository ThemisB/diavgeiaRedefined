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
 * MySQLDatabase provides discrete control over a connection to a single MySQL database in a database application.
 *
 * Use MySQLDatabase to specify the connection information so MySQLDataset components can connect to the
 * database.
 *
 * @link http://www.php.net/manual/en/ref.mysql.php
 */
class MySQLDatabase extends CustomConnection
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

        function MetaFields($tablename)
        {
            $metaColumnsSQL = "SHOW COLUMNS FROM `%s`";

            $rs = $this->Execute(sprintf($metaColumnsSQL,$tablename));
            $result=array();
            while ($row=mysql_fetch_row($rs))
            {
                $result[$row[0]]='';
            }
            return($result);
        }

        function BeginTrans($args=array())
        {
            //Not implemented
        }

        function CompleteTrans($autocomplete=true)
        {
            //Not implemented
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

        function Prepare($query)
        {
            // Not implemented
            // ibase_prepare($this->_connection, $query);
        }

        /**
        * Prepares a stored procedure for execution
        *
        * Not finished
        */
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


        /**
         * Executes a query on the database
         *
         * Use this method to execute an SQL sentence on the database server
         *
         * @param string $query Query to execute
         * @param array $params Not used
         * @return object
         */
        function execute($query,$params=array())
        {
                $this->open();
                $rs = @mysql_query($query,$this->_connection);
                if ($rs===false)
                {
                        DatabaseError("Error executing query: $query [".mysql_error($this->_connection)."]");
                }

                return($rs);
        }

        /**
         * Executes a limited query on the database
         *
         * Use this method to execute an SQL sentence on the database server using LIMIT clause.
         *
         * @param string $query Query to execute
         * @param integer $numrows Rows to get
         * @param integer $offset First row to start counting
         * @param array $params Parameters to use on the query
         * @return object
         */
        function executelimit($query,$numrows,$offset, $params=array())
        {
                $this->open();
                $sql=$query;

                $sql .= " LIMIT $offset, $numrows";

                return($this->execute($sql));
        }

        function DoConnect()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                $this->_connection = mysql_connect($this->Host, $this->UserName, $this->UserPassword);
                if (!$this->_connection)
                {
                    DatabaseError("Cannot connect to database server");
                }
                else
                {
                    $selected=mysql_select_db($this->DatabaseName, $this->_connection);
                    if (!$selected)
                    {
                        DatabaseError("Cannot select database $this->DatabaseName");
                    }
                }
            }
        }

        function DoDisconnect()
        {
                if ($this->_connection!=null)
                {
                        mysql_close($this->_connection);
                        $this->_connection=null;
                }
        }

        /**
         * Return properties for a field
         *
         * @param string $table Name of the table to query for
         * @param string $field Name of the field of that table
         * @return array
         */
        function readFieldDictionaryProperties($table, $field)
        {
                $result=array();
                $table=trim($table);
                $field=trim($field);
                if ($this->_connected)
                {
                        if ($this->_dictionary!='')
                        {
                                $q="select * from $this->_dictionary where dict_tablename='$table' and dict_fieldname='$field'";
                                $r=$this->execute($q);
                                $props=array();
                                while ($arow=mysql_fetch_assoc($r))
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
            $table = $table;
            $sql="SHOW INDEX FROM `$table` ";

            if (!$primary)
            {
                $sql .= " where Key_name='PRIMARY' ";
            }
            else
            {
                $sql .= " where Key_name<>'PRIMARY' ";
            }

            $rs=$this->execute($sql);

            $indexes = array();

        // parse index data into array
        while ($row = mysql_fetch_row($rs))
        {
                if ($primary == FALSE AND $row[2] == 'PRIMARY') {
                        continue;
                }

                if (!isset($indexes[$row[2]])) {
                        $indexes[$row[2]] = array(
                                'unique' => ($row[1] == 0),
                                'columns' => array()
                        );
                }

                $indexes[$row[2]]['columns'][$row[3] - 1] = $row[4];
        }

        // sort columns by order in the index
        foreach ( array_keys ($indexes) as $index )
        {
                ksort ($indexes[$index]['columns']);
        }
            return $indexes;
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
                //TODO: Check here for errors creating table and return false
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
         * This method returns an array with all the databases stored on the server.
         * Not working yet.
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
        function tables()
        {
                //TODO: Check for this, as it's ib code, not mysql
                $metaTablesSQL = "SHOW TABLES from $this->DatabaseName";

                $rs = $this->execute($metaTablesSQL);
                if ($rs === false) return $false;

                $rr=array();
                while ($arr = mysql_fetch_row($rs))
                {
                        $rr[]=$arr[0];
                }
                return $rr;
        }
}

/**
 * MySQLDataSet encapsulates database connectivity for descendant dataset objects.
 *
 * MySQLDataSet defines database-related connectivity properties and methods for a dataset.
 * Applications never use MySQLDataSet objects directly. Instead they use the descendants of MySQLDataSet,
 * such as MySQLQuery, MySQLStoredProc, and MySQLTable, which inherit its database-related properties and methods.
 *
 * Developers who create custom MySQL dataset components may want to derive them from MySQLDataSet to inherit
 * to the database-specific properties of MySQLDataSet in addition to all the functionality of DataSet.
 * In this case, developers should examine the source code to study the protected methods of MySQLDataSet
 * that are not documented for this object.
 */
class MySQLDataSet extends DataSet
{
    public $_rs=null;

    protected $_eof=false;
    public $_buffer=array();

    protected $_database=null;
    protected $_params=array();

    /**
    * Specifies the database object to be used to connect to the server
    *
    * Use this property to set the database to which this table will connect to.
    *
    * @return MySQLDatabase
    */
    function readDatabase() { return $this->_database; }
    function writeDatabase($value) { $this->_database=$this->fixupProperty($value); }
    function defaultDatabase() { return null; }

    function loaded()
    {
        $this->writeDatabase($this->_database);
        parent::loaded();
    }

    function readFields() { return($this->_buffer); }
    function readFieldCount() { return count($this->_buffer); }

    function readRecordCount()
    {
        if ($this->_rs!=null)
        {
                return(mysql_num_rows($this->_rs));
        }
        else return(parent::readRecordCount());
    }

    function MoveBy($distance)
    {
        parent::MoveBy($distance);

        for($i=0;$i<=$distance-1;$i++)
        {
            $this->_eof=!($buff=mysql_fetch_assoc($this->_rs));
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
            if ($lquery!="") $query=$lquery;
            else $query=$this->buildQuery();
            if (trim($query)=='') DatabaseError(_("Missing query to execute"));
            $this->CheckDatabase();
            $this->_eof=false;

            if ((trim($this->_limitstart)=='-1') && (trim($this->_limitcount)=='-1'))
            {
                $this->_rs=$this->Database->Execute($query,$this->_params);
                $this->_buffer=array();
                $this->MoveBy(1);
            }
            else
            {
                $limitstart=trim($this->_limitstart);
                if ($limitstart=='') $limitstart=-1;

                $limitcount=trim($this->_limitcount);
                if ($limitcount=='') $limitcount=-1;

                $this->_rs=$this->Database->ExecuteLimit($query,$limitcount,$limitstart);
                $this->_buffer=array();
                $this->MoveBy(1);
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
    * @param string $nm Name of the property/field to set
    * @return mixed
    */
    function __get($nm)
    {
        try
        {
                //Try to get the property from the object
                return(parent::__get($nm));
        }
        catch (EPropertyNotFound $e)
        {
                if ($this->_rs!=null)
                {
                    if ($this->readActive())
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
                    }
                }
                throw $e;
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
        try
        {
                //Try to get the property from the object
                parent::__set($nm,$val);
        }
        catch (EPropertyNotFound $e)
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
                        else throw $e;
                    }
                    else throw $e;
                }
                else throw $e;
        }

    }
}

/**
 * CustomMySQLTable is the base class for MySQLTable
 *
 * Use MySQLTable to access data in a single database table using MySQL native access in PHP.
 * Table provides direct access to every record and field in an underlying database table.
 * A table component can also work with a subset of records within a database table using
 * ranges and filters.
 *
 */
class CustomMySQLTable extends MySQLDataSet
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

        function InternalDelete()
        {
                $where='';
                reset($this->_keyfields);
                while(list($key, $fname)=each($this->_keyfields))
                {
                    $val=$this->fieldbuffer[$fname];
                    if (trim($val)=='') continue;
                    if ($where!='') $where.=" and ";
                    $where.=" $fname = ".$this->Database->QuoteStr($val);
                }

            if ($where!='')
            {
                $query="delete from $this->TableName where $where";
                $this->Database->Execute($query);
            }

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
                                $avalue=$values[$v];
                                $avalue=str_replace('"','&quot;',$avalue);
                            echo "<input type=\"hidden\" name=\"".$basename."[$v]\" value=\"$avalue\" />";
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
 * MySQLTable encapsulates a database table in a MySQL server.
 *
 * Use MySQLTable to access data in a single database table using MySQL native access in PHP.
 * Table provides direct access to every record and field in an underlying database table.
 * A table component can also work with a subset of records within a database table using
 * ranges and filters.
 *
 */
class MySQLTable extends CustomMySQLTable
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

class CustomMySQLQuery extends CustomMySQLTable
{
        protected $_sql=array();

        /**
         * Contains the text of the SQL statement to execute for the query.
         *
         * Use SQL to provide the SQL statement that a query component executes
         * when its Open method is called. At design time the SQL property can be
         * edited by invoking the String List editor in the Object Inspector.
         *
         * The SQL property may contain only one complete SQL statement at a time.
         * In general, multiple “batch” statements are not allowed unless a particular
         * server supports them.
         *
         * <code>
         * <?php
         *      $sqls=array("select * from tablaprueba");
         *      $this->object->SQL=$sqls;
         * ?>
         * </code>
         *
         * @return array
         */
        function readSQL() { return $this->_sql;     }
        function writeSQL($value)
        {
                //If it's not an array
                if (!is_array($value))
                {
                        //Check for a serialized array
                        $clean=@unserialize($value);
                }
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
        function defaultSQL() { return array();     }

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
         * Contains the parameters for a query’s SQL statement.
         *
         * Access Params at runtime to view and set parameter names and values
         * dynamically (at design time use the editor for the Params property to
         * set parameter information). Index specifies the array element to access.
         *
         * @return array
         */
        function readParams() { return $this->_params; }
        function writeParams($value) { $this->_params=$value; }
        function defaultParams() { return array(); }

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

                return($result);
            }
            else return('');
        }
}

/**
 * MySQLQuery represents a dataset with a result set that is based on an SQL statement.
 *
 * Use MySQLQuery to access one or more tables in a MySQL database using SQL statements.
 *
 * Query components are useful because they can:
 *
 * Access more than one table at a time (called a “join” in SQL).
 *
 * Automatically access a subset of rows and columns in its underlying table(s),
 * rather than always returning all rows and columns.
 *
 */
class MySQLQuery extends CustomMySQLQuery
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
 * MySQLStoredProc encapsulates a stored procedure in an application.
 *
 * Use a MySQLStoredProc object in applications to use a stored procedure on a MySQL database server.
 * A stored procedure is a grouped set of statements, stored as part of a database server’s
 * metadata (just like tables, indexes, and domains), that performs a frequently repeated,
 * database-related task on the server and passes results to the client.
 *
 * Note:   Not all MySQL versions support stored procedures. See a specific server’s
 * documentation to determine if it supports stored procedures.
 *
 * Many stored procedures require a series of input arguments, or parameters, that are used
 * during processing. MySQLStoredProc provides a Params property that enables an application
 * to set these parameters before executing the stored procedure.
 *
 */
class MySQLStoredProc extends CustomMySQLQuery
{
    protected $_storedprocname="";

        /**
         * Name of the stored procedure to execute
         *
         * Set StoredProcName to specify the name of the stored procedure to call
         * on the server. If StoredProcName does not match the name of an existing
         * stored procedure on the server, then when the application attempts to
         * prepare the procedure prior to execution, an exception is raised.
         *
         * @return string
         */
    function getStoredProcName() { return $this->_storedprocname; }
    function setStoredProcName($value) { $this->_storedprocname=$value; }
    function defaultStoredProcName() { return ""; }

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

        function getParams() { return $this->readparams(); }
        function setParams($value) { $this->writeparams($value); }

    protected $_fetchquery="";

    /**
    * Use this property to specify the query to fetch results from the stored procedure call
    *
    * If your procedures produce results in variables, you can use this property to specify
    * the select query to fetch those results
    *
    * @return string
    */
    function getFetchQuery() { return $this->_fetchquery; }
    function setFetchQuery($value) { $this->_fetchquery=$value; }
    function defaultFetchQuery() { return ""; }

        function Prepare()
        {
            $this->Database->PrepareSP($this->buildQuery());
        }

        function buildQuery()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                    $pars="";

                    reset($this->_params);
                    while(list($key, $val)=each($this->_params))
                    {
                        if ($pars!="") $pars.=', ';
                        $pars.="'$val'";
                    }

                    if ($pars!="") $pars="($pars)";

                    $result="call $this->_storedprocname$pars;$this->_fetchquery";


                return($result);
            }
            else return('');
        }
}

?>