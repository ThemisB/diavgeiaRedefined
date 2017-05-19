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

use_unit("controls.inc.php");
use_unit("stdctrls.inc.php");

/**
 * Base class for CheckListBox
 *
 * A class for generating a list where all items have a checkbox at the left.
 * Users can check or uncheck items in the list.
 */
class CustomCheckListBox extends FocusControl
{
        protected $_items = array();
        protected $_borderstyle = bsSingle;
        protected $_borderwidth="1";
        protected $_bordercolor="#CCCCCC";

        protected $_onclick = null;
        protected $_onsubmit = null;

//        protected $_datasource = null;
//        protected $_datafield = "";
        protected $_taborder=0;
        protected $_tabstop=1;
        protected $_columns=1;
        protected $_header=array();
        protected $_headerbackgroundcolor="#CCCCCC";
        protected $_headercolor="#FFFFFF";
        protected $_sorted=false;

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Clear();

                $this->Width = 185;
                $this->Height = 89;

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function loaded()
        {
                parent::loaded();
//                $this->writeDataSource($this->_datasource);
        }

        function preinit()
        {
                $submitted = $this->input->{$this->Name};

                if (is_object($submitted))
                {
                    $this->_checked=$submitted->asStringArray();
                }
                else
                {
                  //There is a post, but nothing for this control posted, so clean the array
                  if ($_SERVER['REQUEST_METHOD']=='POST')
                  {
                    $this->_checked=array();
                  }
                }
        }

