<?php
/**
 * Base abstract class for data source drivers
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
 * CVS file id: $Id: DataSource.php,v 1.36 2007/01/01 10:31:18 wiesemann Exp $
 * 
 * @version  $Revision: 1.36 $
 * @package  Structures_DataGrid
 * @category Structures
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * Base abstract class for data source drivers
 * 
 * SUPPORTED OPTIONS:
 *
 * - fields:            (array) Which data fields to fetch from the datasource.
 *                              An empty array means: all fields.
 *                              Form: array(field1, field2, ...)
 * - primary_key:       (array) Name(s), or numerical index(es) of the 
 *                              field(s) which contain a unique record 
 *                              identifier (only use several fields in case
 *                              of a multiple-fields primary key)
 * - generate_columns:  (bool)  Generate Structures_DataGrid_Column objects 
 *                              with labels. See the 'labels' option.
 *                              DEPRECATED: 
 *                              use Structures_DataGrid::generateColumns() instead
 * - labels:            (array) Data field to column label mapping. Only used 
 *                              when 'generate_columns' is true. 
 *                              Form: array(field => label, ...)
 *                              DEPRECATED: 
 *                              use Structures_DataGrid::generateColumns() instead
 *
 * @author   Olivier Guilyardi <olivier@samalyse.com>
 * @author   Andrew Nagy <asnagy@webitecture.org>
 * @author   Mark Wiesemann <wiesemann@php.net>
 * @package  Structures_DataGrid
 * @category Structures
 * @version  $Revision $
 */
class Structures_DataGrid_DataSource
{
    /**
     * Common and driver-specific options
     *
     * @var array
     * @access protected
     * @see Structures_DataGrid_DataSource::_setOption()
     * @see Structures_DataGrid_DataSource::addDefaultOptions()
     */
    var $_options = array();

    /**
     * Special driver features
     *
     * @var array
     * @access protected
     */
    var $_features = array();
    
    /**
     * Constructor
     *
     */
    function Structures_DataGrid_DataSource()
    {
        $this->_options = array('generate_columns' => false,
                                'labels'           => array(),
                                'fields'           => array(),
                                'primary_key'      => null);

        $this->_features = array(
                'multiSort' => false, // Multiple field sorting
                'writeMode' => false, // insert, update and delete records
        );
    }

    /**
     * Adds some default options.
     *
     * This method is meant to be called by drivers. It allows adding some
     * default options. 
     *
     * @access protected
     * @param array $options An associative array of the form:
     *                       array(optionName => optionValue, ...)
     * @return void
     * @see Structures_DataGrid_DataSource::_setOption
     */
    function _addDefaultOptions($options)
    {
        $this->_options = array_merge($this->_options, $options);
    }

    /**
     * Add special driver features
     *
     * This method is meant to be called by drivers. It allows specifying 
     * the special features that are supported by the current driver.
     *
     * @access protected
     * @param array $features An associative array of the form:
     *                        array(feature => true|false, ...)
     * @return void
     */
    function _setFeatures($features)
    {
        $this->_features = array_merge($this->_features, $features);
    }
    
    /**
     * Set options
     *
     * @param   mixed   $options    An associative array of the form:
     *                              array("option_name" => "option_value",...)
     * @access  protected
     */
    function setOptions($options)
    {
        $this->_options = array_merge($this->_options, $options);
    }

    /**
     * Set a single option
     *
     * @param   string  $name       Option name
     * @param   mixed   $value      Option value
     * @access  public
     */
    function setOption($name, $value)
    {
        $this->_options[$name] = $value;
    }

    /**
     * Generate columns if options are properly set
     *
     * Note: must be called after fetch()
     * 
     * @access public
     * @return array Array of Column objects. Empty array if irrelevant.
     * @deprecated This method relates to the deprecated "generate_columns" option.
     */
    function getColumns()
    {
        $columns = array();
        if ($this->_options['generate_columns'] 
            and $fieldList = $this->_options['fields']) {
                             
            include_once 'Structures/DataGrid/Column.php';
            
            foreach ($fieldList as $field) {
                $label = strtr($field, $this->_options['labels']);
                $col = new Structures_DataGrid_Column($label, $field, $field);
                $columns[] = $col;
            }
        }
        
        return $columns;
    }
    
    
    // Begin driver method prototypes DocBook template
     
    /**#@+
     * 
     * This method is public, but please note that it is not intended to be 
     * called by user-space code. It is meant to be called by the main 
     * Structures_DataGrid class.
     *
     * It is an abstract method, part of the DataGrid Datasource driver 
     * interface, and must/may be overloaded by drivers.
     */
   
    /**
     * Fetching method prototype
     *
     * When overloaded this method must return a 2D array of records 
     * on success or a PEAR_Error object on failure.
     *
     * @abstract
     * @param   integer $offset     Limit offset (starting from 0)
     * @param   integer $len        Limit length
     * @return  object              PEAR_Error with message 
     *                              "No data source driver loaded" 
     * @access  public                          
     */
    function &fetch($offset = 0, $len = null)
    {
        return PEAR::raiseError("No data source driver loaded");
    }

    /**
     * Counting method prototype
     *
     * Note: must be called before fetch() 
     *
     * When overloaded, this method must return the total number or records 
     * or a PEAR_Error object on failure
     * 
     * @abstract
     * @return  object              PEAR_Error with message 
     *                              "No data source driver loaded" 
     * @access  public                          
     */
    function count()
    {
        return PEAR::raiseError("No data source driver loaded");
    }
    
