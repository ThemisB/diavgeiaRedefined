<?php
/**
 * Base class of all Renderer drivers
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
 * CSV file id: $Id: Renderer.php,v 1.72 2007/01/01 10:31:18 wiesemann Exp $
 *
 * @version  $Revision: 1.72 $
 * @package  Structures_DataGrid
 * @category Structures
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * Base class of all Renderer drivers
 *
 * SUPPORTED OPTIONS:
 *
 * - buildHeader:         (bool)   Whether to build the header.
 * - buildFooter:         (bool)   Whether to build the footer.
 * - fillWithEmptyRows:   (bool)   Ensures that all pages have the same number of
 *                                 rows.
 * - numberAlign:         (bool)   Whether to right-align numeric values.
 * - defaultCellValue:    (string) What value to put by default into empty cells.
 * - defaultColumnValues: (array)  Per-column default cell value. This is an array
 *                                 of the form: array(fieldName => value, ...).
 * - hideColumnLinks:     (array)  By default sorting links are enabled on all
 *                                 columns. With this option it is possible to
 *                                 disable sorting links on specific columns. This
 *                                 is an array of the form: array(fieldName, ...).
 *                                 This option only affects drivers that support
 *                                 sorting.
 * - encoding:            (string) The content encoding. If the mbstring extension
 *                                 is present the default value is set from
 *                                 mb_internal_encoding(), otherwise it is ISO-8859-1.
 * - extraVars:           (array)  Variables to be added to the generated HTTP
 *                                 queries.
 * - excludeVars:         (array)  Variables to be removed from the generated
 *                                 HTTP queries.
 * - columnAttributes:    (array)  Column cells attributes. This is an array of
 *                                 the form:
 *                                 array(fieldName => array(attribute => value, ...) ...)
 *                                 This option is only used by XML/HTML based
 *                                 drivers.
 *
 * --- DRIVER INTERFACE ---
 *
 * Methods (none required):
 *     - Constructor
 *     - setContainer()
 *     - getContainer()
 *     - init()
 *     - defaultCellFormatter()
 *     - buildHeader()
 *     - buildBody()
 *     - buildRow()
 *     - buildEmptyRow()
 *     - buildFooter()
 *     - finalize()
 *     - flatten()
 *     - render()
 *     - getPaging()  (deprecated)
 *
 * Properties (all read-only):
 *     - $_columns
 *     - $_columnsNum
 *     - $_currentSort
 *     - $_firstRecord
 *     - $_lastRecord
 *     - $_multiSort
 *     - $_options
 *     - $_page
 *     - $_pageLimit
 *     - $_pagesNum
 *     - $_records
 *     - $_recordsNum
 *     - $_requestPrefix
 *     - $_sortableFields
 *     - $_totalRecordsNum
 *
 * Options that drivers may handle:
 *     - encoding
 *     - fillWithEmptyRows
 *     - numberAlign
 *     - extraVars
 *     - excludeVars
 *
 * @version  $Revision: 1.72 $
 * @author   Olivier Guilyardi <olivier@samalyse.com>
 * @access   public
 * @package  Structures_DataGrid
 * @category Structures
 * @abstract
 */
class Structures_DataGrid_Renderer
{
    /**
     * Columns' fields names and labels
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var array Structure:
     *            array(<columnIndex> => array(field => <fieldName>,
     *                                         label=> <label>), ...)
     *            Where <columnIndex> is zero-based
     * @access protected
     */
    var $_columns = array();

    /**
     * Records content
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var array Structure:
     *            array(
     *              <rowIndex> => array(
     *                 <columnIndex> => array(<cellValue>, ...),
     *              ...),
     *            ...)
     *            Where <rowIndex> and <columnIndex> are zero-based
     * @access protected
     */
    var $_records = array();

    /**
     * Fields/directions the data is currently sorted by
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var     array       Structure: array(fieldName => direction, ....)
     * @access  protected
     */
    var $_currentSort = array();

    /**
     * Whether the backend support sorting by multiple fields
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var     bool
     * @access  protected
     */
    var $_multiSort = false;

    /**
     * Number of columns
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var int
     * @access protected
     */
    var $_columnsNum;

    /**
     * Number of records in the current page
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var int
     * @access protected
     */
    var $_recordsNum = 0;

    /**
     * Total number of records as reported by the datasource
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var int
     * @access protected
     */
    var $_totalRecordsNum;

    /**
     * First record number (starting from 1), in the current page
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var int
     * @access protected
     */
    var $_firstRecord;

