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
use_unit("stdctrls.inc.php");
use_unit("extctrls.inc.php");

/**
 * ProgressBar Orientation
 */
define ('pbHorizontal', 'pbHorizontal');
define ('pbVertical', 'pbVertical');

/**
 * TrackBar Orientation
 */
define ('tbHorizontal', 'tbHorizontal');
define ('tbVertical', 'tbVertical');

/**
 * PageControl Tab position
 */
define ('tpTop', 'tpTop');
define ('tpBottom', 'tpBottom');

/**
 * EditLabel.LabelPosition
 */
define('lpAbove', 'lpAbove');
define('lpBelow', 'lpBelow');
//define('lpLeft',  'lpLeft');
//define('lpRight', 'lpRight');


/**
* Cell render types of ListColumn
*/
define('creEdit', 'creEdit');
define('creBoolean', 'creBoolean');

/**
* ListColumn represents a column of a ListView.
*
* Note: Currently qooxdoo (ListView uses a qooxdoo widget) does not allow
*       "not sortable" columns, meaning all column are sortable on the client side.
*
* @see ListView, ListItem
*/
class ListColumn extends Persistent
{
        protected $_caption="";
        protected $_cellrendertype=creEdit;
        protected $_editable=0;
        protected $_width=-1;
        protected $_visible=1;

        /**
        * Caption of the column. It defines the text that appears on to of the column.
        *
        * Use Caption to label the type of item that appears in the column.
        *
        * @return string
        */
        function getCaption() { return $this->_caption; }
        function setCaption($value) { $this->_caption=$value; }
        function defaultCaption() { return ""; }

        /**
        * The CellRenderType defines how the cells for a specific column are
        * rendered.
        *
        * Current possible values are creEdit and creBoolean where creEdit
        * is default.
        * If the column has a cell render type of creEdit the property Editable has to
        * be true in order to be able to edit the selected cell. Note that the edited
        * values are not transfered to the VCL for PHP framework. They are available
        * on client side only.
        * If creBoolean is set the cell value needs to be set to true or false.
        * The renderer then paints a checkbox. Note that it is read-only mode only. If
        * Editable is set to true the user may enter text rather than changed the checkbox
        * state.
        *
        * @return enum
        */
        function getCellRenderType() { return $this->_cellrendertype; }
        function setCellRenderType($value) { $this->_cellrendertype=$value; }
        function defaultCellRenderType() { return creEdit; }

        /**
        * Defines if the cell in the column are editable.
        *
        * Note: If CellRenderType is set to creBoolean Editable should be set to false.
        *       For the reason read the comment for CellRenderType.
        *
        * @see getCellRenderType()
        *
        * @return bool
        */
        function getEditable() { return $this->_editable; }
        function setEditable($value) { $this->_editable=$value; }
        function defaultEditable() { return 0; }

        /**
        * Width of the column.
        *
        * The width is not fixed and therefor can be changed be the user on the client side.
        * The width may be specified as integer number of pixels (e.g. 100),
        * a string representing percentage of the inner width of the Table (e.g. "25%"),
        * or a string representing a flex width (e.g. "1*").
        *
        * @see getCellRenderType()
        *
        * @return mixed
        */
        function getWidth() { return $this->_width; }
        function setWidth($value) { $this->_width=$value; }
        function defaultWidth() { return -1; }

        /**
        * Determines if the Column is visible.
        *
        * @return bool
        */
        function getVisible() { return $this->_visible; }
        function setVisible($value) { $this->_visible=$value; }
        function defaultVisible() { return 1; }


}

/**
* ListItem is an individual item of a ListView control.
*
* A ListItem specifies a row of the ListView, where Caption is the text shown in
* the first column and SubItems to following columns.
* Note that the count of ListColumn objects defines how many columns are shown, even
* if there are more SubItems.
* The ListItem was modeled after VCL for Windows, meaning that there is
* a caption and subitems. The caption is used for the first column where
* the subitems are used for any further column.
*
* @see ListView, ListColumn
*/
class ListItem extends Persistent
{
        protected $_caption="";
        protected $_data=null;
        protected $_listview=null;
        protected $_selected=0;
        protected $_subitems=array();

        /**
        * Caption is the text shown in the first column of the row.
        *
        * Use Caption to name the list item. The Caption appears of the list view.
        *
        * If the ReadOnly property of the list view is false, the user can edit the caption.
        *
        * @return string
        */
        function getCaption() { return $this->_caption; }
        function setCaption($value) { $this->_caption=$value; }
        function defaultCaption() { return ""; }

        /**
        * Specifies any application-specific data associated with the list item.
        *
        * Use Data to associate arbitrary data structure with the list item.
        * When the user selects or deletes the list item, Data allows the application
        * to quickly access information about the meaning of the list item to
        * implement the appropriate response.
        *
        * @return mixed
        */
        function getData() { return $this->_data; }
        function setData($value) { $this->_data=$value; }
        function defaultData() { return null; }

        /**
        * ListView is the reference back to the ListView where the ListItem
        * belongs to.
        *
        * Read ListView to access the list view object that displays the item.
        * Use the properties and methods of the list view object to make changes
        * that affect the list item or to manipulate other items in the list.
        *
        * Do not confuse the ListView that displays the item with the Owner of
        * the item.
        *
        * @return ListView
        */
        function getListView() { return $this->_listview; }
        function setListView($value) { $this->_listview=$value; }
        function defaultListView() { return null; }

        /**
        * Indicates if the ListItem is selected or not.
        *
        * Use Selected to select or unselect the list item. If the MultiSelect
        * property of the list view is false, setting Selected to true sets the
        * Selected property of all other list items in the list view to false.
        *
        * @return bool
        */
        function getSelected() { return $this->_selected; }
        function setSelected($value) { $this->_selected=$value; }
        function defaultSelected() { return 0; }

        /**
        * An array of SubItems that are shown in the remaing columns.
        *
        * Note that if there are more sub items defined than columns, only the sub items
        * are visible the are within the count of the column.
        * The output of the sub items starts at the second column since the first
        * column is used for Caption.
        *
        * @return array
        */
        function getSubItems() { return $this->_subitems; }
        function setSubItems($value) { $this->_subitems=$value; }
        function defaultSubItems() { return array(); }
}


/**
* Selection types of ListView
*/
define('selNone', 'selNone');
define('selSingle', 'selSingle');
define('selOneInterval', 'selOneInterval');
define('selMultiInterval', 'selMultiInterval');

/**
 * Base class of ListView control
 *
 * Use CustomListView as a base class when defining a control that displays a
 * list of items. CustomListView allows a list of items to be displayed in
 * columns with column headers and sub-items.
 * To explain the concept of items and sub-items, think of it as items
 * are displayed in the first column and the sub-items in the following columns.
 *
 * @see QWidget
 */
class CustomListView extends QWidget
{
        protected $_onsubmit=null;

        protected $_jsonselectionchanged=null;

        protected $_columns=array();
        protected $_items=array();
        protected $_selectiontype=selSingle;
        protected $_sortascending=1;
        protected $_sortcolumnindex=-1;
        protected $_objectcolumns=true;


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=557;
                $this->Height=314;
        }

       function dumpJsEvents()
        {
                parent::dumpJsEvents();
                $this->dumpJSEvent($this->_jsonselectionchanged);
        }

        /**
        * Converts an array that contains strings into an array with ListColumn
        * objects. convertPureArrayToColumns() is used after unserializing the
        * values set by the object inspector.
        *
        * @see ListColumn
        *
        * @param array $columnsarray The array that contains the strings.
        * @return array Returns the array that contains the objects.
        */
        function convertPureArrayToColumns($columnsarray)
        {
                $ret = array();
                if (is_array($columnsarray))
                {
                        foreach($columnsarray as $v)
                        {
                                // check if the value is an array that may contain column values
                                if (is_array($v))
                                {
                                        $lc = new ListColumn();

                                        if (array_key_exists('Caption', $v))
                                                $lc->Caption = $v['Caption'];

                                        $ret[] = $lc;
                                }
                                // check if it is a just a plain string
                                else if (is_string($v))
                                {
                                        $lc = new ListColumn();
                                        $lc->Caption = $v;
                                        $ret[] = $lc;
                                }
                                // check if it is already a ListColumn object
                                else if (is_object($v) && $v->classNameIs("ListColumn"))
                                {
                                        $ret[] = $v;
                                }
                        }
                }
                return $ret;
        }

        /**
        * Converts a two-dimesional array into an array of ListItem objects.
        *
        * @see ListItem
        *
        * @param array $itemsarray Two-dimensional array of strings.
        * @return array An array of ListItem objects.
        */
        function convertPureArrayToItems($itemsarray)
        {
                $ret = array();
                if (is_array($itemsarray))
                {
                        foreach($itemsarray as $vItem)
                        {
                                // check if the value is an array that may contain item values
                                if (is_array($vItem))
                                {
                                        $li = new ListItem();
                                        $subitems = array();

                                        // check if the $v array is a string array
                                        foreach ($vItem as $vSubItem)
                                        {
                                                if (is_string($vSubItem))
                                                {
                                                        $subitems[] = $vSubItem;
                                                }
                                        }

                                        // first subitem is the caption of the ListItem
                                        if (count($subitems) > 0)
                                        {
                                                // remove the first element and set the Caption property with it
                                                $li->Caption = array_shift($subitems);
                                        }
                                        $li->SubItems = $subitems;

                                        $ret[] = $li;
                                }
                                // check if it is already a ListItem object
                                else if (is_object($vItem) && $vItem->classNameIs("ListItem"))
                                {
                                        $ret[] = $vItem;
                                }
                        }
                }
                return $ret;
        }

        function unserialize()
        {
                parent::unserialize();

                // if not in design mode convert the array-columns and items into objects
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        if ($this->_objectcolumns)
                        {
                            $this->_columns = $this->convertPureArrayToColumns($this->_columns);
                            $this->_items = $this->convertPureArrayToItems($this->_items);
                        }
                }
        }

        function loaded()
        {
                parent::loaded();

                // get the SortColumnIndex submitted from the page
                $submittedSortColumnIndex = $this->input->{"{$this->Name}SortColumnIndex"};
                if (is_object($submittedSortColumnIndex))
                {
                        $this->_sortcolumnindex = intval($submittedSortColumnIndex->asString());
                }

                // get the SortAscending submitted from the page
                $submittedSortAscending = $this->input->{"{$this->Name}SortAscending"};
                if (is_object($submittedSortAscending))
                {
                        $this->_sortascending = ($submittedSortAscending->asString() == "true") ? 1 : 0;
                }

                // get the selected items; it's a comma separated list of indices
                $submittedSelectedItems = $this->input->{"{$this->Name}SelectedItems"};
                if (is_object($submittedSelectedItems))
                {
                        // make sure that the string is set otherwise explode() may
                        // return an array with one empty item is it
                        if (strlen($submittedSelectedItems->asString()) > 0)
                        {
                                // convert the string to an array
                                $arr = explode(',', $submittedSelectedItems->asString());

                                // set the selected state of each item
                                $index = 0;
                                foreach($this->_items as $item)
                                {
                                        $item->Selected = in_array($index, $arr);
                                        $index++;
                                }
                        }
                }
        }

        function init()
        {
                parent::init();

                // this is only to check if the ListView was submitted
                $submittedSelectedItems = $this->input->{"{$this->Name}SelectedItems"};
                if (is_object($submittedSelectedItems))
                {
                        // call OnSubmit after the items have been updated
                        $this->callEvent('onsubmit', array());
                }
        }

        /*
        function dumpForAjax()
        {
                $this->commonScript();
        }

        function commonScript()
        {
                $columns = array();
                $cellrendertypes = array();
                // add the columns captions to the array
                foreach ($this->_columns as $column)
                {
                        $cre = creEdit;
                        if (is_object($column))
                        {
                                // put the column caption in quotes
                                $columns[] = "\"".$column->Caption."\"";
                                $cre = $column->CellRenderType;
                        }
                        else if (is_string($column))
                        {
                                $columns[] = "\"".$column."\"";
                        }
                        $cellrendertypes[] = $cre;
                }

                // get the column index where the indices will be written to
                $columnIndexOfIndices = count($columns);
                // add the "Index" column; it will be hidden
                $columns[] = "\"Index\"";

                echo "  var columnData = [" . implode(",", $columns) . "];\n";
                echo "  var rowData = [];\n\n";

                // prepare an array that hold all indices that are selected
                $selecteditemindices = array();

                // items are currently only available at run time
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        foreach ($this->_items as $key => $item)
                        {
                                $row = array();
                                // quote if the Caption is a string
                                $row[] = ($cellrendertypes[0] == creEdit) ? "\"".$item->Caption."\"" : $item->Caption;

                                $index = 1;  // $index at 0 is Caption
                                foreach ($item->SubItems as $subitem)
                                {
                                        // quote if the sub item is a string
                                        $row[] = ($cellrendertypes[$index] == creEdit) ? "\"".$subitem."\"" : $subitem;
                                        $index++;
                                }

                                // make sure the count of columns in this row do not exceed the one of $columns
                                while (count($row) > count($columns))
                                {
                                        array_pop($row);
                                }

                                // add the the index of the current row
                                $row[] = $key;

                                echo "  rowData.push([" . implode(",", $row) . "]);\n";

                                if ($item->Selected)
                                {
                                        $selecteditemindices[] = $key;
                                }
                        }
                }

                echo "  tableModel.setColumns(columnData);\n";
                echo "  tableModel.setData(rowData);\n";

                echo "  var {$this->Name}_colmodel = $this->Name.getTableColumnModel();\n";

                // add the columnIndexOfIndices to the Table object in JS
                // so we later know it in the updateSelectedListViewItems() JS function
                echo "  $this->Name.columnIndexOfIndices = $columnIndexOfIndices;\n";
                // make sure this column of the indices is not visible
                echo "  {$this->Name}_colmodel.setColumnVisible($columnIndexOfIndices, false);\n";

                // currently only available at run time
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $index = 0;
                        // output the special column properties
                        foreach ($this->_columns as $column)
                        {
                                if ($column->Editable)
                                {
                                        echo "  tableModel.setColumnEditable($index, true);\n";
                                }
                                if ($column->Width != -1)
                                {
                                        $width = (is_int($column->Width)) ? $column->Width : "\"$column->Width\"";
                                        echo "  {$this->Name}_colmodel.setColumnWidth($index, $width);\n";
                                }
                                // add the renderer (BooleanDataCellRenderer) if set
                                if ($column->CellRenderType == creBoolean)
                                {
                                        echo "  {$this->Name}_colmodel.setDataCellRenderer($index, new qx.ui.table.BooleanDataCellRenderer());\n";
                                }
                                if (!$column->Visible)
                                {
                                        echo "  {$this->Name}_colmodel.setColumnVisible($index, false);\n";
                                }

                                $index++;
                        }
                }

                // if a sort column is set then sort the items acording to it;
                if ($this->_sortcolumnindex > -1)
                {
                        echo "  tableModel.sortByColumn($this->_sortcolumnindex, ".($this->_sortascending ? "true" : "false").");\n";
                }

                // set the selection mode
                $qxstr = "qx.ui.table.SelectionModel.SINGLE_SELECTION";
                switch ($this->_selectiontype)
                {
                        case selNone:          $qxstr = "qx.ui.table.SelectionModel.NO_SELECTION"; break;
                        case selSingle:        $qxstr = "qx.ui.table.SelectionModel.SINGLE_SELECTION"; break;
                        case selOneInterval:   $qxstr = "qx.ui.table.SelectionModel.SINGLE_INTERVAL_SELECTION"; break;
                        case selMultiInterval: $qxstr = "qx.ui.table.SelectionModel.MULTIPLE_INTERVAL_SELECTION"; break;
                }
                echo "  $this->Name.getSelectionModel().setSelectionMode($qxstr); \n";

                // set the selected items
                sort($selecteditemindices);
                echo "  var selecteditemindices = [" . implode(",", $selecteditemindices) . "];\n";
                echo "  var found;\n";
                echo "  var ii;\n";
                echo "  for (var i = 0; i < rowData.length; i++) { \n";
                echo "    found = false;\n";
                echo "    ii = 0;\n";
                echo "    while (!found && ii < selecteditemindices.length) { \n";
                echo "      found = (selecteditemindices[ii] == rowData[i][$columnIndexOfIndices]); \n";
                echo "      ii++;\n";
                echo "    }\n";
                echo "    if (found) {\n";
                echo "      $this->Name.getSelectionModel().addSelectionInterval(i, i); \n";
                echo "    }\n";
                echo "  }\n";

                // output the rest of the common properties
                echo "  $this->Name.setBorder(qx.renderer.border.BorderPresets.getInstance().shadow);\n";
                $color = ($this->_color != "") ? $this->_color : "white";
                echo "  $this->Name.setBackgroundColor(\"$color\");\n";
                echo "  $this->Name.setLeft(0);\n";
                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight($this->Height);\n";

                __QLibrary_SetCursor($this->Name, $this->Cursor);
        }
        */

        /**
        * Dumps required code to show information, and columns on the listview
        *
        * This is an internal method used by the component to generate all columns
        * and rows required to build up the control.
        *
        * You don't need to call this method directly.
        *
        *  @see dumpForAjax()
        */
        function updateControl($create=true)
        {

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        // redirect the form's OnSubmit JS event; save it first so the original
                        // event is not lost
//                        echo "  var {$this->Name}_formonsubmit = document.forms[0].onsubmit;\n";
//                        echo "  document.forms[0].onsubmit = {$this->Name}UpdateProps;\n";
                }

