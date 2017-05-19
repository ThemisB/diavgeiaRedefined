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
use_unit("rtl.inc.php");

define('daFail','daFail');
define('daAbort','daAbort');


/**
 * Encapsulates a table field
 *
 * This class is used to encapsulate the name of a table field and the caption
 * to be shown on data-aware component.
 *
 */
class Field extends Object
{
        private $_fieldname;
        private $_displaylabel;

        /**
        * Indicates the name of the physical column in the underlying table or query result to which a field component is bound.
        *
        * Use FieldName to specify which field in the underlying dataset the field component represents. FieldName is used when
        * displaying references to the field to users, unless a DisplayLabel has been set.
        *
        * @see getDisplayLabel()
        * @return string
        */
        function getFieldName() { return $this->_fieldname;     }
        function setFieldName($value) { $this->_fieldname=$value; }

        /**
        * Contains the text to display in the corresponding column heading of a data grid.
        *
        * Use DisplayLabel to assign column headings to a data grid. The column headings of the data grid use
        * the DisplayName property of the field whose value they represent. Setting DisplayLabel changes the
        * read-only DisplayName property from FieldName to the string specified as DisplayLabel.
        *
        * @see getFieldName()
        * @return string
        */
        function getDisplayLabel() { return $this->_displaylabel;       }
        function setDisplayLabel($value) { $this->_displaylabel=$value; }
}

/**
 * CustomConnection, a common ancestor for all Connection objects
 *
 * A connection must represent the object which through data objects (tables, queries, etc) perform
 * their operations. Components like Database inherit from CustomConnection and implement the right
 * functionality.
 *
 */
class CustomConnection extends Component
{

    protected $_datasets=null;
    protected $_fstreamedconnected=false;

    /**
    * Provides an indexed array of all active datasets for a database component.
    *
    * Use DataSets to access active datasets associated with a database component. An active dataset is one that is currently open.
    *
    * @see readClients()
    * @return Collection
    */
    function readDataSets() { return $this->_datasets; }
    function writeDataSets($value) { $this->_datasets=$value; }
    function defaultDataSets() { return null; }

    protected $_clients=null;

    /**
    * Returns the fieldnames for the table
    *
    * Use this method to get an array with the fieldnames for an specific table.
    * This method can be useful if you want to explore the structure of a table.
    *
    * @param string $tablename Table to get the fields for
    *
    * @return array Array with fieldnames for $tablename
    */
    function MetaFields($tablename)
    {
    }

    /**
    * Begins a new transaction against the database server.
    *
    * Call BeginTrans to begin a new transaction against the database server.
    *
    * Updates, insertions, and deletions that take place after a call to StartTransaction
    * are held by the server until an application calls CompleteTrans with true to commit the changes
    * or false to Rollback
    *
    * @see completeTrans()
    */
    function BeginTrans()
    {
        //To be overriden
    }

    /**
    * Permanently stores updates, insertions, and deletions of data associated with
    * the current transaction, and ends the current transactions, but
    * if false is sent in the autocomplete parameter, then a rollback is performed
    * and then Cancels all updates, insertions, and deletions for the current
    * transaction and ends the transaction.
    *
    * Call CompleteTrans to permanently store to the database server all updates,
    * insertions, and deletions of data associated with the current transaction and
    * then end the transaction. The current transaction is the last transaction
    * started by calling BeginTrans.
    *
    * If you send false on the autocomplete parameter, then it cancels all updates,
    * insertions, and deletions for the current transaction and to end the transaction.
    * The current transaction is the last transaction started by calling BeginTrans.
    *
    * @see beginTrans()
    *
    * @param bool $autocomplete If true, the transaction will be commited, if false, will be rolled back
    * @return bool
    */
    function CompleteTrans($autocomplete=true)
    {
        //To be overriden
    }



    /**
    * Send a connect event to all the datasets, both for connecting and disconnecting
    *
    * This is an internal method used to fire a dataset connect event to all attached
    * datasets.
    *
    * @see DataSet::dataEvent()
    *
    * @param $connecting boolean specifies the status of the connection
    */
    function SendConnectEvent($connecting)
    {
        for($i=0;$i<=$this->_clients->count()-1;$i++)
        {
            $client=$this->_clients->items[$i];
            if ($client->inheritsFrom('DataSet'))
            {
                $client->DataEvent(deConnectChange, $connecting);
            }
        }
    }

    /**
    * Returns a date formatted to be used on this database, depending on the type
    *
    * You must use this method to get a data formatted in a valid format depending
    * on the type of database.
    *
    * @see param(), quoteStr()
    *
    * @param string $input Date to convert
    * @return string Date converted to a valid format
    */
    function DBDate($input)
    {
        return($input);
    }

    /**
    * Sends a query to the server for optimization prior to execution.
    *
    * Call Prepare to have a remote database server allocate resources for the
    * query and to perform additional optimizations.
    *
    * If the query will only be executed once, the application does not need to
    * explicitly call Prepare. Executing an unprepared query generates these
    * calls automatically. However, if the same query is to be executed repeatedly,
    * it is more efficient to prevent these automatic calls by calling Prepare
    * explicitly.
    *
    * @param string $query SQL sentence to be prepared
    */
    function Prepare($query)
    {

    }

    /**
    * Returns a parameter formatted depending on the database type
    *
    * When writting parametrized queries, use this method to get a parameter formatted
    * in a valid format for the current database type.
    *
    * @see DBDate(), QuoteStr()
    *
    * @param string $input Parameter name
    * @return string $input converted to a valid parameter
    */
    function Param($input)
    {
        return($input);
    }

    /**
    * Quote a string depending on the database type
    *
    * When writting queries, use this method to get a string quoted in a format
    * valid for the current database type.
    *
    * @see param(), dbDate()
    *
    * @param string $input String to quote
    * @return string $input quoted with valid quotes
    */
    function QuoteStr($input)
    {
        return($input);
    }

    /**
    * Returns the clients of this database
    *
    * @see readDatasets()
    *
    * @return Collection
    */
    function readClients() { return $this->_clients; }
    function writeClients($value) { $this->_clients=$value; }
    function defaultClients() { return null; }

    protected $_onafterconnect=null;

    /**
    * Occurs after a connection is established.
    *
    * Write an OnAfterConnect event handler to take application-specific
    * actions immediately after the connection component opens a connection to
    * the remote source of database information.
    *
    * @see readConnected(), readOnBeforeConnect()
    *
    * @return mixed
    */
    function readOnAfterConnect() { return $this->_onafterconnect; }
    function writeOnAfterConnect($value) { $this->_onafterconnect=$value; }
    function defaultOnAfterConnect() { return null; }

    protected $_onbeforeconnect=null;

    /**
    * Occurs immediately before establishing a connection.
    *
    * Write a OnBeforeConnect event handler to take application-specific actions
    * before the connection component opens a connection to the remote source of
    * database information.
    *
    * @see readConnected(), readOnAfterConnect()
    *
    * @return mixed
    */
    function readOnBeforeConnect() { return $this->_onbeforeconnect; }
    function writeOnBeforeConnect($value) { $this->_onbeforeconnect=$value; }
    function defaultOnBeforeConnect() { return null; }

    protected $_oncustomconnect=null;

    function getOnCustomConnect() { return $this->_oncustomconnect; }
    function setOnCustomConnect($value) { $this->_oncustomconnect=$value; }
    function defaultOnCustomConnect() { return null; }

    protected $_onafterdisconnect=null;

    /**
    * Occurs after the connection closes.
    *
    * Write an OnAfterDisconnect event handler to take application-specific
    * actions after the connection component drops a connection.
    *
    * @see readConnected(), readOnBeforeDisconnect()
    *
    * @return mixed
    */
    function readOnAfterDisconnect() { return $this->_onafterdisconnect; }
    function writeOnAfterDisconnect($value) { $this->_onafterdisconnect=$value; }
    function defaultOnAfterDisconnect() { return null; }

    protected $_onbeforedisconnect=null;

    /**
    * Occurs immediately before the connection closes.
    *
    * Write a BeforeDisconnect event handler to take application-specific actions
    * before dropping a connection.
    *
    * @see readConnected(), readOnAfterDisconnect()
    *
    * @return mixed
    */
    function readOnBeforeDisconnect() { return $this->_onbeforedisconnect; }
    function writeOnBeforeDisconnect($value) { $this->_onbeforedisconnect=$value; }
    function defaultOnBeforeDisconnect() { return null; }

    protected $_onlogin=null;