    /**
     * Last record number (starting from 1), in the current page
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var int
     * @access protected
     */
    var $_lastRecord;

    /**
     * Current page
     *
     * Page number starting from 1.
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var int
     * @access protected
     */
    var $_page = 1;

    /**
     * Number of records per page
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var int
     * @access protected
     */
    var $_pageLimit = null;

    /**
     * Number of pages
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var int
     * @access protected
     */
    var $_pagesNum;

     /**
     * GET/POST/Cookie parameters prefix
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var string
     * @access protected
     */
    var $_requestPrefix = '';

    /**
     * Which fields the datagrid may be sorted by
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var array Field names
     * @access protected
     */
    var $_sortableFields = array();

    /**
     * The default directions to sort by
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var array Structure: array(field => ASC|DESC, ...)
     * @access protected
     */
    var $_defaultDirections = array();

    /**
     * Common and driver-specific options
     *
     * Drivers can read the content of this property but must not change it.
     *
     * @var array
     * @access protected
     * @see Structures_DataGrid_Renderer::setOption()
     * @see Structures_DataGrid_Renderer::_addDefaultOptions()
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
     * Columns objects
     *
     * Beware: this is a private property, it is not meant to be accessed
     * by drivers. Use the $_columns property instead
     *
     * @var array
     * @access private
     * @see Structures_DataGrid_Renderer::_columns
     */
    var $_columnObjects = array();

    /**
     * Whether the datagrid has been built or not
     * @var bool
     * @access private
     * @see Structures_DataGrid_Renderer::isBuilt()
     */
    var $_isBuilt = false;

    /**
     * Cache for the GET parameters that are common to all sorting http queries
     *
     * @var array
     * @access private
     * @see Structures_DataGrid_Renderer::_buildSortingHttpQuery()
     */
    var $_sortingHttpQueryCommon = null;

    /**
     * Whether streaming is enabled or not
     *
     * @var bool
     * @access private
     */
    var $_streamingEnabled = false;

    /**
     * Instantiate the driver and set default options and features
     *
     * Drivers may overload this method in order to change/add default options.
     *
     * @access  public
     * @see Structures_DataGrid_Renderer::_addDefaultOptions()
     */
    function Structures_DataGrid_Renderer()
    {
        $this->_options = array(

            /* Options that the drivers may/should handle */
            'encoding'              => 'ISO-8859-1',
            'fillWithEmptyRows'     => false,
            'numberAlign'           => true,
            'extraVars'             => array(),
            'excludeVars'           => array(),
            'columnAttributes'      => array(),

            /* Options that must not be accessed by drivers */
            'buildHeader'           => true,
            'buildFooter'           => true,
            'defaultCellValue'      => null,
            'defaultColumnValues'   => array(),
            'hideColumnLinks'       => array(),

        );

        $this->_features = array(
                'streaming' => false,
                'outputBuffering' => false,
        );

        if (function_exists('mb_internal_encoding')) {
            $encoding = mb_internal_encoding();
            if ($encoding != 'pass') {
                $this->_options['encoding'] = $encoding;
            }
        }

    }

    /**
     * Adds some default options.
     *
     * This method is meant to be called by drivers. It allows adding some
     * default options.
     *
     * @access protected
     * @param array $options An associative array of the from:
     *                       array(optionName => optionValue, ...)
     * @return void
     * @see Structures_DataGrid_Renderer::setOption()
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
     * Set multiple options
     *
     * @param   mixed   $options    An associative array of the form:
     *                              array("option_name" => "option_value",...)
     * @access  public
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
     * Provide columns
     *
     * This method is supposed to be called ONLY by the code that loads the
     * driver. In most cases, that'll be the Structures_DataGrid class.
     *
     * @param array $columns Array of Structures_DataGrid_Column objects
     * @access public
     */
    function setColumns(&$columns)
    {
        $this->_columnObjects = &$columns;
    }

    /**
     * Specify how the datagrid is currently sorted
     *
     *
     * This method is supposed to be called ONLY by the code that loads the
     * driver. In most cases, that'll be the Structures_DataGrid class.
     *
     * The multiSort capabilities is related to the multiSort DataSource
     * feature. In short : the DataGrid checks if the DataSource supports
     * multiSort and informs the Renderer about it.
     *
     * @param array $currentSort        Structure:
     *                                  array(fieldName => direction, ....)
     * @param bool  $multiSortCapable   Whether the backend support sorting by
     *                                  multiple fields
     * @access public
     */
    function setCurrentSorting($currentSort, $multiSortCapable = false)
    {
        $this->_currentSort = $currentSort;
        $this->_multiSort   = $multiSortCapable;
    }