        function init()
        {
                parent::init();

                $submitted = $this->input->{$this->Name};

                if (is_object($submitted))
                {
                        // Allows the OnSubmit event to be fired because it is not
                        // a mouse or keyboard event.
                        if ($this->_onsubmit != null)
                        {
                                $this->callEvent('onsubmit', array());
                        }
                }

                $submitEvent = $this->input->{$this->readJSWrapperHiddenFieldName()};

                if (is_object($submitEvent) && $this->_enabled == 1)
                {
                        // Checks if a click event has been fired
                        if ($this->_onclick != null && $submitEvent->asString() == $this->readJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                }
        }


        //TODO: Add properties to allow you get/set which items are checked on the list
        function dumpContents()
        {
                $events = "";
                if ($this->_enabled == 1)
                {
                        // Gets the string for the JS Events
                        $events = $this->readJsEvents();

                        // Adds or replaces the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                }

                if ($this->_borderstyle == bsNone )
                {       $border = ""; }
                else
                {       $border = "solid"; }
                if ($this->_borderwidth !=="")
                {       $border .= " " . $this->_borderwidth . "px"; }
                if ($this->_bordercolor !=="")
                {       $border .= " " . $this->_bordercolor; }
                if ($border != "")
                {       $border = "border: " . $border . ";"; }

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                echo "  <DIV style=\"OVERFLOW-Y:auto; OVERFLOW-X:hidden; WIDTH:{$this->Width}px; HEIGHT:{$this->Height}px; $border\" $class>\n";

                $style="";
                if ($this->Style=="")
                {
                        // Gets the Font attributes
                        $style .= $this->Font->FontString;

                        if ($this->Color != "")
                        { $style  .= "background-color: " . $this->Color . ";"; }

                        // Adds the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                $w=$this->_width;
                $h=$this->_height;

                $spanstyle = $style;

                // Sets enabled/disabled status
                $enabled = (!$this->_enabled) ? "disabled=\"disabled\"" : "";

                // Sets tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                 //Add correct layout table for the grouping
                $style.="table-layout:fixed;";

                // Gets the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                if ($style != "") $style = "style=\"$style\"";
                if ($spanstyle != "") $spanstyle = "style=\"$spanstyle\"";

                // Gets the alignment of the Items
                switch ($this->_alignment)
                {
                        case agNone   : $alignment = ""; break;
                        case agLeft   : $alignment = "align=\"Left\""; break;
                        case agCenter : $alignment = "align=\"Center\""; break;
                        case agRight  : $alignment = "align=\"Right\""; break;
                        default       : $alignment = ""; break;
                }

//                if (($this->ControlState & csDesigning) != csDesigning)
//                {
//                        if ($this->hasValidDataField())
//                        {
//                                //Checks if the value of the current data-field is in the items array as value
//                                $val = $this->readDataFieldValue();
//
//                                //Dumps hidden fields to know which record to update
//                                $this->dumpHiddenKeyFields();
//                        }
//                }

                // Calls the OnShow event if assigned so the Items property can be changed
                if ($this->_onshow != null) $this->callEvent('onshow', array());

                $hinttext=$this->_hint!=$this->defaultHint()&& $this->ShowHint==true?$this->_hint:$this->defaultHint();
                echo "    <table cellpadding=\"0\" cellspacing=\"0\" title=\"$hinttext\"  $style $class>";
                if (is_array($this->_items)&& count($this->_items)>0)
                {/*
                        // Uses $index to call the JS CheckListBox function
                        $index = 0;
                        foreach ($this->_items as $key => $item)
                        {
                                // Adds the checked attribute if the itemindex is the current item
                                $checked = ((isset($this->_checked[$key])) && ($this->_checked[$key]==1)) ? "checked=\"checked\"" : "";
                                // Allows only an OnClick if enabled
                                $itemclick = ($this->_enabled == 1 && $this->Owner != null) ? "onclick=\"return CheckListBoxClick('$this->Name" . "_" . $index . "', $index);\"" : "";

                                $element = $this->Name . "_" . $key;
                                // Adds a new row for every item
                                echo "    <tr>\n";
                                echo "      <td width=\"20\"><input ID=\"$element\" type=\"checkbox\" name=\"$this->Name[$key]\" value=\"1\" $events $enabled $taborder $hint $class $checked /></td>\n";
                                echo "      <td $alignment><span ID=\"$element\" $itemclick $hint $spanstyle $class>$item</span></td>\n";
                                echo "    </tr>\n";
                                $index++;
                        }
                }
                echo "    </table>\n";*/

                        $index = 0;


                        //Avoid div by 0
                        $numItems=count($this->items);
                        $columnsWidth=$w/$this->_columns;
                        $itemsPerColumn=ceil($numItems/$this->_columns);
                        $rowHeight= $h/$itemsPerColumn;
                        $itemsPerRow=ceil($numItems/$itemsPerColumn);

                        for($row=0; $row<$itemsPerColumn; ++$row)
                        {
                                echo "<tr>\n";

                                for($column=0; $column<$itemsPerRow; ++ $column)
                                {
                                        //echo "<td width=\"20\">\n";
                                        //do we have more items to place in this <td>?
                                        $curItemNum=$row+$itemsPerColumn*$column;
                                        if($curItemNum<$numItems)
                                        {
                                                $key=$curItemNum;
                                                $item=$this->_items[$key];

                                                $element = $this->Name . "_" . $key;

                                                $itemWidth=$columnsWidth-20;

                                                $headerStyle="";
                                                if(isset($this->_header[$curItemNum])&& $this->_header[$curItemNum]==true)
                                                {
                                                        echo "      <td width=\"20\" style=\" color:$this->_headercolor; background-color:$this->_headerbackgroundcolor \"><input ID=\"$element\" type=\"checkbox\" style=\"  visibility:hidden\"></input></td>\n";
                                                        $headerStyle=" color:$this->_headercolor; background-color:$this->_headerbackgroundcolor ";
                                                }
                                                else
                                                {
                                                        //if this item is checked set it
                                                        $checked = ((isset($this->_checked[$key])) && ($this->_checked[$key]==1)) ? "checked=\"checked\"" : "";
                                                        echo "      <td width=\"20\"><input ID=\"$element\" type=\"checkbox\" name=\"$this->Name[$key]\" value=\"1\" $events $enabled $taborder $hint $class $checked /></td>\n";
                                                }

                                                // Allows only an OnClick if enabled
                                                $itemclick = ($this->_enabled == 1 && $this->Owner != null) ? "onclick=\"return CheckListBoxClick('$this->Name" . "_" . $index . "', $index);\"" : "";

                                                //ie needs cell style just in a span inside <td>, firefox needs them in the <td> amazing... ¬¬
                                                echo "</td><td $alignment width=\"$itemWidth\ height=\"$rowHeight\" style=\"overflow:hidden;white-space:nowrap; $headerStyle\">\n";
                                                echo "<span id=$element  style=\"white-space:nowrap;\" $itemclick $hinttext $spanstyle $class>$item</span>\n";
                                        }
                                        //echo "</td>\n";
                                }
                                echo "</tr>\n";
                        }
                }
                echo "  </table>\n";
                echo "  </DIV>";

                // Adds a hidden field to determine which radiogroup fired the event
                if ($this->_onclick != null)
                {
                        echo "\n";
                        echo "<input type=\"hidden\" name=\"".$this->readJSWrapperHiddenFieldName()."\" value=\"\" />";
                }
        }


        function dumpFormItems()
        {
                        // Adds a hidden field so we can determine for which event the chart was fired
                        if ($this->_onclick != null)
                        {
                                $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                                echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                        }
        }

        /*
        * Writes the Javascript section to the header
        */
        function dumpJavascript()
        {
                parent::dumpJavascript();

                if ($this->_enabled == 1)
                {
                        if ($this->_onclick != null && !defined($this->_onclick))
                        {
                                // Outputs the same function only once in case two or
                                //more objects use the same OnClick event handler.
                                // Otherwise, if for example two radio groups use the same
                                // OnClick event handler, it would be output twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // Outputs the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }

                        // Outputs the function only once
                        if (!defined('CheckListBoxClick'))
                        {
                                define('CheckListBoxClick', 1);

                                echo "function CheckListBoxClick(name, index)\n";
                                echo "{\n";
                                echo "  var event = event || window.event;\n";
                                echo "  var obj=document.getElementById(name);\n";
                                echo "  if (obj) {\n";
                                echo "    if (!obj.disabled) {\n";
                                echo "      obj.checked = !obj.checked;\n";
                                echo "      return obj.onclick();\n";
                                echo "    }\n";
                                echo "  }\n";
                                echo "  return false;\n";
                                echo "}\n";
                        }
                }
        }

        /**
        * Adds an item to the list and returns the number of items on the list. Each
        * item can have a key which will be used as the value when the form is posted
        * to the server.
        *
        * @see Clear(), readCount()
        *
        * @param mixed $item Value of item to add.
        * @param mixed $itemkey Key of the item in the array. Default key is used if null.
        * @return integer Return the number of items in the list.
        */
        function AddItem($item, $itemkey = null)
        {
                end($this->_items);     //Sets the array to the end
                if ($itemkey != null)   //Adds the item at specified position
                {
                        $this->_items[$itemkey] = $item;
                }
                else                    //Adds the item as the last one
                {
                        $this->_items[] = $item;
                }

                /*if($this->Sorted)
                        asort($this->_items);*/

                return($this->Count);
        }

        /**
        * Deletes all of the items from the list control by assigning an empty
        * array to the items property
        *
        * @see AddItem(), readCount()
        */
        function Clear()
        {
                $this->_items = array();
        }


        /**
        * Return the item in the list box specified by $itemkey
        *
        * Use ItemAtPos to get the value of an item specified by its key value.
        * If not item is found, null is returned
        *
        * @param string $itemkey Key of the item to search for
        * @return string|null
        */
        function ItemAtPos($itemkey)
        {
                if(isset($this->_items[$itemkey]))
                        return $this->_items[$itemkey];
                else
                        return null;
        }

        /**
        * Set the checked property for all items to true
        *
        * Use this method to check all items in the listbox, so the checkbox attached
        * shows a mark inside.
        *
        */
        function SelectAll()
        {
                foreach($this->items as $k=>$v)
                        $this->_checked[$k]=true;
        }

        /**
        * Returns the number of items in the list. This value is the count of the
        * internal items array
        *
        * @see AddItem(), Clear()
        *
        * @return integer
        */
        function readCount()                    { return count($this->_items); }

        /**
         * Specifies Border width used to display a control
         *
         * Use this property to specify the width, in pixels, of the border to
         * use when rendering this control on the browser.
         *
         * The default value is 1.
         *
         * @see readBorderColor(), readBorderStyle()
         *
         * @return integer
         */
        function readBorderWidth()              { return $this->_borderwidth; }
        function writeBorderWidth($value)       { $this->_borderwidth=$value; }
        function defaultBorderWidth()           { return 1; }

        /**
         * Specifies Border color used to display a control.
         *
         * Use this property to specify the color to be used when drawing the
         * border of this control. You can use any color specifier, from RGB to
         * a color name.
         *
         * @see readBorderWidth(), readBorderStyle()
         *
         * @return string
         */
        function readBorderColor()              { return $this->_bordercolor; }
        function writeBorderColor($value)       { $this->_bordercolor=$value; }
        function defaultBorderColor()           { return "#CCCCCC"; }

        /**
         * Specifies Border Style used to display a control
         *
         * Valid values for this property are:
         *
         * bsSingle - The control will show a single border
         *
         * bsNone - The control won't show a border
         *
         * @see readBorderWidth(), readBorderColor()
         *
         * @return enum
         */
        function readBorderStyle()              { return $this->_borderstyle; }
        function writeBorderStyle($value)       { $this->_borderstyle=$value; }
        function defaultBorderStyle()           { return bsSingle; }

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
        function readOnClick()                  { return $this->_onclick; }
        function writeOnClick($value)           { $this->_onclick = $value; }
        function defaultOnClick()               { return null; }

        /**
        * Occurs when the control is submitted.
        *
        * Use this event to react when the form is submitted and, therefore,
        * this control is updated with the new values sent by the user.
        *
        * @return mixed
        */
        function readOnSubmit()                 { return $this->_onsubmit; }
        function writeOnSubmit($value)          { $this->_onsubmit=$value; }
        function defaultOnSubmit()              { return null; }


        /**
        * Defines an array of items taht will be rendered as columns using
        * BackgroundHeaderColor and HeaderColor properties
        */
        function getHeader()                   { return $this->_header; }
        function setHeader($value)
        {
          //This changes string-key based array to integer-key based array
          $this->_header=array();
          reset($value);
          while (list($k,$v)=each($value))
          {
            $this->_header[$k]=$v;
          }
        }
        function defaultHeader()                { return array();        }

        //TODO: Implement data-aware properties
//        function readDataField()              { return $this->_datafield; }
//        function writeDataField($value)       { $this->_datafield = $value; }
//        function defaultDataField()           { return ""; }

//        function readDataSource()             { return $this->_datasource; }
//        function writeDataSource($value)      { $this->_datasource = $this->fixupProperty($value); }
//        function defaultDataSource()          { return null; }

        /**
        * Contains the strings that appear in the list. This is an array in which each
        * item has a key and a value ($key=>$value)
        *
        * @see AddItem(), readCount()
        *
        * @return array
        */
        function readItems()                    { return $this->_items; }
        function writeItems($value)
        {
                if (is_array($value)) { $this->_items = $value; }
                else  { $this->_items = (empty($value)) ? array() : array($value); }
        }
        function defaultItems()                 { return array(); }

        protected $_checked=array();

        /**
        * Array property which specifies which items are checked or not
        *
        * Use this property to read which items have been checked by the user or
        * to set the initial items that must be checked.
        *
        * <code>
        * <?php
        *      //This set, before the control is shown, the first and third items
        *      //to checked state and the second item will be unchecked
        *      function CheckListBox1BeforeShow($sender, $params)
        *      {
        *         $checked=array();
        *         $checked[]=1;
        *         $checked[]=0;
        *         $checked[]=1;
        *         $this->CheckListBox1->Checked=$checked;
        *      }
        * ?>
        * </code>
        *
        * <code>
        * <?php
        *      //Reading the checked property, you can know which items have been
        *      //checked by the user
        *      function Button2Click($sender, $params)
        *      {
        *               $checked=$this->CheckListBox1->Checked;
        *
        *               reset($checked);
        *               while(list($key, $val)=each($checked))
        *               {
        *                       if ($val==1) echo "The item #$key is checked<br>";
        *               }
        *      }
        * ?>
        * </code>
        * @return array
        */
        function getChecked() { return $this->_checked; }
        function setChecked($value)
        {
          //This changes string-key based array to integer-key based array
          $this->_checked=array();
          reset($value);
          while (list($k,$v)=each($value))
          {
            $this->_checked[$k]=$v;
          }
        }
        function defaultChecked() { return array(); }

        /**
        * TabOrder indicates the order in which controls are accessed when using
        * the Tab key.
        * The TabOrder value can be between 0 and 32767.
        * @see readTabStop()
        * @return integer
        */
        function readTabOrder()                 { return $this->_taborder; }
        function writeTabOrder($value)          { $this->_taborder=$value; }
        function defaultTabOrder()              { return 0; }

        /**
        * Enables or disables the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @see readTabOrder()
        * @return bool
        */
        function readTabStop()                  { return $this->_tabstop; }
        function writeTabStop($value)           { $this->_tabstop=$value; }
        function defaultTabStop()               { return 1; }


        /**
        * Specifies the number of columns that the list box uses to display its items.
        *
        * Set Columns to indicate the number of columns in a list box.
        * This causes the list box to accommodate new items that do not fit in the
        * specified number of columns by adding additional rows.
        *
        * @return integer
        */
        function getColumns() { return $this->_columns; }
        function setColumns($value) { $this->_columns=$value?$value:1; }
        function defaultColumns() { return 1; }

        /**
        * Specifies the background color for a header item in the listbox.
        *
        * Set HeaderBackgroundColor to indicate the color that appears as the
        * background of header items. Header items are items in the list box for
        * which the Header property is true. HeaderBackgroundColor can make a
        * header item visually more distinct from the checkable items in the list box.
        *
        * @return string
        */
        function getHeaderBackgroundColor() { return $this->_headerbackgroundcolor; }
        function setHeaderBackgroundColor($value) { $this->_headerbackgroundcolor=$value; }
        function defaultHeaderBackgroundColor() { return "#CCCCCC"; }

        /**
        * Specifies the font color for a header item in the list box.
        *
        * Set HeaderColor to indicate the font color of header items. Header items
        * are items in the list box for which the Header property is true.
        * HeaderColor should be a color that provides contrast with the HeaderBackgroundColor
        * property, which specifies the background color for header items.
        *
        * @return string
        */
        function getHeaderColor() { return $this->_headercolor; }
        function setHeaderColor($value) { $this->_headercolor=$value; }
        function defaultHeaderColor() { return "#FFFFFF"; }

       /* function getSorted() { return $this->_sorted; }
        function setSorted($value) { $this->_sorted=$value;  if($this->_sorted) asort($this->_items);}
        function defaultSorted() { return false; }*/



}

/**
* CheckListBox displays a list with check boxes next to each item.
*
* CheckListBox is similar to ListBox, except that each item has a check box next to it.
* Users can check or uncheck items in the list.
*
*/
class CheckListBox extends CustomCheckListBox
{
        /*
        * Publishes the events for the CheckBox component
        */
        function getOnClick()                   { return $this->readOnClick(); }
        function setOnClick($value)             { $this->writeOnClick($value); }

        function getOnSubmit()                  { return $this->readOnSubmit(); }
        function setOnSubmit($value)            { $this->writeOnSubmit($value); }

        /*
        * Publishes the JS events for the CheckBox component
        */
        function getjsOnBlur()                  { return $this->readjsOnBlur(); }
        function setjsOnBlur($value)            { $this->writejsOnBlur($value); }

        function getjsOnChange()                { return $this->readjsOnChange(); }
        function setjsOnChange($value)          { $this->writejsOnChange($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        function getjsOnDblClick()              { return $this->readjsOnDblClick(); }
        function setjsOnDblClick($value)        { $this->writejsOnDblClick($value); }

        function getjsOnFocus()                 { return $this->readjsOnFocus(); }
        function setjsOnFocus($value)           { $this->writejsOnFocus($value); }

        function getjsOnMouseDown()             { return $this->readjsOnMouseDown(); }
        function setjsOnMouseDown($value)       { $this->writejsOnMouseDown($value); }

        function getjsOnMouseUp()               { return $this->readjsOnMouseUp(); }
        function setjsOnMouseUp($value)         { $this->writejsOnMouseUp($value); }

        function getjsOnMouseOver()             { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value)       { $this->writejsOnMouseOver($value); }

        function getjsOnMouseMove()             { return $this->readjsOnMouseMove(); }
        function setjsOnMouseMove($value)       { $this->writejsOnMouseMove($value); }

        function getjsOnMouseOut()              { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value)        { $this->writejsOnMouseOut($value); }

        function getjsOnKeyPress()              { return $this->readjsOnKeyPress(); }
        function setjsOnKeyPress($value)        { $this->writejsOnKeyPress($value); }

        function getjsOnKeyDown()               { return $this->readjsOnKeyDown(); }
        function setjsOnKeyDown($value)         { $this->writejsOnKeyDown($value); }

        function getjsOnKeyUp()                 { return $this->readjsOnKeyUp(); }
        function setjsOnKeyUp($value)           { $this->writejsOnKeyUp($value); }

        /*
        * Publishes the properties for the CheckBox component
        */

        function getAlignment()                 { return $this->readAlignment(); }
        function setAlignment($value)           { $this->writeAlignment($value); }

        function getBorderWidth()               { return $this->readBorderWidth(); }
        function setBorderWidth($value)         { $this->writeBorderWidth($value); }

        function getBorderColor()               { return $this->readBorderColor(); }
        function setBorderColor($value)         { $this->writeBorderColor($value); }

        function getBorderStyle()               { return $this->readBorderStyle(); }
        function setBorderStyle($value)         { $this->writeBorderStyle($value); }

        function getColor()                     { return $this->readColor(); }
        function setColor($value)               { $this->writeColor($value); }

//        function getDataField()                 { return $this->readDataField(); }
//        function setDataField($value)           { $this->writeDataField($value); }

//        function getDataSource()                { return $this->readDataSource(); }
//        function setDataSource($value)          { $this->writeDataSource($value); }

        function getEnabled()                   { return $this->readEnabled(); }
        function setEnabled($value)             { $this->writeEnabled($value); }

        function getFont()                      { return $this->readFont(); }
        function setFont($value)                { $this->writeFont($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        function getParentColor()               { return $this->readParentColor(); }
        function setParentColor($value)         { $this->writeParentColor($value); }

        function getParentFont()                { return $this->readParentFont(); }
        function setParentFont($value)          { $this->writeParentFont($value); }

        function getParentShowHint()            { return $this->readParentShowHint(); }
        function setParentShowHint($value)      { $this->writeParentShowHint($value); }

        function getPopupMenu()                 { return $this->readPopupMenu(); }
        function setPopupMenu($value)           { $this->writePopupMenu($value); }

        function getShowHint()                  { return $this->readShowHint(); }
        function setShowHint($value)            { $this->writeShowHint($value); }

        function getStyle()                     { return $this->readstyle(); }
        function setStyle($value)               { $this->writestyle($value); }

        function getTabOrder()                  { return $this->readTabOrder(); }
        function setTabOrder($value)            { $this->writeTabOrder($value); }

        function getTabStop()                   { return $this->readTabStop(); }
        function setTabStop($value)             { $this->writeTabStop($value); }

        function getVisible()                   { return $this->readVisible(); }
        function setVisible($value)             { $this->writeVisible($value); }


}

?>