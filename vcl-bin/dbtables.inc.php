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
use_unit("rtl.inc.php");
use_unit('adodb/adodb.inc.php');
use_unit('adodb/adodb-exceptions.inc.php');

/**
 * Database provides discrete control over a connection to a single database in a database application.
 *
 * Use Database to specify the connection information so dataset components can connect to the
 * database.
 *
 * @link http://adodb.sourceforge.net/
 */
class Database extends CustomConnection
{
        public $_connection=null;
        protected $_debug=0;
        protected $_drivername="mysql";
        protected $_databasename="";
        protected $_host="";
        protected $_username="";
        protected $_userpassword="";
        protected $_connected=0;
        protected $_dictionary="";
        protected $_dictionaryproperties=false;

        function MetaFields($tablename)
        {
            $fd=$this->_connection->MetaColumns($tablename);
            $result=array();
            reset($fd);
            while(list($key, $val)=each($fd))
            {

                $result[$val->name]='';
            }
            return($result);
        }

    protected $_charset="";

    /**
    * Determines the character set to be used when opening a connection
    *
    * Use this property to specify the charset to use when opening a connection,
    * the value for this property varies depending on the database provider.
    *
    * @return string
    */
    function getCharset() { return $this->_charset; }
    function setCharset($value) { $this->_charset=$value; }
    function defaultCharset() { return ""; }



        function BeginTrans()
        {
            $this->_connection->StartTrans();
        }

        function CompleteTrans($autocomplete=true)
        {
            return($this->_connection->CompleteTrans($autocomplete));
        }

        function getOnAfterConnect() { return $this->readonafterconnect(); }
        function setOnAfterConnect($value) { $this->writeonafterconnect($value); }

        function getOnBeforeConnect() { return $this->readonbeforeconnect(); }
        function setOnBeforeConnect($value) { $this->writeonbeforeconnect($value); }

        function getOnAfterDisconnect() { return $this->readonafterdisconnect(); }
        function setOnAfterDisconnect($value) { $this->writeonafterdisconnect($value); }

        function getOnBeforeDisconnect() { return $this->readonbeforedisconnect(); }
        function setOnBeforeDisconnect($value) { $this->writeonbeforedisconnect($value); }


        function Prepare($query)
        {
            $this->_connection->Prepare($query);
        }

        /**
        * Prepares the Stored Procedure to be executed
        *
        * Use this method before execute several times a stored procedure to get
        * some performance gain.
        *
        * @param string $query Stored Procedure query to be prepared
        */
        function PrepareSP($query)
        {
            $this->_connection->PrepareSP($query);
        }

        function DBDate($input)
        {
            return($this->_connection->DBDate($input));
        }

        function Param($input)
        {
            return($this->_connection->Param($input));
        }