    /**
     * Sorting method prototype
     *
     * When overloaded this method must return true on success or a PEAR_Error 
     * object on failure.
     * 
     * Note: must be called before fetch() 
     * 
     * @abstract
     * @param   string  $sortSpec   If the driver supports the "multiSort" 
     *                              feature this can be either a single field 
     *                              (string), or a sort specification array of 
     *                              the form: array(field => direction, ...)
     *                              If "multiSort" is not supported, then this
     *                              can only be a string.
     * @param   string  $sortDir    Sort direction: 'ASC' or 'DESC'
     * @return  object              PEAR_Error with message 
     *                              "No data source driver loaded" 
     * @access  public                          
     */
    function sort($sortSpec, $sortDir = null)
    {
        return PEAR::raiseError("No data source driver loaded");
    }    
  
    /**
     * Datasource binding method prototype
     *
     * When overloaded this method must return true on success or a PEAR_Error 
     * object on failure.
     *
     * @abstract
     * @param   mixed $container The datasource container
     * @param   array $options   Binding options
     * @return  object           PEAR_Error with message 
     *                           "No data source driver loaded" 
     * @access  public                          
     */
    function bind($container, $options = array())
    {
        return PEAR::raiseError("No data source driver loaded");
    }
 
    /**
     * Record insertion method prototype
     *
     * Drivers that support the "writeMode" feature must implement this method.
     *
     * When overloaded this method must return true on success or a PEAR_Error 
     * object on failure. 
     *
     * @abstract
     * @param   array   $data   Associative array of the form: 
     *                          array(field => value, ..)
     * @return  object          PEAR_Error with message 
     *                          "No data source driver loaded or write mode not 
     *                          supported by the current driver"
     * @access  public                          
     */
    function insert($data)
    {
        return PEAR::raiseError("No data source driver loaded or write mode not". 
                                "supported by the current driver");
    }

    /**
     * Return the primary key specification
     *
     * This method always returns an array containing:
     * - either one field name or index in case of a single-field key
     * - or several field names or indexes in case of a multiple-fields key
     *
     * Drivers that support the "writeMode" feature should overload this method
     * if the key can be detected. However, the detection must not override the
     * "primary_key" option.
     *
     * @return  array       Field(s) name(s) or numerical index(es)
     * @access  protected
     */
    function getPrimaryKey()
    {
        return $this->_options['primary_key'];
    }

    /**
     * Record updating method prototype
     *
     * Drivers that support the "writeMode" feature must implement this method.
     *
     * When overloaded this method must return true on success or a PEAR_Error 
     * object on failure.
     *
     * @abstract
     * @param   array   $key    Unique record identifier
     * @param   array   $data   Associative array of the form: 
     *                          array(field => value, ..)
     * @return  object          PEAR_Error with message 
     *                          "No data source driver loaded or write mode 
     *                          not supported by the current driver"
     * @access  public                          
     */
    function update($key, $data)
    {
        return PEAR::raiseError("No data source driver loaded or write mode not". 
                                "supported by the current driver");
    }

    /**
     * Record deletion method prototype
     *
     * Drivers that support the "writeMode" feature must implement this method.
     *
     * When overloaded this method must return true on success or a PEAR_Error 
     * object on failure.
     *
     * @abstract
     * @param   array   $key    Unique record identifier
     * @return  object          PEAR_Error with message 
     *                          "No data source driver loaded or write mode 
     *                          not supported by the current driver"
     * @access  public                          
     */
    function delete($key)
    {
        return PEAR::raiseError("No data source driver loaded or write mode not". 
                                "supported by the current driver");
    }

    /**#@-*/

    // End DocBook template
  
    /**
     * List special driver features
     *
     * @return array Of the form: array(feature => true|false, etc...)
     * @access public
     */
    function getFeatures()
    {
        return $this->_features;
    }
   
    /**
     * Tell if the driver as a specific feature
     *
     * @param  string $name Feature name
     * @return bool 
     * @access public
     */
    function hasFeature($name)
    {
        return $this->_features[$name];
    }
    
    /**
     * Dump the data as returned by fetch().
     *
     * This method is meant for debugging purposes. It returns what fetch()
     * would return to its DataGrid host as a nicely formatted console-style
     * table.
     *
     * @param   integer $offset     Limit offset (starting from 0)
     * @param   integer $len        Limit length
     * @param   string  $sortField  Field to sort by
     * @param   string  $sortDir    Sort direction: 'ASC' or 'DESC'
     * @return  string              The table string, ready to be printed
     * @uses    Structures_DataGrid_DataSource::fetch()
     * @access  public
     */
    function dump($offset=0, $len=null, $sortField=null, $sortDir='ASC')
    {
        $records =& $this->fetch($offset, $len, $sortField, $sortDir);
        $columns = $this->getColumns();

        if (!$columns and !$records) {
            return "<Empty set>\n";
        }
        
        include_once 'Console/Table.php';
        $table = new Console_Table();
        
        $headers = array();
        if ($columns) {
            foreach ($columns as $col) {
                $headers[] = is_null($col->fieldName)
                            ? $col->columnName
                            : "{$col->columnName} ({$col->fieldName})";
            }
        } else {
            $headers = array_keys($records[0]);
        }

        $table->setHeaders($headers);
        
        foreach ($records as $rec) {
            $table->addRow($rec);
        }
       
        return $table->getTable();
    }
  
}

/* vim: set expandtab tabstop=4 shiftwidth=4: */
?>