    /**
    * Occurs when an application connects to a database.
    *
    * Write an OnLogin event handler to take specific actions when an application
    * attempts to connect to a database.
    *
    * If there is no OnLogin event handler, the current UserName and Password are the ones used
    * from the UserName and UserPassword properties.
    *
    * These values are then passed to the remote server.
    *
    * @return mixed
    */
    function readOnLogin() { return $this->_onlogin; }
    function writeOnLogin($value) { $this->_onlogin=$value; }
    function defaultOnLogin() { return null; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->_datasets=new Collection();
                $this->_clients=new Collection();
        }

        /**
        * Opens the connection.
        *
        * Call Open to establish a connection to the remote source of database information.
        * Open sets the Connected property to true.
        *
        * @see readConnected(), close()
        */
        function Open()
        {
            $this->Connected=true;
        }


        /**
        * Closes the connection.
        *
        * Call Close to disconnect from the remote source of database information.
        * Before the connection component is deactivated, all associated datasets are
        * closed. Calling Close is the same as setting the Connected property to false.
        *
        * @see readConnected(), open()
        */
        function Close()
        {
            $this->Connected=false;
        }


        function loaded()
        {
                parent::loaded();
                if ($this->_fstreamedconnected)
                {
                    $this->Connected=true;
                }
        }

        /**
        * Determines whether a connection has been established to the remote source of data.
        *
        * Set Connected to true to open the connection. Set Connected to false to terminate the connection.
        *
        * Setting Connected to true generates a OnBeforeConnect event, calls the protected
        * DoConnect method to establish the connection, and generates an OnAfterConnect event.
        * In addition, when setting Connected to true.
        *
        * Setting Connected to false generates a OnBeforeDisconnect event, calls the protected
        * DoConnect method to drop the connection, and generates an OnAfterDisconnect event.
        *
        * When deriving custom connection components from CustomConnection, override readConnected to return
        * true when a connection is established, and override DoConnect and DoDisconnect to create and drop
        * the connection.
        *
        * @see Open(), Close()
        * @return boolean
        */
        function readConnected() { return "0"; }
        function writeConnected($value)
        {
            if (($this->ControlState & csLoading)==csLoading)
            {
                $this->_fstreamedconnected=$value;
            }
            else
            {
                if ($value == $this->readConnected())
                {
                }
                else
                {
                    if ($value)
                    {
                        $this->callEvent("onbeforeconnect",array());
                        $this->DoConnect();
                        $this->SendConnectEvent(true);
                        $this->callEvent("onafterconnect",array());
                    }
                    else
                    {
                        $this->callEvent("onbeforedisconnect",array());
                        $this->SendConnectEvent(false);
                        $this->DoDisconnect();
                        $this->callEvent("onafterdisconnect",array());
                    }
                }
            }
        }
        function defaultConnected() { return "0"; }

        /**
        * Provides the interface for a method that opens a connection.
        *
        * The Connected property uses DoConnect to establish a connection.
        * Descendant classes override the DoConnect method to establish their
        * connection as appropriate. As implemented in CustomConnection,
        * DoConnect does nothing.
        *
        * @see open(), close(), readConnected()
        */
        function DoConnect()
        {
            //Override this
        }

        /**
        * Provides the interface for a method that terminates the connection.
        *
        * The Connected property uses DoDisconnect to close a connection.
        * Descendant classes override the DoDisconnect method to drop a connection.
        * As implemented in CustomConnection, DoDisconnect does nothing.
        *
        * @see open(), close(), readConnected()
        */
        function DoDisconnect()
        {
            //Override this
        }
}


define('deFieldChange',1);
define('deRecordChange',2);
define('deDataSetChange',3);
define('deDataSetScroll',4);
define('deLayoutChange',5);
define('deUpdateRecord',6);
define('deUpdateState',7);
define('deCheckBrowseMode',8);
define('dePropertyChange',9);
define('deFieldListChange',10);
define('deFocusControl',11);
define('deParentScroll',12);
define('deConnectChange',13);
define('deReconcileError',14);
define('deDisabledStateChange',15);

define('dsInactive'    ,1);
define('dsBrowse'      ,2);
define('dsEdit'        ,3);
define('dsInsert'      ,4);
define('dsSetKey'      ,5);
define('dsCalcFields'  ,6);
define('dsFilter'      ,7);
define('dsNewValue'    ,8);
define('dsOldValue'    ,9);
define('dsCurValue'    ,10);
define('dsBlockRead'   ,11);
define('dsInternalCalc',12);
define('dsOpening'     ,13);

/**
* Exception for a DatabaseError
*
* This exception is raised whenever a data access component generates an error.
*
* @see DatabaseError
*/
class EDatabaseError extends Exception { }

/**
* Function to raise a Database Error
*
* Call DatabaseError to raise an EDatabaseError exception, using Message as the text for the exception.
* If a component is provided as the second parameter, the message is prefixed by the name of the component to help
* in interpreting the error message.
*
* Calling DatabaseError rather than creating and raising the exception directly in code reduces the overall code size of the application.
*
* @see EDatabaseError
*
* @param string $message Message of the exception to show
* @param Component $component Component is raising the exception
*/
function databaseError($message, $component=null)
{
  if ((assigned($component)) && ($component->Name != ''))
  {
    throw new EDatabaseError(sprintf('%s: %s', $component->Name, $message));
  }
  else
  {
    throw new EDatabaseError($message);
  }
}

/**
* DataSet component, base class to inherit and create dataset components
*
* A DataSet is a collection of information, organized in rows and fields, and this class
* implement the basic interface all data-aware components will use to show information.
*
* A DataSet is not attached to an specific source of information, you can, for example, create a
* DataSet that provide information from a memory array.
*
*/
class DataSet extends Component
{
        protected $_limitstart='0';
        protected $_limitcount='10';

        /**
        * Defines the starting record to filter the dataset with
        *
        * Use this property to filter the dataset and to set which is the first
        * record to be added to the set.
        *
        * @see getLimitCount()
        *
        * @return integer
        */
        function getLimitStart() { return $this->_limitstart;   }
        function setLimitStart($value) { $this->_limitstart=$value;     }
        function defaultLimitStart() { return "0"; }

        /**
        * Defines how many records will be shown
        *
        * Use this property to set how many records do you want to get on the
        * set, at max.
        *
        * @see getLimitStart()
        *
        * @return integer
        */
        function getLimitCount() { return $this->_limitcount;   }
        function setLimitCount($value) { $this->_limitcount=$value; }
        function defaultLimitCount() { return "10"; }

        /**
        * Override this method to perform the closing of the dataset
        *
        * This method is called internally by the engine to close the dataset.
        * Is not intended to be called directly the component user.
        *
        * @see Close()
        *
        */
        function internalClose() {}

        /**
        * Override this method to handle exceptions
        *
        * This method is called internally by the engine to handle an exception using
        * the dataset.
        *
        * Is not intended to be called directly the component user.
        */
        function internalHandleException() {}

        /**
        * Override this method to init field definitions. Not used.
        */
        function internalInitFieldDefs() {}

        /**
        * Override this method to perform the opening of the dataset
        *
        * This method is called internally by the engine to open the dataset.
        * Is not intended to be called directly the component user.
        *
        * @see open()
        *
        */
        function internalOpen() {}

        /**
        * Override this method to return if the cursor is open or not
        *
        * This method is called internally by the engine to determine if the cursor
        * is open or not.
        *
        * Is not intended to be called directly the component user.
        *
        * @return boolean True if cursor is open
        */
        function isCursorOpen() {}

        /**
        * This property returns an array with the field names and values
        *
        * Use Fields to access fields that make up this dataset.
        * The order of field components in Fields corresponds directly to the
        * order of columns in the table or tables underlying a dataset.
        *
        * Accessing fields with the Fields property is useful for applications that:
        *
        * Iterate over some or all fields in a dataset.
        *
        * Work with underlying tables whose internal data structure is unknown at runtime.
        *
        * If an application knows the data types of individual fields, then it can read
        * or write individual field values through the Fields property.
        *
        * @return array
        */
        function readFields() { return array(); }

        /**
        * Indicates the number of field components associated with the dataset.
        *
        * Examine FieldCount to determine the number of fields listed by the Fields property.
        *
        * @return integer
        */
        function readFieldCount() { return 0; }

        /**
        * Buffer to hold values for searching/filtering
        */
        public $fieldbuffer=array();

        protected $_recordcount=0;
        protected $_state=dsInactive;
        protected $_modified=false;
        protected $_InternalOpenComplete=false;
        protected $_DefaultFields=false;
        protected $_DisableCount=0;

        protected $_datasetfield=null;

        /**
        * Indicates the persistent DataSetField object that owns a nested dataset.
        *
        * Not used.
        *
        * @return Field
        */
        function readDataSetField() { return $this->_datasetfield; }
        function writeDataSetField($value) { $this->_datasetfield=$value; }
        function defaultDataSetField() { return null; }