//                        echo "  alert(tableModel);\n";


                $columns = array();
                $cellrendertypes = array();
                // add the columns captions to the array
                foreach ($this->_columns as $column)
                {
                        $cre = creEdit;
                        if (is_object($column))
                        {
                                // put the column caption in quotes
                                $columns[] = "\"".$column->Caption."\"";
                                $cre = $column->CellRenderType;
                        }
                        else if (is_string($column))
                        {
                                $columns[] = "\"".$column."\"";
                        }
                        $cellrendertypes[] = $cre;
                }


                // get the column index where the indices will be written to
                $columnIndexOfIndices = count($columns);
                // add the "Index" column; it will be hidden
                $columns[] = "\"Index\"";

                echo "  var columnData = [" . implode(",", $columns) . "];\n";
                echo "  var rowData = [];\n\n";

                // prepare an array that hold all indices that are selected
                $selecteditemindices = array();

                // items are currently only available at run time
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        foreach ($this->_items as $key => $item)
                        {
                                $row = array();
                                // quote if the Caption is a string
                                $val=str_replace('"','\"',$item->Caption);
                                $row[] = ($cellrendertypes[0] == creEdit) ? "\"".$val."\"" : $item->Caption;

                                $index = 1;  // $index at 0 is Caption
                                foreach ($item->SubItems as $subitem)
                                {
                                        $val=str_replace('"','\"',$subitem);
                                        // quote if the sub item is a string
                                        $row[] = ($cellrendertypes[$index] == creEdit) ? "\"".$val."\"" : $subitem;
                                        $index++;
                                }

                                // make sure the count of columns in this row do not exceed the one of $columns
                                while (count($row) > count($columns))
                                {
                                        array_pop($row);
                                }

                                // add the the index of the current row
                                $row[] = $key;

                                echo "  rowData.push([" . implode(",", $row) . "]);\n";

                                if ($item->Selected)
                                {
                                        $selecteditemindices[] = $key;
                                }
                        }
                }

                if (!$create)
                {
                        echo "  var tableModel=".$this->owner->Name.".".$this->Name.".getTableModel();\n";
                        echo "  var $this->Name=".$this->owner->Name.".".$this->Name.";\n";
                }


                echo "  tableModel.setColumns(columnData);\n";
                echo "  tableModel.setData(rowData);\n";

                if ($create)
                {
                        echo "  var $this->Name = new qx.ui.table.Table(tableModel);\n";
                        if (($this->ControlState & csDesigning)!=csDesigning)
                        {
                            if ($this->owner!=null) echo "  ".$this->owner->Name.".".$this->Name."=$this->Name;\n";
                        }
                        echo "  var {$this->Name}_colmodel = $this->Name.getTableColumnModel();\n";
                }

                // add the columnIndexOfIndices to the Table object in JS
                // so we later know it in the updateSelectedListViewItems() JS function
                echo "  $this->Name.columnIndexOfIndices = $columnIndexOfIndices;\n";
                // make sure this column of the indices is not visible
                echo "  {$this->Name}_colmodel.setColumnVisible($columnIndexOfIndices, false);\n";


                // currently only available at run time
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $index = 0;
                        // output the special column properties
                        foreach ($this->_columns as $column)
                        {
                                if ($column->Editable)
                                {
                                        echo "  tableModel.setColumnEditable($index, true);\n";
                                }
                                if ($column->Width != -1)
                                {
                                        $width = (is_int($column->Width)) ? $column->Width : "\"$column->Width\"";
                                        echo "  {$this->Name}_colmodel.setColumnWidth($index, $width);\n";
                                }
                                // add the renderer (BooleanDataCellRenderer) if set
                                if ($column->CellRenderType == creBoolean)
                                {
                                        echo "  {$this->Name}_colmodel.setDataCellRenderer($index, new qx.ui.table.BooleanDataCellRenderer());\n";

                                        if ($column->Editable)
                                        {
                                            echo "  var factory=new qx.ui.table.CheckBoxCellEditorFactory(); \n";
                                            echo "  $this->Name.getTableColumnModel().setCellEditorFactory($index,factory);\n";
                                        }

                                }
                                if (!$column->Visible)
                                {
                                        echo "  {$this->Name}_colmodel.setColumnVisible($index, false);\n";
                                }

                                $index++;
                        }
                }


                // if a sort column is set then sort the items acording to it;
                if ($this->_sortcolumnindex > -1)
                {
                        echo "  tableModel.sortByColumn($this->_sortcolumnindex, ".($this->_sortascending ? "true" : "false").");\n";
                }

                // add the JS event if set
                if ($this->_jsonselectionchanged != null)
                {
                        echo "  $this->Name.getSelectionModel().addEventListener(\"changeSelection\", $this->_jsonselectionchanged); \n";
                }

                // set the selection mode
                $qxstr = "qx.ui.table.SelectionModel.SINGLE_SELECTION";
                switch ($this->_selectiontype)
                {
                        case selNone:          $qxstr = "qx.ui.table.SelectionModel.NO_SELECTION"; break;
                        case selSingle:        $qxstr = "qx.ui.table.SelectionModel.SINGLE_SELECTION"; break;
                        case selOneInterval:   $qxstr = "qx.ui.table.SelectionModel.SINGLE_INTERVAL_SELECTION"; break;
                        case selMultiInterval: $qxstr = "qx.ui.table.SelectionModel.MULTIPLE_INTERVAL_SELECTION"; break;
                }
                echo "  $this->Name.getSelectionModel().setSelectionMode($qxstr); \n";

                // set the selected items
                sort($selecteditemindices);
                echo "  var selecteditemindices = [" . implode(",", $selecteditemindices) . "];\n";
                /*
                echo "  var found;\n";
                echo "  var ii;\n";
                echo "  for (var i = 0; i < rowData.length; i++) { \n";
                echo "    found = false;\n";
                echo "    ii = 0;\n";
                echo "    while (!found && ii < selecteditemindices.length) { \n";
                echo "      found = (selecteditemindices[ii] == rowData[i][$columnIndexOfIndices]); \n";
                echo "      ii++;\n";
                echo "    }\n";
                echo "    if (found) {\n";
                echo "      $this->Name.getSelectionModel().addSelectionInterval(i, i); \n";
                echo "    }\n";
                echo "  }\n";
                */


                // output the rest of the common properties
                echo "  $this->Name.setBorder(qx.renderer.border.BorderPresets.getInstance().shadow);\n";
                $color = ($this->_color != "") ? $this->_color : "white";
                echo "  $this->Name.setBackgroundColor(\"$color\");\n";
//                echo "  $this->Name.setLeft(0);\n";
//                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight($this->Height);\n";
        }

        /**
        * This is an internal method you don't need to call directly
        *
        * This method is called by the Ajax engine to get the code to update the
        * component after an ajax call
        *
        * @see commonScript()
        */
        function dumpForAjax()
        {
                $this->updateControl(false);
        }

        function dumpContents()
        {
                // add the hidden fields before we start with the output of the JS
                echo "<input type=\"hidden\" name=\"{$this->Name}SelectedItems\" id=\"{$this->Name}SelectedItems\" value=\"\" />\n";
                echo "<input type=\"hidden\" name=\"{$this->Name}SortColumnIndex\" id=\"{$this->Name}SortColumnIndex\" value=\"$this->_sortcolumnindex\" />\n";
                echo "<input type=\"hidden\" name=\"{$this->Name}SortAscending\" id=\"{$this->Name}SortAscending\" value=\"".($this->_sortascending ? "1" : "0")."\" />\n";

                $this->dumpCommonContentsTop();

                // call the updateSelectedListViewItems within this javascript function
                echo "function {$this->Name}UpdateProps() { \n"
                    ."  var tableModel = $this->Name.getTableModel(); \n"
                    ."  document.forms[0].{$this->Name}SortColumnIndex.value = tableModel.getSortColumnIndex(); \n"
                    ."  document.forms[0].{$this->Name}SortAscending.value = tableModel.isSortAscending(); \n"
                    ."  updateSelectedListViewItems($this->Name, document.forms[0].{$this->Name}SelectedItems); \n"
                    // call the original OnSubmit event if it exists
                    ."  if(typeof({$this->Name}_formonsubmit) == 'function') \n"
                    ."    {$this->Name}_formonsubmit(); \n"
                    ."  return true; \n"
                    ."} \n\n";

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        // redirect the form's OnSubmit JS event; save it first so the original
                        // event is not lost
                        echo "  var {$this->Name}_formonsubmit = document.forms[0].onsubmit;\n";
                        echo "  document.forms[0].onsubmit = {$this->Name}UpdateProps;\n";
                }

                echo "  var tableModel = new qx.ui.table.SimpleTableModel();\n";
                $this->updateControl(true);

                __QLibrary_SetCursor($this->Name, $this->Cursor);

                // allow the user of this component to add some customized JS code
                $this->callEvent('onshow', array());

                $this->dumpCommonContentsBottom();

        }

        /*
        function dumpContents()
        {
                // add the hidden fields before we start with the output of the JS
                echo "<input type=\"hidden\" name=\"{$this->Name}SelectedItems\" id=\"{$this->Name}SelectedItems\" value=\"\" />\n";
                echo "<input type=\"hidden\" name=\"{$this->Name}SortColumnIndex\" id=\"{$this->Name}SortColumnIndex\" value=\"$this->_sortcolumnindex\" />\n";
                echo "<input type=\"hidden\" name=\"{$this->Name}SortAscending\" id=\"{$this->Name}SortAscending\" value=\"".($this->_sortascending ? "1" : "0")."\" />\n";

                $this->dumpCommonContentsTop();


                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        // redirect the form's OnSubmit JS event; save it first so the original
                        // event is not lost
                        echo "  var {$this->Name}_formonsubmit = document.forms[0].onsubmit;\n";
                        echo "  document.forms[0].onsubmit = {$this->Name}UpdateProps;\n";
                }

                echo "  var tableModel = new qx.ui.table.SimpleTableModel();\n";
                echo "  var $this->Name = new qx.ui.table.Table(tableModel);\n";


                // add the JS event if set
                if ($this->_jsonselectionchanged != null)
                {
                        echo "  $this->Name.getSelectionModel().addEventListener(\"changeSelection\", $this->_jsonselectionchanged); \n";
                }

                $this->commonScript();

                // allow the user of this component to add some customized JS code
                $this->callEvent('onshow', array());

                $this->dumpCommonContentsBottom();
        }
        */

        function dumpJavascript()
        {
                parent::dumpJavascript();

                // only write this function once; it can be used by other ListViews
                if (!defined('updateSelectedListViewItems'))
                {
                        define('updateSelectedListViewItems', 1);

                        echo "function updateSelectedListViewItems(lv, hiddenfield) { \n"
                            ."  var selectedRowData = []; \n"
                            ."  var i = -1; \n"
                            ."  var tableModel = lv.getTableModel(); \n"
                            ."  lv.getSelectionModel().iterateSelection(function(index) { \n"
                            ."    i = tableModel.getValue(lv.columnIndexOfIndices, index); \n"
                            ."    selectedRowData.push(i); \n"
                            ."  }); \n"
                            ."  hiddenfield.value = selectedRowData.toString(); \n"
                            ."} \n\n";
                }
        }

        function dumpHeaderCode()
        {
            parent::dumpHeaderCode();
            if (!defined('QOOXDOO_CHECKBOXEDITOR'))
            {
                define('QOOXDOO_CHECKBOXEDITOR',1);
                echo "<script type=\"text/javascript\">\n"
?>
qx.OO.defineClass("qx.ui.table.CheckBoxCellEditorFactory", qx.ui.table.CellEditorFactory,
function() {
  qx.ui.table.CellEditorFactory.call(this);
});


// overridden
qx.Proto.createCellEditor = function(cellInfo) {
  var cellEditor = new qx.ui.form.CheckBox('','','',false);

  cellEditor.setChecked(cellInfo.value);
  return cellEditor;
}


// overridden
qx.Proto.getCellEditorValue = function(cellEditor) {
  var value = cellEditor.getChecked();
  return value;
}
</script>
<?php
    }
}

        /**
        * Adds a new column to the ListView.
        *
        * Use this method to add columns to the listview. After that, you can use
        * addItem to add new items, where the caption for that item will be
        * shown on the first column, subitems will be shown on the rest.
        *
        * <code>
        * <?php
        *      function ListView1BeforeShow($sender, $params)
        *      {
        *       $this->ListView1->addColumn("Column1");
        *       $this->ListView1->addColumn("Column2");
        *       $this->ListView1->addItem("Item1",array('test'));
        *       $this->ListView1->addItem("Item2",array('subitem'));
        *      }
        * ?>
        * </code>
        *
        * @see ListColumn, addItem
        *
        * @param string $caption Title or caption of the column.
        * @param mixed $width Please have a look at ListColumn::Width for
        *                     further details about the allowed values.
        *                     -1 indicates that no Width is set.
        * @param enum(creEdit, creBoolean) $cellRenderType Defines how the cells of the column are rendered.
        * @param bool $editable Indicates if the cells of the column are editable.
        *                       If creBoolean is used editable should be set to false.
        * @return ListColumn Returns the newly created and added ListColumn object.
        */
        function addColumn($caption, $width = -1, $cellRenderType = creEdit, $editable = true)
        {
                $col = new ListColumn();
                $col->Caption = $caption;
                $col->Width = $width;
                $col->CellRenderType = $cellRenderType;
                $col->Editable = $editable;

                $this->_columns[] = $col;

                return $col;
        }

        /**
        * Adds a new item/row to the ListView.
        *
        * The ListItem was modeled after VCL for Windows, meaning that there is
        * a caption and subitems. The caption is used for the first column where
        * the subitems are used for any further column.
        *
        * <code>
        * <?php
        *      function ListView1BeforeShow($sender, $params)
        *      {
        *       $this->ListView1->addColumn("Column1");
        *       $this->ListView1->addColumn("Column2");
        *       $this->ListView1->addItem("Item1",array('test'));
        *       $this->ListView1->addItem("Item2",array('subitem'));
        *      }
        * ?>
        * </code>
        *
        *
        * @see ListItem, deleteItem()
        *
        * @param string $caption Caption of the item.
        * @param array $subitems An array of strings used for the 2nd - x column.
        * @param bool $selected Defines if the item/row is selected.
        * @return ListItem Returns the newly created and added ListItem object.
        */
        function addItem($caption, $subitems = array(), $selected = false)
        {
                $item = new ListItem();
                $item->ListView = $this;
                $item->Caption = $caption;
                $item->SubItems = (is_array($subitems)) ? $subitems : array();
                $item->Selected = $selected;

                $this->_items[] = $item;

                return $item;
        }

        /**
        * Delete an item by it's index.
        *
        * @see ListItem, deleteSelected()
        *
        * @param integer $index The index to delete.
        */
        function deleteItem($index)
        {
                $items = $this->_items;
                // reset the items
                $this->_items = array();
                foreach($items as $key => $item)
                {
                        // add all except item at $index
                        if ($key != $index)
                        {
                                $this->_items[] = $item;
                        }
                }
        }

        /**
        * Deletes all the selected items.
        *
        * @see deleteItem()
        */
        function deleteSelected()
        {
                $items = $this->_items;
                // reset the items
                $this->_items = array();
                foreach($items as $item)
                {
                        // only add the unselected items
                        if (!$item->Selected)
                        {
                                $this->_items[] = $item;
                        }
                }
        }

        /**
        * Removes the selection, leaving all items unselected.
        *
        * @see deleteSelected()
        *
        */
        function clearSelected()
        {
                foreach($this->_items as $item)
                {
                        $item->Selected = false;
                }
        }

        /**
        * Selects all items.
        *
        * @see deleteSelected(), clearSelected()
        */
        function selectAll()
        {
                foreach($this->_items as $item)
                {
                        $item->Selected = true;
                }
        }

        /**
        * Occurs when the form containing the control was submitted.
        *
        * Use this event to write code that will get executed when the form
        * is submitted and the control is about to update itself with the modifications
        * the user has made on it.
        *
        * @return mixed
        */
        function readOnSubmit() { return $this->_onsubmit; }
        function writeOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }

        /**
        * JS event occurs when the selection of the list view was changed.
        *
        * Use this event to react to changes on the listview selection because
        * it's fired when the items selected on the listview are changed.
        *
        * @return mixed
        */
        function readjsOnSelectionChanged() { return $this->_jsonselectionchanged; }
        function writejsOnSelectionChanged($value) { $this->_jsonselectionchanged=$value; }
        function defaultjsOnSelectionChanged() { return null; }


        /**
        * Describes the list of ListColumn objects used for the settings of the columns.
        *
        * Use this property to specify an array in which each item represents
        * a column.
        *
        * @see ListColumn
        *
        * @return array
        */
        function readColumns()        { return $this->_columns; }
        function writeColumns($value) { $this->_columns=$value; }
        function defaultColumns()               { return null; }

        /**
        * Contains the list of items displayed by the list view.
        *
        * This property is an array that contain the items shown by the list view,
        * you can use it as any other array, but you will get better results using
        * the methods provided to manage it.
        *
        * Use addItem(), deleteItem() to modify the array.
        *
        * @see ListItem, addItem, deleteItem()
        *
        * @return array
        */
        function readItems()          { return $this->_items; }
        function writeItems($value)   { $this->_items=$value; }
        function defaultItems()                 { return null; }

        /**
        * SelectionType defines how the user can select the items in the ListView.
        * Possible values are:
        *
        * selNone - No items can be selected.
        *
        * selSingle - Only a single item in th elist can be selected.
        *
        * selOneInterval - One interval can be selected.
        *
        * selMultiInterval - Multiple intervals can be selected.
        *
        * @see deleteSelected(), clearSelected(), selectAll()
        *
        * @return enum
        */
        function readSelectionType() { return $this->_selectiontype; }
        function writeSelectionType($value) { $this->_selectiontype=$value; }
        function defaultSelectionType() { return selSingle; }

        /**
        * Indicates if the sorted column is in ascending order.
        *
        * If false, the items of the sorted column are in descending order.
        * If no sorted column is set this property has no affect.
        *
        * @see readSortColumnIndex()
        *
        * @return bool
        */
        function readSortAscending() { return $this->_sortascending; }
        function writeSortAscending($value) { $this->_sortascending=$value; }
        function defaultSortAscending() { return 1; }

        /**
        * Indicates the index of the column of the ListView that is sorted.
        *
        * The index starts at 0 for the first column. If SortColumnIndex is set to -1
        * no column is sorted.
        *
        * @see readSortAscending()
        *
        * @return integer
        */
        function readSortColumnIndex() { return $this->_sortcolumnindex; }
        function writeSortColumnIndex($value) { $this->_sortcolumnindex=$value; }
        function defaultSortColumnIndex() { return -1; }


}

/**
 * ListView displays a list of items in one or more columns.
 *
 * Use ListView to manage and display a list of items in a form. The items can be
 * displayed in columns with column headers and sub-items.
 *
 * ListView publishes many of the properties, events, and methods of CustomListView,
 * but does not introduce any new behavior.
 *
 * @see ListItem, ListColumn
 * @example ListView/listview.php How to use ListView control
 */
class ListView extends CustomListView
{
    function serialize()
    {
    	parent::serialize();

        //Stores the items on the session
        $owner = $this->readOwner();
        if ($owner != null)
        {
        	$prefix = $owner->readNamePath().".".$this->_name.".";
            $_SESSION[$prefix."items"]= serialize($this->_items);
        }
    }

    function unserialize()
    {
        //Recovers the current page from the session, if any
        $owner = $this->readOwner();
        if ($owner != null)
        {
        	$prefix = $owner->readNamePath().".".$this->_name.".";
            if (isset($_SESSION[$prefix."items"])) $this->items = safeunserialize($_SESSION[$prefix."items"]);
        }
    	parent::unserialize();
    }

        /*
        * Publish the events for the component
        */
        function getOnSubmit()                  { return $this->readOnSubmit(); }
        function setOnSubmit($value)            { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the component
        */
        function getjsOnSelectionChanged()      { return $this->readjsOnSelectionChanged(); }
        function setjsOnSelectionChanged($value) { $this->writejsOnSelectionChanged($value); }

        /*
        * Publish the properties for the component
        */
        function getColor()                     { return $this->readColor(); }
        function setColor($value)               { $this->writeColor($value); }

        function getColumns()                   { return $this->readColumns(); }
        function setColumns($value)             { $this->writeColumns($value); }

        //Comented, as it should not be published on the OI
        /*
        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }
        */

        function getParentColor()               { return $this->readParentColor(); }
        function setParentColor($value)         { $this->writeParentColor($value); }

        function getSelectionType()             { return $this->readSelectionType(); }
        function setSelectionType($value)       { $this->writeSelectionType($value); }

        function getSortAscending()             { return $this->readSortAscending(); }
        function setSortAscending($value)       { $this->writeSortAscending($value); }

        function getSortColumnIndex()           { return $this->readSortColumnIndex(); }
        function setSortColumnIndex($value)     { $this->writeSortColumnIndex($value); }

        function getVisible()                   { return $this->readVisible(); }
        function setVisible($value)             { $this->writeVisible($value); }
}

/**
 * Base class for PageControl component, which is a set of pages used to make a
 * multiple page dialog box.
 *
 * Use PageControl to create a multiple page dialog or tabbed notebook. PageControl
 * displays multiple overlapping pages called Tabs. The user selects a page by clicking
 * the page’s tab that appears at the top of the control. To add a new page to a PageControl
 * object at design time, edit the Pages property.
 */
class CustomPageControl extends QWidget
{
        protected $_tabs = array();
        protected $_tabindex = -1;
        protected $_tabposition = tpTop;