    /**
     * Specify page and row limits
     *
     * This method is supposed to be called ONLY by the code that loads the
     * driver. In most cases, that'll be the Structures_DataGrid class.
     *
     * @param int $currentPage Current page number
     * @param int $rowsPerPage Maximum number of rows per page
     * @param int $totalRowNum Total number of data rows
     * @access public
     */
    function setLimit($currentPage, $rowsPerPage, $totalRowNum) {
        $this->_page            = $currentPage;
        $this->_pageLimit       = $rowsPerPage;
        $this->_totalRecordsNum = $totalRowNum;
        $this->_pagesNum        = (is_null($rowsPerPage) or $totalRowNum == 0) ?
            1 : ceil($totalRowNum / $rowsPerPage);
        $this->_firstRecord     = ($currentPage - 1) * $rowsPerPage + 1;
        $this->_lastRecord      = (is_null($rowsPerPage))
                                  ? $totalRowNum
                                  : min($this->_firstRecord + $rowsPerPage - 1,
                                        $totalRowNum);
        if ($this->_lastRecord > $totalRowNum) {
            $this->_lastRecord  = $totalRowNum;
        }
    }

    /**
     * Tell the renderer whether streaming is enabled or not
     *
     * This method is supposed to be called ONLY by the code that loads the
     * driver. In most cases, that'll be the Structures_DataGrid class.
     *
     * @param int $status Whether streaming is enabled or not
     * @access public
     */
    function setStreaming($status) {
        $this->_streamingEnabled = (boolean)$status;
    }

    /**
     * Attach a container object
     *
     * Drivers that provide support for the Structures_DataGrid::fill() method
     * must implement this method.
     *
     * @abstract
     * @param  object Container of the class supported by the driver
     * @access public
     * @return mixed  True or PEAR_Error
     */
    function setContainer(&$container)
    {
        return $this->_noSupport(__FUNCTION__);
    }

    /**
     * Return the container used by the driver
     *
     * Drivers should implement this method when they have some kind of support
     * for rendering containers.
     *
     * @abstract
     * @return object Container of the class supported by the driver
     *                or PEAR_Error
     * @access public
     */
    function &getContainer()
    {
        return $this->_noSupport(__FUNCTION__);
    }

    /**
     * Create or/and prepare the container
     *
     * Drivers may optionally implement this method for any pre-build()
     * operations.
     *
     * For the container support, it is responsible for creating the
     * container if it has not already been provided by the user with
     * the setContainer() method. It is where preliminary container
     * setup should also be done.
     *
     * @abstract
     * @access protected
     */
    function init()
    {
    }

    /**
     * Build the header
     *
     * Drivers may optionally implement this method.
     *
     * @abstract
     *
     * @param   array $columns Columns' fields names and labels (This is a
     *                         convenient reference to the $_columns protected
     *                         property)
     * @access  protected
     * @return  void or PEAR_Error
     */
    function buildHeader(&$columns)
    {
    }