        /**
        * Indicates the current operating mode of the dataset.
        *
        * Examine State to determine the current operating mode of the dataset.
        * State determines what can be done with data in a dataset, such as editing
        * existing records or inserting new ones. The dataset state constantly changes
        * as an application processes data.
        *
        * Opening a dataset changes State from dsInactive to dsBrowse. An application
        * can call Edit to put a dataset into dsEdit state, or call Insert to put a
        * dataset into dsInsert state.
        *
        * Posting or canceling edits, insertions, or deletions, changes State from
        * its current state to dsBrowse. Closing a dataset changes its state to dsInactive.
        *
        * @return enum
        */
        function readState() { return $this->_state; }
        function writeState($value) { $this->_state=$value; }
        function defaultState() { return dsInactive; }

        protected $_mastersource=null;

        protected $_masterfields=array();

        /**
        * Specifies one or more fields in a master table to link with corresponding
        * fields in this table in order to establish a master-detail relationship
        * between the tables.
        *
        * Use MasterFields after setting the MasterSource property to specify the
        * names of one or more fields to use in establishing a detail-master
        * relationship between this table and the one specified in MasterSource.
        *
        * MasterFields is an array containing one or more field names in the master table.
        *
        * Each time the current record in the master table changes, the new values in
        * those fields are used to select corresponding records in this table for display.
        *
        * @see readMasterSource()
        *
        * @return array
        */
        function readMasterFields() { return $this->_masterfields; }
        function writeMasterFields($value) { $this->_masterfields=$value; }
        function defaultMasterFields() { return array(); }

        /**
        * Specifies the name of the data source for a dataset to use as a master
        * table in establishing a detail-master relationship between this table and another one.
        *
        * Use MasterSource to specify the name of the data source component whose DataSet
        * property identifies a dataset to use as a master table in establishing a detail-master
        * relationship between this table and another one.
        *
        * Note: At design time choose an available data source from the MasterSource property’s
        * drop-down list in the Object Inspector.
        *
        * After setting the MasterSource property, specify which fields to use in the master
        * table by setting the MasterFields property. At runtime each time the current record
        * in the master table changes, the new values in those fields are used to select corresponding
        * records in this table for display.
        *
        * @see readMasterFields()
        *
        * @return DataSource
        */
        function readMasterSource() { return $this->_mastersource;   }
        function writeMasterSource($value)
        {
                $this->_mastersource=$this->fixupProperty($value);
        }

        protected $_recno=0;

        /**
        * Indicates the current record in the dataset.
        *
        * Examine RecNo to determine the record number of the current record in the dataset.
        * Applications might use this property with RecordCount to iterate through all
        * the records in a dataset, though typically record iteration is handled with calls
        * to First, Last, MoveBy, Next, and Prior.
        *
        * @see readRecKey()
        *
        * @return integer
        */
        function readRecNo() { return $this->_recno; }
        function writeRecNo($value)
        {
            if ($value!=$this->_recno)
            {
                $diff=$value-$this->_recno;
                if ($diff>0)
                {
                    $this->MoveBy($diff);
                }
                $this->_recno=$value;
            }
        }
        function defaultRecNo() { return 0; }

        protected $_reckey=array();

        /**
        * Specifies the record key for this dataset
        *
        * This property specifies the fields and values that determine
        * the key of a record.
        *
        * @see readRecNo()
        *
        * @return array
        */
        function readRecKey() { return $this->_reckey; }
        function writeRecKey($value) { $this->_reckey=$value; }
        function defaultRecKey() { return ""; }

