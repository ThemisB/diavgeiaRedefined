<?php
/**
 * Structures_DataGrid_Column Class
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
 * CSV file id: $Id: Column.php,v 1.49 2007/01/01 10:31:18 wiesemann Exp $
 * 
 * @version  $Revision: 1.49 $
 * @package  Structures_DataGrid
 * @category Structures
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * Structures_DataGrid_Column Class
 *
 * This class represents a single column for the DataGrid.
 *
 * @version  $Revision: 1.49 $
 * @author   Andrew S. Nagy <asnagy@webitecture.org>
 * @author   Olivier Guilyardi <olivier@samalyse.com>
 * @author   Mark Wiesemann <wiesemann@php.net>
 * @access   public
 * @package  Structures_DataGrid
 * @category Structures
 */
class Structures_DataGrid_Column
{
    /**
     * The name (label) of the column
     * @var string
     */
    var $columnName;

    /**
     * The name of the field to map to
     * @var string
     */
    var $fieldName;

    /**
     * The field name to order by. Optional
     * @var string
     */
    var $orderBy;

    /**
     * The default direction to order this column by
     * 
     * @var array
     * @access private
     */
    var $defaultDirection = 'ASC';

    /**
     * The attributes to use for the cell. Optional
     * @var array
     */
    var $attribs;

    /**
     * The value to be used if a cell is empty
     * @var string
     */
    var $autoFillValue;

    /**
     * A callback function to be called for each cell to modify the output
     * @var     mixed
     * @access  private
     */
    var $formatter;
    
    /**
     * User defined parameters passed to the formatter callback function
     * @var     array
     * @access  private
     */
    var $formatterArgs;

    /**
     * Constructor
     *
     * Creates default table style settings
     *
     * @param   string      $label          The label of the column to be printed
     * @param   string      $field          The name of the field for the column
     *                                      to be mapped to
     * @param   string      $orderBy        The field or expression to order the
     *                                      data by
     * @param   array       $attributes     The attributes for the XML or HTML
     *                                      TD tag; form: array(name => value, ...)
     * @param   string      $autoFillValue  The value to use for the autoFill
     * @param   mixed       $formatter      Formatter callback. See setFormatter()
     * @param   array       $formatterArgs  Associative array of arguments 
     *                                      passed as second argument to the 
     *                                      formatter callback
     * @see http://www.php.net/manual/en/language.pseudo-types.php
     * @see Structures_DataGrid::addColumn()
     * @see setFormatter()
     * @access  public
     */
    function Structures_DataGrid_Column($label, 
                                        $field = null,
                                        $orderBy = null, 
                                        $attributes = array(),
                                        $autoFillValue = null,
                                        $formatter = null,
                                        $formatterArgs = array())
    {
        $this->columnName = $label;
        $this->fieldName = $field;
        $this->orderBy = $orderBy;
        $this->attribs = $attributes;
        $this->autoFillValue = $autoFillValue;
        if (!is_null($formatter)) {
            $this->setFormatter($formatter, $formatterArgs);
        }
    }

    /**
     * Get column label
     *
     * The label is the text rendered into the column header. 
     *
     * @return  string
     * @access  public
     */
    function getLabel()
    {
        return $this->columnName;
    }

    /**
     * Set column label
     *
     * The label is the text rendered into the column header. 
     *
     * @param   string      $str        Column label
     * @access  public
     */
    function setLabel($str)
    {
        $this->columnName = $str;
    }

    /**
     * Get name of the field for the column to be mapped to
     *
     * Returns the name of the field for the column to be mapped to
     *
     * @return  string
     * @access  public
     */
    function getField()
    {
        return $this->fieldName;
    }

    /**
     * Set name of the field for the column to be mapped to
     *
     * Defines the name of the field for the column to be mapped to
     *
     * @param   string      $str        The name of the field for the column to
     *                                  be mapped to
     * @access  public
     */
    function setField($str)
    {
        $this->fieldName = $str;
    }