        function QuoteStr($input)
        {
            return($this->_connection->qstr($input));
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
        * Specifies if the database is connected or not
        *
        * @see Open(), Close()
        *
        * @return boolean
        */
        function readConnected() { return ($this->_connection!=null); }
        function getConnected() { return $this->readconnected(); }
        function setConnected($value) { $this->writeconnected($value); }

        /**
        * Specifies if the database is in debug mode or not
        *
        * Use this property if you want to get more information when a problem arises
        * connecting to the database.
        *
        * @return boolean
        */
        function getDebug() { return $this->_debug; }
        function setDebug($value) { $this->_debug=$value; }
        function defaultDebug() { return 0; }

        /**
        * Specifies the type of database you want to access
        *
        * @link http://phplens.com/adodb/supported.databases.html
        *
        * @return string
        */
        function getDriverName() { return $this->_drivername;   }
        function setDriverName($value) { $this->_drivername=$value; }
        function defaultDriverName()   { return $this->_drivername="mysql"; }
        /**
        * Specifies the dictionary table you want to use
        *
        * @see createDictionaryTable()
        *
        * @return string
        */
        function getDictionary() { return $this->_dictionary;   }
        function setDictionary($value) { $this->_dictionary=$value; }
        function defaultDictionary()   { return $this->_dictionary=""; }

        /**
        * Specifies the name of the database you want to access
        * @return string
        */
        function getDatabaseName() { return $this->_databasename;       }
        function setDatabaseName($value) { $this->_databasename=$value; }
        function defaultDataBaseName() { return ""; }
        /**
        * Specifies the host where your database resides
        * @return string
        */
        function getHost() { return $this->_host;       }
        function setHost($value) { $this->_host=$value; }
        function defaultHost() {return "";}

        /**
        * Specifies the username used to acces the database
        * @return string
        */
        function getUserName() { return $this->_username;       }
        function setUserName($value) { $this->_username=$value; }
        function defaultUserName() {return "";}
        /**
        * Specifies the password to access the database
        * @return string
        */
        function getUserPassword() { return $this->_userpassword;       }
        function setUserPassword($value) { $this->_userpassword=$value; }
        function defaultUserPassword() { return ""; }

        /**
         * Executes a query
         *
         * @param string $query  Query to execute
         * @return object ResultSet object to work with
         */
        function execute($query,$params=array())
        {
                $this->open();
                $rs=$this->_connection->Execute($query,$params);
                if ($rs==null)
                {
                        DatabaseError("Error executing query: $query [".$this->_connection->ErrorMsg()."]");
                }
                return($rs);
        }

        /**
         * Executes a limited query
         *
         * @param string $query SQL sentence to execute
         * @param integer $numrows Numrows to retrieve
         * @param integer $offset Starting row to retrieve
         * @param array $params Parameters to use on the query
         * @return object Resultset object to work with
         */
        function executelimit($query,$numrows,$offset, $params=array())
        {
                $this->open();
                $rs=$this->_connection->SelectLimit($query,$numrows,$offset, $params);
                if ($rs==null)
                {
                        DatabaseError("Error executing query: $query [".$this->_connection->ErrorMsg()."]");
                }
                return($rs);
        }

        function DoConnect()
        {
                $result=false;

            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                global $ADODB_FETCH_MODE;
                $ADODB_FETCH_MODE=ADODB_FETCH_ASSOC;

                try
                {
                    $this->_connection = ADONewConnection($this->DriverName);

                    if(trim($this->Charset)!='') $this->_connection->charSet=$this->Charset;

                    $this->_connection->debug=$this->Debug;

                    $this->callEvent("oncustomconnect",array());

                    if (($this->DriverName=='borland_ibase') || ($this->DriverName=='ibase'))
                    {
                        $result=$this->_connection->PConnect($this->DatabaseName,$this->UserName,$this->UserPassword);
                    }
                    else
                    {
                        $result=$this->_connection->Connect($this->Host,$this->UserName,$this->UserPassword,$this->DatabaseName);
                    }
                }
                catch (Exception $e)
                {
                    DatabaseError("Cannot connect to database server");
                }
            }
            return($result);
        }

        function DoDisconnect()
        {
                if ($this->_connection!=null)
                {
                        $this->_connection->Close();
                        $this->_connection=null;
                }
        }