        function serialize()
        {
                parent::serialize();

                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".";
                        $_SESSION[$prefix."State"] = $this->_state;
//                        $_SESSION[$prefix."FieldBuffer"] = serialize($this->fieldbuffer);
//                        if (!empty($this->_regkey))
//                        {
//                            $_SESSION[$prefix."RegKey"] = serialize($this->_regkey);
//                        }
//                        $_SESSION[$prefix."RegKey"] = serialize($this->_regkey);
//                        $_SESSION[$prefix."RecNo"] = $this->_recno;
                }
        }

        function unserialize()
        {
                parent::unserialize();
                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".";
                        if (isset($_SESSION[$prefix."State"])) $this->_state= $_SESSION[$prefix."State"];
//                        if (isset($_SESSION[$prefix."FieldBuffer"])) $this->fieldbuffer= unserialize($_SESSION[$prefix."FieldBuffer"]);
//                        if (isset($_SESSION[$prefix."RegKey"])) $this->_regkey= unserialize($_SESSION[$prefix."RegKey"]);
//                        if (isset($_SESSION[$prefix."RecNo"]))
//                        {
//                            $this->RecNo= $_SESSION[$prefix."RecNo"];
//                        }
                }
        }

        /**
        * Indicates whether the active record is modified.
        *
        * Check Modified to determine if the active record is modified. If Modified
        * is true, the active record is modified. If false, the active record is not modified.
        *
        * Note: In general, an application need not check the status of Modified.
        * Properties, events, and methods of TDataSet and its descendants that modify records
        * generally check this status automatically and take appropriate actions based on its value.
        *
        * @see redCanModify()
        *
        * @return boolean
        */
        function readModified() { return $this->_modified; }
        function writeModified($value) { $this->_modified=$value; }
        function defaultModified() { return false; }

        protected $_canmodify=true;

        /**
        * Indicates whether an application can insert, edit, and delete data in a table.
        *
        * Check the status of CanModify to determine if an application can modify a
        * dataset in any way. If CanModify is true, the dataset can be modified. If
        * CanModify is false, the table is read-only.
        *
        * CanModify is set automatically when an application opens a table. If the ReadOnly
        * property of a table component is true, then CanModify is set to false.
        *
        * Note: Even if CanModify is true, it is not a guarantee that a user will be able
        * to insert or update records in a table. Other factors may come in to play,
        * for example, SQL access privileges.
        *
        * @see readModified()
        *
        * @return boolean
        */
        function readCanModify() { return $this->_canmodify; }
        function writeCanModify($value) { $this->_canmodify=$value; }
        function defaultCanModify() { return true; }

        protected $_onbeforeopen=null;

        /**
        * Occurs before an application executes a request to open a dataset.
        *
        * Write a OnBeforeOpen event handler to take specific action before an
        * application opens a dataset for viewing or editing. OnBeforeOpen is
        * triggered when an application sets the Active property to true for
        * a dataset or an application calls Open.
        *
        * @see readOnAfterOpen()
        *
        * @return mixed
        */
        function readOnBeforeOpen() { return $this->_onbeforeopen; }
        function writeOnBeforeOpen($value) { $this->_onbeforeopen=$value; }
        function defaultOnBeforeOpen() { return null; }

        protected $_onafteropen=null;

        /**
        * Occurs after an application completes opening a dataset and before any data access occurs.
        *
        * Write an AfterOpen event handler to take specific action immediately after an
        * application opens the dataset. AfterOpen is called after the dataset establishes
        * access to its data and the dataset is put into dsBrowse state. For example,
        * an AfterOpen event handler might check an ini file to determine the last record
        * touched in the dataset the previous time the application ran, and position the
        * dataset at that record.
        *
        * @see readOnBeforeOpen()
        *
        * @return mixed
        */
        function readOnAfterOpen() { return $this->_onafteropen; }
        function writeOnAfterOpen($value) { $this->_onafteropen=$value; }
        function defaultOnAfterOpen() { return null; }

        protected $_onbeforeclose=null;

        /**
        * Occurs immediately before the dataset closes.
        *
        * Write a OnBeforeClose event to take specific action before an application
        * closes a dataset. Calling Close or setting the Active property to false
        * results in a call to the OnBeforeClose event handler.
        *
        * @see readOnAfterClose()
        *
        * @return mixed
        */
        function readOnBeforeClose() { return $this->_onbeforeclose; }
        function writeOnBeforeClose($value) { $this->_onbeforeclose=$value; }
        function defaultOnBeforeClose() { return null; }

        protected $_onafterclose=null;

        /**
        * Occurs after an application closes a dataset.
        *
        * Write an OnAfterClose event handler to take specific action immediately
        * after an application closes a dataset.
        *
        * OnAfterClose is called after a dataset is closed and the dataset state
        * is set to dsInactive.
        *
        * @see readOnBeforeClose()
        *
        * @return mixed
        */
        function readOnAfterClose() { return $this->_onafterclose; }
        function writeOnAfterClose($value) { $this->_onafterclose=$value; }
        function defaultOnAfterClose() { return null; }

        protected $_onbeforeinsert=null;

        /**
        * Occurs before an application enters insert mode.
        *
        * Write a OnBeforeInsert event handler to take specific action before an
        * application inserts or appends a new record. The Insert or Append method
        * generates a OnBeforeInsert method before it sets the dataset into dsInsert state.
        *
        * @see readOnAfterInsert()
        *
        * @return mixed
        */
        function readOnBeforeInsert() { return $this->_onbeforeinsert; }
        function writeOnBeforeInsert($value) { $this->_onbeforeinsert=$value; }
        function defaultOnBeforeInsert() { return null; }

        protected $_onafterinsert=null;

        /**
        * Occurs after an application inserts a new record.
        *
        * Write an OnAfterInsert event handler to take specific action immediately
        * after an application inserts a record. The Insert and Append methods generate
        * an OnAfterInsert event after inserting or appending a new record.
        *
        * @see readOnBeforeInsert()
        *
        * @return mixed
        */
        function readOnAfterInsert() { return $this->_onafterinsert; }
        function writeOnAfterInsert($value) { $this->_onafterinsert=$value; }
        function defaultOnAfterInsert() { return null; }

        protected $_onbeforeedit=null;

        /**
        * Occurs before an application enters edit mode for the active record.
        *
        * Write a OnBeforeEdit event handler to take specific action before an
        * application enables editing of the active record. For example, an
        * application that keeps a log of database edits could use the OnBeforeEdit
        * event to record the edit request, time, and user before entering edit state.
        *
        * @see readOnAfterEdit()
        *
        * @return mixed
        */
        function readOnBeforeEdit() { return $this->_onbeforeedit; }
        function writeOnBeforeEdit($value) { $this->_onbeforeedit=$value; }
        function defaultOnBeforeEdit() { return null; }

        protected $_onafteredit=null;

        /**
        * Occurs after an application starts editing a record.
        *
        * Write an OnAfterEdit event handler to take specific action immediately
        * after dataset enters edit mode. OnAfterEdit is called by Edit after it
        * enables editing of a record, recalculates calculated fields, and calls
        * the data event handler to process a record change.
        *
        * @see readOnBeforeEdit()
        *
        * @return mixed
        */
        function readOnAfterEdit() { return $this->_onafteredit; }
        function writeOnAfterEdit($value) { $this->_onafteredit=$value; }
        function defaultOnAfterEdit() { return null; }

        protected $_onbeforepost=null;

        /**
        * Occurs before an application posts changes for the active record to the database or change log.
        *
        * Write a OnBeforePost event handler to take specific action before an
        * application posts dataset changes. OnBeforePost is triggered when an
        * application calls the Post method. Post checks to make sure all required
        * fields are present, then calls OnBeforePost before posting the record.
        *
        * An application might use OnBeforePost to perform validity checks on data
        * changes before committing them. If it encountered a validity problem, it
        * could call Abort to cancel the Post operation.
        *
        * @see readOnAfterPost()
        *
        * @return mixed
        */
        function readOnBeforePost() { return $this->_onbeforepost; }
        function writeOnBeforePost($value) { $this->_onbeforepost=$value; }
        function defaultOnBeforePost() { return null; }

        protected $_onafterpost=null;

        /**
        * Occurs after an application writes the active record to the database or change log and returns to browse state.
        *
        * Write an OnAfterPost event handler to take specific action immediately
        * after an application posts a change to the active record. OnAfterPost
        * is called after a modification or insertion is made to a record.
        *
        * @see readOnBeforePost()
        *
        * @return mixed
        */
        function readOnAfterPost() { return $this->_onafterpost; }
        function writeOnAfterPost($value) { $this->_onafterpost=$value; }
        function defaultOnAfterPost() { return null; }

        protected $_onbeforecancel=null;

        /**
        * Occurs before an application executes a request to cancel changes to the active record.
        *
        * Write a OnBeforeCancel event to take specific action before an application
        * carries out a request to cancel changes. OnBeforeCancel is called by the
        * Cancel method before it cancels a dataset operation such as Edit, Insert, or Delete.
        *
        * An application might use the OnBeforeCancel event to record a user’s changes in an undo buffer.
        *
        * @see readOnAfterCancel()
        *
        * @return mixed
        */
        function readOnBeforeCancel() { return $this->_onbeforecancel; }
        function writeOnBeforeCancel($value) { $this->_onbeforecancel=$value; }
        function defaultOnBeforeCancel() { return null; }

        protected $_onaftercancel=null;

        /**
        * Occurs after an application completes a request to cancel modifications to the active record.
        *
        * Write an OnAfterCancel event handler to take specific action after an
        * application cancels changes to the active record. OnAfterCancel is called by the
        * Cancel method after it updates the current position, releases the lock on
        * the active record if necessary, and sets the dataset state to dsBrowse.
        * If an application requires additional processing before returning control to
        * a user after a Cancel event, code it in the OnAfterCancel event.
        *
        * @see readOnBeforeCancel()
        *
        * @return mixed
        */
        function readOnAfterCancel() { return $this->_onaftercancel; }
        function writeOnAfterCancel($value) { $this->_onaftercancel=$value; }
        function defaultOnAfterCancel() { return null; }

        protected $_onbeforedelete=null;

        /**
        * Occurs before an application attempts to delete the active record.
        *
        * Write a BeforeDelete event handler to take specific action before an
        * application deletes the active record. OnBeforeDelete is called by
        * Delete before it actually deletes a record.
        *
        * @see readOnAfterCancel()
        *
        * @return mixed
        */
        function readOnBeforeDelete() { return $this->_onbeforedelete; }
        function writeOnBeforeDelete($value) { $this->_onbeforedelete=$value; }
        function defaultOnBeforeDelete() { return null; }

        protected $_onafterdelete=null;

        /**
        * Occurs after an application deletes a record.
        *
        * Write an OnAfterDelete event handler to take specific action immediately
        * after an application deletes the active record in a dataset. OnAfterDelete
        * is called by Delete after it deletes the record, sets the dataset state to
        * dsBrowse, and repositions the current record.
        *
        * @see readOnBeforeDelete()
        *
        * @return mixed
        */
        function readOnAfterDelete() { return $this->_onafterdelete; }
        function writeOnAfterDelete($value) { $this->_onafterdelete=$value; }
        function defaultOnAfterDelete() { return null; }

        protected $_oncalcfields=null;

        /**
        * Occurs when an application recalculates calculated fields.
        *
        * (not used)
        *
        * @return mixed
        */
        function readOnCalcFields() { return $this->_oncalcfields; }
        function writeOnCalcFields($value) { $this->_oncalcfields=$value; }
        function defaultOnCalcFields() { return null; }

        protected $_ondeleteerror=null;

        /**
        * Not used, reserved for future use
        */
        function readOnDeleteError() { return $this->_ondeleteerror; }
        function writeOnDeleteError($value) { $this->_ondeleteerror=$value; }
        function defaultOnDeleteError() { return null; }

        protected $_filter="";

        /**
        * Specifies the text of the current filter for a dataset.
        *
        * Use Filter to specify a dataset filter. When filtering is applied to a
        * dataset, only those records that meet a filter’s conditions are available.
        * Filter describes the filter condition.
        *
        * @return string
        */
        function readFilter() { return $this->_filter; }
        function writeFilter($value)
        {
            if ($value!=$this->_filter)
            {
                //$this->Close();
                $this->_filter=$value;
                //$this->Open();
            }
        }
        function defaultFilter() { return ""; }



        protected $_onfilterrecord=null;

        /**
        * Not used, reserved for future use
        */
        function readOnFilterRecord() { return $this->_onfilterrecord; }
        function writeOnFilterRecord($value) { $this->_onfilterrecord=$value; }
        function defaultOnFilterRecord() { return null; }

        protected $_onnewrecord=null;

        /**
        * Not used, reserved for future use
        */
        function readOnNewRecord() { return $this->_onnewrecord; }
        function writeOnNewRecord($value) { $this->_onnewrecord=$value; }
        function defaultOnNewRecord() { return null; }

        protected $_onposterror=null;

        /**
        * Not used, reserved for future use
        */
        function readOnPostError() { return $this->_onposterror; }
        function writeOnPostError($value) { $this->_onposterror=$value; }
        function defaultOnPostError() { return null; }


        /**
        * Checks if an specific operation can be made, if not, calls $ErrorEvent
        * @param string $Operation Operation to perform on the dataset
        * @param string $ErrorEvent Event to call if there is any error
        */
        function checkOperation($Operation, $ErrorEvent)
        {
            $Done = false;
            do
            {
                try
                {
//                $this->UpdateCursorPos();
                  $this->$Operation();
                  $Done=true;
                }
                catch (EDatabaseError $e)
                {
                    $Action=daFail;
                    $Action=$this->callEvent($ErrorEvent, array('Exception'=>$e, 'Action'=>$Action));
                    if ($Action===null) $Action=daFail;
                    if ($Action==daFail) throw $e;
                    if ($Action==daAbort) Abort();
                }

            }
            while(!$Done);
        }

        /**
        * Used to notify attached datasets about an specific event
        * @param integer $event Event to notify
        * @param array $info Info for the event
        */
        function dataEvent($event, $info)
        {
            $NotifyDataSources = !(($this->ControlsDisabled()) || ($this->State == dsBlockRead));

            switch($event)
            {
            /*
    deFieldChange:
      begin
        if TField(Info).FieldKind in [fkData, fkInternalCalc] then
          SetModified(True);
        UpdateCalcFields;
      end;
    deFieldListChange:
      FieldList.Updated := False;
    dePropertyChange:
      FieldDefs.Updated := False;
    deCheckBrowseMode:
      CheckNestedBrowseMode;
    deDataSetChange, deDataSetScroll:
      NotifyDetails;
    deLayoutChange:
      begin
        FieldList.Updated := False;
        if ControlsDisabled then
          FEnableEvent := deLayoutChange;
      end;
    deUpdateState:
      if ControlsDisabled then
      begin
        Event := deDisabledStateChange;
        Info := Integer(State <> dsInactive);
        NotifyDataSources := True;
        FEnableEvent := deLayoutChange;
      end;
      */
      }
        /*
        if ($NotifyDataSources)
        {
            for I := 0 to FDataSources.Count - 1 do
              TDataSource(FDataSources[I]).DataEvent(Event, Info);
        }
        */
        }

        /**
        * Checks to see if the database connection is active.
        *
        * Call CheckActive to determine if the connection to a database server is active.
        * If the database connection is inactive, an DatabaseError exception is raised.
        *
        * @see databaseError()
        */
        function checkActive()
        {
            if ($this->State == dsInactive) DatabaseError(_("Cannot perform this operation on a closed dataset"), $this);
        }

        /**
        * Checks to see if the dataset can be modified.
        *
        * Call CheckCanModify to determine if the dataset can be modified.
        * If the dataset cannot be modified, an DatabaseError exception is raised.
        *
        * @see databaseError()
        */
        function checkCanModify()
        {
            if (!$this->CanModify) DatabaseError(_("Cannot modify a read-only dataset", Self));
        }

        /**
        * Indicates whether data-aware controls update their display to reflect changes to the dataset.
        *
        * Call ControlsDisabled to ascertain whether the updating of data display in data-aware
        * controls is currently disabled. If ControlsDisabled is true, controls are currently disabled.
        * ControlsDisabled is true as long as the reference count that keeps track of disabling for the
        * dataset is greater than zero. This count is incremented every time the DisableControls method
        * is called and decremented when EnableControls is called. Applications call DisableControls to
        * improve performance and prevent constant updates during automated iterations through records in
        * the dataset.
        *
        * In complex applications, when controls may be disabled multiple times by different processes, you
        * can use ControlsDisabled as a check in a procedure to reenable controls should each call to
        * DisableControls not be paired with a subsequent call to EnableControls.
        *
        * @see disableControls(), enableControls()
        *
        * @return boolean True if controls has been disabled
        */
        function controlsDisabled()
        {
            return($this->_DisableCount!=0);
        }

        /**
        * Disables data display in data-aware controls associated with the dataset.
        *
        * Call DisableControls prior to iterating through a large number of records
        * in the dataset to prevent data-aware controls from updating every time
        * the active record changes. Disabling controls speeds performance because
        * data does not need to be processed by data-aware controls.
        *
        * If controls are not already disabled, DisableControls records the current
        * state of the dataset, broadcasts the state change to all associated data-aware
        * controls and detail datasets, and increments the dataset’s disabled count variable.
        * Otherwise, DisableControls just increments the disabled count variable.
        *
        * The disabled count is used internally to determine whether to display data
        * in data-aware controls. When the disable count variable is greater than zero,
        * data is not updated.
        *
        * If the dataset is the master of a master/detail relationship, calling DisableControls
        * also disables the master/detail relationship.
        *
        * Note: Calls to DisableControls can be nested. Only when all calls to DisableControls
        * is matched to a corresponding call to EnableControls does the dataset update
        * data controls and detail datasets.
        *
        * @see ControlsDisabled(), EnableControls()
        */
        function DisableControls()
        {
            if ($this->_DisableCount == 0)
            {
                $this->_DisableState=$this->State;
                $this->_EnableEvent=deDataSetChange;
            }
            $this->_DisableCount++;
        }

        /**
        * Enable controls attached to the datasource
        *
        * Call EnableControls to permit data display in data-aware controls after
        * a prior call to DisableControls. EnableControls decrements the disabled
        * count variable for the dataset if it is not already zero. If the disable
        * count variable is zero, EnableControls updates the current state of the
        * dataset, if necessary, and then tells associated controls to re-enable display.
        *
        * @see DisableControls(), EnableControls()
        *
        */
        function EnableControls()
        {
            if ($this->_DisableCount!=0)
            {
                $this->_DisableCount--;
                if ($this->_DisableCount==0)
                {
                    if ($this->_DisableState!=$this->State) $this->DataEvent(deUpdateState, 0);
                    if (($this->_DisableState!=dsInactive) && ($this->_State != dsInactive)) $this->DataEvent($this->_EnableEvent, 0);
                }
            }
        }

        /**
        * Clear buffers associated with the dataset
        *
        * This method set the dataset buffers to the inital state, that is, recordcount
        * to 0 and bof/eof to true. The fieldbuffer is also cleared to an empty array.
        *
        */
        function clearBuffers()
        {
            $this->_recordcount = 0;
//            $this->_activerecord = 0;
//            $this->_currentrecord = -1;
            $this->_bof = true;
            $this->_eof = true;
            $this->fieldbuffer=array();
        }

        /**
        * Begins an insert/append operation
        *
        * This method is called by the dataset to start an insert or append
        * operation, it first checks the browse mode, after that, checks if the
        * dataset can be modified and finally, calls the OnBeforeInsert event
        *
        * @see insert(), append(), endInsertAppend()
        */
        function beginInsertAppend()
        {
            $this->CheckBrowseMode();
            $this->CheckCanModify();
            $this->callEvent('onbeforeinsert', array());
            $this->CheckParentState();
        }

        /**
        * Finishes an insert/append operation
        *
        * This method is called by a dataset to finish an insert or append
        * operation. It sets the dataset in insert state, calls the OnNewRecord
        * event and finally calls the OnAfterInsert.
        *
        * @see insert(), append(), endInsertAppend()
        */
        function endInsertAppend()
        {
            $this->State=dsInsert;
            try
            {
                $this->callEvent('onnewrecord',array());
            }
            catch (Exception $e)
            {
                $this->UpdateCursorPos();
                $this->FreeFieldBuffers();
                $this->State=dsBrowse;
                throw $e;
            }
            $this->_modified = false;
            $this->DataEvent(deDataSetChange, 0);
            $this->callEvent('onafterinsert',array());
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
        * Inserts a new, empty record in the dataset.
        *
        * Call Insert to:
        *
        * 1 - Open a new, empty record in the dataset.
        * 2 - Set the active record to the new record.
        *
        * After a call to Insert, an application can allow users to enter data
        * in the fields of the record, and then post those changes to the database
        * or change log using Post.
        *
        * @see beginInsertAppend(), endInsertAppend(), append()
        */
        function insert()
        {
            $this->BeginInsertAppend();
            //OldCurrent := Bookmark;
            //MoveBuffer(FRecordCount, FActiveRecord);
            //Buffer := ActiveBuffer;
            //InitRecord(Buffer);
            //if FRecordCount = 0 then
            //SetBookmarkFlag(Buffer, bfBOF) else
            //SetBookmarkData(Buffer, Pointer(OldCurrent));
            //if FRecordCount < FBufferCount then Inc(FRecordCount);
            $this->InternalInsert();
            $this->EndInsertAppend();
        }

        /**
        * Adds a new, empty record to the end of the dataset.
        *
        * For datasets that permit editing, call Append to:
        *
        * 1 - Open a new, empty record at the end of the dataset.
        * 2 - Set the active record to the new record.
        *
        * After a call to Append, an application can enable users to enter data
        * in the fields of the record, and can then post those changes to the
        * database or change log using Post
        *
        * @see beginInsertAppend(), endInsertAppend(), insert()
        */
        function append()
        {
                $Buffer="";
                $this->BeginInsertAppend();
                $this->ClearBuffers();
                $this->InitRecord($Buffer);
                $this->_recordcount = 1;
                $this->_bof = False;
//                $this->GetPriorRecords();
                $this->InternalInsert();
                $this->EndInsertAppend();
        }

        /**
        * Cancels modifications to the active record if those changes are not yet posted.
        *
        * Call Cancel to undo modifications made to one or more fields belonging to
        * the active record. As long as those changes are not already posted, Cancel
        * returns the record to its previous state, and sets the dataset state to dsBrowse.
        *
        * Typically Cancel is used to back out of changes in response to user request, or
        * in field validation routines that back out illegal field values.
        *
        * Note: If the dataset is not in an editing state (dsEdit or dsInsert), Cancel does nothing.
        *
        * @see edit(), insert()
        */
        function cancel()
        {
            switch($this->State)
            {
                case dsEdit:
                case dsInsert:
                {
                    $this->DataEvent(deCheckBrowseMode, 0);
                    $this->callEvent("onbeforecancel",array());
//                    $DoScrollEvents = ($this->State == dsInsert);
//                    if ($DoScrollEvents) $this->DoBeforeScroll();
//                    $this->UpdateCursorPos();
                    $this->InternalCancel();
                    $this->fieldbuffer=array();
                    $this->State=dsBrowse;
                    //$this->Resync([]);
                    $this->callEvent("onaftercancel",array());
//                    if ($DoScrollEvents) $this->DoAfterScroll();
                    break;
                }
            }
        }

        /**
        * Ensures that data-aware controls and detail datasets reflect record updates.
        *
        * UpdateRecord is used internally by some dataset methods to inform data-aware
        * controls of updates and trigger an OnUpdateRecord event if updates
        * are enabled. Applications should not need to call UpdateRecord directly unless
        * they provide custom dataset methods that bypass DataSet methods.
        *
        * @see edit(), insert()
        */
        function updateRecord()
        {
            if (($this->State!=dsEdit) && ($this->State!=dsInsert) && ($this->State!=dsSetKey)) DatabaseError(_("Dataset not in edit or insert mode"), $this);
            $this->DataEvent(deUpdateRecord,0);
        }

        /**
        * Automatically posts or cancels data changes when the active record changes.
        *
        * CheckBrowseMode is used internally by many dataset methods to ensure that
        * modifications to the active record are posted when a dataset’s state is
        * dsEdit, dsInsert, or dsSetKey and a method switches to a different record.
        *
        * If State is dsEdit or dsInsert, CheckBrowseMode calls UpdateRecord, and,
        * if the Modified property for the dataset is true, calls Post. If Modified
        * is false, CheckBrowseMode calls Cancel.
        *
        * If State is dsSetKey, CheckBrowseMode calls Post.
        *
        * If State is dsInactive, CheckBrowseMode raises an exception.
        *
        * If an application uses existing dataset methods, CheckBrowseMode is always
        * called when necessary, so there is usually no need to call CheckBrowseMode directly.
        *
        * Applications that provide custom dataset routines may need to call CheckBrowseMode
        * inside those routines to guarantee that changes are posted when switching to a different record.
        *
        * @see edit(), insert(), checkActive(), dataEvent(), updateRecord(), post(), cancel()
        */
        function checkBrowseMode()
        {
            $this->CheckActive();
            $this->DataEvent(deCheckBrowseMode, 0);
            switch($this->State)
            {
                case dsEdit:
                case dsInsert:
                {
                    $this->UpdateRecord();
                    if ($this->Modified) $this->post();
                    else $this->cancel();
                    break;
                }
                case dsSetKey:
                {
                    $this->post();
                    break;
                }
            }
        }

        /**
        * Closes a dataset.
        *
        * Call Close to set the Active property of a dataset to false. When Active
        * is false, the dataset is closed; it cannot read or write data and data-aware
        * controls can’t use it to fetch data or post edits.
        *
        * An application must close the dataset before changing properties that affect the
        * status of the database or the controls that display data in an application.
        * For example, to change the DataSource property for a dataset, the dataset must
        * be closed. Closing the dataset puts it into the dsInactive state.
        *
        * @see open()
        */
        function close()
        {
            $this->Active=false;
        }

        /**
        * Deletes the active record and positions the dataset on the next record.
        *
        * Call Delete to remove the active record from the database. If the dataset
        * is inactive, Delete raises an exception. Otherwise, Delete:
        *
        * Verifies that the dataset is not empty (and raises an exception if it is).
        *
        * Calls CheckBrowseMode to post any pending changes to a prior record if necessary.
        *
        * Calls the OnBeforeDelete event handler.
        *
        * Deletes the record.
        *
        * Frees any buffers allocated for the record.
        *
        * Puts the dataset into dsBrowse mode.
        *
        * Resynchronizes the dataset to make the next undeleted record active.
        * If the record deleted was the last record in the dataset, then the previous record becomes the current record.
        *
        * Calls the AfterDelete event handler.
        *
        * @see readOnBeforeDelete(), readOnAfterDelete()
        */
        function delete()
        {
            $this->CheckActive();
            if (($this->State==dsInsert) || ($this->State==dsSetKey)) $this->Cancel();
            else
            {
                if ($this->Recordcount==0) DatabaseError(_("Cannot perform this operation on an empty dataset"), Self);
                $this->DataEvent(deCheckBrowseMode, 0);
                $this->callevent("onbeforedelete",array());
                $this->CheckOperation("InternalDelete", "ondeleteerror");
                $this->fieldbuffer=array();
                $this->State=dsBrowse;
                $this->callevent("onafterdelete",array());
            }
        }

        /**
        * Sets the parent dataset in edit state
        *
        * This is an internal method you don't need to call directly.
        *
        * @see edit()
        */
        function checkParentState()
        {
            if ($this->DataSetField != null) $this->DataSetField->DataSet->Edit();
        }

        /**
        * Enables editing of data in the dataset.
        *
        * Call Edit to permit editing of the active record in a dataset. Edit
        * determines the current state of the dataset. If the dataset is empty,
        * Edit calls Insert. Otherwise Edit:
        *
        * Calls CheckBrowseMode to post any pending changes to a prior record if necessary.
        *
        * Checks the CanModify property and raises an exception if the dataset can’t be edited.
        *
        * Calls the OnBeforeEdit event handler.
        *
        * Retrieves the record.
        *
        * Puts the dataset into dsEdit state, enabling the application or user to modify fields in the record.
        *
        * Broadcasts the state change to associated controls.
        *
        * Calls the OnAfterEdit event handler.
        *
        * Modifications will go to a buffer waiting for post()/cancel()
        *
        * @see readOnBeforeEdit(), readOnAfterEdit(), post()
        */
        function edit()
        {
            if ((($this->State==dsEdit) || ($this->State==dsInsert)))
            {
            }
            else
            {
//                if ($this->_recordcount==0) $this->Insert();
//                else
//                {
                    $this->CheckBrowseMode();
                    $this->CheckCanModify();
                    $this->callevent("onbeforeedit",array());
                    $this->CheckParentState();
                    $this->CheckOperation("InternalEdit", "onediterror");
//                    $this->GetCalcFields(ActiveBuffer);
                    $this->State=dsEdit;
                    $this->DataEvent(deRecordChange, 0);
                    $this->callevent("onafteredit",array());
//                }
            }
        }

        /**
        * Indicates the total number of records associated with the dataset.
        *
        * As implemented in DataSet, RecordCount is always 0. Ordinarily an application
        * does not access RecordCount at the DataSet level. Instead a redeclared and
        * implemented RecordCount property in a descendant class is accessed. RecordCount
        * provides a fallback property for derived dataset classes that do not reimplement
        * the property access method.
        *
        * @return integer
        */
        function readRecordCount()
        {
            return $this->_recordcount;
        }
        function defaultRecordCount() { return 0; }


        /**
        * Moves to the first record in the dataset.
        *
        * Call First to make the first record in the dataset active. First posts
        * any changes to the active record and:
        *
        * Clears the record buffers.
        *
        * Fetches the first record and makes it the active record.
        *
        * Fetches any additional records required for display, such as those needed to
        * fill out a grid control.
        *
        * Sets the Bof property to true.
        *
        * Broadcasts the record change so that data controls and linked detail sets can update.
        *
        * Note: DataSet uses internal, protected methods to reposition the active record and
        * to fetch additional records required for display. In DataSet, these internal methods are empty
        * stubs. Descendant classes implement these methods to enable the First method to work.
        *
        * @see last(), readBof(), readEof()
        */
        function first()
        {
            $this->CheckBrowseMode();
            $FReopened = false;
            /*
            if IsUniDirectional then begin
                if not BOF then begin             // Need to Close and Reopen dataset: (Midas)
                    Active := False;
                    Active := True;
                end;
                FReopened := True
            end
            else ClearBuffers;
            */
            $this->ClearBuffers();
            try
            {
                $this->InternalFirst();
                //if not FReopened then begin
                //$this->GetNextRecord();
                //$this->GetNextRecords();
                //end;
            }
            catch (Exception $e)
            {
                $this->_bof = true;
                $this->DataEvent(deDataSetChange, 0);
                throw $e;
            }

            $this->_bof = true;
            $this->DataEvent(deDataSetChange, 0);
        }

        /**
        * Performs an internal open of the dataset
        *
        * This is method called by the dataset to perform an open of the data.
        * It calls InternalOpen, a method you should implement if you are deriving
        * from Dataset.
        *
        * @see open(), readBof()
        */
        function doInternalOpen()
        {
            $this->_DefaultFields = ($this->FieldCount == 0);
            $this->InternalOpen();
            $this->_InternalOpenComplete = true;
            //$this->UpdateBufferCount();
            $this->_bof = true;
        }

        /**
        * Opens the cursor for the dataset
        *
        * This method is called to open the cursor for this dataset by calling
        * DoInternalOpen.
        *
        * @see doInternalOpen(), open()
        *
        * @param boolean $InfoQuery If true, initialize internal field defs
        */
        function openCursor($InfoQuery= False)
        {
            if ($InfoQuery) $this->InternalInitFieldDefs();
            else if ($this->State!=dsOpening) $this->DoInternalOpen();
        }

        /**
        * Finishes the open cursor operation
        *
        * This method is called when opening a cursor to complete the open operation,
        * it first calls DoInternalOpen and fires the OnAfterOpen event.
        *
        * @see DoInternalOpen(), Open(), OpenCursor()
        */
        function OpenCursorComplete()
        {
            try
            {
                if ($this->State == dsOpening) $this->DoInternalOpen();
            }
            catch(Exception $e)
            {
                if ($this->_InternalOpenComplete)
                {
                    $this->State=dsBrowse;
                    $this->callEvent("onafteropen", array());
                }
                else
                {
                    $this->State=dsInactive;
                    $this->CloseCursor();
                }
                throw $e;
            }
            if ($this->_InternalOpenComplete)
            {
                if ($this->_state==dsInactive) $this->_state=dsBrowse;
                $this->callEvent("onafteropen", array());
            }
            else
            {
                $this->State=dsInactive;
                $this->CloseCursor();
            }
        }

        /**
        * Close the cursor for this dataset
        *
        * This method is used to close the cursor attached to the dataset, it
        * calls InternalClose, a method you need to override if you are deriving
        * from Dataset.
        *
        * @see internalClose(), close()
        */
        function closeCursor()
        {
//            BlockReadSize := 0;
            $this->_InternalOpenComplete = false;
//            FreeFieldBuffers;
//            ClearBuffers;
//            SetBufListSize(0);
            $this->InternalClose();
//            FBufferCount := 0;
//            FDefaultFields := False;
        }

        /**
        * To be overriden to perform a first() operation
        *
        * This method is called when a first operation is atempted, so if you are
        * creating new types of datasets, you need to override this method.
        *
        * @see first()
        */
        function internalFirst()
        {
        }

        /**
        * To be overriden to perform a last() operation
        *
        * This method is called when a last operation is atempted, so if you are
        * creating new types of datasets, you need to override this method.
        *
        * @see last()
        */
        function internalLast()
        {
          databaseError("Last operations are not implemented for this type dataset",$this);
        }

        /**
        * To initialize the current record
        * @param array $Buffer Initial values
        *
        * @see internalInitRecord()
        */
        function initRecord($Buffer)
        {
            $this->InternalInitRecord($Buffer);
//            $this->ClearCalcFields($Buffer);
//            $this->SetBookmarkFlag($Buffer, bfInserted);
        }

        function internalInitRecord($buffer)
        {
        }

        function internalAddRecord($buffer, $append)
        {
        }

        /**
        * To be overriden to perform a delete() operation
        *
        * This method is called when a delete operation is atempted, so if you are
        * creating new types of datasets, you need to override this method.
        *
        * @see delete()
        */
        function internalDelete()
        {
        }

        /**
        * To be overriden to perform a post() operation
        *
        * This method is called when a post operation is atempted, so if you are
        * creating new types of datasets, you need to override this method.
        *
        * @see post()
        */
        function internalPost()
        {
//            $this->CheckRequiredFields();
        }

        /**
        * To be overriden to perform a cancel() operation
        *
        * This method is called when a cancel operation is atempted, so if you are
        * creating new types of datasets, you need to override this method.
        *
        * @see cancel()
        */
        function internalCancel()
        {
        }

        /**
        * To be overriden to perform a edit() operation
        *
        * This method is called when a edit operation is atempted, so if you are
        * creating new types of datasets, you need to override this method.
        *
        * @see edit()
        */
        function internalEdit()
        {
        }

        /**
        * To be overriden to perform a insert() operation
        *
        * This method is called when a insert operation is atempted, so if you are
        * creating new types of datasets, you need to override this method.
        *
        * @see insert()
        */
        function internalInsert()
        {
        }

        /**
        * To be overriden to perform a refresh() operation
        *
        * This method is called when a refresh operation is atempted, so if you are
        * creating new types of datasets, you need to override this method.
        *
        * @see refresh()
        */
        function internalRefresh()
        {
        }

        /**
        * Moves to the last record in the dataset.
        *
        * Call Last to make the last record in the dataset active.
        * Last posts any changes to the active record and
        *
        * Clears the record buffers.
        *
        * Fetches the last record and makes it the active record.
        *
        * Fetches any additional records required for display, such as those needed to fill out a grid control.
        *
        * Sets the Eof property to true.
        *
        * Broadcasts the record change so that data controls and linked detail sets can update.
        *
        *
        * Note: DataSet uses internal, protected methods to reposition the active record
        * and to fetch additional records required for display. In DataSet, these internal methods
        * are empty stubs. Descendant classes implement these methods to enable the Last method to work.
        *
        * @see internalLast(), first()
        */
        function last()
        {
            //$this->CheckBiDirectional();
            $this->CheckBrowseMode();
            $this->ClearBuffers();
            try
            {
                $this->InternalLast();
//                $this->GetPriorRecord();
//                $this->GetPriorRecords();
            }
            catch (Exception $e)
            {
                $this->_eof = true;
                $this->DataEvent(deDataSetChange, 0);
                throw $e;
            }

            $this->_eof = true;
            $this->DataEvent(deDataSetChange, 0);
        }

        /**
        * Re-fetches data from the database to update a dataset’s view of data.
        *
        * Call Refresh to ensure that an application has the latest data from a database.
        * For example, when an application turns off filtering for a dataset, it should immediately
        * call Refresh to display all records in the dataset, not just those that used to meet the filter condition.
        *
        * DataSet generates a OnBeforeRefresh event before refreshing the records and an OnAfterRefresh event afterwards.
        *
        * Warning: Dataset refresh the data by closing and reopening the cursor. This can have unintended side effects if,
        * for example, you have code in the OnBeforeClose, OnAfterClose, OnBeforeOpen, or OnAfterOpen event handlers.
        *
        * @see readActive()
        */
        function refresh()
        {
            $this->Active=false;
            $this->Active=true;
        }

        /**
        * Moves to the next record in the dataset.
        *
        * Call Next to move to the next record in the dataset, making it the
        * active record. Next posts any changes to the active record and
        *
        * Sets the Bof and Eof properties to false.
        *
        * Fetches the next record and makes it the active record.
        *
        * Fetches any additional records required for display, such as those needed to fill out a grid control.
        *
        * Sets the Eof property to true if the last record in the dataset was already active.
        *
        * Broadcasts the record change so that data controls and linked detail sets can update.
        *
        * Note: DataSet uses internal, protected methods to move the active record and
        * to fetch additional records required for display. In DataSet, these internal methods are empty stubs.
        * Descendant classes implement these methods to enable the Next method to work.
        *
        * @see prior()
        */
        function next()
        {
//            if ($this->BlockReadSize > 0) $this->BlockReadNext();
//            else
              $this->MoveBy(1);
              if (!$this->EOF) $this->fieldbuffer=$this->_rs->fields;
        }

        /**
        * Opens the dataset.
        *
        * Call Open to set the Active property for the dataset to true. When Active
        * is true, dataset can be populated with data. It can read data from a database
        * or other source (such as a provider). Depending on the CanModify property,
        * active datasets can post changes.
        *
        * Setting Active to true:
        *
        * Triggers the OnBeforeOpen event handler if one is defined for the dataset.
        *
        * Sets the dataset state to dsBrowse.
        *
        * Establishes a way to fetch data (typically by opening a cursor).
        *
        * Triggers the After Open event handler if one is defined for the dataset.
        *
        * If an error occurs during the dataset open, dataset state is set to dsInactive, and any cursor is closed.
        *
        * @see close(), readActive()
        */
        function open()
        {
            $this->Active=true;
        }

        /**
        * Implements a virtual method to write a modified record to the database or change log.
        *
        * DataSet implements a virtual method to write a modified record to the database or
        * change log. Dataset methods that change the dataset state, such as Edit, Insert, or Append,
        * or that move from one record to another, such as First, Last, Next, and Prior automatically call Post.
        *
        * Designers of custom datasets can choose whether to implement Post by writing records to the
        * database server or to an internal change log.
        *
        * @see cancel(), edit(), insert()
        */
        function post()
        {
            $this->UpdateRecord();
            switch ($this->State)
            {
                case dsEdit:
                case dsInsert:
                {
                    $this->DataEvent(deCheckBrowseMode, 0);
                    $this->callevent("onbeforepost",array());
                    $this->CheckOperation("InternalPost", "onposterror");
                    $this->fieldbuffer=array();
                    //$this->FreeFieldBuffers();
                    $this->State=dsBrowse;
                    $this->callevent("onafterpost",array());
                    break;
                }
            }
        }

        /**
        * Moves to another record relative to the active record in the dataset.
        *
        * Call MoveBy to move the active record by the number of records specified by
        * Distance. A positive value for Distance indicates forward progress through
        * the dataset, while a negative value indicates backward progress.
        *
        * MoveBy posts any changes to the active record and
        *
        * Sets the Bof and Eof properties to false.
        *
        * If Distance is positive, repeatedly fetches Distance subsequent records
        * (if possible), and makes the last record fetched active. If an attempt is
        * made to move past the end of the file, MoveBy sets Eof to true.
        *
        * If Distance is negative, repeatedly fetches the appropriate number of
        * previous records (if possible), and makes the last record fetched active.
        * If an attempt is made to move past the start of the file, MoveBy sets Bof
        * to true. If the dataset is unidirectional, the dataset raises an EDatabaseError
        * exception when MoveBy tries to fetch a prior record.
        *
        * Broadcasts information about the record change so that data-aware controls and
        * linked datasets can update.
        *
        * @param integer $distance Records to move the pointer
        *
        * @see first(), last(), prior(), next()
        */
        function moveBy($distance)
        {
            $this->_recno+=$distance;
        }

        /**
        * Moves to the previous record in the dataset.
        *
        * Call Prior to move to the previous record in the dataset, making it the
        * active record. Prior posts any changes to the active record and
        *
        * Sets the Bof and Eof properties to false.
        *
        * Fetches the previous record and makes it the active record. If the dataset
        * is unidirectional, it raises an EDatabaseError exception at this point.
        *
        * Fetches any additional records required for display, such as those needed to
        * fill out a grid control.
        *
        * Sets the Bof property to true if the first record in the dataset was already active.
        *
        * Broadcasts the record change so that data controls and linked detail sets can update.
        *
        * Note: DataSet uses internal, protected methods to move the active record and
        * to fetch additional records required for display. In DataSet, these internal
        * methods are empty stubs. Descendant classes implement these methods to enable the Prior
        * method to work.
        *
        * @see next(), moveBy()
        */
        function prior()
        {
            $this->MoveBy(-1);
        }

        /**
        * Specifies whether or not a dataset is open.
        *
        * Use Active to determine or set whether a dataset is populated with data.
        * When Active is false, the dataset is closed; the dataset cannot read or write
        * data and data-aware controls can not use it to fetch data or post edits.
        * When Active is true, the dataset can be populated with data. It can read data
        * from a database or other source (such as a provider). Depending on the
        * CanModify property, active datasets can post changes.
        *
        * Setting Active to true:
        *
        * Generates a OnBeforeOpen event.
        *
        * Sets the dataset state to dsBrowse.
        *
        * Establishes a way to fetch data (typically by opening a cursor).
        *
        * Generates an OnAfterOpen event.
        *
        * If an error occurs while opening the dataset, dataset state is set to
        * dsInactive, and any cursor is closed.
        *
        *
        *
        * Setting Active to false:
        *
        * 1 - Triggers a BeforeClose event.
        *
        * 2 - Sets the State property to dsInactive.
        *
        * 3 - Closes the cursor.
        *
        * 4 - Triggers an AfterClose event.
        *
        * An application must set Active to false before changing other properties
        * that affect the status of a database or the controls that display data in
        * an application.
        *
        * Note: Calling the Open method sets Active to true; calling the Close method
        * sets Active to false.
        *
        * @see open(), close(), readState()
        *
        * @return boolean
        */
        function readActive()
        {
            if (($this->readState()==dsInactive) || ($this->readState()==dsOpening) || ($this->_rs==null))
            {
                return(0);
            }
            else return(true);
        }

        protected $_fstreamedactive=false;

        function loaded()
        {
            parent::loaded();
            $this->writeMasterSource($this->_mastersource);
            if ($this->_fstreamedactive)
            {
                $this->Active=true;
            }
        }

        function writeActive($value)
        {
            if (($this->ControlState & csLoading)==csLoading)
            {
                $this->_fstreamedactive=$value;
            }
            else
            {
                if ($this->Active != $value)
                {
                    if ($value==true)
                    {
                        $this->callevent("onbeforeopen",array());
                        try
                        {
                            $this->OpenCursor();
                            if ($this->State!=dsOpening)
                            {
                                $this->OpenCursorComplete();
                            }
                        }
                        catch (Exception $e)
                        {
                            if ($this->State!=dsOpening)
                            {
                                $this->OpenCursorComplete();
                            }
                            throw $e;
                        }
                    }
                    else
                    {
                        $this->callevent("onbeforeclose",array());
                        $this->State=dsInactive;
                        $this->CloseCursor();
                        $this->callevent("onafterclose",array());
                    }
                }
            }
        }

        function defaultActive() { return "0"; }


        protected $_bof=false;
        protected $_eof=false;

        /**
        * Indicates whether the first record in the dataset is active.
        *
        * Test Bof (beginning of file) to determine if the dataset is positioned
        * at the first record. If Bof is true, the active record is unequivocally
        * the first row in the dataset. Bof is true when an application.
        *
        * Opens a dataset.
        *
        * Calls a dataset’s First method.
        *
        * Call a dataset’s Prior method, and the method fails because the first row is already active.
        *
        * Bof is false in all other cases.
        *
        * @see EOF(), First()
        *
        * @return boolean
        */
        function readBOF() { return $this->_bof; }
        function defaultBOF() { return false; }

        /**
        * Indicates whether a dataset is positioned at the last record.
        *
        * Test Eof (end-of-file) to determine if the active record in a dataset
        * is the last record. If Eof is true, the current record is unequivocally
        * the last row in the dataset. Eof is true when an application:
        *
        * Opens an empty dataset.
        *
        * Calls a dataset’s Last method. (Unless it is a unidirectional dataset)
        *
        * Call a dataset’s Next method, and the method fails because the current record is already the last row in the dataset.
        *
        *
        *
        * Eof is false in all other cases.
        *
        * Tip: If both Eof and Bof are true, the dataset is empty.
        *
        * @see BOF(), Last(), Next()
        *
        * @return boolean
        */
        function readEOF() { return $this->_eof; }
        function defaultEOF() { return false; }
}