    /**
     * Get the field name or the expression to order the data by
     *
     * Returns the name of the field to order the data by. With SQL based
     * datasources, this may be an SQL expression (function, etc..). 
     *
     * @return  string
     * @access  public
     */
    function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * Set the field name or the expression to order the data by
     *
     * Set the name of the field to order the data by. With SQL based
     * datasources, this may be an SQL expression (function, etc..). 
     *
     * @param   string      $str  field name or expression 
     * @access  public
     */
    function setOrderBy($str)
    {
        $this->orderBy = $str;
    }

    /**
     * Return the default direction to order this column by
     *
     * @return  string  "ASC" or "DESC"
     * @access  public
     */
    function getDefaultDirection($str)
    {
        return $this->defaultDirection;
    }

    /**
     * Set the default direction to order this column by
     *
     * @param   string      $str    "ASC" or "DESC"
     * @access  public
     */
    function setDefaultDirection($str)
    {
        $this->defaultDirection = $str;
    }

    /**
     * Get the column XML/HTML attributes 
     *
     * Return the attributes applied to all cells in this column.
     * This only makes sense for HTML or XML rendering
     *
     * @return  array   Attributes; form: array(name => value, ...)
     * @access  public
     */
    function getAttributes()
    {
        return $this->attribs;
    }

    /**
     * Set the column XML/HTML attributes 
     *
     * Set the attributes to be applied to all cells in this column.
     * This only makes sense for HTML or XML rendering
     * 
     * @param   array   $attributes form: array(name => value, ...)
     * @access  public
     */
    function setAttributes($attributes)
    {
        $this->attribs = $attributes;
    }

    /**
     * Get auto fill value
     *
     * Returns the value to be printed if a cell in the column is null.
     *
     * @return  string
     * @access  public
     */
    function getAutoFillValue()
    {
        return $this->autoFillValue;
    }

    /**
     * Set auto fill value
     *
     * Defines a value to be printed if a cell in the column is null.
     *
     * @param   string      $str        The value to use for the autoFill
     * @access  public
     */
    function setAutoFillValue($str)
    {
        $this->autoFillValue = $str;
    }

    /**
     * Set Formatter Callback
     *
     * Define a formatting callback function with optional arguments for 
     * this column.
     *
     * @param   mixed   $formatter  Callback PHP pseudo-type (Array or String)
     * @param   array   $arguments  Associative array of parameters passed to 
     *                              as second argument to the callback function
     * @return  mixed               PEAR_Error on failure 
     * @see http://www.php.net/manual/en/language.pseudo-types.php
     * @access  public
     */
    function setFormatter($formatter, $arguments = array())
    {
        $this->formatterArgs = $arguments;
        if (is_array($formatter)) {
            $formatter[1] = $this->_parseCallbackString($formatter[1], 
                                                        $this->formatterArgs);
        } else {
            $formatter = $this->_parseCallbackString($formatter, 
                                                     $this->formatterArgs);
        }
        if (is_callable ($formatter)) {
            $this->formatter = $formatter;
        } else {
            return PEAR::raiseError('Column formatter is not a valid callback');
        }
    }

    /**
     * Choose a format preset
     *
     * EXPERIMENTAL: the behaviour of this method may change in future releases.
     *
     * This method allows to associate an "automatic" predefined formatter
     * to the column, for common needs as formatting dates, numbers, ...
     *
     * The currently supported predefined formatters are :
     * - dateFromTimestamp: format a UNIX timestamp according to the 
     *   date()-like format string passed as second argument 
     * - dateFromMysql : format a MySQL DATE, DATETIME, or TIMESTAMP MySQL 
     *   according to the date() like format string passed as second argument
     * - number: format a number, according to the same optional 2nd, 3rd and 
     *   4th arguments that the number_format() PHP function accepts.
     * - printf: format using the printf expression passed as 2nd argument.
     * - printfURL: url-encode and format using the printf expression passed 
     *   as 2nd argument
     *
     * @example format.php         Common formats
     * @param   mixed  $type,...   Predefined formatter name, followed by
     *                             formatter-specific parameters
     * @return  void
     * @access  public
     */
    function format($type)
    {
        $params = func_get_args();
        $this->setFormatter(array(get_class($this), '_autoFormatter'), $params);
    }