        /**
        * This getter is overriden to sync the layers with the tabs
        *
        * @see Control::getLayer()
        * @return string
        *
        */
        function getActiveLayer()
        {
            $result="";

            if (($this->_tabindex>=0) && ($this->_tabindex<=count($this->_tabs)))
            {
                $result=$this->_tabs[$this->_tabindex];
            }
            else
            {
                if (count($this->_tabs)>=1)
                {
                    $result=$this->_tabs[0];
                }
            }
            return($result);
        }

        function setActiveLayer($value)
        {
            $key = array_search($value, $this->_tabs);
            if ($key===false)
            {
            }
            else
            {
                $this->_tabindex=$key;
            }
        }

         /**
         * This is an internal method you don't need to call directly
         *
         * It dumps the common javascript code to update the control if used
         * inside an Ajax call
         *
         * @see dumpForAjax()
         *
         */
        function commonScript()
        {
                //TODO: Check here to update child widgets
                $position=boolToStr($this->_tabposition==tpTop);
//                echo "  if (!$this->Name) { var div=findObj('$this->Name'); var $this->Name=div.firstChild.firstChild.qx_Widget; }\n";
//                echo "  $this->Name.setLeft(0);\n";
//                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight($this->Height);\n";
                echo "  $this->Name.setPlaceBarOnTop($position);\n";
        }

        /**
        * This is an internal method you don't need to call directly
        *
        * This method is called by the Ajax engine to get the code to update the
        * component after an ajax call
        *
        * @see commonScript()
        */
        function dumpForAjax()
        {
                $this->commonScript();
        }

        function init()
        {
                parent::init();

                $state_field=$this->Name.'_state';

                $state = $this->input->{$state_field};

                if (is_object($state))
                {
                        $tab=$state->asInteger();
                        if ($tab!='')
                        {
                                $this->TabIndex=$tab-1;
                        }
                }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                echo "  var $this->Name = new qx.ui.pageview.tabview.TabView;\n";
                $this->commonScript();

                if ($this->_tabs != null)
                {

                        //$tabs = split("[\n]", $this->_tabs);
                        $i = 0;
                        $tablist = "";
                        $pagelist = "";
                        $pageblock = "";
                        $selectedtab= "tab" . $this->Name . "_1";
                        $pages=array();
                        $names=array();

                        reset($this->_tabs);
                        while (list(, $name) = each($this->_tabs))
                        {
                                if ($name == "") continue;

                                $i++;
                                $tabname = "tab" . $this->Name . "_" . $i;
                                $pagename = "page" . $this->Name . "_" . $i;

                                $avalue=str_replace('"','\"',$name);
                                echo "  var $tabname = new qx.ui.pageview.tabview.Button(\"$avalue\");\n";

                                if ((($this->ControlState & csDesigning)!=csDesigning))
                                {
                                  echo " $tabname.addEventListener('click', function(e) { var state=findObj('".$this->Name."_state'); state.value=$i; ";
                                  if ($this->jsOnChange != null) echo "  $this->jsOnChange(e); ";
                                  echo "  });\n";
                                }

                                $pageblock .= "  var $pagename = new qx.ui.pageview.tabview.Page($tabname);\n";
                                $pages[]=$pagename;
                                $names[]=$name;

                                if ($tablist != "") { $tablist .= ","; };
                                $tablist .= $tabname;

                                if ($pagelist != "") { $pagelist .= ","; };
                                $pagelist .= $pagename;

                                if (($i - 1) == $this->_tabindex) { $selectedtab = $tabname; };
                        }
                        if ($i >= 1)
                        {
                                echo "  $selectedtab.setChecked(true);\n";
                                echo "  $this->Name.getBar().add($tablist);\n";
                                echo $pageblock;

                                echo "  $this->Name.getPane().add($pagelist);\n";

                                reset($pages);
                                while(list($key, $val)=each($pages))
                                {
                                    $this->dumpChildrenControls(-31,-11,$val, $names[$key]);
                                }

                        }
                }

                if (($this->Visible) || (($this->ControlState & csDesigning)==csDesigning))
                      { $visible="true"; }
                else  { $visible="false"; };

                echo "  $this->Name.setVisibility($visible);\n";

                $this->dumpCommonQWidgetJSEvents($this->Name, -1);
                $this->dumpCommonContentsBottom();
        }


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->ControlStyle="csAcceptsControls=1";

                $this->Width=300;
                $this->Height=400;
        }

        /**
         * Contains the list of text strings that label the tabs of the tab control.
         * This property is an array in which every item is the caption for each tab.
         * Use it to add/delete/modify tabs, and to put controls on an specific tab
         * the Layer property of the control must match the caption of the tab you want
         * to put the control into.
         *
         * <code>
         * <?php
         *     function PageControl1BeforeShow($sender, $params)
         *     {
         *              $tabs=array();
         *
         *              $tabs[]='Tab 1';
         *              $tabs[]='Tab 2';
         *              $tabs[]='Tab 3';
         *
         *              $this->PageControl1->Tabs=$tabs;
         *
         *              $b1=new Button($this);
         *              $b1->Parent=$this->PageControl1;
         *              $b1->Layer="Tab 1";
         *              $b1->Left=100;
         *              $b1->Top=100;
         *
         *              $b2=new Button($this);
         *              $b2->Parent=$this->PageControl1;
         *              $b2->Layer="Tab 2";
         *              $b2->Left=50;
         *              $b2->Top=50;
         *     }
         * ?>
         * </code>
         *
         * @see getActiveLayer(), readTabIndex()
         *
         * @return string
         */
        protected function readTabs()                   { return $this->_tabs; }
        protected function writeTabs($value)            { $this->_tabs=$value; }
        function defaultTabs()   { return null; }

        /**
         * Identifies the selected tab on a tab control, use it to set the active
         * tab you want to set the PageControl, the index must be the in sync with
         * the Tabs property
         *
         * @see getActiveLayer(), readTabs()
         *
         * @return integer
         */
        protected function readTabIndex()               { return $this->_tabindex; }
        protected function writeTabIndex($value)        { $this->_tabindex=$value; }
        function defaultTabIndex()   { return -1;               }

        /**
         * Determines whether tabs appear at the top or bottom, you can set the tabs
         * at the top of the control or at the bottom
         *
         * Valid values for this property are:
         *
         * tpTop - Tabs are placed at the top of the control
         *
         * tpBottom - Tabs are placed at the bottom of the control
         *
         * @see readTabs()
         *
         * @return enum
         */
        protected function readTabPosition()            { return $this->_tabposition; }
        protected function writeTabPosition($value)     { $this->_tabposition=$value; }
        function defaultTabPosition()   { return tpTop;               }
}

/**
 * A set of pages used to make a multiple page dialog box.
 *
 * Use PageControl to create a multiple page dialog or tabbed notebook. PageControl
 * displays multiple overlapping pages called Tabs. The user selects a page by clicking
 * the page’s tab that appears at the top of the control. To add a new page to a PageControl
 * object at design time, edit the Pages property.
 *
 * @example PageControl/pagecontrolsample.php How to use PageControl
 * @example PageControl/pagecontrolsample.xml.php How to use PageControl (form)
 */
class PageControl extends CustomPageControl
{
        //Publish Standard Properties
        function getEnabled()                   { return $this->readEnabled(); }
        function setEnabled($value)             { $this->writeEnabled($value); }

        function getPopupMenu()                 { return $this->readPopupMenu(); }
        function setPopupMenu($value)           { $this->writePopupMenu($value); }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        // Common events
        function getjsOnActivate()              { return $this->readjsOnActivate(); }
        function setjsOnActivate($value)        { $this->writejsOnActivate($value); }

        function getjsOnDeActivate()            { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value)      { $this->writejsOnDeActivate($value); }

        function getjsOnBlur()                  { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)            { $this->writejsOnBlur($value); }