        /**
         * Return properties for a field
         *
         * @param string $table Name of the table to query for
         * @param string $field Name of the field of that table
         * @return array Array with properties for that field table
         */
        function readFieldDictionaryProperties($table, $field)
        {
                $table=trim($table);
                $field=trim($field);
                $result=false;
                if ($this->_connection!=null)
                {
                        if ($this->_dictionary!='')
                        {
                                global $ADODB_FETCH_MODE;
                                $ADODB_FETCH_MODE=ADODB_FETCH_ASSOC;

                                $q="select * from $this->_dictionary where dict_tablename='$table' and dict_fieldname='$field'";
                                $r=$this->execute($q);
                                $props=array();
                                while ($r->fetchInto($arow))
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
         * @param string $table Name of the table to get indexes
         * @param boolean $primary If true, also get primary indexes
         * @return array Array with indexes from that table
         */
        function extractIndexes($table, $primary = FALSE)
        {
                return($this->_connection->MetaIndexes($table,$primary));
        }

        /**
         * Return an array with dictionary properties
         *
         * @return array
         */
        function readDictionaryProperties() { return $this->_dictionaryproperties;   }
        function writeDictionaryProperties($value) { $this->_dictionaryproperties=$value; }


        /**
         * Creates the dictionary table on the database
         *
         * @return boolean True if dictionary table has been created correctly
         */
        function createDictionaryTable()
        {
                $result=false;
                if ($this->_connection!=null)
                {
                        if ($this->_dictionary!='')
                        {
                                if ($this->_drivername=='borland_ibase')
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

                                        $result=true;
                                }
                                else
                                {
                                        $q="CREATE TABLE $this->_dictionary (";
                                        $q.="  `dict_id` int(11) unsigned NOT NULL auto_increment,";
                                        $q.="  `dict_tablename` varchar(60) NULL,";
                                        $q.="  `dict_fieldname` varchar(60) NULL,";
                                        $q.="  `dict_property` varchar(60) NULL,";
                                        $q.="  `dict_value1` varchar(60) NULL,";
                                        $q.="  `dict_value2` text NULL,";
                                        $q.="  PRIMARY KEY (`dict_id`)";
                                        $q.=");";
                                        $this->execute($q);

                                        $result=true;
                                }
                        }
                }
                return($result);
        }

        /**
         * Return tables on this database
         *
         * @return array Table names for this database
         */
        function tables()
        {
                if ($this->_connection==null)
                {
                        $this->open();
                }
                return($this->_connection->MetaTables());
        }

        /**
         * Return databases with this connection information
         *
         * @return array Table names for this database
         */
        function databases()
        {
                if ($this->_connection==null)
                {
                        $this->open();
                }
                return($this->_connection->MetaDatabases());
        }

}

/**
 * DBDataSet encapsulates database connectivity for descendant dataset objects.
 *
 * DBDataSet defines database-related connectivity properties and methods for a dataset.
 * Applications never use DBDataSet objects directly. Instead they use the descendants of DBDataSet,
 * such as Query, StoredProc, and Table, which inherit its database-related properties and methods.
 *
 * Developers who create custom dataset components may want to derive them from DBDataSet to inherit
 * to the database-specific properties of DBDataSet in addition to all the functionality of DataSet.
 * In this case, developers should examine the source code to study the protected methods of DBDataSet
 * that are not documented for this object.
 */
class DBDataSet extends DataSet
{
    public $_rs=null;
    protected $_database=null;
    protected $_params=array();

    /**
    * Specifies the database object to be used to connect to the server
    *
    * @return CustomConnection
    */
    function readDatabase() { return $this->_database; }
    function writeDatabase($value) { $this->_database=$this->fixupProperty($value); }
    function defaultDatabase() { return null; }

    function loaded()
    {
        $this->writeDatabase($this->_database);
        parent::loaded();
    }

    /**
    * Field array (name=>value) of the current record
    *
    * @return array
    */
    function readFields()
    {
        if ($this->_rs!=null)
        {
                return($this->_rs->fields);
        }
        else return array();

    }

    /**
    * Number of fields on the current record
    *
    * @return integer
    */
    function readFieldCount()
    {
        if ($this->_rs!=null)
        {
                return count($this->_rs->_numOfFields);
        }
        else return 0;
    }

    /**
    * Number of records in the dataset
    *
    * @return integer
    */
    function readRecordCount()
    {
        if (assigned($this->_rs))
        {
            return($this->_rs->RecordCount());
        }
        else return(parent::readRecordCount());
    }

    function MoveBy($distance)
    {
        parent::MoveBy($distance);
        for($i=0;$i<=$distance-1;$i++)
        {
            if (!$this->_rs->EOF)
            {
                $this->_rs->MoveNext();
            }
        }
    }

    /**
    * If true, the pointer is at the end of the dataset
    *
    * @return boolean
    */
    function readEOF()
    {
        return($this->_rs->EOF);
    }

    /**
    * Checks if the assigned database is an object
    *
    * This method checks for the database property to be an object, if not,
    * raises a DatabaseError exception.
    */
    function CheckDatabase()
    {
        if (!is_object($this->_database)) DatabaseError(_("No Database assigned or is not an object"));
    }

    public $_keyfields=array();

    function InternalClose()
    {
        $this->_rs=null;
    }

    function InternalOpen()
    {
        if (($this->ControlState & csDesigning)!=csDesigning)
        {
            $query=$this->buildQuery();
            if (trim($query)=='') DatabaseError(_("Missing query to execute"));
            $this->CheckDatabase();

            if ((trim($this->_limitstart)=='-1') && (trim($this->_limitcount)=='-1'))
            {
                $this->_rs=$this->Database->Execute($query,$this->_params);
            }
            else
            {
                $limitstart=trim($this->_limitstart);
                if ($limitstart=='') $limitstart=-1;

                $limitcount=trim($this->_limitcount);
                if ($limitcount=='') $limitcount=-1;
                $this->_rs=$this->Database->ExecuteLimit($query,$limitcount,$limitstart, $this->_params);
            }

            $this->_keyfields=$this->readKeyFields();
            if (!is_array($this->_rs->fields))
            {
                if ($this->_tablename!='')
                {
                    $fd=$this->Database->MetaFields($this->_tablename);
                    $this->_rs->fields=$fd;
                }
            }
            $this->fieldbuffer=$this->_rs->fields;
        }
    }

    function InternalFirst()
    {
        $this->_rs->MoveFirst();

            if (!is_array($this->_rs->Fields))
            {
                if ($this->_tablename!='')
                {
                    $fd=$this->Database->MetaFields($this->_tablename);
                    $this->_rs->Fields=$fd;
                }
            }
    }

    function InternalLast()
    {
        $this->_rs->MoveLast();

            if (!is_array($this->_rs->Fields))
            {
                if ($this->_tablename!='')
                {
                    $fd=$this->Database->MetaFields($this->_tablename);
                    $this->_rs->Fields=$fd;
                }
            }
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
            	if ((is_array($this->_rs->fields)) && (array_key_exists($fieldname,$this->_rs->fields)))
                {
                	if ($this->State==dsBrowse)
                    {
                    	return ($this->_rs->fields[$fieldname]);
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
            	if ((is_array(($this->_rs->fields))) && (array_key_exists($fieldname,$this->_rs->fields)))
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
    * @param string $nm  Name of the property/field to get
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
    			//If there is no such property, then try to search for a field
                return($this->fieldget($nm));
        }
    }

    /**
    * Overriden to allow get field values as properties
    *
    * @param string $nm Name of the property/field to set
    * @param mixed $val Value to set this property/field
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
        		$this->fieldset($nm,$val);
        }
    }


}

/**
 * Table encapsulates a database table.
 *
 * Use Table to access data in a single database table using adoDB. Table provides
 * direct access to every record and field in an underlying database table, whether
 * it is from an ODBC-compliant database, or an SQL database on a remote server,
 * such as InterBase, Oracle, Sybase, MS-SQL Server, Informix, or DB2. A table
 * component can also work with a subset of records within a database table using
 * ranges and filters.
 *
 */
class CustomTable extends DBDataSet
{
        protected $_tablename="";

        /**
        * Name of the table you want to access
        *
        * @return string
        */
        function readTableName() { return $this->_tablename; }
        function writeTableName($value) { $this->_tablename=$value; }
        function defaultTableName() { return ""; }

        protected $_hasautoinc="1";

        function getHasAutoInc() { return $this->_hasautoinc; }
        function setHasAutoInc($value) { $this->_hasautoinc=$value; }
        function defaultHasAutoInc() { return "1"; }



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


                try
                {
                    $updateSQL = $this->Database->_connection->AutoExecute($this->TableName, $buffer, 'UPDATE', $where);
                    $this->_rs->fields=array_merge($this->_rs->fields,$this->fieldbuffer);
                }
                catch (Exception $e)
                {
                    $this->_rs->fields=array_merge($this->_rs->fields,$this->fieldbuffer);
                    throw $e;
                }

                //TODO: Handle errors
            }
            else
            {
                $where='';
                if ($this->HasAutoInc)
                {
                  if (is_array($this->_keyfields))
                  {
                      reset($this->_keyfields);
                      while(list($key, $fname)=each($this->_keyfields))
                      {
                          unset($this->fieldbuffer[$fname]);
                      }
                  }
                }

                $insertSQL = $this->Database->_connection->AutoExecute($this->TableName, $this->fieldbuffer, 'INSERT');

                $this->_rs->fields=array_merge($this->_rs->fields,$this->fieldbuffer);
                //TODO: Handle errors
            }
        }

        /**
         * Builds the query to execute
         *
         * @return string
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

                return($result);
            }
            else return('');
        }

          /**
           * Return an array containg the row values
           *
           * @return array
           */
  function readAssociativeFieldValues()
  {
        $result=array();

        if ($this->Active)
        {
                return($this->_rs->fields);
        }

        return($result);
  }

        /**
        * Return an array with Key fields for the table
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

        /**
         * Dump hidden html fields with the key fields of this dataset
         *
         * @param string $basename Prefix to be used to generate hidden key field names
         * @param array $values Array with the values to generate
         */
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
         * Specifies the field to order this table for
         *
         * @return string
         */
    function readOrderField() { return $this->_orderfield; }
    function writeOrderField($value) { $this->_orderfield=$value; }
    function defaultOrderField() { return ""; }

    protected $_order="asc";

        /**
         * Specifies the ordering of the query, ascendant or descendant
         *
         * @return string
         */
    function readOrder() { return $this->_order; }
    function writeOrder($value) { $this->_order=$value; }
    function defaultOrder() { return "asc"; }
}

/**
 * Table encapsulates a database table.
 *
 * Use Table to access data in a single database table using adoDB. Table provides
 * direct access to every record and field in an underlying database table, whether
 * it is from an ODBC-compliant database, or an SQL database on a remote server,
 * such as InterBase, Oracle, Sybase, MS-SQL Server, Informix, or DB2. A table
 * component can also work with a subset of records within a database table using
 * ranges and filters.
 *
 */
class Table extends CustomTable
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

/**
 * Base class for Query.
 *
 * Query represents a dataset with a result set that is based on an SQL statement.
 *
 * Use Query to access one or more tables in a database using SQL statements.
 * Query components can be used with remote database servers (such as Sybase,
 * SQL Server, Oracle, Informix, DB2, and InterBase), with local tables (Paradox,
 * InterBase, dBASE, Access, and FoxPro), and with ODBC-compliant databases.
 *
 * Query components are useful because they can:
 *
 * Access more than one table at a time (called a “join” in SQL).
 *
 * Automatically access a subset of rows and columns in its underlying table(s),
 * rather than always returning all rows and columns.
 *
 */
class CustomQuery extends CustomTable
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
        function defaultParams() { return ""; }

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
 * Query represents a dataset with a result set that is based on an SQL statement.
 *
 * Use Query to access one or more tables in a database using SQL statements.
 * Query components can be used with remote database servers (such as Sybase,
 * SQL Server, Oracle, Informix, DB2, and InterBase), with local tables (Paradox,
 * InterBase, dBASE, Access, and FoxPro), and with ODBC-compliant databases.
 *
 * Query components are useful because they can:
 *
 * Access more than one table at a time (called a “join” in SQL).
 *
 * Automatically access a subset of rows and columns in its underlying table(s),
 * rather than always returning all rows and columns.
 *
 */
class Query extends CustomQuery
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
 * StoredProc encapsulates a stored procedure in an application.
 *
 * Use a StoredProc object in applications to use a stored procedure on a database server.
 * A stored procedure is a grouped set of statements, stored as part of a database server’s
 * metadata (just like tables, indexes, and domains), that performs a frequently repeated,
 * database-related task on the server and passes results to the client.
 *
 * Note:   Not all database servers support stored procedures. See a specific server’s
 * documentation to determine if it supports stored procedures.
 *
 * Many stored procedures require a series of input arguments, or parameters, that are used
 * during processing. StoredProc provides a Params property that enables an application
 * to set these parameters before executing the stored procedure.
 *
 * Params is an array of values. Depending on server implementation, a stored procedure can
 * return either a single set of values, or a result set similar to the result set returned by a query.
 */
class StoredProc extends CustomQuery
{
    protected $_storedprocname="";

    /**
    * Type of databases in which stored procedures doesn't return a result set
    */
    protected $_noFetchDBs = array("oracle","oci8");
    protected $_usecall= array("mysql");

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

    protected $_fetchquery="";

    /**
    * Use this property to specify the query to fetch results from the stored procedure call
    *
    * Servers, like MySQL, use CALL to execute stored procedures on the server, if your procedures
    * produce results in variables, you can use this property to specify the select query to
    * fetch those results
    *
    * @return string
    */
    function getFetchQuery() { return $this->_fetchquery; }
    function setFetchQuery($value) { $this->_fetchquery=$value; }
    function defaultFetchQuery() { return ""; }



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

        function Prepare()
        {
            //TODO:Handle Binding variables
            $this->Database->PrepareSP($this->buildQuery());
        }

        /**
        * Executes the stored procedure, and checks if it returns a result set
        * or not to use one method or another
        *
        * Call Execute to execute a stored procedure on the server. Before calling Execute:
        *
        * 1 - Provide any input parameters in the Params property. At design time, a developer
        * can provide parameters using the Parameters editor. At runtime an application must access Params directly.
        *
        * 2 - Call Prepare to bind the parameters.
        *
        */
        function Execute()
        {
            if (in_array($this->Database->Drivername, $this->_noFetchDBs))
            {
                $this->Database->Execute($this->buildQuery());
            }
            else
            {
                $this->Close();
                $this->Open();
            }
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

                    //Check the type of database to use a different method to
                    //execute the stored procedure
                    if (in_array($this->Database->Drivername, $this->_noFetchDBs))
                    {
                        $result="Begin ".$this->_storedprocname.$pars."; end;";
                    }
                    else
                    if (in_array($this->Database->Drivername, $this->_usecall))
                    {
                      $result="call $this->_storedprocname$pars;$this->_fetchquery";
                    }
                    else
                    {
                      $result="select * from $this->_storedprocname$pars";
                    }


                return($result);
            }
            else return('');
        }
}

?>