    /**
     * Automatic formatter(s)
     * 
     * @param   array   $data   Datagrid and record data
     * @param   data    $params Formatter-specific parameters
     * @access  private
     * @static
     */
    function _autoFormatter($data, $params)
    {
        $value = $data['record'][$data['fieldName']];
        $type = $params[0];
        
        switch ($type) {
            case 'dateFromTimestamp':
                $format = $params[1];
                return date($format, $value);
            case 'dateFromMysql':
                $format = $params[1];
                if (preg_match('/^([0-9]+)-([0-9]+)-([0-9]+) '.
                               '*([0-9]+):([0-9]+):([0-9]+)$/', $value, $r)) {
                    $time = mktime($r[4], $r[5], $r[6], $r[2], $r[3], $r[1]);
                    return date($format, $time);
                } elseif (preg_match('/^([0-9]+)-([0-9]+)-([0-9]+)$/', $value, $r)){
                    $time = mktime(0, 0, 0, $r[2], $r[3], $r[1]);
                    return date($format, $time);
                } else {
                    return "Unrecognized date format";
                }
            case 'number':
                switch (count($params)) {
                    case 4: 
                        return number_format($value, $params[1], 
                                             $params[2], $params[3]);
                    case 3: 
                        return "Wrong parameter count for the 'number' format";
                    case 2: 
                        return number_format($value, $params[1]);
                    default:
                        return number_format($value);
                }
            case 'printfURL':
                $value = urlencode($value);
            case 'printf':
                return sprintf($params[1], $value);
        }
    }

    /**
     * Parse a callback function string
     *
     * This method parses a string of the type "myFunction($param1=foo,...)",
     * return the isolated function name ("myFunction") and fills $paramList 
     * with the extracted parameters (array('param1' => foo, ...))
     * 
     * @param   string  $callback   Callback function string
     * @param   array   $paramList  Reference to an array of parameters
     * @return  string              Function name
     * @access  private
     */
    function _parseCallbackString($callback, &$paramList)
    {   
        if ($size = strpos($callback, '(')) {
            $orig_callback = $callback;
            // Retrieve the name of the function to call
            $callback = substr($callback, 0, $size);
            if (strstr($callback, '->')) { 
                $callback = explode('->', $callback);
            } elseif (strstr($callback, '::')) {
                $callback = explode('::', $callback);
            }

            // Build the list of parameters
            $length = strlen($orig_callback) - $size - 2;
            $parameters = substr($orig_callback, $size + 1, $length);
            $parameters = ($parameters === '') ? array() : split(',', $parameters);

            // Process the parameters
            foreach($parameters as $param) {
                if ($param != '') {
                    $param = str_replace('$', '', $param);
                    if (strpos($param, '=') != false) {
                        $vars = split('=', $param);
                        $paramList[trim($vars[0])] = trim($vars[1]);
                    } else {
                        $paramList[$param] = $$param;
                    }
                }
            }
        }

        return $callback;
    }
    
    /**
     * Formatter
     *
     * This method is not meant to be called by user-space code.
     * 
     * Calls a predefined function to develop custom output for the column. The
     * defined function can accept parameters so that each cell in the column
     * can be unique based on the record.  The function will also automatically
     * receive the record array as a parameter.  All parameters passed into the
     * function will be in one array.
     *
     * @access  public
     */
    function formatter($record, $row, $col)
    {
        // Define the parameter list
        $paramList = array();
        $paramList['record'] = $record;
        $paramList['fieldName'] = $this->fieldName;
        $paramList['columnName'] = $this->columnName;
        $paramList['orderBy'] = $this->orderBy;
        $paramList['attribs'] = $this->attribs;
        $paramList['currRow'] = $row;
        $paramList['currCol'] = $col;

        // Call the formatter
        if (isset($GLOBALS['_STRUCTURES_DATAGRID']['column_formatter_BC'])) {
            $paramList = array_merge($this->formatterArgs, $paramList);
            $formatted = call_user_func($this->formatter, $paramList);
        } else {
            if ($this->formatterArgs) {
                $formatted = call_user_func($this->formatter, $paramList, 
                                            $this->formatterArgs);
            } else {
                $formatted = call_user_func($this->formatter, $paramList);
            }
        }

        return $formatted;
    }

}

/* vim: set expandtab tabstop=4 shiftwidth=4: */
?>