/**
 * DataSource provides an interface between a dataset component and data-aware controls on a form.
 *
 * Use DataSource to
 *
 * provide a conduit between a dataset and data-aware controls on a form that enable display,
 * navigation, and editing of the data underlying the dataset.
 *
 * link two datasets in a master/detail relationship.
 *
 * All datasets must be associated with a data source component if their data is to be displayed and
 * manipulated in data-aware controls. Similarly, each data-aware control needs to be associated with
 * a data source component in order for the control to receive and manipulate data.
 *
 * Data source components also link datasets in master-detail relationships.
 */
class Datasource extends Component
{
        protected $_dataset;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
        * Specifies the dataset for which the data source component serves as
        * a conduit to data-aware controls or other datasets.
        *
        * Set DataSet to the name of an existing dataset component either at
        * design time, or at runtime. By changing the value of DataSet at runtime
        * an application can effectively use the same data-aware controls to
        * display and edit data in different datasets.
        *
        *
        * Note: To link a dataset that resides in a data module to a form at
        * design-time, choose File | Use unit
        *
        * @return DataSet
        */
        function getDataSet() { return $this->_dataset; }
        function setDataSet($value)
        {
                $this->_dataset=$this->fixupProperty($value);
        }

        function loaded()
        {
                parent::loaded();
                $this->setDataSet($this->_dataset);
        }
}

?>