        function getjsOnChange()                { return $this->readjsOnChange(); }
        function setjsOnChange($value)          { $this->writejsOnChange($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        function getjsOnContextMenu()           { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value)     { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()              { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value)        { $this->writejsOnDblClick($value); }

        function getjsOnFocus()                 { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)           { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()               { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value)         { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()              { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value)        { $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()                 { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)           { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()             { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value)       { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()               { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value)         { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()             { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value)       { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()              { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value)        { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()             { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value)       { $this->writejsOnMouseOver($value); }

        //Publish Properties
        function getTabs()                      { return $this->readTabs(); }
        function setTabs($value)                { $this->writeTabs($value); }

        function getTabIndex()                  { return $this->readTabIndex(); }
        function setTabIndex($value)            { $this->writeTabIndex($value); }

        function getTabPosition()               { return $this->readTabPosition(); }
        function setTabPosition($value)         { $this->writeTabPosition($value); }
}

/**
 * TreeNode describes an individual node in a tree view control.
 *
 * Each node in a tree view control consists of a label and an optional image.
 * Each item can be the parent of a list of subitems. By clicking an item, the
 * user can expand or collapse the associated list of subitems.
 *
 * @see TreeView
 */
class TreeNode extends Persistent
{
        protected $_caption="";
        protected $_expanded=0;
        protected $_imageindex=-1;
        protected $_itemid=0;
        protected $_items=array();
        protected $_level=0;
        protected $_selectedindex=-1;
        protected $_tag=0;
        protected $_parentnode=null;


        function __construct()
        {
                //Calls inherited constructor
                parent::__construct();

                // get a unique ID for each tree node
                $this->_itemid = uniqid();
        }


        /**
        * Add a child node to the current TreeNode object.
        *
        * @param string $caption The caption of the new node.
        * @param integer $tag The tag for custom identification of the node.
        * @param integer $imageindex If a image list is assigend to the TreeView
        *                            this index is used to set an individual icon for the TreeNode.
        * @param integer $selectedindex Index of selected icon.
        * @return TreeNode Returns the newly created TreeNode object.
        */
        function addChild($caption, $tag = 0, $imageindex = -1, $selectedindex = -1)
        {
                $tn = new TreeNode();
                $tn->ParentNode = $this;
                $tn->Level = $this->_level + 1;

                $tn->Caption = $caption;
                $tn->Tag = $tag;
                $tn->ImageIndex = $imageindex;
                $tn->SelectedIndex = $selectedindex;

                $this->_items[] = $tn;

                return $tn;
        }

        /**
        * This function is used to find a TreeNode object with the ItemID property.
        *
        * Since ItemID is the only unique identifier of the TreeNode this function
        * is one to safly find a tree node.
        * The node where the function is called is compared and all child nodes.
        *
        * @see getItemID()
        *
        * @param string $itemid ItemID to search for.
        * @return mixed Returns the TreeNode object if found, otherwise null.
        */
        function findNodeWithItemID($itemid)
        {
                if ($this->_itemid == $itemid)
                {
                        return $this;
                }
                else if (count($this->_items) > 0)
                {
                        foreach($this->_items as $item)
                        {
                                $res = $item->findNodeWithItemID($itemid);
                                if ($res != null)
                                {
                                        return $res;
                                }
                        }
                }
                else
                {
                        return null;
                }
        }

        /**
        * Caption to be shown on the node.
        *
        * Use Caption to specify the string that is displayed in the tree view.
        * The value of Caption can be assigned directly at run-time or can be set
        * within the TreeView Items Editor while modifying the Items property of the TreeView
        * component.
        *
        * @return string
        */
        function getCaption() { return $this->_caption; }
        function setCaption($value) { $this->_caption=$value; }

        /**
        * Specifies whether the tree node is expanded.
        *
        * When a tree node is expanded, the minus button is shown and child nodes are displayed.
        * Set Expanded to true to display the children of a node. Set Expanded to false to collapse the
        * node, hiding all of its descendants.
        *
        * @return bool
        */
        function getExpanded() { return $this->_expanded; }
        function setExpanded($value) { $this->_expanded=$value; }

        /**
        * Specifies which image is displayed when a node is in its normal state and is not currently selected.
        *
        * Use the ImageIndex property with the Images property of the tree view to specify the image for the node in its normal state.
        *
        * @return integer
        */
        function getImageIndex() { return $this->_imageindex; }
        function setImageIndex($value) { $this->_imageindex=$value; }

        /**
        * Contains a string that uniquely identifies each node in a tree view.
        *
        * It is used to search nodes in findNodeWithItemID().
        *
        * @see findNodeWithItemID()
        *
        * @return string
        */
        function getItemID() { return $this->_itemid; }
        function setItemID($value) { $this->_itemid=$value; }

        /**
        * Items is an array of child TreeNode objects.
        *
        * Use Items to access childs nodes based on its position. The first child node
        * has an index of 0, the second an index of 1, and so on.
        *
        * @return array
        */
        function getItems() { return $this->_items; }
        function setItems($value)
        {
                if (is_array($value))
                {
                        $this->_items = $value;
                }
                else
                {
                        $this->_items = (empty($value)) ? array() : array($value);
                }
        }

        /**
        * Level of the TreeNode. This property is for information purpose only.
        *
        * Nothing happens by setting a different level. The setter is used
        * so the property is serialized/unserialized.
        *
        * @return integer
        */
        function getLevel() { return $this->_level; }
        function setLevel($value) { $this->_level=$value; }

        /**
        * Specifies the index in the tree view’s image list of the image displayed for the node when it is selected.
        *
        * Use the SelectedIndex property to specify an image to display when the tree node is selected.
        *
        * @return integer
        */
        function getSelectedIndex() { return $this->_selectedindex; }
        function setSelectedIndex($value) { $this->_selectedindex=$value; }

        /**
        * Tag to to identify the TreeNode differently than with the ItemID.
        *
        * The Tag property should be a simple type (string, integer, etc) since
        * it is used as a variable in javascript.
        *
        * @return mixed
        */
        function getTag() { return $this->_tag; }
        function setTag($value) { $this->_tag=$value; }

        /**
        * Reference to parent TreeNode object.
        *
        * A Parent node is one level higher than the node and contains the node as a subnode.
        *
        * @return object Returns a TreeNode object or null if root.
        */
        function getParentNode() { return $this->_parentnode; }
        function setParentNode($value) { $this->_parentnode=$value; }
}

/**
 * Base class for TreeView component
 *
 * A tree control is used to arrange items in a tree like data structure.
 * The control persists the expanded tree nodes. The same is true for the
 * selected tree node.
 * Currently multi-selection of tree nodes is not possible.
 *
 * Note: Customized icons for the tree nodes are only visible at run time.
 *
 * @see TreeNode
 */
class CustomTreeView extends QWidget
{
        protected $_onchangeselected=null;

        protected $_jsonchangeselected=null;
        protected $_jsontreeclose=null;
        protected $_jsontreeopenwhileempty=null;
        protected $_jsontreeopenwithcontent=null;

        protected $_items=array();
        protected $_images = null;
        protected $_selecteditemid = -1;
        protected $_showlines = 1;
        protected $_showroot = 0;

        private $_itemcountatlevel = array();



        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csSlowRedraw=1";
                $this->Width=300;
                $this->Height=321;
        }

        /**
        * The function convertPureArrayToTreeNodes() is used to convert a tree
        * that just exists of nested arrays into a tree with TreeNodes objects.
        * It is used to convert the array written by the tree node editor (or items editor)
        * of the object inspector of Delphi for PHP. It may also be used to convert
        * older code into TreeNodes. Just call this function after the tree is
        * assembled in the array.
        *
        * Note: This function calls itself recursivly to convert all child nodes too.
        *
        * @param array $itemsarray The array of items to convert.Has to be in the
        *                          same format as the serialized array of the object inspector.
        * @param object $parentnode Defines the parent TreeNode object to which the tree nodes
        *                           (or itmes) are assigend to.
        * @return array Returns an array of TreeNode objects that were converted.
        */
        function convertPureArrayToTreeNodes($itemsarray, $parentnode = null)
        {
                $ret = array();
                if (is_array($itemsarray))
                {
                        foreach($itemsarray as $k => $v)
                        {
                                // check if the value is an array that may contain tree node values
                                if (is_array($v))
                                {
                                        $tn = new TreeNode();
                                        $tn->ParentNode = $parentnode;

                                        $tn->Level = ($parentnode == null) ? 0 : $parentnode->Level + 1;

                                        if (array_key_exists('Caption', $v))
                                                $tn->Caption = $v['Caption'];
                                        if (array_key_exists('ImageIndex', $v))
                                                $tn->ImageIndex = $v['ImageIndex'];
                                        if (array_key_exists('SelectedIndex', $v))
                                                $tn->SelectedIndex = $v['SelectedIndex'];
                                        if (array_key_exists('Tag', $v))
                                                $tn->Tag = $v['Tag'];
                                        if (array_key_exists('Items', $v))
                                                $tn->Items = $this->convertPureArrayToTreeNodes($v['Items'], $tn);

                                        $ret[] = $tn;
                                }
                                // check if it is already a TreeNode object
                                else if (is_object($v) && $v->classNameIs("TreeNode"))
                                {
                                        $v->Items = $this->convertPureArrayToTreeNodes($v->Items, $tn);
                                        $ret[] = $v;
                                }
                        }
                }
                return $ret;
        }

        function unserialize()
        {
                parent::unserialize();

                // if not in design mode convert the array-treenodes into object-treenodes
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $this->_items = $this->convertPureArrayToTreeNodes($this->_items);
                }

                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".";
                        // restore the selected item id
                        if (isset($_SESSION[$prefix."SelectedItemID"]))
                        {
                                $this->_selecteditemid = $_SESSION[$prefix."SelectedItemID"];
                        }
                }
        }

        function serialize()
        {
                parent::serialize();

                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".";
                        // let's save the SelectedItemID to the session
                        // (it's only a public property and not automatially stored in the session)
                        $_SESSION[$prefix."SelectedItemID"] = $this->_selecteditemid;
                }
        }

        function loaded()
        {
                parent::loaded();
                $this->setImageList($this->_images);
        }

        function init()
        {
                parent::init();

                // get the expanded nodes; it's a comma separated list of ItemIDs
                $submittedExpandedNodes = $this->input->{"{$this->Name}ExpandedNodes"};
                if (is_object($submittedExpandedNodes))
                {
                        // convert the string to an array
                        $arr = explode(',', $submittedExpandedNodes->asString());
                        //
                        $this->updateExpandedNodes($this->_items, $arr);
                }

                // get the selected item id
                $submittedselItemID = $this->input->{"{$this->Name}SelItemID"};
                if (is_object($submittedselItemID) && $submittedselItemID->asString() != "")
                {
                        $this->_selecteditemid = $submittedselItemID->asString();

                        // fire the OnChangeSelected event if assigned and the component is enabled
                        if ($this->_onchangeselected != null && $this->_enabled == 1)
                        {
                                // find the select tree node
                                $tn = $this->findNodeWithItemID($this->_selecteditemid);
                                $this->callEvent('onchangeselected', array("treenode" => $tn,
                                                                           "itemid"   => $this->_selecteditemid));
                        }
                }
        }

        /**
        * Dumps the first row for the items
        *
        * @param array $item Item to dump
        * @param integer $level Level of that item
        */
        protected function dumpRow($item, $level)
        {
                $caption = "";
                if (array_key_exists('Caption', $item))
                {
                        $caption = $item['Caption'];
                }
                else if (is_object($item) && $item->methodExists("getCaption"))
                {
                        $caption = $item->Caption;
                }

                $imageindex = -1;
                if (array_key_exists('ImageIndex', $item))
                {
                        $imageindex = $item['ImageIndex'];
                }
                else if (is_object($item) && $item->methodExists("getImageIndex"))
                {
                        $imageindex = $item->ImageIndex;
                }
                $selectedindex = -1;
                if (array_key_exists('SelectedIndex', $item))
                {
                        $selectedindex = $item['SelectedIndex'];
                }
                else if (is_object($item) && $item->methodExists("getSelectedIndex"))
                {
                        $selectedindex = $item->SelectedIndex;
                }

                $images = "";
                if (($this->_images != null) && (is_object($this->_images)))
                {
                        if ($imageindex != -1)
                        {
                                $image = $this->_images->readImageByID($imageindex, 1);
                                $images .= ", $image";
                        }
                        if ($selectedindex != -1 && $imageindex != $selectedindex)
                        {
                                $image = $this->_images->readImageByID($selectedindex, 1);
                                $images .= ", $image";
                        }
                }

                $avalue=str_replace('"','\"',$caption);
                echo "  trs = qx.ui.treefullcontrol.TreeRowStructure.getInstance().standard(\"$avalue\"" . $images . ");\n";
        }

        /**
        * Dumps a tree node and its sub-nodes.
        *
        * @param array $item Item to dump
        * @param string $parentname Name of the parent to use
        * @param integer $level Level to use to dump the item
        */
        protected function dumpItem($item, $parentname, $level)
        {
                if (!isset($this->_itemcountatlevel[$level]))
                {
                        $this->_itemcountatlevel[$level] = 1;
                }
                else
                {
                        $this->_itemcountatlevel[$level]++;
                }

                $c='p_'.$level.'_'.$this->_itemcountatlevel[$level];

                $this->dumpRow($item, $level);


                // get the (Sub)Items of the current item
                $items = array();
                if (array_key_exists('Items', $item))
                {
                        $items = $item['Items'];
                }
                else if (is_object($item) && $item->methodExists("getItems"))
                {
                        $items = $item->Items;
                }

                if (count($items) == 0)
                {
                        echo "  var $c = new qx.ui.treefullcontrol.TreeFile(trs);\n";
                }
                else
                {
                        echo "  var $c = new qx.ui.treefullcontrol.TreeFolder(trs);\n";
                }

                // get the Tag of the current item
                $tag = -1;
                $itemid = -1;
                if (array_key_exists('Tag', $item))
                {
                        $tag=$item['Tag'];
                }
                else if (is_object($item) && $item->methodExists("getTag"))
                {
                        $tag = $item->Tag;
                        // item id only exists in the tree node
                        $itemid = $item->ItemID;
                }

                __QLibrary_SetCursor($c, $this->Cursor);

                if (is_object($item) && $item->methodExists("getExpanded") && $item->Expanded == 1 && count($items) > 0)
                {
                        echo "  $c.setOpen(true);\n";
                }

                echo "  $c.itemid = '$itemid';\n";
                echo "  $c.tag = $tag;\n";
                echo "  $c.setEnabled(".(($this->_enabled) ? 'true' : 'false').");\n";
                echo "  $parentname.add($c);\n\n";

                if ($this->SelectedItemID == $itemid)
                {
                        echo "  $this->Name.setSelectedElement($c); \n\n";
                }

                if (count($items) > 0)
                {
                        $i = 0;
                        while (list($k, $child)=each($items))
                        {
                                $this->dumpItem($child, $c, ($level + 1));
                        }
                }
        }

    protected $_rootnodecaption="Items";

    /**
    * Specifies the text to be used for the root node
    *
    * All trees have a root node, from which all child nodes are created, by default,
    * the caption for this node is "Items". Use this property to change that value.
    *
    * @return string
    */
    function getRootNodeCaption() { return $this->_rootnodecaption; }
    function setRootNodeCaption($value) { $this->_rootnodecaption=$value; }
    function defaultRootNodeCaption() { return "Items"; }



        function dumpContents()
        {
                echo "<input type=\"hidden\" name=\"{$this->Name}SelItemID\" id=\"{$this->Name}SelItemID\" value=\"{$this->_selecteditemid}\" />\n";
                echo "<input type=\"hidden\" name=\"{$this->Name}ExpandedNodes\" id=\"{$this->Name}ExpandedNodes\" value=\"\" />\n";

                $this->dumpCommonContentsTop();

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        // redirect the form's OnSubmit JS event; save it first so the original
                        // event is not lost
                        echo "  var {$this->Name}_formonsubmit = document.forms[0].onsubmit;\n";
                        echo "  document.forms[0].onsubmit = {$this->Name}UpdateExpandedTreeNodes;\n";
                }

                $avalue=str_replace('"','\"',$this->RootNodeCaption);
                echo "  var trsroot = qx.ui.treefullcontrol.TreeRowStructure.getInstance().standard(\"$avalue\");\n";
                echo "  var $this->Name = new qx.ui.treefullcontrol.Tree(trsroot);\n\n";


                if ((is_array($this->_items)) && (count($this->_items) != 0))
                {
                        $this->_itemcountatlevel = array();
                        echo "  var trs = null;\n";
                        reset($this->_items);
                        while (list($k, $item)=each($this->_items))
                        {
                                // Level is 1 since the real root node is the tree
                                $this->dumpItem($item, $this->Name, 1);
                        }
                }

                echo "  $this->Name.setUseDoubleClick(true);\n";
                if ($this->_showlines == 1) echo "  $this->Name.setUseTreeLines(true);\n";
                else echo "  $this->Name.setUseTreeLines(false);\n";
                if ($this->_showroot == 0)
                {
                        echo "  $this->Name.setHideNode(true);\n";
                }
                echo "  $this->Name.setBorder(qx.renderer.border.BorderPresets.getInstance().inset);\n";
                echo "  $this->Name.setBackgroundColor(\"white\");\n";
                echo "  $this->Name.setEnabled(".(($this->_enabled) ? 'true' : 'false').");\n";
//                echo "  $this->Name.setLeft(0);\n";
//                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setOpen(1);\n";
                echo "  $this->Name.setOverflow(\"scroll\");\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight(" . ($this->Height-1) . ");\n\n";

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        // add the event listener if needed
                        if ($this->_jsontreeclose!=null && $this->_enabled)
                        {
                                echo "  $this->Name.addEventListener(\"treeClose\", $this->_jsontreeclose);\n";
                        }

                        if ($this->_jsontreeopenwhileempty!=null && $this->_enabled)
                        {
                                echo "  $this->Name.addEventListener(\"treeOpenWhileEmpty\", $this->_jsontreeopenwhileempty);\n";
                        }

                        if ($this->_jsontreeopenwithcontent!=null && $this->_enabled)
                        {
                                echo "  $this->Name.addEventListener(\"treeOpenWithContent\", $this->_jsontreeopenwithcontent);\n";
                        }

                        if ($this->_jsonchangeselected!=null && $this->_enabled)
                        {
                                echo "  $this->Name.getManager().addEventListener(\"changeSelection\", $this->_jsonchangeselected);\n";
                        }

                        // we have to decouple this event from the form.submit()
                        // since the tree (open tree nodes, etc) is updated
                        // AFTER this event occured. If the form would be submitted in the
                        // changeSelection event the tree would not be in the correct state.
                        $submit = ($this->_onchangeselected!=null && $this->_enabled) ? "    window.setTimeout('formSubmit()', 100); \n" : "";

                        // add event listener to update the selected item id
                        $hiddenfield = "document.forms[0].{$this->Name}SelItemID";
                        echo "  $this->Name.getManager().addEventListener(\"changeSelection\", function(e) { \n"
                            ."    $hiddenfield.value = e.getData()[0].itemid; \n"
                            ."$submit"
                            ."  }); \n";
                }

                $this->callEvent('onshow', array());

                $this->dumpCommonQWidgetProperties($this->Name, 0);
                $this->dumpCommonQWidgetJSEvents($this->Name, 1);
                $this->dumpCommonContentsBottom();
        }

        function dumpJsEvents()
        {
                parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonchangeselected);
        }

        function dumpJavascript()
        {
                parent::dumpJavascript();

                // call the updateExpandedTreeNodes within this javascript function
                echo "function {$this->Name}UpdateExpandedTreeNodes() { \n"
                    ."  updateExpandedTreeNodes($this->Name, document.forms[0].{$this->Name}ExpandedNodes); \n"
                    // call the original OnSubmit event if it exists
                    ."  if(typeof({$this->Name}_formonsubmit) == 'function') \n"
                    ."    {$this->Name}_formonsubmit(); \n"
                    ."  return true; \n"
                    ."} \n\n";

                // only write this function once; it can be used be other TreeViews
                if (!defined('updateExpandedTreeNodes'))
                {
                        define('updateExpandedTreeNodes', 1);

                        echo "function updateExpandedTreeNodes(tree, hiddenfield) { \n"
                            ."  var res = new Array(); \n"
                            ."  var items = tree.getItems(); \n"
                            ."  var item; \n"
                            ."  var opencount = 0; \n"
                            ."  for (var i=0; i<items.length; i++) { \n"
                            ."    item = items[i]; \n"
                            ."    if (typeof(item.getOpen) == 'function' && item.getOpen()) { \n"
                            ."      res[opencount] = item.itemid; \n"
                            ."      opencount++; \n"
                            ."    } \n"
                            ."  } \n"
                            ."  hiddenfield.value = res.toString(); \n"
                            ."} \n\n";
                }

                if (!defined('formSubmit'))
                {
                        define('formSubmit', 1);
                        echo "function formSubmit() { \n"
                           ."  var res = true; \n"
                           ."  if (typeof(document.forms[0].onsubmit) == 'function') \n"
                           ."    res = document.forms[0].onsubmit(); \n"
                           ."  if (res) \n"
                           ."    document.forms[0].submit(); \n"
                           ."} \n\n";
                }
        }

        /**
        * Add a TreeNode to the Items array of the TreeView.
        *
        * The returned TreeNode will have Level = 1 and ParentNode = null. The Level
        * is 1 since the true root node is static and cannot be configured yet but may in
        * the future.
        *
        * <code>
        * <?php
        *       function btnAddNodeClick($sender, $params)
        *       {
        *                $this->TreeView1->addNodeToItems($this->edtNodeName->Text, 0, 1, 1);
        *       }
        * ?>
        * </code>
        * @param string $caption The caption of the new node.
        * @param integer $tag The tag for custom identification of the node.
        * @param integer $imageindex If a image list is assigend to the TreeView
        *                            this index is used to set an individual icon for the TreeNode.
        * @param integer $selectedindex Index of selected icon.
        * @return TreeNode Returns the newly created TreeNode object.
        */
        function addNodeToItems($caption, $tag = 0, $imageindex = -1, $selectedindex = -1)
        {
                $tn = new TreeNode();
                $tn->ParentNode = null;
                $tn->Level = 1;

                $tn->Caption = $caption;
                $tn->Tag = $tag;
                $tn->ImageIndex = $imageindex;
                $tn->SelectedIndex = $selectedindex;

                $this->_items[] = $tn;

                return $tn;
        }

        /**
        * This function is used to find a TreeNode object with the ItemID property.
        * Since ItemID is the only unique identifier of the TreeNode this function
        * is one to safly find a tree node.
        * This function iterates through all TreeNodes in the Items array.
        *
        * <code>
        * <?php
        *      function btnAddToSelectedClick($sender, $params)
        *      {
        *               $node = $this->TreeView1->findNodeWithItemID($this->TreeView1->SelectedItemID);
        *               if ($node != null)
        *                      $node->addChild($this->edtNodeName->Text, 0, 1, 1);
        *      }
        * ?>
        * </code>
        * @param string $itemid ItemID to search for.
        * @return mixed Returns the TreeNode object if found, otherwise null.
        */
        function findNodeWithItemID($itemid)
        {
                foreach($this->_items as $item)
                {
                        $res = $item->findNodeWithItemID($itemid);
                        if ($res != null)
                        {
                                return $res;
                        }
                }
                return null;
        }

        /**
        * Updates the Expanded property on all TreeNodes. If the ItemID of a
        * TreeNode is found in $itemidarray Expanded is true, otherwise false.
        * @param array $items An array of TreeNode objects.
        * @param array $itemidarray An array that contains the ItemIDs of all expanded nodes.
        */
        protected function updateExpandedNodes($items, $itemidarray)
        {
                foreach ($items as $item)
                {
                        $item->Expanded = in_array($item->ItemID, $itemidarray);
                        $this->updateExpandedNodes($item->Items, $itemidarray);
                }
        }

        /**
         * Image list used to customize the tree node icons. Be sure the correct
         * ImageIndex or SelectedIndex is used in the TreeNode.
         *
         * @see ImageList
         *
         * @return ImageList
         */
        function readImageList()      { return $this->_images; }
        function writeImageList($value) { $this->_images=$this->fixupProperty($value); }
        function defaultImageList()             { return null; }

        /**
         * Lists the individual nodes that appear in the tree view control.
         * At design time the items in the Items array is build out of pure array
         * rather than TreeNode objects. Once the TreeView is unserialized at run time
         * the array contains TreeNode objects.
         *
         * @return array
         */
        function readItems()          { return $this->_items; }
        function writeItems($value)   { $this->_items=$value; }

        /**
         * Specifies the ItmeID of the selected node.
         * @return string
         */
        function readSelectedItemID()      { return $this->_selecteditemid; }
        function writeSelectedItemID($value) { $this->_selecteditemid=$value; }
        function defaultSelectedItemID()             { return -1; }

        /**
         * Specifies whether to display the lines that link child nodes to their
         * corresponding parent nodes.
         * @return boolean
         */
        function readShowLines()      { return $this->_showlines; }
        function writeShowLines($value) { $this->_showlines=$value; }
        function defaultShowLines()             { return 1; }

        /**
         * Specifies whether the top-level (root) node is displayed. Currently
         * this node can not be modified (it is static).
         * @return boolean
         */
        function readShowRoot()       { return $this->_showroot; }
        function writeShowRoot($value){ $this->_showroot=$value; }
        function defaultShowRoot()              { return 0; }

        /**
         * Occurs when a tree node gets selected.
         * <code>
         * <?php
         *      function TreeView1JSChangeSelected($sender, $params)
         *      {
         *      ?>
         *      //Add your javascript code here
         *      document.getElementById("lblSelectedNode1").innerHTML = "Selected node: " + TreeView1.getSelectedElement().getLabelObject().getHtml();
         *      <?php
         *      }
         * ?>
         * </code>
         * @return mixed
         */
        function readjsOnChangeSelected() { return $this->_jsonchangeselected; }
        function writejsOnChangeSelected($value) { $this->_jsonchangeselected=$value; }

        /**
        * Occurs when a open tree node is closed. Note that the event is called
        * before the node is closed.
        * @return mixed
        */
        function readjsOnTreeClose() { return $this->_jsontreeclose; }
        function writejsOnTreeClose($value) { $this->_jsontreeclose=$value; }
        function defaultjsOnTreeClose() { return null; }

        /**
        * Occurs when a closed tree node that has no children is opened.
        *
        * Note that the event is called before the node is opened. This event
        * is useful for you to provide the children dynamically, for example,
        * using Ajax to query for the node children and populate them in javascript.
        *
        * @return mixed
        */
        function readjsOnTreeOpenWhileEmpty() { return $this->_jsontreeopenwhileempty; }
        function writejsOnTreeOpenWhileEmpty($value) { $this->_jsontreeopenwhileempty=$value; }
        function defaultjsOnTreeOpenWhileEmpty() { return null; }

        /**
        * Occurs when a closed tree node that has children is opened.
        *
        * This event is fired when a node is opened and has children.
        * Note that the event is called before the node is opened.
        *
        * @return mixed
        */
        function readjsOnTreeOpenWithContent() { return $this->_jsontreeopenwithcontent; }
        function writejsOnTreeOpenWithContent($value) { $this->_jsontreeopenwithcontent=$value; }
        function defaultjsOnTreeOpenWithContent() { return null; }

        /**
        * Occurs when a tree node gets selected.
        * Use the $params argument passed to the event handler to get the selected
        * tree node ($params["treenode"]) and the selected ItemID ($params["itemid"]).
        *
        * <code>
        * <?php
        *      function TreeView1ChangeSelected($sender, $params)
        *      {
        *               if (is_object($params["treenode"]))
        *                       $this->lblSelectedNode2->Caption = "Selected: ".$params["treenode"]->Caption;
        *      }
        * ?>
        * </code>
        * @return mixed
        */
        function readOnChangeSelected()         { return $this->_onchangeselected; }
        function writeOnChangeSelected($value)  { $this->_onchangeselected=$value; }
        function defaultOnChangeSelected()      { return null; }
}

/**
 * A tree control is used to arrange items in a tree like data structure.
 *
 * The control persists the expanded tree nodes. The same is true for the
 * selected tree node.
 * Currently multi-selection of tree nodes is not possible.
 *
 * Note: Customized icons for the tree nodes are only visible at run time.
 *
 * @example TreeView/treeview.php Working with TreeView
 * @example TreeView/treeview.xml.php Working with TreeView (form)
 */
class TreeView extends CustomTreeView
{
        //Publish common properties

        function getEnabled()                   { return $this->readEnabled(); }
        function setEnabled($value)             { $this->writeEnabled($value); }

        function getPopupMenu()                 { return $this->readPopupMenu(); }
        function setPopupMenu($value)           { $this->writePopupMenu($value); }

        function getVisible()                   { return $this->readVisible(); }
        function setVisible($value)             { $this->writeVisible($value); }

        // Common events
        function getjsOnActivate()              { return $this->readjsOnActivate(); }
        function setjsOnActivate($value)        { $this->writejsOnActivate($value); }

        function getjsOnDeActivate()            { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value)      { $this->writejsOnDeActivate($value); }

        function getjsOnBlur()                  { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)            { $this->writejsOnBlur($value); }

        function getjsOnChange()                { return $this->readjsOnChange(); }
        function setjsOnChange($value)          { $this->writejsOnChange($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        function getjsOnContextMenu()           { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value)     { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()              { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value)        { $this->writejsOnDblClick($value); }

        function getjsOnFocus()                 { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)           { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()               { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value)         { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()              { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value)        { $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()                 { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)           { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()             { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value)       { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()               { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value)         { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()             { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value)       { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()              { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value)        { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()             { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value)       { $this->writejsOnMouseOver($value); }

        //Publish properties
        function getImageList()                 { return $this->readImageList(); }
        function setImageList($value)           { $this->writeImageList($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        function getShowLines()                 { return $this->readShowLines(); }
        function setShowLines($value)           { $this->writeShowLines($value); }

        function getShowRoot()                  { return $this->readShowRoot(); }
        function setShowRoot($value)            { $this->writeShowRoot($value); }

        // Publish events
        function getjsOnChangeSelected()        { return $this->readjsOnChangeSelected(); }
        function setjsOnChangeSelected($value)  { $this->writejsOnChangeSelected($value); }

        function getjsOnTreeClose()             { return $this->readjsOnTreeClose(); }
        function setjsOnTreeClose($value)       { $this->writejsOnTreeClose($value); }

        function getjsOnTreeOpenWhileEmpty()    { return $this->readjsOnTreeOpenWhileEmpty(); }
        function setjsOnTreeOpenWhileEmpty($value) { $this->writejsOnTreeOpenWhileEmpty($value); }

        function getjsOnTreeOpenWithContent()   { return $this->readjsOnTreeOpenWithContent(); }
        function setjsOnTreeOpenWithContent($value) { $this->writejsOnTreeOpenWithContent($value); }

        function getOnChangeSelected()          { return $this->readOnChangeSelected(); }
        function setOnChangeSelected($value)    { $this->writeOnChangeSelected($value); }
}

/**
 * Base class for TextField control
 *
 * A TextField control is very much an Edit control, but it differs in that this one
 * is inherited from QWidget, adding more run-time capabilities, as it's created using
 * javascript.
 *
 * For simple HTML forms, use Edit, as it has less overhead, but when you require
 * a more ajaxian form, use this one.
 *
 */
class CustomTextField extends QWidget
{
        protected $_borderstyle = bsSingle;
        protected $_charcase = ecNormal;
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_ispassword = 0;
        protected $_maxlength = 0;
        protected $_readonly = 0;
        protected $_text = "";

        protected $_onclick = null;

        /**
        * Modify the text depending on the CharCase property
        */
        protected function AdjustText()
        {
                if ($this->_charcase == ecUpperCase)
                { $this->_text = strtoupper($this->_text); }
                else
                if ($this->_charcase == ecUpperCase)
                { $this->_text = strtolower($this->_text); }
        }

        /**
        * Nothing here. See LabeledEdit for more info
        */
        protected function dumpExtraControlCode()
        {
                // Nothing here. See LabeledEdit for more info
        }

        /**
        * Returns an array with the control dimensions
        * @return array Array with control bounding rect
        */
        protected function CalculateEditorRect()
        {
                return array(0, 0, $this->Width, $this->Height);
        }

        protected $_filterinput=1;

        /**
        * Determines if the control is going to filter input information sent
        * by the user
        *
        * Web applications take user input in the form of strings and then dump
        * that information out, that can lead to security problems like cross-site
        * scripting if you don't filter such information.
        *
        * This property, if true, will filter out unwanted values, set it to false
        * to prevent this behavior.
        *
        * @return boolean
        */
        function getFilterInput() { return $this->_filterinput; }
        function setFilterInput($value) { $this->_filterinput=$value; }
        function defaultFilterInput() { return 1; }

        function preinit()
        {
                $val=$this->Name."_value";


                $this->input->disable=!$this->_filterinput;
                //If there is something posted
                $submitted = $this->input->$val;
                if (is_object($submitted))
                {
                        //Get the value and set the text field
                        $this->_text = html_entity_decode($submitted->asString(), ENT_QUOTES);

                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_text);
                }
        }

        function loaded()
        {
                parent::loaded();
                $this->writeDataSource($this->_datasource);
        }

        function init()
        {
                parent::init();

                //TODO: Read this from the common POST object
                if (!$this->owner->UseAjax)
                {
                        if ((isset($_POST[$this->Name."_state"])) && ($_POST[$this->Name."_state"]!=''))
                        {
                                $this->callEvent('onclick',array('tag'=>$_POST[$this->Name."_state"]));
                        }
                }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                $str=str_replace('"','&quot;',$this->_text);

                echo "</script><input type=\"hidden\" id=\"$this->Name"."_value\" name=\"$this->Name"."_value\" value=\"$str\" /><script type=\"text/javascript\">\n";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if (($this->_datasource != null) && ($this->_datafield != ""))
                        {
                                if ($this->_datasource->DataSet != null)
                                {
                                        $ds = $this->_datasource->DataSet;
                                        $df = $this->_datafield;
                                        $this->_text = $ds->$df;
                                }
                        }
                }

                if ($this->_borderstyle == bsNone)
                { $border = "none"; }
                else
                { $border = "solid"; }

                $charcase = "";
                if ($this->_charcase == ecLowerCase)
                { $charcase = "lowercase"; }
                else
                if ($this->_charcase == ecUpperCase)
                { $charcase = "uppercase"; }
                if ($this->ReadOnly) { $readonly="true"; }
                else                 { $readonly="false"; }

                // call the OnShow event if assigned so the Text property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                $this->dumpExtraControlCode();

                list($left, $top, $width, $height) = $this->CalculateEditorRect();

                if ($this->_ispassword)
                { echo "  var $this->Name = new qx.ui.form.PasswordField();\n"; }
                else
                { echo "  var $this->Name = new qx.ui.form.TextField();\n"; }

                $avalue=str_replace('"','\"',$this->Text);
                echo "  $this->Name.setLeft($left);\n"
                   . "  $this->Name.setTop($top);\n"
                   . "  $this->Name.setWidth($width);\n"
                   . "  $this->Name.setHeight($height);\n"
                   . "  $this->Name.setMaxLength($this->MaxLength);\n"
                   . "  $this->Name.setValue(\"$avalue\");\n"
                   . "  $this->Name.setReadOnly($readonly);\n"
                   . "  $this->Name.setBorder(new qx.renderer.border.Border(1, '$border'));\n";
                if ($this->Color != "")
                { echo "  $this->Name.setBackgroundColor(new qx.renderer.color.Color('$this->Color'));\n"; }

                if ($charcase != "")
                { echo "  $this->Name.setStyleProperty('textTransform', '$charcase');\n";  }

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                    echo "  $this->Name.addEventListener('keyup', function(e) { var hidvalue=findObj(\"$this->Name"."_value\"); hidvalue.value=$this->Name.getComputedValue(e); });\n";
                }

                $this->dumpCommonQWidgetProperties($this->Name);
                $this->dumpCommonQWidgetJSEvents($this->Name, 1);
                $this->dumpCommonContentsBottom();
        }

        function dumpJsEvents()
        {
                parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonchange);
        }

        /**
        * Determines whether the edit control has a single line border
        * around the client area.
        *
        * Valid values for this property are:
        *
        * bsSingle - The control has a border
        *
        * bsNone - The control has no border
        *
        *
        * @return enum
        */
        protected function readBorderStyle()        { return $this->_borderstyle; }
        protected function writeBorderStyle($value) { $this->_borderstyle=$value; }
        function defaultBorderStyle()     { return bsSingle; }
        /**
        * Determines the case of the text within the edit control.
        *
        * Valid values for this property are:
        *
        * ecNormal - No charcase conversion
        *
        * ecLowerCase - Input is converted to lowercase
        *
        * ecUpperCase - Input is converted to upper case
        *
        * Note: When CharCase is set to ecLowerCase or ecUpperCase,
        *       the case of characters is converted as the user types them
        *       into the edit control. Changing the CharCase property to
        *       ecLowerCase or ecUpperCase changes the actual contents
        *       of the text, not just the appearance. Any case information
        *       is lost and can’t be recaptured by changing CharCase to ecNormal.
        *
        * @return enum
        */
        protected function readCharCase()           { return $this->_charcase; }
        protected function writeCharCase($value)    { $this->_charcase=$value; $this->AdjustText(); }
        function defaultCharCase()        { return ecNormal; }

        /**
        * DataField is the fieldname to be attached to the control.
        *
        * This property allows you to show/edit information from a table column
        * using this control. To make it work, you must also assign the Datasource
        * property, which specifies the dataset that contain the fieldname to work on
        *
        * @return string
        */
        protected function readDataField()          { return $this->_datafield; }
        protected function writeDataField($value)   { $this->_datafield = $value; }
        function defaultDataField()       { return ""; }

        /**
        * DataSource property allows you to link this control to a dataset containing
        * rows of data.
        *
        * To make it work, you must also assign DataField property with
        * the name of the column you want to use
        *
        * @return Datasource
        */
        protected function readDataSource()         { return $this->_datasource; }
        protected function writeDataSource($value)  { $this->_datasource = $this->fixupProperty($value); }
        function defaultDataSource()      { return null; }

        /**
        * If IsPassword is true then all characters are displayed with a password
        * character defined by the browser.
        * Note: The text is still in readable text in the HTML page!
        *
        * @return boolean
        */
        protected function readIsPassword()         { return $this->_ispassword; }
        protected function writeIsPassword($value)  { $this->_ispassword = $value; }
        function defaultIsPassword()      { return 0; }
        /**
        * Specifies the maximum number of characters the user can enter into
        * the edit control. A value of 0 indicates that there is no
        * application-defined limit on the length. You can use it to constraint
        * the length of information to get from the user.
        *
        * @return integer
        */
        protected function readMaxLength()          { return $this->_maxlength; }
        protected function writeMaxLength($value)   { $this->_maxlength=$value; }
        function defaultMaxLength()       { return 0; }
        /**
        * Set the control to read-only mode. That way the user cannot enter
        * or change the text of the edit control. Use it to show information into
        * the control and to prevent the user to modify the contents.
        *
        * @return boolean
        */
        protected function readReadOnly()           { return $this->_readonly; }
        protected function writeReadOnly($value)    { $this->_readonly=$value; }
        function defaultReadOnly()        { return 0; }
        /**
        * Text info associated with control, this property specifies the initial
        * text the control is going to show, after that, the user can modify the
        * contents, unless ReadOnly is true
        *
        * @return string
        */
        protected function readText()               { return $this->_text; }
        protected function writeText($value)        { $this->_text = $value; }
        function defaultText()            { return ""; }

        /**
        * Occurs when the user clicks the control.
        *
        * Use the OnClick event handler to respond when the user clicks the control.
        *
        * Usually OnClick occurs when the user presses and releases the left mouse button
        * with the mouse pointer over the control. This event can also occur when:
        *
        * The user selects an item in a grid, outline, list, or combo box by pressing an arrow key.
        *
        * The user presses Spacebar while a button or check box has focus.
        *
        * The user presses Enter when the active form has a default button (specified by the Default property).
        *
        * The user presses Esc when the active form has a cancel button (specified by the Cancel property).
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        protected function readOnClick()            { return $this->_onclick; }
        protected function writeOnClick($value)     { $this->_onclick = $value; }
        function defaultOnClick()                   { return null; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=120;
                $this->Height=21;
        }
}

/**
 * An Edit control with a more powerful javascript interface.
 *
 * A TextField control is very much an Edit control, but it differs in that this one
 * is inherited from QWidget, adding more run-time capabilities, as it's created using
 * javascript.
 *
 * For simple HTML forms, use Edit, as it has less overhead, but when you require
 * a more ajaxian form, use this one.
 *
 */
class TextField extends CustomTextField
{

        //Publish common properties

        function getFont()              { return $this->readFont(); }
        function setFont($value)        { $this->writeFont($value); }

        function getColor()             { return $this->readColor(); }
        function setColor($value)       { $this->writeColor($value); }

        function getEnabled()           { return $this->readEnabled(); }
        function setEnabled($value)     { $this->writeEnabled($value); }

        function getParentColor()       { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentFont()        { return $this->readParentFont(); }
        function setParentFont($value)  { $this->writeParentFont($value); }

        function getParentShowHint()    { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getPopupMenu()         { return $this->readPopupMenu(); }
        function setPopupMenu($value)   { $this->writePopupMenu($value); }

        function getShowHint()          { return $this->readShowHint(); }
        function setShowHint($value)    { $this->writeShowHint($value); }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        // Common events
        function getjsOnActivate()      { return $this->readjsOnActivate(); }
        function setjsOnActivate($value){ $this->writejsOnActivate($value); }

        function getjsOnDeActivate()    { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value) { $this->writejsOnDeActivate($value); }

        function getjsOnBlur()          { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)    { $this->writejsOnBlur($value); }

        function getjsOnChange()        { return $this->readjsOnChange(); }
        function setjsOnChange($value)  { $this->writejsOnChange($value); }

        function getjsOnClick()         { return $this->readjsOnClick(); }
        function setjsOnClick($value)   { $this->writejsOnClick($value); }

        function getjsOnContextMenu()   { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value) { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()      { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value){ $this->writejsOnDblClick($value); }

        function getjsOnFocus()         { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)   { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()       { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()      { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value){ $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()         { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)   { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()      { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value){ $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()       { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()     { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()      { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value) { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()     { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value) { $this->writejsOnMouseOver($value); }

        //Publish new properties
        function getBorderStyle()       { return $this->readBorderStyle();  }
        function setBorderStyle($value) { $this->writeBorderStyle($value);  }

        function getCharCase()          { return $this->readCharCase(); }
        function setCharCase($value)    { $this->writeCharCase($value); }

        function getDataField()         { return $this->readDataField(); }
        function setDataField($value)   { $this->writeDataField($value); }

        function getDataSource()        { return $this->readDataSource(); }
        function setDataSource($value)  { $this->writeDataSource($value); }

        function getIsPassword()        { return $this->readIsPassword(); }
        function setIsPassword($value)  { $this->writeIsPassword($value); }

        function getMaxLength()         { return $this->readMaxLength(); }
        function setMaxLength($value)   { $this->writeMaxLength($value); }

        function getReadOnly()          { return $this->readReadOnly(); }
        function setReadOnly($value)    { $this->writeReadOnly($value); }

        function getText()              { return $this->readText(); }
        function setText($value)        { $this->writeText($value); }

        // publish events
        //function getOnClick()           { return $this->readOnClick(); }
        //function setOnClick($value)     { $this->writeOnClick($value); }
}

/**
 * MonthCalendar is stand-alone calendar in which a user can select a date.
 *
 * Use MonthCalendar to allow a user to specify a date or range of dates using a
 * standard calendar user interface.
 */
class MonthCalendar extends FocusControl
{
        public $_calendar=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                date_default_timezone_set($this->TimeZone);

                use_unit('jscalendar/calendar.php');

                $this->_calendar = new DHTML_Calendar(VCL_HTTP_PATH."/jscalendar/", "en", 'calendar-win2k-2', false);

                $this->Width=200;
                $this->Height=200;
        }

        private $_timezone="UTC";

        /**
        * The timezone to be used when generating the time for the control, the
        * default value is UTC, to know which values you can use, visit this link:
        * @link http://www.php.net/manual/en/timezones.php
        */
        function getTimeZone() { return $this->_timezone; }
        function setTimeZone($value) { $this->_timezone=$value; }
        function defaultTimeZone() { return "UTC"; }

        protected $_showsTime=true;

        /**
        * Determines if the calendar also shows the time part of a date
        *
        * Use this property to enable/disable the ability for the monthcalendar
        * to set times for an specific date.
        *
        * @return boolean
        */
        function getShowsTime() { return $this->_showsTime; }
        function setShowsTime($value) { $this->_showsTime=$value; }
        function defaultShowsTime() { return true; }

    protected $_firstday=1;

    /**
    * Sets which is the first day of the week in the calendar
    *
    * Use this property to change the first day of the week for the calendar,
    * where 0 is Sunday, 1 is Monday, 2 is Tuesday, etc
    *
    * @return integer
    */
    function getFirstDay() { return $this->_firstday; }
    function setFirstDay($value) { $this->_firstday=$value; }
    function defaultFirstDay() { return 1; }

    protected $_date="";

    /**
    * Specifies the date the component is going to show or the date the user selected.
    *
    * Use this property to set a date for the MonthCalendar to show or to retrieve the
    * date the user selected. The format is the format specified in DateFormat
    * property.
    *
    * @return string
    */
    function getDate() { return $this->_date; }
    function setDate($value) { $this->_date=$value; }
    function defaultDate() { return ""; }

        function preinit()
        {
                parent::preinit();

                $submitteddate= $this->input->{"{$this->Name}_date"};
                if (is_object($submitteddate))
                {
                        $this->_date=$submitteddate->asstring();
                }
        }

        function dumpJsEvents()
        {
                parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonupdate);

                if (!defined($this->Name.'_update'))
                {
                  define($this->Name.'_update',1);
?>
                  function <?php echo $this->Name; ?>_update(event)
                  {
                      findObj('<?php echo $this->Name; ?>_date').value=event.date.print(event.params.ifFormat);
<?php
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                  if ($this->_jsonupdate!=null) echo "$this->_jsonupdate(event);\n";
                }
?>
                  }
<?php
                }
        }

        protected $_dateformat='%m-%d-%Y %I:%M';

        /**
        * Specifies the format for the date
        *
        * Use this property to specify the datetime format to use when using
        * this control.
        *
        * @return string
        */
        function getDateFormat() { return $this->_dateformat; }
        function setDateFormat($value) { $this->_dateformat=$value; }
        function defaultDateFormat() { return '%m-%d-%Y %I:%M'; }

        function dumpHeaderCode()
        {
                $this->_calendar->load_files();
        }

        protected $_jsonupdate=null;

        /**
        * This event is fired after the date is changed on the calendar.
        *
        * Use this javascript event to get notified on a change of the selected
        * date by the user.
        *
        * @return mixed
        */
        function getjsOnUpdate() { return $this->_jsonupdate; }
        function setjsOnUpdate($value) { $this->_jsonupdate=$value; }
        function defaultjsOnUpdate() { return null; }

        function dumpContents()
        {

              echo "<input type=\"hidden\" name=\"{$this->Name}_date\" id=\"{$this->Name}_date\" value=\"$this->_date\" />\n";

              $date=$this->Date;
              if ($date=='')
              {
                $date=date('m/d/Y H:i:s');
              }

              $onupdate="null";

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                  //if ($this->_jsonupdate!=null) $onupdate=$this->_jsonupdate;
                  $onupdate=$this->Name.'_update';
                }

                echo "<div id=\"".$this->Name."_container\">\n";
                echo $this->_calendar->_make_calendar(
                array(
                'flat'=>$this->Name."_container",
                'firstDay'       => $this->_firstday, // show Monday first
                'showsTime'      => $this->_showsTime,
                 'width'      => $this->Width,
                 'height'      => $this->Height,
                 'date' => $date,
                 'onUpdate'=>$onupdate,
                 'showOthers'     => true,
                 'ifFormat'       => $this->_dateformat,
                 'daFormat'       => $this->_dateformat,
                 'timeFormat'     => '12'
                ), $this->Name) . "\n";
                echo "</div>\n";
                echo "<script type=\"text/javascript\">\n";
                echo "  $this->Name.table.width='".($this->Width-3)."px';\n";
                echo "  $this->Name.table.height='".($this->Height-3)."px';\n";
                echo "</script>";
        }

}

/**
 * DateTimePicker displays a combobox for entering dates or times.
 *
 * DateTimePicker is a visual component designed specifically for entering dates
 * or times.
 *
 * It features a popup calendar when you click on the arrow button that allows the
 * user to select a date and time which will be inserted on the edit part of the control.
 */
class DateTimePicker extends FocusControl
{
        public $_calendar=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                date_default_timezone_set($this->TimeZone);

                use_unit('jscalendar/calendar.php');

                $this->_text="";//If format property changes, this is bad: strftime($this->_ifFormat, strtotime('now'));
                $this->_calendar = new DHTML_Calendar(VCL_HTTP_PATH."/jscalendar/", "en", 'calendar-win2k-2', false);

                $this->Width=200;
                $this->Height=17;
        }

        private $_timezone="UTC";

        /**
        * The timezone to be used when generating the time for the control, the
        * default value is UTC, to know which values you can use, visit this link:
        * @link http://www.php.net/manual/en/timezones.php
        *
        * Note: When dropping this component on the designer, the value for the
        * control it will be set to the date/time at that time, so this property
        * won't have effect
        */
        function getTimeZone() { return $this->_timezone; }
        function setTimeZone($value) { $this->_timezone=$value; }
        function defaultTimeZone() { return "UTC"; }

        function dumpHeaderCode()
        {
            if (!defined('JSCALENDAR'))
            {
                define('JSCALENDAR',1);
                $this->_calendar->load_files();
            }
        }

        function dumpContents()
        {
                $style=$this->Font->FontString;

                //TODO: ColorToString and StringToColor
                if ($this->color!="")
                {
                        $style.="background-color: ".$this->color.";";
                }

                $h=$this->Height-1;
                $w=$this->Width;

                $d=15;
                if ($h!=15) $d=$h;

                $style.="height:".$h."px;width:".($w-$d)."px;";

                date_default_timezone_set($this->TimeZone);

                $this->_calendar->make_input_field
                (
                   // calendar options go here; see the documentation and/or calendar-setup.js
                   array('firstDay'       => 1, // show Monday first
                         'showsTime'      => $this->_showsTime,
                         'showOthers'     => true,
                         'ifFormat'       => $this->_ifFormat,
                         'timeFormat'     => '24'),
                   // field attributes go here
                   array('style'       => $style,
                         'name'        => $this->Name,
                         'value'       => $this->_text),
                   $h
                );
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function preinit()
        {
                //If there is something posted
                $submitted = $this->input->{$this->Name};
                if (is_object($submitted))
                {
                        //Get the value and set the text field
                        $this->_text = $submitted->asString();

                        //If there is any valid DataField attached, update it
                        //$this->updateDataField($this->_text);
                }
        }

        protected $_text="";

        /**
        * Value for the datetime picker
        *
        * Use this property to get/set the value of the datetimepicker
        *
        * @return string
        */
        function getText() { return $this->_text; }
        function setText($value) { $this->_text=$value; }
        function defaultText() { return ""; }

        protected $_showsTime=true;

        /**
        * Determines if the datetimepicker also shows the time part of a date
        *
        * Use this property to enable/disable the ability for the datetimepicker
        * to set times for an specific date.
        *
        * @return boolean
        */
        function getShowsTime() { return $this->_showsTime; }
        function setShowsTime($value) { $this->_showsTime=$value; }
        function defaultShowsTime() { return true; }

        protected $_ifFormat='%Y-%m-%d %I:%M';

        /**
        * Specifies the input format for the date
        *
        * Use this property to specify the datetime format to use when using
        * this control.
        *
        * @return string
        */
        function getIfFormat() { return $this->_ifFormat; }
        function setIfFormat($value) { $this->_ifFormat=$value; }
        function defaultIfFormat() { return '%Y-%m-%d %I:%M'; }

}

/**
 * Base class for ProgressBar control
 *
 * Use ProgressBar to add a progress bar to a form. Progress bars provide users
 * with visual feedback about the progress of a procedure within an application.
 * As the procedure progresses, the rectangular progress bar gradually fills from
 * left to right with the specified color.
 */
class CustomProgressBar extends DWidget
{
        protected $_orientation=pbHorizontal;
        protected $_position=50;
        protected $_min=0;
        protected $_max=100;
        protected $_step=10;

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $left=0;
                        $top=0;
                }
                else
                {
                        $left=$this->Left;
                        $top=$this->Top;

                        if ($this->owner!=null)
                        {
                                $layout=$this->owner->Layout;

                                if ($layout->Type==ABS_XY_LAYOUT)
                                {
                                        $left=0;
                                        $top=0;
                                }

                        }
                }

                if ($this->_orientation == pbHorizontal) { $orient="horz"; }
                else                                   { $orient="vert"; };

                echo "<script type=\"text/javascript\">\n"
                   . "  var " . $this->Name . "=new ProgressBar('$orient',$left,$top,$this->Width,$this->Height,$this->Position);\n"
                   . "  " . $this->Name . ".setRange($this->Min,$this->Max);\n"
                   . "  " . $this->Name . ".setValue(" . $this->Position . ");\n"
                   . "  dynapi.document.addChild(" . $this->Name . ");\n"
                   . "</script>\n";
                /*
                echo "        ".$this->Name.".onscroll=function(e){\n";
                echo "                status=".$this->Name.".getValue()\n";
                echo "        }\n";
                echo "\n";
                */
        }

        /**
         * Specifies whether the progress bar is oriented vertically or horizontally.
         * When changing this property, the dimensions (width, height) are exchanged.
         *
         * Valid values for this property are:
         *
         * pbHorizontal - The control is placed in horizontal position
         *
         * pbVertical - The control is placed in vertical position
         *
         * @return enum
         */
        protected function readOrientation()    { return $this->_orientation; }
        protected function writeOrientation($value)
        {
                if ($value != $this->_orientation)
                {
                        $w=$this->Width;
                        $h=$this->Height;

                        if (($value==pbHorizontal) && ($w<$h))
                        {
                                $this->Height=$w;
                                $this->Width=$h;
                        }
                        else
                        if (($value==pbVertical) && ($w>$h))
                        {
                                $this->Height=$w;
                                $this->Width=$h;
                        }
                        $this->_orientation=$value;
                }
        }
        function defaultOrientation() { return pbHorizontal; }
        /**
         * Specifies the current position of the progress bar.
         *
         * You can read Position to determine how far the process tracked by the
         * progress bar has advanced from Min toward Max. Set Position to cause
         * the progress bar to display a position between Min and Max. For example,
         * when the process tracked by the progress bar completes, set Position to
         * Max so that it appears completely filled.
         * When a progress bar is created, Min and Max represent percentages,
         * where Min is 0 (0% complete) and Max is 100 (100% complete). If these
         * values are not changed, Position is the percentage of the process that
         * has already been completed.
         *
         * @return integer
         */
        protected function readPosition()       { return $this->_position; }
        protected function writePosition($value) { $this->_position=$value; }
        /**
         * Specifies the lower limit of the range of possible positions.
         *
         * Use Max along with the Min property to establish the range of possible
         * positions a progress bar. When the process tracked by the progress bar
         * begins, the value of Position should equal Min.
         *
         * @return integer
         */
        protected function readMin()            { return $this->_min; }
        protected function writeMin($value)     { $this->_min=$value; }
        function defaultMin()         { return 0; }
        /**
         * Specifies the upper limit of the range of possible positions.
         *
         * Use Max along with the Min property to establish the range of possible
         * positions a progress bar. When the process tracked by the progress bar
         * is complete, the value of Position should equal Max.
         *
         * @return integer
         */
        protected function readMax()            { return $this->_max; }
        protected function writeMax($value)     { $this->_max=$value; }
        function defaultMax()         { return 100; }

        /**
         * Specifies the amount that Position increases when the StepIt method is called.
         *
         * This property specifies how much the StepIt method increases the position
         * property.
         *
         * This property is an integer, the default value is 10.
         *
         * @return integer
         */
        protected function readStep()           { return $this->_step; }
        protected function writeStep($value)    { $this->_step=$value; }
        function defaultStep()        { return 10; }

        /**
         * Advances the Position of the progress bar by a specified amount, position
         * cannot be set to a higher value than the Max property.
         *
         * @param integer $value   Increase the value of Position by the given value.
         */
        function StepBy($value)
        {
                $p = $this->Position;
                $p += $value;
                if ($p > $this->Max)    { $p = $this->Max; };
                $this->Position = $p;
        }

        /**
         * Advances Position by the amount specified in the Step property, it uses
         * the StepBy method to move the Position property
         *
         * @see Step
         */
        function StepIt()               { $this->StepBy($this->Step); }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->ControlStyle="csSlowRedraw=1";
                $this->writeDWidgetClassName("ProgressBar");
                $this->Width=200;
                $this->Height=17;
        }
}

/**
 * Use ProgressBar to add a progress bar to a form.
 *
 * Progress bars provide users
 * with visual feedback about the progress of a procedure within an application.
 * As the procedure progresses, the rectangular progress bar gradually fills from
 * left to right with the specified color.
 * @example ProgressBar/uProgressBar.php How ProgressBar work
 * @example ProgressBar/uProgressBar.xml.php How ProgressBar work (form)
 */
class ProgressBar extends CustomProgressBar
{
        // publish new properties
        function getOrientation()       { return $this->readOrientation(); }
        function setOrientation($value) { $this->writeOrientation($value); }

        function getPosition()          { return $this->readPosition(); }
        function setPosition($value)    { $this->writePosition($value); }

        function getMin()               { return $this->readMin(); }
        function setMin($value)         { $this->writeMin($value); }

        function getMax()               { return $this->readMax(); }
        function setMax($value)         { $this->writeMax($value); }

        function getStep()              { return $this->readStep(); }
        function setStep($value)        { $this->writeStep($value); }
}

define('moHorizontal',0);
define('moVertical',1);

/**
 * MainMenu with graphic capabilities
 *
 * This component is not in use, it's still in the VCL to check for it's compatibility
 * and add it in the future.
 *
 */
/*
class GraphicMainMenu extends Control
{
        protected $_menuobject;
        protected $_menuitems=array();
        private $_itemcount=0;
        private $_menuwidth=60;
        private $_menuheight=49;
        private $_submenuoffset=0;
        private $_backcolor="#F0F0F0";
        private $_selectedbackcolor="#C1D2EE";
        private $_borderwidth="1px";
        private $_borderstyle="solid";
        private $_bordercolor="#CCCCCC";

        private $_orientation=moHorizontal;

        function getOrientation() { return $this->_orientation; }
        function setOrientation($value) { $this->_orientation=$value; }
        function defaultOrientation() { return moHorizontal; }

        function readParentFont()
        {
                return(0);
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csSlowRedraw=1";
        }

        function dumpHeaderCode()
        {
                if (!defined('DYNAPI'))
                {
                        echo "<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/dynapi/src/dynapi.js\"></script>\n";
                        define('DYNAPI', 1);
                }

                if (!defined('DYNAPI_'.strtoupper($this->className())))
                {
                        echo "<script type=\"text/javascript\">\n";
                        if (!defined('DYNAPI'))
                        {
                                echo "dynapi.library.setPath('".VCL_HTTP_PATH."/dynapi/src/');\n";
                                echo "dynapi.library.include('dynapi.api');\n";
                                define('DYNAPI',1);
                        }
                        echo "dynapi.library.include('HTMLMenu');\n";
                        echo "dynapi.library.include('Image');\n";
                        echo "</script>\n";

                        define('DYNAPI_'.strtoupper($this->className()),1);
                }
        }

        function dumpItem($item,$parent)
        {
                $caption="'".$item['Caption']."'";
                $itemc="item".$this->_itemcount;
                $this->_itemcount++;

                $w='null';
                if (array_key_exists('Width',$item)) $w=$item['Width'];

                $css='null';
                if (array_key_exists('CSS',$item)) $css="'".$item['CSS']."'";

                $backcol='null';
                if (array_key_exists('BackColor',$item)) $backcol="'".$item['BackColor']."'";

                $backimage='null';
                if (array_key_exists('BackImage',$item)) $backimage=$item['BackImage'];

                $overimage='null';
                if (array_key_exists('OverImage',$item)) $overimage=$item['OverImage'];

                $selectedimage='null';
                if (array_key_exists('SelectedImage',$item)) $selectedimage=$item['SelectedImage'];

                $img="";

                if ($backimage!='null')
                {
                        $modifiers='null';
                        if ($overimage!='null')
                        {
                                $modifiers="{oversrc:'$overimage'}";
                        }

                        $img="var i1 = dynapi.functions.getImage('$backimage', $w, $this->_menuheight, $modifiers);";
                        $caption="{image:i1,text:$caption}";
                }

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                if ($selectedimage!='null')
                {
                        $cond='null';
                        if (array_key_exists('SelectedCondition',$item)) $cond=$item['SelectedCondition'];
                        if ($cond!='null')
                        {
                                $code="if ($cond) return(1); else return(0);";
                                $ret=eval($code);
                                if ($ret)
                                {
                                        $modifiers='null';
                                        $img="var i1 = dynapi.functions.getImage('$selectedimage', $w, $this->_menuheight, $modifiers);";
                                        $caption="{image:i1,text:'".$item['Caption']."'}";
                                }
                        }
                }
                }

                echo $img;

                $link='null';
                if (array_key_exists('Link',$item)) $link="'document.location=\'".$item['Link']."\';'";

                echo "$parent.addItem($css,$caption,'$itemc',$link,$w,null,$backcol);\n";

                if (array_key_exists('Items',$item))
                {
                        $subitems=$item['Items'];

                        $w='60';

                        if (array_key_exists('SubMenuWidth',$item)) $w=$item['SubMenuWidth'];

                        reset($subitems);
                        echo $itemc."mbar = ".$this->Name.".createMenuBar('$itemc',$w);\n";
                        while (list($k,$v)=each($subitems))
                        {
                        $this->dumpItem($v,$itemc."mbar");
                        }
                }
        }

        function dumpContents()
        {
                $style=$this->Font->FontString;

                $cr='default';
                if ($this->_cursor!="")
                {
                        $cr=strtolower(substr($this->_cursor,2));
                }

                echo "<script type=\"text/javascript\">\n";
                echo "\n";
                echo "// Write Style to browser\n";
//                echo "HTMLComponent.writeStyle({\n";
//                echo "        MNUItm:                 'cursor: default;border: ".$this->_borderwidth." ".$this->_borderstyle." ".$this->_bordercolor.";',\n";
//                echo "        MNUItmText:     'cursor: $cr; $style'\n";
//                echo "});\n";
                echo "\n";
                echo "var  p ={align:\"top\"}\n";
                echo "\n";

                $orientation="horz";
                if ($this->_orientation==moVertical) $orientation="vert";

                echo "var ".$this->Name." = dynapi.document.addChild(new HTMLMenu('','$orientation'),'".$this->Name."');\n";
                echo $this->Name.".backCol = \"".$this->_backcolor."\"\n";
                echo $this->Name.".selBgCol = '".$this->_selectedbackcolor."';\n";
                echo $this->Name.".cssMenu = 'MNU';\n";
                echo $this->Name.".cssMenuText = 'MNUItmText';\n";
                echo $this->Name.".cssMenuItem = 'MNUItm';\n";
                echo "\n";
                echo "var ".$this->Name."mbar;\n";


                $this->_itemcount=0;
                $items=$this->_menuitems;

                if ((!is_array($items))  || (empty($items)))
                {
                        $items=array();
                        $items[]=array
                        (
                                'Caption'=>'MainMenu'
                         );
                }
                echo $this->Name."mbar = ".$this->Name.".createMenuBar('".$this->Name."main',".$this->_menuwidth.",".$this->_menuheight.",".$this->_submenuoffset.",0);\n";
                reset($items);

                while (list($k,$v)=each($items))
                {
                        $item=$v;
                        $this->dumpItem($item,$this->Name."mbar");
                }


                echo "</script>\n";
                echo "<script type=\"text/javascript\">\n";
                echo "dynapi.document.insertChild(".$this->Name.");\n";
                echo "</script>\n";
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getMenuItems() { return $this->_menuitems; }
        function setMenuItems($value) { $this->_menuitems=$value; }

        function getMenuWidth() { return $this->_menuwidth; }
        function setMenuWidth($value) { $this->_menuwidth=$value; }

        function getMenuHeight() { return $this->_menuheight; }
        function setMenuHeight($value) { $this->_menuheight=$value; }

        function getSubmenuOffset() { return $this->_submenuoffset; }
        function setSubmenuOffset($value) { $this->_submenuoffset=$value; }

        function getBackColor() { return $this->_backcolor; }
        function setBackColor($value) { $this->_backcolor=$value; }

        function getBorderColor() { return $this->_bordercolor; }
        function setBorderColor($value) { $this->_bordercolor=$value; }

        function getBorderStyle() { return $this->_borderstyle; }
        function setBorderStyle($value) { $this->_borderstyle=$value; }


        function getBorderWidth() { return $this->_borderwidth; }
        function setBorderWidth($value) { $this->_borderwidth=$value; }

        function getSelectedBackColor() { return $this->_selectedbackcolor; }
        function setSelectedBackColor($value) { $this->_selectedbackcolor=$value; }

}
*/

/**
 * Base class for RichEdit controls.
 *
 *
 * This control uses the Xinha as WYSIWYG HTML editor.
 *
 * Note: Be aware that after a webpage with a CustomRichEdit has been submitted
 *       the Lines and Text properties are strings containing any HTML that are
 *       allowed by the Xinha editor.
 *
 * @link http://xinha.python-hosting.com/
 */
class CustomRichEdit extends CustomMemo
{
        /**
        * This time is used for to work around a problem in the Xinha editor. The
        * editor JS object is not yet initialized while the page is loading.
        * The time must be set each time CustomRichEdit gets shown (not persistent),
        * so the place to change its value would be OnBeforeShow();.
        *
        * A current problem in Xinha is that it does not save the contents of the editor
        * back to the textarea when a form.submit(); has been called via JS. By
        * adding a JS mouseout event to the editor we can fix that.
        *
        * Default value $loadjstime is set to 3000 milliseconds.
        */
        public $loadjstime = 5000;

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
				$this->ControlStyle="csVerySlowRedraw=1";

                $this->Width = 400;
                $this->Height = 270;

                $this->_richeditor = 1;
        }

        /**
        * Dumps the code to attach an event to the richedit
        * @param string $event Javascript function to be attached
        * @param string $eventname Name of the event to attach
        */
        protected function readRichEditJSEvent($event, $eventname)
        {
                $result = "";
                if ($event != null)
                {
                        $result  = "        HTMLArea._addEvent(html_editor._htmlArea, \"$eventname\", $event);\n";
                        $result .= "        HTMLArea._addEvent(html_editor._doc, \"$eventname\", $event);\n";
                }
                return $result;
        }

    protected $_toolbars=array();

    /**
    * Set the toolbar configuration for this control
    *
    * This property is of type array of strings, where each line is a toolbar
    * and you can specify which buttons show on the toolbar, separated with , (comma)
    *
    * This is the complete set of buttons:
    *
    * popupeditor
    * separator,formatblock,fontname,fontsize,bold,italic,underline,strikethrough
    * separator,forecolor,hilitecolor,textindicator
    * separator,subscript,superscript
    * linebreak,separator,justifyleft,justifycenter,justifyright,justifyfull
    * separator,insertorderedlist,insertunorderedlist,outdent,indent
    * separator,inserthorizontalrule,createlink,insertimage,inserttable
    * linebreak,separator,undo,redo,selectall,print,cut,copy,paste,overwrite,saveas
    * separator,killword,clearfonts,removeformat,toggleborders,splitblock,lefttoright,righttoleft
    * separator,htmlmode,showhelp,about
    *
    * @return array
    */
    function readToolbars() { return $this->_toolbars; }
    function writeToolbars($value) { $this->_toolbars=$value; }
    function defaultToolbars() { return array(); }
        /**
        * Code to attach all the richedit javascript events
        * @return string
        */
        protected function readRichEditJSEvents()
        {
                $result  = "";
                $result .= $this->readRichEditJSEvent($this->readjsOnBlur(),      "blur");
                $result .= $this->readRichEditJSEvent($this->readjsOnChange(),    "change");
                $result .= $this->readRichEditJSEvent($this->readjsOnClick(),     "click");
                $result .= $this->readRichEditJSEvent($this->readjsOnDblClick(),  "dblclick");
                $result .= $this->readRichEditJSEvent($this->readjsOnFocus(),     "focus");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseDown(), "mousedown");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseUp(),   "mouseup");

                $result .= $this->readRichEditJSEvent($this->readjsOnMouseOver(), "mouseover");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseMove(), "mousemove");
                $result .= $this->readRichEditJSEvent($this->readjsOnMouseOut(),  "mouseout");
                $result .= $this->readRichEditJSEvent($this->readjsOnKeyPress(),  "keypress");
                $result .= $this->readRichEditJSEvent($this->readjsOnKeyDown(),   "keydown");
                $result .= $this->readRichEditJSEvent($this->readjsOnKeyUp(),     "keyup");
                $result .= $this->readRichEditJSEvent($this->readjsOnSelect(),    "select");

                return $result;
        }



        /**
        * This is an internal method you don't need to call directly
        *
        * This method is called by the Ajax engine to get the code to update the
        * component after an ajax call
        *
        * @see commonScript()
        */
        function dumpForAjax()
        {
            $text=$this->Text;
            $text=str_replace('"','\"',$text);
            $text=str_replace("\r\n",'\n',$text);
            $text=str_replace("\n",'\n',$text);
?>
        var html_editor = <?php echo $this->_name; ?>_html_editor;
        html_editor._textArea.value = "<?php echo $text; ?>";
        html_editor.setHTML("<?php echo $text; ?>");
<?php
        }

        function dumpHeaderCode()
        {
                if ($this->canShow())
                {
                        if ($this->_richeditor)
                        {
                                $pref = strtolower($this->_name);

                                $style = $this->Font->FontString;

                                if ($this->color != "")
                                {
                                        $style .= "background-color: " . $this->color . ";";
                                }

                                if (!defined('XINHA'))
                                {
                                        //define('XINHA', 1);

?>
  <script type="text/javascript">
  _editor_url  = "<?php echo VCL_HTTP_PATH;      ?>/resources/xinha/";
  _editor_lang = "en";      // And the language we need to use in the editor.
  </script>

  <script type="text/javascript" src="<?php echo VCL_HTTP_PATH; ?>/resources/xinha/htmlarea.js"></script>
<?php
                                }
?>

  <script type="text/javascript">
  var <?php echo $this->_name; ?>_previous_load = null;
  var <?php echo $this->_name; ?>_html_editor = null;
  xinha_init    = null;

  // This contains the names of textareas we will make into Xinha editors
  xinha_init = xinha_init ? xinha_init : function()
  {
        xinha_editors = null;
        xinha_config  = null;
        xinha_plugins = null;

        xinha_plugins = xinha_plugins ? xinha_plugins : [];

        if(!HTMLArea.loadPlugins(xinha_plugins, xinha_init)) return;
        xinha_editors = xinha_editors ? xinha_editors : ['<?php echo $this->_name;     ?>'];
        xinha_config = xinha_config ? xinha_config : new HTMLArea.Config();

        xinha_config.pageStyle = 'body { <?php echo $style;     ?> }';

        xinha_editors   = HTMLArea.makeEditors(xinha_editors, xinha_config, xinha_plugins);
        <?php echo $this->_name; ?>_html_editor = xinha_editors['<?php echo $this->_name; ?>'];

        //      xinha_editors.<?php echo $this->_name;     ?>.config.width  = <?php echo $this->_width;     ?>;
        //      xinha_editors.<?php echo $this->_name;     ?>.config.height = <?php echo $this->_height;     ?>;

        <?php
            if (count($this->_toolbars)>0)
            {
        ?>
        xinha_editors.<?php echo $this->_name;     ?>.config.toolbar=[
        <?php
            reset($this->_toolbars);
            while(list($key, $line)=each($this->_toolbars))
            {
                if ($key>0) echo ",\n";
                $items=split(',',$line);
                reset($items);
                echo '[';
                while(list($k, $toolbutton)=each($items))
                {
                    if ($k>0) echo ',';
                    echo '"'.$toolbutton.'"';
                }
                echo ']';
            }
        ?>
   ];
            <?php
                }
            ?>


        HTMLArea.startEditors(xinha_editors);

        if (<?php echo $this->_name;     ?>_previous_load!=null) <?php echo $this->_name;     ?>_previous_load();
  }
  <?php echo $this->_name;     ?>_previous_load=window.onload;

  window.onload   = xinha_init;

  function updateEditor_<?php echo $this->_name; ?>()
  {
        var html_editor = <?php echo $this->_name; ?>_html_editor;

        <?php
                //TODO: Find a way to disable the xinha control in JS.
                //echo ($this->Enabled) ? "" : "html_editor._doc.body.contentEditable = false;\n";
                echo $this->readRichEditJSEvents();


        // This is a work around so the data in the rich edit gets saved when another control calls form.submit();
        // The function needs to be called by a timer since _textArea is not initialized on load.
        ?>
        HTMLArea._addEvent(html_editor._htmlArea, "mouseout", function () {
          html_editor._textArea.value = html_editor.getHTML();
        });
  }
  </script>
  <script type="text/javascript">
  // allow enough time to load the page; see public variable to change the time
  setTimeout("updateEditor_<?php echo $this->_name; ?>()", <?php echo $this->loadjstime; ?>);
  </script>
<?php
                        }
                }
        }
}


/**
 * Base class for RichEdit controls.
 *
 * A RichEdit control provides the application user the opportunity to edit text
 * with formatting, in this case, HTML text. User can make text bold, italic, insert images
 * etc.
 *
 * This control uses Xinha as WYSIWYG HTML editor.
 *
 * Note: Be aware that after a webpage with a CustomRichEdit has been submitted
 *       the Lines and Text properties are strings containing any HTML that is
 *       allowed by the Xinha editor.
 *
 * @link http://xinha.python-hosting.com/
 *
 */
class RichEdit extends CustomRichEdit
{
        /*
        * Publish the events for the component
        */
        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the component
        */
        function getjsOnBlur                    () { return $this->readjsOnBlur(); }
        function setjsOnBlur                    ($value) { $this->writejsOnBlur($value); }

        function getjsOnChange                  () { return $this->readjsOnChange(); }
        function setjsOnChange                  ($value) { $this->writejsOnChange($value); }

        function getjsOnClick                   () { return $this->readjsOnClick(); }
        function setjsOnClick                   ($value) { $this->writejsOnClick($value); }

        function getjsOnDblClick                () { return $this->readjsOnDblClick(); }
        function setjsOnDblClick                ($value) { $this->writejsOnDblClick($value); }

        function getjsOnFocus                   () { return $this->readjsOnFocus(); }
        function setjsOnFocus                   ($value) { $this->writejsOnFocus($value); }

        function getjsOnMouseDown               () { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown               ($value) { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp                 () { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp                 ($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseOver               () { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver               ($value) { $this->writejsOnMouseOver($value); }

        function getjsOnMouseMove               () { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove               ($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut                () { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut                ($value) { $this->writejsOnMouseOut($value); }

        function getjsOnKeyPress                () { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress                ($value) { $this->writejsOnKeyPress($value); }

        function getjsOnKeyDown                 () { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown                 ($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyUp                   () { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp                   ($value) { $this->writejsOnKeyUp($value); }

        function getjsOnSelect                  () { return $this->readjsOnSelect(); }
        function setjsOnSelect                  ($value) { $this->writejsOnSelect($value); }


        /*
        * Publish the properties for the component
        */
        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getDataField()
        {
                return $this->readDataField();
        }
        function setDataField($value)
        {
                $this->writeDataField($value);
        }

        function getDataSource()
        {
                return $this->readDataSource();
        }
        function setDataSource($value)
        {
                $this->writeDataSource($value);
        }

        /*
        //TODO: Find a way to disable the xinha control in JS.
        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }
        */

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getLines()
        {
                return $this->readLines();
        }
        function setLines($value)
        {
                $this->writeLines($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

        function getToolbars() { return $this->readToolbars(); }
        function setToolbars($value) { $this->writeToolbars($value); }



        function getParentFont()
        {
                return $this->readParentFont();
        }
        function setParentFont($value)
        {
                $this->writeParentFont($value);
        }

        function getParentShowHint()
        {
                return $this->readParentShowHint();
        }
        function setParentShowHint($value)
        {
                $this->writeParentShowHint($value);
        }

        function getPopupMenu()
        {
                return $this->readPopupMenu();
        }
        function setPopupMenu($value)
        {
                $this->writePopupMenu($value);
        }

        function getShowHint()
        {
                return $this->readShowHint();
        }
        function setShowHint($value)
        {
                $this->writeShowHint($value);
        }

        /*
        //TODO: Investigate if tabindex can be set on the xinha control.
        function getTabOrder()
        {
                return $this->readTabOrder();
        }
        function setTabOrder($value)
        {
                $this->writeTabOrder($value);
        }

        function getTabStop()
        {
                return $this->readTabStop();
        }
        function setTabStop($value)
        {
                $this->writeTabStop($value);
        }
        */

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }
}

/**
 * Use TrackBar to put a track bar on a form. A track bar represents a position
 * along a continuum using a slider and, optionally, tick marks.
 *
 * During program execution, the slider can be moved to the desired position by
 * dragging it with the mouse or by clicking the mouse on the bar. To use the
 * keyboard to move the slider, press the arrow keys or the Page Up and Page Down keys.
 *
 * @example TrackBarDemo/uSlider.php Working with TrackBar
 * @example TrackBarDemo/uSlider.xml.php Working with TrackBar (form)
 */
class TrackBar extends Control
{
        protected $_position = 0;
        protected $_maxposition = 10;

        function dumpJsEvents()
        {
                $this->dumpJSEvent($this->jsOnChange);
        }

        function dumpFormItems()
        {
        	echo "<input type=\"hidden\" id=\"{$this->_name}_position\" name=\"{$this->_name}_position\" value=\"$this->_position\" />";
        }

        function dumpHeaderCode()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
					echo "<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/js/common.js\"></script>\n";
                }
                if (!defined('SLIDERBAR'))
                {
                	define('SLIDERBAR', 1);
					echo '<script type="text/javascript" src="'. VCL_HTTP_PATH .'/slider/js/range.js"></script>';
					echo '<script type="text/javascript" src="'. VCL_HTTP_PATH .'/slider/js/timer.js"></script>';
					echo '<script type="text/javascript" src="'. VCL_HTTP_PATH .'/slider/js/slider.js"></script>';

					echo '<link type="text/css" rel="StyleSheet" href="'. VCL_HTTP_PATH .'/slider/css/luna/luna.css" />';
                }
        }

	    protected $_orientation=tbHorizontal;

        /**
         * Specifies whether the track bar is oriented vertically or horizontally.
         * When changing this property, the dimensions (width, height) are exchanged.
         *
         * Valid values for this property are:
         *
         * tbHorizontal - The control is placed in horizontal position
         *
         * tbVertical - The control is placed in vertical position
         *
         * @return enum
         */
        function getOrientation() { return $this->_orientation; }
    	function setOrientation($value)
        {
                if ($value != $this->_orientation)
                {
                        $w=$this->Width;
                        $h=$this->Height;

                        if (($value==tbHorizontal) && ($w<$h))
                        {
                                $this->Height=$w;
                                $this->Width=$h;
                        }
                        else
                        if (($value==tbVertical) && ($w>$h))
                        {
                                $this->Height=$w;
                                $this->Width=$h;
                        }
                        $this->_orientation=$value;
                }
        }
    	function defaultOrientation() { return tbHorizontal; }

        function preinit()
        {
                //If there is something posted
                $submitted = $this->input->{$this->Name."_position"};
                if (is_object($submitted))
                {
                        $this->_position= $submitted->asInteger();
                }
        }

        function dumpContents()
        {
        	echo "<div class=\"slider\" id=\"$this->_name\" tabIndex=\"1\" style=\"width:{$this->Width}px;height:{$this->Height}px;\">\n";
			echo "<input class=\"slider-input\" id=\"{$this->_name}-input\"/>\n";
            echo "</div>\n";

            $orientation="horizontal";
            if ($this->_orientation==tbVertical) $orientation="vertical";
?>
<script type="text/javascript">
var s = new Slider(findObj("<?php echo $this->_name; ?>"), findObj("<?php echo $this->_name; ?>-input"),"<?php echo $orientation; ?>");
s.setMinimum(<?php echo $this->_minposition; ?>);
s.setMaximum(<?php echo  $this->_maxposition; ?>);
s.setValue(<?php echo $this->_position; ?>);

s.onchange = function () {
	var hidden=findObj("<?php echo $this->_name; ?>_position");
    hidden.value=this.getValue();

<?php
	if ($this->_jsonchange!=null) echo $this->_jsonchange."(this);";
?>
};
</script>
<?php
        }

        /**
         * Specifies the maximum Position of a TTrackBar, position property cannot
         * be higher that the value set for this property
         *
         * Use Max to set an upper limit to the value that can be represented using the
         * track bar. A slider indicates the current Position in a range between MinPosition and MaxPosition.
         *
         * @return integer
         */
        function getMaxPosition()        { return $this->_maxposition; }
        function setMaxPosition($value) { $this->_maxposition = $value; }
        function defaultMaxPosition()               { return 10; }

    protected $_minposition=0;

    /**
    * Specifies the minimum position the trackbar can take, position property
    * cannot be less than the value set for this property.
    *
    * Use this property to set a lower limit to the value represented by the track bar.
    * A slider indicates the current Position in a range between MinPosition and MaxPosition.
    * @return integer
    */
    function getMinPosition() { return $this->_minposition; }
    function setMinPosition($value) { $this->_minposition=$value; }
    function defaultMinPosition() { return 0; }



        /**
         * Contains the current position of the slider of a TrackBar, use this
         * property to set the initial position for the control when is rendered.
         *
         * Read Position to determine the current value represented by the track bar.
         * Position is a value in the range between 0 and MaxPosition (inclusive).
         * Set Position to programmatically move the slider of the track bar to a new value.
         *
         * @return integer
         */
        function getPosition()           { return $this->_position; }
        function setPosition($value)    { $this->_position = $value; }
        function defaultPosition()                  { return 0; }

        function getjsOnChange()        { return $this->readjsOnChange(); }
        function setjsOnChange($value)  { $this->writejsOnChange($value); }
}

/**
 * Base class for UpDown control
 *
 * Use UpDown to add an up-down control to a form. Up-down controls consist of a
 * pair of arrow buttons, such as the arrows that appear in a spin box. Up-down
 * controls allow users to change the size of a numerical value by clicking on arrow buttons.
 */
class CustomUpDown extends QWidget
{
        protected $_borderstyle = bsSingle;
        protected $_datasource = null;
        protected $_datafield = "";

        protected $_increment = 1;
        protected $_min=0;
        protected $_max=100;
        protected $_position=0;

        function dumpContents()
        {
                $this->dumpCommonContentsTop($this->_position);

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if (($this->_datasource != null) && ($this->_datafield != ""))
                        {
                                if ($this->_datasource->DataSet != null)
                                {
                                        $ds = $this->_datasource->DataSet;
                                        $df = $this->_datafield;
                                        $this->_position = $ds->$df;
                                }
                        }
                }

                if ($this->_borderstyle == bsNone)
                { $border = "none"; }
                else
                { $border = "solid"; }

                // call the OnShow event if assigned so the Text property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                echo "  var $this->Name = new qx.ui.form.Spinner($this->Min,$this->Position,$this->Max);\n"
//                   . "  $this->Name.setLeft(0);\n"
//                   . "  $this->Name.setTop(0);\n"
                   . "  $this->Name.setWidth($this->Width);\n"
                   . "  $this->Name.setHeight($this->Height);\n"
                   . "  $this->Name.setIncrementAmount($this->Increment);\n"
                   . "  $this->Name.setBorder(new qx.renderer.border.Border(1, '$border'));\n";

                echo "  $this->Name.addEventListener('change', function(e) { hid=findObj(\"".$this->Name."_state\"); hid.value=$this->Name.getValue(); });\n";

                $this->dumpCommonQWidgetProperties($this->Name, 0);
                $this->dumpCommonQWidgetJSEvents($this->Name, 2);

                $this->dumpCommonContentsBottom();
        }

        function loaded()
        {
                parent::loaded();
                $this->writeDataSource($this->_datasource);
        }

        function preinit()
        {
            parent::preinit();


            $state_field=$this->Name.'_state';

            $state = $this->input->{$state_field};

            if (is_object($state))
            {
                $this->_position=$state->asInteger();
            }
        }

        /**
        * Check the position property between min and max
        */
        protected function CheckPosition()
        {
                if ($this->Min > $this->Max)
                { $this->Max = $this->Min; }

                if ($this->Position > $this->Max)
                { $this->Position = $this->Max; }
                else
                if ($this->Position < $this->Min)
                { $this->Position = $this->Min; }
        }

        // Properties
        /**
        * Determines whether the edit control has a single line border
        * around the client area.
        *
        * Valid values for this property are:
        *
        * bsSingle - The control has a border
        *
        * bsNone - The control has no border
        *
        * @return enum
        */
        protected function readBorderStyle()        { return $this->_borderstyle; }
        protected function writeBorderStyle($value) { $this->_borderstyle=$value; }
        function defaultBorderStyle()     { return bsSingle; }

        /**
        * DataField is the fieldname to be attached to the control.
        *
        * This property allows you to show/edit information from a table column
        * using this control. To make it work, you must also assign the Datasource
        * property, which specifies the dataset that contain the fieldname to work on
        *
        * @return string
        */
        protected function readDataField()          { return $this->_datafield; }
        protected function writeDataField($value)   { $this->_datafield = $value; }
        function defaultDataField()       { return ""; }

        /**
        * DataSource property allows you to link this control to a dataset containing
        * rows of data.
        *
        * To make it work, you must also assign DataField property with
        * the name of the column you want to use
        *
        * @return Datasource
        */
        protected function readDataSource()         { return $this->_datasource; }
        protected function writeDataSource($value)  { $this->_datasource = $this->fixupProperty($value); }
        function defaultDataSource()      { return null; }

        /**
         * Specifies the amount the Position value changes each time the up
         * or down button is pressed.
         *
         * @return integer
         */
        protected function readIncrement()          { return $this->_increment; }
        protected function writeIncrement($value)   { $this->_increment=$value; }
        function defaultIncrement()        { return 1; }

        /**
         * Specifies the minimum value of the Position property, so it cannot be
         * less than the value set for this property
         *
         * @return integer
         */
        protected function readMin()                { return $this->_min; }
        protected function writeMin($value)         { $this->_min=$value; $this->CheckPosition(); }
        function defaultMin()             { return 0; }

        /**
         * Specifies the maximum value of the Position property, so it cannot be
         * higher than the value set for this property
         *
         * @return integer
         */
        protected function readMax()                { return $this->_max; }
        protected function writeMax($value)         { $this->_max=$value; $this->CheckPosition(); }
        function defaultMax()             { return 100; }

        /**
         * Specifies the current value represented by the up-down control, use it to set
         * the initial value for the control
         *
         * @return integer
         */
        protected function readPosition()           { return $this->_position; }
        protected function writePosition($value)    { $this->_position=$value; $this->CheckPosition(); }
        function defaultPosition()        { return 0; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=120;
                $this->Height=21;
        }
}

/**
 * Use UpDown to add an up-down control to a form.
 *
 * Up-down controls consist of a pair of arrow buttons, such as the arrows that
 * appear in a spin box. Up-down controls allow users to change the size of a
 * numerical value by clicking on arrow buttons.
 */
class UpDown extends CustomUpDown
{
        // Publish inherited
        //function getFont()              { return $this->readFont(); }
        //function setFont($value)        { $this->writeFont($value); }

        //function getParentFont()        { return $this->readParentFont(); }
        //function setParentFont($value)  { $this->writeParentFont($value); }

        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getParentShowHint()    { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint()          { return $this->readShowHint(); }
        function setShowHint($value)    { $this->writeShowHint($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        // Publish new properties
        function getBorderStyle()       { return $this->readBorderStyle();  }
        function setBorderStyle($value) { $this->writeBorderStyle($value);  }

        function getDataField()         { return $this->readDataField(); }
        function setDataField($value)   { $this->writeDataField($value); }

        function getDataSource()        { return $this->readDataSource(); }
        function setDataSource($value)  { $this->writeDataSource($value); }

        function getIncrement()         { return $this->readIncrement(); }
        function setIncrement($value)   { $this->writeIncrement($value); }

        function getMin()               { return $this->readMin(); }
        function setMin($value)         { $this->writeMin($value); }

        function getMax()               { return $this->readMax(); }
        function setMax($value)         { $this->writeMax($value); }

        function getPosition()          { return $this->readPosition(); }
        function setPosition($value)    { $this->writePosition($value); }

        // Common events
        function getjsOnActivate()      { return $this->readjsOnActivate(); }
        function setjsOnActivate($value){ $this->writejsOnActivate($value); }

        function getjsOnDeActivate()    { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value) { $this->writejsOnDeActivate($value); }

        function getjsOnBlur()          { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)    { $this->writejsOnBlur($value); }

        function getjsOnChange()        { return $this->readjsOnChange(); }
        function setjsOnChange($value)  { $this->writejsOnChange($value); }

        function getjsOnClick()         { return $this->readjsOnClick(); }
        function setjsOnClick($value)   { $this->writejsOnClick($value); }

        function getjsOnContextMenu()   { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value) { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()      { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value){ $this->writejsOnDblClick($value); }

        function getjsOnFocus()         { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)   { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()       { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()      { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value){ $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()         { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)   { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()      { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value){ $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()       { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()     { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()      { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value) { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()     { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value) { $this->writejsOnMouseOver($value); }
}

/**
 * This widget provides a selector to allow the user to choose a color.
 *
 * Drop this component on a form and use the OnChange event to react to changes
 * on the selected color.
 *
 * <code>
 * <?php
 *   function ColorSelector1JSChange($sender, $params)
 *   {
 *     ?>
 *       alert("#"+qx.lang.String.pad(ColorSelector1.getRed().toString(16).toUpperCase(), 2) + qx.lang.String.pad(ColorSelector1.getGreen().toString(16).toUpperCase(), 2) + qx.lang.String.pad(ColorSelector1.getBlue().toString(16).toUpperCase(), 2);
 *     <?php
 *   }
 * ?>
 * </code>
 *
 */
class ColorSelector extends QWidget
{
   //     protected $_jsonchange=null;

        function dumpContents()
        {
                $this->Width=557;
                $this->Height=314;

                $this->dumpCommonContentsTop();

                $value=$this->Color;
                if ($value!='')
                {
                        if ($value[0]=='#') $value=substr($value,1);
                        $r=hexdec(substr($value,0,2));
                        $g=hexdec(substr($value,2,2));
                        $b=hexdec(substr($value,4,2));
                        $value="$r,$g,$b";
                }

//                echo "  d.setBackgroundColor('#EBE9ED');\n";
                echo "  var $this->Name = new qx.ui.component.ColorSelector($value);\n";
//                echo "        $this->Name.setLeft(0);\n";
//                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";
                echo "  $this->Name.setBackgroundColor('#EBE9ED');\n";

                if (($this->Hidden==false) || (($this->ControlState & csDesigning)==csDesigning))
                      { $visible="true"; }
                else  { $visible="false"; };

                echo "  $this->Name.setVisibility($visible);\n";

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        if (($this->_jsonchange!="") && ($this->_jsonchange!=null))
                        {
                                echo "  $this->Name.addEventListener(\"dialogok\", $this->_jsonchange);\n";
                        }
                }

                $this->dumpCommonContentsBottom();
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=557;
                $this->Height=314;
                $this->ControlStyle="csSlowRedraw=1";
        }

        //Publish common properties
        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        /**
         * This event provides an opportunity to read the color the user has set
         * the selector
         *
         * To get the selected color, you can call to the getRed, getGreen and getBlue
         * methods of the ColorSelector component using javascript.
         *
         * The following sample shows you how to get a valid HTML color from the dialog
         *
         * <code>
         * <?php
         *   function ColorSelector1JSChange($sender, $params)
         *   {
         *     ?>
         *       alert("#"+qx.lang.String.pad(ColorSelector1.getRed().toString(16).toUpperCase(), 2) + qx.lang.String.pad(ColorSelector1.getGreen().toString(16).toUpperCase(), 2) + qx.lang.String.pad(ColorSelector1.getBlue().toString(16).toUpperCase(), 2);
         *     <?php
         *   }
         * ?>
         * </code>
         *
         * @return mixed
         *
         */
        function getjsOnChange()                { return $this->readjsOnChange(); }
        function setjsOnChange($value)          { $this->writejsOnChange($value); }
}

/**
 * This is a helper class for the Label used in the LabeledEdit control
 *
 * LabeledEdit is an edit control that has an associated label and this class
 * is the control used for that label
 */

class SubLabel extends Persistent
{
        protected $_caption = "";
        public $_control= null;

        function assignTo($dest)        { $dest->_caption=$this->_caption; }

        /**
         * Specifies the caption used in the label
         *
         * Use this property to determine the Caption for this control. This text
         * will be shown at the side of the edit control that also makes up LabeledEdit.
         *
         * @return string
         */
        function getCaption()           { return $this->_caption; }
        function setCaption($value)    { $this->_caption=$value; }
        function defaultCaption()                  { return ""; }

        function readOwner()
        {
            return($this->_control);
        }
}

/**
* Base class for LabeledEdit component
*
* It provides an Edit component with an attached Label, so it's easier for you to
* create and design forms, as a single component is required.
*
*/
class CustomLabeledEdit extends CustomTextField
{
        protected $_lblname = "";

        protected $_edtlabel=null;
        protected $_lblspacing = 3;
        protected $_lblposition = lpAbove;
        protected $_text = "";

        /**
        * Calculates the rect for the editor component
        * @return array Coordinates for the editor component
        */
        protected function CalculateEditorRect()
        {
                switch ($this->_lblposition)
                {
                        case lpBelow:
                                $y = 0;
                                break;
                        default: // lpAbove:
                                $y = 14 + $this->_lblspacing;
                                break;
                }
                return array(0, $y, $this->Width, $this->Height - 14 - $this->_lblspacing);
        }

        /**
        * Dumps the control for the label part of the component
        */
        protected function dumpExtraControlCode()
        {
                $eh = $this->Height - 14 - $this->_lblspacing;
                switch ($this->_lblposition)
                {
                        case lpBelow:
                                $y = $eh;
                                break;
                        default: // lpAbove:
                                $y = 0;
                                break;
                }

                $this->_lblname = $this->Name . "_Lbl";

                $avalue=str_replace('"','\"',$this->_edtlabel->Caption);
                echo "  var $this->_lblname = new qx.ui.basic.Atom(\"" . $avalue. "\");\n"
//                   . "  $this->_lblname.setLeft(0);\n"
                   . "  $this->_lblname.setTop($y);\n"
                   . "  $this->_lblname.setWidth($this->Width);\n"
                   . "  $this->_lblname.setHorizontalChildrenAlign(\"left\");\n";

                $aname=$this->_lblname;

                $this->PrepareQWJSEvent($aname, $this->jsOnClick, "click");
                $this->PrepareQWJSEvent($aname, $this->jsOnDblClick, "dblclick");
                $this->PrepareQWJSEvent($aname, $this->jsOnMouseDown, "mousedown");
                $this->PrepareQWJSEvent($aname, $this->jsOnMouseUp, "mouseup");
                $this->PrepareQWJSEvent($aname, $this->jsOnMouseMove, "mousemove");
                $this->PrepareQWJSEvent($aname, $this->jsOnMouseOut, "mouseout");
                $this->PrepareQWJSEvent($aname, $this->jsOnMouseOver, "mouseover");

                if (($this->Visible) || (($this->ControlState & csDesigning)==csDesigning))
                      { $visible="true"; }
                else  { $visible="false"; };
                echo "  $this->_lblname.setVisibility($visible);\n";
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        echo  "  if (isdefined(window,'inline_div')) ";
                }
                echo "   inline_div.add($this->_lblname);\n";
        }

        function addOtherChildren($parentname, $topoffset, $leftoffset)
        {
                $eh = $this->Height - 14 - $this->_lblspacing;
                switch ($this->_lblposition)
                {
                        case lpBelow:
                                $y = $this->Top+$eh;
                                $ey=$this->Top;
                                break;
                        default: // lpAbove:
                                $y = $this->Top;
                                $ey=$y+14+$this->_lblspacing;
                                break;
                }

                echo "  $this->_lblname.setLeft(".($this->Left+$leftoffset).");\n";
                echo "  $this->_lblname.setTop(".($y+$topoffset).");\n";
                echo "  $parentname.add($this->_lblname);\n";
                echo "  $this->Name.setLeft(".($this->Left+$leftoffset).");\n";
                echo "  $this->Name.setTop(".($ey+$topoffset).");\n";
        }

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->_edtlabel = new SubLabel();
                $this->_edtlabel->_control=$this;

                $this->Width = 121;
                $this->Height = 34;
        }

        function setName($value)
        {
                $oldname=$this->_name;
                parent::setName($value);

                //Sets the caption if not already changed
                if ($this->_edtlabel->Caption == $oldname)
                {
                        $this->_edtlabel->Caption = $this->Name;
                }
        }

        /**
         * Use EditLabel to work with the label that is associated with this
         * labeled edit control. Use this label’s properties to specify the
         * caption that appears on the label.
         *
         * @return string
         */
        protected function readEditLabel()              { return $this->_edtlabel; }
        protected function writeEditLabel($value)       { if (is_object($value)) $this->_edtlabel=$value; }
        /**
         * Specifies the position of the label relative to the edit control, you can set
         * it to be above or below
         *
         * Valid values for this property are:
         *
         * lpAbove - Label is placed above edit control
         *
         * lpBelow - Label is placed below edit contro
         *
         * @return enum
         */
        protected function readLabelPosition()          { return $this->_lblposition; }
        protected function writeLabelPosition($value)   { $this->_lblposition=$value; }
        function defaultLabelPosition()     { return lpAbove; }

        /**
         * Specifies the distance, in pixels, between the label and the edit region, so you
         * have the oportunity to set some space between them.
         *
         * @return integer
         */
        protected function readLabelSpacing()           { return $this->_lblspacing; }
        protected function writeLabelSpacing($value)    { $this->_lblspacing=$value; }
        function defaultLabelSpacing()      { return 3; }
}

/**
* An edit component with an attached Label.
*
* It provides an Edit component with an attached Label, so it's easier for you to
* create and design forms, as a single component is required.
*
* You can set the text for the Label using the EditLabel property and its subproperties.
*
*/
class LabeledEdit extends CustomLabeledEdit
{
        //Publish common properties
        //function getFont()              { return $this->readFont(); }
        //function setFont($value)        { $this->writeFont($value); }

        function getColor()             { return $this->readColor(); }
        function setColor($value)       { $this->writeColor($value); }

        function getEnabled()           { return $this->readEnabled(); }
        function setEnabled($value)     { $this->writeEnabled($value); }

        function getParentColor()       { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentFont()        { return $this->readParentFont(); }
        function setParentFont($value)  { $this->writeParentFont($value); }

        function getParentShowHint()    { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getPopupMenu()         { return $this->readPopupMenu(); }
        function setPopupMenu($value)   { $this->writePopupMenu($value); }

        function getShowHint()          { return $this->readShowHint(); }
        function setShowHint($value)    { $this->writeShowHint($value); }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        //Publish Edit control properties
        function getBorderStyle()       { return $this->readBorderStyle();  }
        function setBorderStyle($value) { $this->writeBorderStyle($value);  }

        function getCharCase()          { return $this->readCharCase(); }
        function setCharCase($value)    { $this->writeCharCase($value); }

        function getDataField()         { return $this->readDataField(); }
        function setDataField($value)   { $this->writeDataField($value); }

        function getDataSource()        { return $this->readDataSource(); }
        function setDataSource($value)  { $this->writeDataSource($value); }

        function getIsPassword()        { return $this->readIsPassword(); }
        function setIsPassword($value)  { $this->writeIsPassword($value); }

        function getMaxLength()         { return $this->readMaxLength(); }
        function setMaxLength($value)   { $this->writeMaxLength($value); }

        function getReadOnly()          { return $this->readReadOnly(); }
        function setReadOnly($value)    { $this->writeReadOnly($value); }

        function getText()              { return $this->readText(); }
        function setText($value)        { $this->writeText($value); }

        // publish Common Events
        function getjsOnActivate()      { return $this->readjsOnActivate(); }
        function setjsOnActivate($value){ $this->writejsOnActivate($value); }

        function getjsOnDeActivate()    { return $this->readjsOnDeActivate(); }
        function setjsOnDeActivate($value) { $this->writejsOnDeActivate($value); }

        function getjsOnChange()        { return $this->readjsOnChange(); }
        function setjsOnChange($value)  { $this->writejsOnChange($value); }

        function getjsOnBlur()          { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)    { $this->writejsOnBlur($value); }

        function getjsOnClick()         { return $this->readjsOnClick(); }
        function setjsOnClick($value)   { $this->writejsOnClick($value); }

        function getjsOnContextMenu()   { return $this->readjsOnContextMenu(); }
        function setjsOnContextMenu($value) { $this->writejsOnContextMenu($value); }

        function getjsOnDblClick()      { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value){ $this->writejsOnDblClick($value); }

        function getjsOnFocus()         { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)   { $this->writejsOnFocus($value); }

        function getjsOnKeyDown()       { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value) { $this->writejsOnKeyDown($value); }

        function getjsOnKeyPress()      { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value){ $this->writejsOnKeyPress($value); }

        function getjsOnKeyUp()         { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)   { $this->writejsOnKeyUp($value); }

        function getjsOnMouseDown()      { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value){ $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()       { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value) { $this->writejsOnMouseUp($value); }

        function getjsOnMouseMove()     { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value) { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()      { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value) { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver()     { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value) { $this->writejsOnMouseOver($value); }

        // publish new properties
        function getEditLabel()             { return $this->readEditLabel(); }
        function setEditLabel($value)       { $this->writeEditLabel($value); }

        function getLabelPosition()         { return $this->readLabelPosition(); }
        function setLabelPosition($value)   { $this->writeLabelPosition($value); }

        function getLabelSpacing()         { return $this->readLabelSpacing(); }
        function setLabelSpacing($value)   { $this->writeLabelSpacing($value); }
        // publish events
        //function getOnClick()           { return $this->readOnClick(); }
        //function setOnClick($value)     { $this->writeOnClick($value); }
}

/**
 * Base class for ToolBar object
 *
 * ToolBar manages tool buttons and other controls, arranging them in a row and automatically
 * adjusting their sizes and positions.
 *
 */
class CustomToolBar extends QWidget
{
        protected $_items=array();
        protected $_images = null;
        protected $_useparts = false;

        function loaded()
        {
                parent::loaded();
                $this->writeImages($this->_images);
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
                //This function is used as a common click processor for all item clicks
                echo '<script type="text/javascript">';
                echo "function $this->Name"."_clickwrapper(e)\n";
                echo "{\n";
                echo "  submit=true; \n";
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->JsOnClick!=null)
                        {
                                echo "  submit=".$this->JsOnClick."(e);\n";
                        }
                }
                echo "  var tag=e.getTarget().tag;\n";
                echo "  if ((tag!=0) && (submit))\n";
                echo "  {\n";
                echo "    var hid=findObj('$this->Name"."_state');\n";
                echo "    if (hid) hid.value=tag;\n";
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $form = "document.".$this->owner->Name;
                        echo "    if (($form.onsubmit) && (typeof($form.onsubmit) == 'function')) { $form.onsubmit(); }\n";
                        echo "    $form.submit();\n";
                }
                echo "    }\n";
                echo "}\n";
                echo '</script>';
        }

        /**
        * Dump the toolbar parts
        */
        private function dumpParts()
        {
                reset($this->_items);
                while(list($index, $item) = each($this->_items))
                {
                        echo "\n";
                        echo "  <!-- Part #$index Start -->\n";
                        echo "    var tbp = new qx.ui.toolbar.Part;\n";

                        $subitems = $item['Items'];
                        // check if has subitems
                        if ((isset($subitems)) && (count($subitems)))
                        {
                                $this->dumpButtons("tbp", $subitems);
                        }

                        echo "    $this->Name.add(tbp);\n";
                        echo "  <!-- Part $index End -->\n";
                }
        }

        /**
        * Dump toolbar buttons
        * @param string $name Name of the toolbar to add items
        * @param array $items Button items to add
        */
        private function dumpButtons($name, $items)
        {
                reset($items);
                while(list($index, $item) = each($items))
                {
                        $caption=$item['Caption'];

                        $imageindex=$item['ImageIndex'];
                        if (($this->_images != null) && (is_object($this->_images)))
                        {
                                $image = $this->_images->readImageByID($imageindex, 1);
                        }
                        else
                        {
                                $image = "null";
                        }

                        $tag = $item['Tag'];
                        if ($tag == '') $tag=0;

                        $itemname = $name . "_" . $index;

                        if ($caption=='-')
                        {
                                echo "    var $itemname = new qx.ui.toolbar.Separator();\n";
                        }
                        else
                        {
                                $avalue=str_replace('"','\"',$caption);
                                echo "    var $itemname = new qx.ui.toolbar.Button(\"$avalue\", $image);\n";
                                __QLibrary_SetCursor($itemname, $this->Cursor);
                                echo "    $itemname.addEventListener(\"execute\", " . $this->Name . "_clickwrapper);\n";
                                echo "    $itemname.tag=$tag;\n";
                        }
                        $elements[] = $itemname;
                }

                if (isset($elements))
                {
                        echo "\n";
                        echo "    $name.add(" . implode(",", $elements) . ");\n";
                        unset($elements);
                }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                echo "\n";
                echo "  var ".$this->Name."    = new qx.ui.toolbar.ToolBar;\n";
//                echo "  $this->Name.setLeft(0);\n";
//                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight(".($this->Height-1).");\n";

                if ($this->UseParts)
                {
                        $this->dumpParts();
                }
                else
                {
                        echo "  <!-- Part Main Start -->\n";
                        echo "  var tbp = new qx.ui.toolbar.Part;\n";
                        $this->dumpButtons("tbp", $this->_items);
                        echo "  $this->Name.add(tbp);\n";
                        echo "  <!-- Part Main End -->\n";
                }
                $this->dumpCommonQWidgetProperties($this->Name, 0);
                $this->dumpCommonQWidgetJSEvents($this->Name, 2);
                $this->dumpCommonContentsBottom();
        }

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=300;
                $this->Height=30;
                $this->Align = alTop;
        }

        function defaultAlign()                 { return alTop; }

        /**
         * ImageList component used to show images for the different items.
         *
         * Check the Items property to know how to setup the array to specify the index for the
         * image to show
         *
         * @see readItems()
         *
         * @return ImageList
         */
        protected function readImages()         { return $this->_images; }
        protected function writeImages($value)  { $this->_images = $this->fixupProperty($value); }
        function defaultImages()                { return null; }
        /**
         * Describes the elements of the menu.
         *
         * Use Items to access information about the elements in the control.
         * Item contain information about Caption, associated image and Tag.
         *
         * @return Collection
         */
        protected function readItems()          { return $this->_items; }
        protected function writeItems($value)   { $this->_items=$value; }
        /**
         * Defines how items specified are used to build toolbar elements.
         *
         * If set to True then main level in the Items tree will define Parts
         * and elements from sublevel will be used to build buttons
         * Otherwise, only elements from the main level are used and all subitems are ignored.
         *
         * @return boolean
         */
        protected function readUseParts()       { return $this->_useparts; }
        protected function writeUseParts($value){ $this->_useparts=$value; }
        function defaultUseParts()              { return false; }
}

/**
 * ToolBar manages tool buttons and other controls, arranging them in a row and automatically
 * adjusting their sizes and positions.
 *
 * Use the Items property to add elements to the toolbar.
 */
class ToolBar extends CustomToolBar
{
        //Publish common properties
//        function getColor()                     { return $this->readColor(); }
//        function setColor($value)               { $this->writeColor($value); }

//        function getFont()                      { return $this->readFont(); }
//        function setFont($value)                { $this->writeFont($value); }

//        function getParentFont()                { return $this->readParentFont(); }
//        function setParentFont($value)          { $this->writeParentFont($value); }

        function getVisible()                   { return $this->readVisible(); }
        function setVisible($value)             { $this->writeVisible($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        // publish properties
        function getImages()                    { return $this->readImages(); }
        function setImages($value)              { $this->writeImages($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        function getUseParts()                  { return $this->readUseParts(); }
        function setUseParts($value)            { $this->writeUseParts($value); }
}

?>