    /**
     * Stream a chunk of records
     *
     * @param  array    $records   2D array of records
     * @param  integer  $startRow  Starting row number
     * @param  boolean  $eof       Whether the current chunk is the last chunk
     * @access  protected
     * @return  void or PEAR_Error
     */
    function streamBody($records, $startRow, $eof = false)
    {
        $rowNum = count($records);
        for ($row = 0; $row < $rowNum; $row++) {
            $result = $this->buildRow($row + $startRow, $records[$row]);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        if ($eof && $this->_options['fillWithEmptyRows'] && !is_null($this->_pageLimit)) {
            for ($row = $this->_recordsNum; $row < $this->_pageLimit; $row++) {
                $result = $this->buildEmptyRow($row);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }
    }

    /**
     * Build the body
     *
     * Drivers may overload() this method, if buildRow() and buildEmptyRow()
     * are not flexible enough.
     *
     * @access  protected
     * @return  void or PEAR_Error
     */
    function buildBody()
    {
        for ($row = 0; $row < $this->_recordsNum; $row++) {
            $result = $this->buildRow($row, $this->_records[$row]);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        if ($this->_options['fillWithEmptyRows'] && !is_null($this->_pageLimit)) {
            for ($row = $this->_recordsNum; $row < $this->_pageLimit; $row++) {
                $result = $this->buildEmptyRow($row);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }
    }

    /**
     * Build a body row
     *
     * This is a very simple method for drivers to build a row.
     * For more flexibility, drivers should overload buildBody()
     *
     * @param int   $index Row index (zero-based)
     * @param array $data  Record data.
     *                     Structure: array(0 => <value0>, 1 => <value1>, ...)
     * @return void or PEAR_Error
     * @access protected
     * @abstract
     */
    function buildRow($index, $data)
    {
    }

    /**
     * Build an empty row
     *
     * Drivers must overload this method if they need to do something with
     * empty rows that remain at the end of the body.
     *
     * This method will only be called if the "fillWithEmptyRows" option is
     * enabled.
     *
     * @param int   $index Row index (zero-based)
     * @return void or PEAR_Error
     * @access protected
     * @abstract
     */
    function buildEmptyRow($index)
    {
    }

    /**
     * Build the footer
     *
     * Drivers may optionally implement this method.
     *
     * @abstract
     * @access  protected
     * @return  void or PEAR_Error
     */
    function buildFooter()
    {
    }

    /**
     * Finish building the datagrid.
     *
     * Drivers may optionally implement this method for any post-build()
     * operations.
     *
     * @abstract
     * @access  protected
     * @return  void or PEAR_Error
     */
    function finalize()
    {
    }

    /**
     * Retrieve output from the container object
     *
     * Drivers may optionally implement this method.
     *
     * This method is meant to retrieve final output from the container.
     *
     * Usually the container is an object (ex: HTMLTable instance),
     * and the final output a string.
     *
     * The driver knows how to retrieve such final output from a given
     * container (ex: HTMLTable::toHTML()), and this is where to do it.
     *
     * Sometimes the container may not be an object, but the final output
     * itself. In this case, this method should simply return the container.
     *
     * This method mustn't output anything directly to the standard output.
     *
     * @abstract
     * @return mixed Output
     * @access protected
     */
    function flatten()
    {
        return $this->_noSupport(__FUNCTION__);
    }

    /**
     * Default formatter for all cells
     *
     * Drivers may optionally implement this method.
     *
     * @abstract
     * @param string  Cell value
     * @return string Formatted cell value
     * @access protected
     */
    function defaultCellFormatter($value)
    {
        return $value;
    }

    /**
     * Build the grid
     *
     * Drivers must not overload this method. Pre and post-build operations
     * can be performed in init() and finalize()
     *
     * @param  array    $chunk     2D array of records
     * @param  integer  $startRow  Starting row number of current chunk
     * @param  boolean  $eof       Whether the current chunk is the last chunk
     * @access public
     * @return void
     */
    function build($chunk, $startRow, $eof = false)
    {
        // on first call of build(): initialize the columns and prepare the header
        if (empty($this->_columns)) {
            $this->_columns = array();
            foreach ($this->_columnObjects as $index => $column) {
                if (!is_null($column->orderBy)) {
                    $field = $column->orderBy;
                    if (!in_array($field,$this->_sortableFields) and
                        !in_array($field, $this->_options['hideColumnLinks'])
                       ) {
                        $this->_sortableFields[] = $field;
                    }
                } else if (!is_null($column->fieldName)) {
                    $field = $column->fieldName;
                } else {
                    $field = $column->columnName;
                }

                $label = $column->columnName;

                if (isset($this->_options['defaultColumnValues'][$field])) {
                    $column->setAutoFillValue($this->_options['defaultColumnValues'][$field]);
                } else if (!is_null($this->_options['defaultCellValue'])) {
                    $column->setAutoFillValue($this->_options['defaultCellValue']);
                }

                if (is_array($column->attribs)) {
                    if (!array_key_exists($field, $this->_options['columnAttributes'])) {
                        $this->_options['columnAttributes'][$field] = array();
                    }
                    $this->_options['columnAttributes'][$field] =
                        array_merge($this->_options['columnAttributes'][$field],
                                    $column->attribs);
                }

                $this->_defaultDirections[$field] = $column->defaultDirection;

                $this->_columns[$index] = compact('field','label');
            }

            $this->_columnsNum = count($this->_columns);

            $result = $this->init();
            if (PEAR::isError($result)) {
                return $result;
            }

            if ($this->_options['buildHeader']) {
                $result = $this->buildHeader($this->_columns);
                if (PEAR::isError($result)) {
                    return $result;
                }
            }
        }

        $chunkSize = count($chunk);
        $this->_recordsNum += $chunkSize;

        $row = 0;
        for ($rec = 0; $rec < $chunkSize; $rec++) {
            $content = array();
            $col = 0;
            foreach ($this->_columnObjects as $column) {
                $content[] = $this->recordToCell($column, $chunk[$rec],
                                                 $row + $startRow, $col);
                $col++;
            }
            $chunk[$rec] = $content;
            $row++;
        }

        if (!$this->hasFeature('streaming')) {
            $this->_records = array_merge($this->_records, $chunk);
        } else {
            $result = $this->streamBody($chunk, $startRow, $eof);
            if (PEAR::isError($result)) {
                return $result;
            }
        }

        // if this is the last chunk, do some final operations
        if ($eof) {
            if (is_null($this->_pageLimit)) {
                $result = $this->_pageLimit = $this->_recordsNum;
                if (PEAR::isError($result)) {
                    return $result;
                }
            }

            if (!$this->hasFeature('streaming')) {
                $result = $this->buildBody();
                if (PEAR::isError($result)) {
                    return $result;
                }
            }

            if ($this->_options['buildFooter']) {
                $result = $this->buildFooter();
                if (PEAR::isError($result)) {
                    return $result;
                }
            }

            $result = $this->finalize();
            if (PEAR::isError($result)) {
                return $result;
            }

            $this->_isBuilt = true;
        }
    }

    /**
     * Returns the output from the renderer (e.g. HTML table, XLS object, ...)
     *
     * Drivers must not overload this method. Output generation has to be
     * implemented in flatten().
     *
     * @access  public
     * @return  mixed    The output from the renderer
     */
    function getOutput()
    {
        if ($this->_streamingEnabled) {
            return PEAR::raiseError('getOutput() cannot be used together with ' .
                                    'streaming.');
        }

        if ($this->hasFeature('outputBuffering')) {
            return $this->flatten();
        } else {
            return $this->_noSupport(__FUNCTION__);
        }
    }

    /**
     * Render to the standard output
     *
     * This method may be overloaded by renderer drivers in order to prepare
     * writing to the standard output (like calling header(), etc...).
     *
     * @access  public
     * @return  void or object PEAR_Error
     */
    function render()
    {
        if ($this->hasFeature('outputBuffering')) {
            echo $this->flatten();
        } else {
            $result = $this->build(array(), 0);
            if (PEAR::isError($result)) {
                return $result;
            }
        }
    }

    /**
     * Return an error related to an unsupported public method
     *
     * When a given public method is not implemented/supported by the driver
     * it must return a PEAR_Error object with code DATAGRID_ERROR_UNSUPPORTED.
     * This is a helper method for generating such PEAR_Error objects.
     *
     * Example:
     *
     * <code>
     * function anUnsupportedMethod()
     * {
     *     return $this->_noSupport(__FUNCTION__);
     * }
     * </code>
     *
     * @param string $method The name of the unsupported method
     * @return object PEAR_Error with code DATAGRID_ERROR_UNSUPPORTED
     * @access protected
     */
    function _noSupport($method)
    {
        return PEAR::raiseError("The renderer driver class \"" .get_class($this).
                                "\" does not support the $method() method",
                                DATAGRID_ERROR_UNSUPPORTED);
    }

    /**
     * Sets the rendered status.  This can be used to "flush the cache" in case
     * you need to render the datagrid twice with the second time having changes
     *
     * This is quite an obsolete method...
     *
     * @access  public
     * @param   bool        $status     The rendered status of the DataGrid
     */
    function setRendered($status = false)
    {
        if (!$status) {
            $this->_isBuilt = false;
        }
        /* What are we supposed to do with $status = true ? */
    }

     /**
     * Set the HTTP Request prefix
     *
     * @param string $prefix The prefix string
     * @return void
     * @access public
     */
    function setRequestPrefix($prefix)
    {
        $this->_requestPrefix = $prefix;
    }

    /**
     * Perform record/column to cell intersection and formatting
     *
     * @param  object $column The column object
     * @param  array  $record Array of record values
     * @param  int    $row    The row number of the cell
     * @param  int    $col    The column number of the cell
     * @return string Formatted cell value
     * @access private
     */
    function recordToCell(&$column, $record, $row = null, $col = null)
    {
        $value = '';
        if (isset($column->formatter) and !empty($column->formatter)) {
            $value = $column->formatter($record, $row, $col);
        } else if (isset($column->fieldName) and isset($record[$column->fieldName])) {
            $value = $this->defaultCellFormatter($record[$column->fieldName]);
        }

        if (empty($value) and !is_null($column->autoFillValue)) {
            $value = $column->autoFillValue;
        }

        return $value;
    }

    /**
     * Query the grid build status
     *
     * @return bool Whether the grid has already been built or not
     * @access public
     */
    function isBuilt()
    {
        return $this->_isBuilt;
    }

    /**
     * Build an HTTP query for sorting a given column
     *
     * This is a handy method that most drivers can use in order to build
     * the HTTP queries that are used to sort columns.
     *
     * It takes the global "extraVars", "excludeVars" options as well as the
     * $_requestPrefix property into account and can also convert the ampersand
     * to XML/HTML entities according to the "encoding" option.
     *
     * @param $field            Sort field name
     * @param $direction        Sort direction
     * @param $convertAmpersand Whether to convert ampersands to XML/HTML
     *                          compliant entities
     * @param $extraParameters  Optional extra HTTP parameters
     * @return string Query string of the
     * @access protected
     *
     */
    function _buildSortingHttpQuery($field, $direction, $convertAmpersand = false,
                                    $extraParameters = array())
    {
        $prefix = $this->_requestPrefix;

        if (is_null($this->_sortingHttpQueryCommon)) {
            // Build and cache the list of common get parameters
            $this->_sortingHttpQueryCommon = $this->_options['extraVars'];
            $ignore   = $this->_options['excludeVars'];
            $ignore[] = $prefix . 'orderBy';
            $ignore[] = $prefix . 'direction';
            foreach ($extraParameters as $var => $value) {
                $ignore[] = $prefix . $var;
            }
            foreach ($_GET as $key => $val) {
                if (!in_array($key, $ignore)) {
                    $this->_sortingHttpQueryCommon[$key] = $val;
                }
            }
        }

        // Build list of GET variables
        $get = array();
        $get[$prefix . 'orderBy'] = $field;
        $get[$prefix . 'direction'] = $direction;
        foreach ($extraParameters as $var => $value) {
            $get[$prefix . $var] = $value;
        }

        // Merge common and column-specific GET variables
        $get = array_merge($this->_sortingHttpQueryCommon, $get);

        // Build query
        if ($convertAmpersand and ini_get('arg_separator.output') == '&') {
            $query = htmlentities(http_build_query($get),ENT_QUOTES,
                                  $this->_options['encoding']);
        } else {
            $query = http_build_query($get);
        }

        return $query;
    }

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

}

// This function is here because we can't depend on PHP_Compat
if (!function_exists('http_build_query')) {
    function http_build_query($formdata, $numeric_prefix = null)
    {
        // If $formdata is an object, convert it to an array
        if (is_object($formdata)) {
            $formdata = get_object_vars($formdata);
        }

        // Check we have an array to work with
        if (!is_array($formdata)) {
            user_error('http_build_query() Parameter 1 expected to be Array or Object. Incorrect value given.',
                E_USER_WARNING);
            return false;
        }

        // If the array is empty, return null
        if (empty($formdata)) {
            return;
        }

        // Argument seperator
        $separator = ini_get('arg_separator.output');
        if (strlen($separator) == 0) {
            $separator = '&';
        }

        // Start building the query
        $tmp = array ();
        foreach ($formdata as $key => $val) {
            if (is_null($val)) {
                continue;
            }

            if (is_integer($key) && $numeric_prefix != null) {
                $key = $numeric_prefix . $key;
            }

            if (is_scalar($val)) {
                array_push($tmp, urlencode($key) . '=' . urlencode($val));
                continue;
            }

            // If the value is an array, recursively parse it
            if (is_array($val) || is_object($val)) {
                array_push($tmp, http_build_query_helper($val, urlencode($key)));
                continue;
            }

            // The value is a resource
            return null;
        }

        return implode($separator, $tmp);
    }

    // Helper function
    function http_build_query_helper($array, $name)
    {
        $tmp = array ();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                array_push($tmp, http_build_query_helper($value, sprintf('%s[%s]', $name, $key)));
            } elseif (is_scalar($value)) {
                array_push($tmp, sprintf('%s[%s]=%s', $name, urlencode($key), urlencode($value)));
            } elseif (is_object($value)) {
                array_push($tmp, http_build_query_helper(get_object_vars($value), sprintf('%s[%s]', $name, $key)));
            }
        }

        // Argument seperator
        $separator = ini_get('arg_separator.output');
        if (strlen($separator) == 0) {
            $separator = '&';
        }

        return implode($separator, $tmp);
    }
}

/* vim: set expandtab tabstop=4 shiftwidth=4: */
?>
