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
 *
 * Base class for DynAPI widgets
 *
 */
class DWidget extends FocusControl
{
        protected $_DWidgetClassName="";

        /**
        * Dynapi widget class
        * @return string
        */
        function readDWidgetClassName()         { return $this->_DWidgetClassName; }
        function writeDWidgetClassName($value)  { $this->_DWidgetClassName=$value; }

        function dumpHeaderCode()
        {
                if (!defined('DYNAPI'))
                {
                        echo "<script type=\"text/javascript\" src=\""
                           . VCL_HTTP_PATH . "/dynapi/src/dynapi.js\"></script>\n"
                           . "<script type=\"text/javascript\">\n"
                           . "  dynapi.library.setPath('" . VCL_HTTP_PATH . "/dynapi/src/');\n"
                           . "  dynapi.library.include('dynapi.api');\n"
                           . "</script>\n";
                        define('DYNAPI', 1);
                }

                if (!defined('DYNAPI_' . strtoupper($this->className())))
                {
                        echo "<script type=\"text/javascript\">\n"
                             . "  dynapi.library.include('" . $this->DWidgetClassName . "');\n"
                             . "</script>\n";
                        define('DYNAPI_'.strtoupper($this->className()),1);
                }
        }

        function dumpContents()
        {
                echo "<script type=\"text/javascript\">\n"
                   . "  dynapi.document.insertChild(" . $this->Name . ");\n"
                   . "</script>\n";
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csSlowRedraw=1";
        }
}

        /**
        * Init qooxdoo library, only once
        */
function __QLibrary_InitLib()
{
        if (!defined('QOOXDOO'))
        {
                echo "<script type=\"text/javascript\" src=\"" . VCL_HTTP_PATH . "/qooxdoo/framework/script/qx.js\" charset=\"UTF-8\"></script>\n"
                   . "<script type=\"text/javascript\">\n"
                   . "  qx.log.Logger.ROOT_LOGGER.setMinLevel(qx.log.Logger.LEVEL_FATAL);\n"
                   . "  qx.manager.object.AliasManager.getInstance().add(\"static\", \"" . VCL_HTTP_PATH . "/qooxdoo/framework/resource/static/\");\n"
                   . "  qx.manager.object.AliasManager.getInstance().add(\"widget\", \"" . VCL_HTTP_PATH . "/qooxdoo/framework/resource/widget/windows/\");\n"
                   . "  qx.manager.object.AliasManager.getInstance().add(\"icon\", \"" . VCL_HTTP_PATH . "/qooxdoo/framework/resource/icon/VistaInspirate/\");\n"
                   . "</script>\n";

                define('QOOXDOO',1);
        }
}

        /**
        * Set widget cursor
        * @param string $Name Component Name
        * @param string $Cursor Cursor to be set
        */
function __QLibrary_SetCursor($Name, $Cursor)
{
        if ($Cursor !== "")
        {
                switch ($Cursor)
                {
                        case "crPointer":   $cursor="pointer"; break;
                        case "crHand":      $cursor="pointer"; break;
                        case "crCrossHair": $cursor="crosshair"; break;
                        case "crHelp":      $cursor="help"; break;
                        case "crText":      $cursor="text"; break;
                        case "crWait":      $cursor="wait"; break;
                        case "crE-Resize":  $cursor="e-resize"; break;
                        case "crNE-Resize": $cursor="ne-resize"; break;
                        case "crN-Resize":  $cursor="n-resize"; break;
                        case "crNW-Resize": $cursor="nw-resize"; break;
                        case "crW-Resize":  $cursor="w-resize"; break;
                        case "crSW-Resize": $cursor="sw-resize"; break;
                        case "crS-Resize":  $cursor="s-resize"; break;
                        case "crSE-Resize": $cursor="se-resize"; break;
                        case "crAuto":      $cursor="move"; break;
                        default:            $cursor="default"; break;
                }
                echo "  $Name.setCursor(\"$cursor\");\n";
        }
}

/**
 * Base class for qooxdoo widgets
 *
 * Qooxdoo widgets are the ones based on the qooxdoo library, a javascript/dhtml/ajax
 * library that provide advanced controls that work on the browser.
 *
 * This class abstracts all the repetitive code you need to write if you want to create
 * a component based on this library.
 *
 * @link http://www.qooxdoo.org
 */
class QWidget extends FocusControl
{
        /**
        * Dumps to the output the code to set common properties, like enabled, font, color, etc.
        *
        * This method is responsible to dump all the qooxdoo code to set common properties, like
        * enabled, font, color and visibility.
        *
        * @param string $Name Name of the component you are dumping
        * @param boolean $FontSupport If true (default) dumps code for Font setting, not all qooxdoo widgets have this capability
        */
        function dumpCommonQWidgetProperties($Name, $FontSupport = 1)
        {
                __QLibrary_SetCursor($Name, $this->Cursor);
                if ($this->Enabled) { $enabled="true"; }
                else                { $enabled="false"; }

                echo "  $Name.setEnabled($enabled);\n";
                if ($FontSupport)
                {
                echo "  $Name.setFont(\"{$this->Font->Size} '{$this->Font->Family}' {$this->Font->Weight}\");\n";
                if ($this->Font->Color != "")
                { echo "  $Name.setColor(new qx.renderer.color.Color('{$this->Font->Color}'));\n"; }
                }

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $visible="true";
                }
                else
                {
                        if ($this->Hidden)
                        {
                                $visible="false";
                        }
                        else
                        {
                                 $visible="true";
                        }
                }

                echo "  $Name.setVisibility($visible);\n";
        }

        /**
        * Dumps code to add an event for the widget
        *
        * This method uses qooxdoo addEventListener function to dump the line that
        * attaches an specific function to a qooxdoo event
        *
        * @param string $Name Name of the component to attach the event to
        * @param string $event Name of the javascript function to attach the event to
        * @param string $eventname Name of the qooxdoo event i.e. execute
        */
        protected function PrepareQWJSEvent($Name, $event, $eventname)
        {
                if ($event != null)
                {
                        echo "  $Name.addEventListener('$eventname', function(e) { $event(e); });\n";
                }
        }

        /**
        * This function uses PrepareQWJSEvent to dump the attachment for common javascript events
        *
        * This method is used in runtime to attach common javascript events, like OnActivate, OnKeyDown, etc, to their
        * counterparts in qooxdoo, like focusin, keydown
        *
        * @param string $Name Name of the component to attach the events
        * @param string $UseOnChangeEvent If an OnChange event must be attached, some controls have a change event an anothers can have a keyup event
        */
        function dumpCommonQWidgetJSEvents($Name, $UseOnChangeEvent)
                {
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $this->PrepareQWJSEvent($Name, $this->jsOnActivate, "focusin");
                        $this->PrepareQWJSEvent($Name, $this->jsOnDeActivate, "focusout");
                        $this->PrepareQWJSEvent($Name, $this->jsOnBlur, "blur");
                        $this->PrepareQWJSEvent($Name, $this->jsOnClick, "click");
                        //$this->PrepareQWJSEvent($Name, $this->readjsOnShow, "appear");
                        //$this->PrepareQWJSEvent($Name, $this->jsOnHide, "disappear");
                        $this->PrepareQWJSEvent($Name, $this->jsOnDblClick, "dblclick");
                        $this->PrepareQWJSEvent($Name, $this->jsOnFocus, "focus");
                        $this->PrepareQWJSEvent($Name, $this->jsOnKeyDown, "keydown");
                        $this->PrepareQWJSEvent($Name, $this->jsOnKeyPress, "keypress");
                        $this->PrepareQWJSEvent($Name, $this->jsOnKeyUp, "keyup");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseDown, "mousedown");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseUp, "mouseup");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseMove, "mousemove");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseOut, "mouseout");
                        $this->PrepareQWJSEvent($Name, $this->jsOnMouseOver, "mouseover");

                        // Special events
                        if (($this->jsOnContextMenu != null) || ($this->PopupMenu != null))
                        {
                                echo "  $Name.addEventListener('contextmenu', function(e) {";
                                if ($this->jsOnContextMenu != null) echo " $this->jsOnContextMenu(e);";
                                if ($this->PopupMenu != null)       echo " Show" . $this->PopupMenu->Name . "(e, 1);";
                                echo " });\n";
                }
                        if ($this->jsOnChange != null)
                {
                                switch ($UseOnChangeEvent)
                                {
                                        case 1:
                                                $event = "keyup";
                                                break;
                                        case 2:
                                                $event = "change";
                                                break;
                                        default:
                                                $event = "";
                                                break;
                                }
                                if ($event !== "")
                                {
                                        echo "  $Name.addEventListener('$event', function(e) { $this->jsOnChange(e); });\n";
                                }
                        }
                }
        }

        function dumpHeaderCode()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                { echo "<html>\n<head>\n"; }
                __QLibrary_InitLib();
                if (($this->ControlState & csDesigning)==csDesigning)
                { echo "</head>\n"; }
        }

        function getHidden() { return $this->readhidden(); }
        function setHidden($value) { $this->writehidden($value); }


        /**
         * Dump the common qooxdoo initialization code
         *
         */
        function dumpCommonContentsTop($state_value="")
        {
                //In design mode, this component needs a body
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo '<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" >';
                }

                echo "<input type=\"hidden\" id=\"$this->Name"."_state\" name=\"$this->Name"."_state\" value=\"$state_value\" />\n";

                if ((($this->ControlState & csDesigning)==csDesigning) || (($this->Parent!=null) && (!$this->Parent->inheritsFrom("QWidget"))))
                {
                        //Creates the div
                        echo "<div id=\"$this->Name\"></div>\n"
                           . "<script type=\"text/javascript\">\n"
//                           . " function ".$this->Name."_qinit() {\n"
                           . "  var d = qx.ui.core.ClientDocument.getInstance();\n"
                           . "  var inline_div = new qx.ui.basic.Inline(\"$this->Name\");\n"
                           . "  inline_div.setHeight(\"auto\");\n"
                           . "  inline_div.setWidth(\"auto\");\n\n";
//                           . "  d.setOverflow(\"auto\");\n";
//                           . "  d.setOverflow(\"scrollY\");\n";
                        //   . "  d.setBackgroundColor(null);\n"
                }
                else
                {
                        echo "<script type=\"text/javascript\">\n";
                }
        }

        /**
         * Dump common qooxdoo finalization code
         *
         */
        function dumpCommonContentsBottom()
        {
                if ((($this->ControlState & csDesigning)==csDesigning) || (($this->Parent!=null) && (!$this->Parent->inheritsFrom("QWidget"))))
                {
                echo "  d.add(inline_div);\n"
                   . "  inline_div.add($this->Name);\n"
//                   . " }\n"
//                   . " qx.core.Init.getInstance().load=".$this->Name."_qinit();\n"
                   . "</script>\n";
                }
                else
                {
                        echo "</script>\n";
                }

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo "</body>\n";
                        echo "</html>\n";
                }
        }

        /**
        * Override this method to add more childrens to a qwidget parent, useful
        * if your component is built by more than one component
        *
        * @param string $parentname Name of the parent component
        * @param integer $topoffset Top coordinate for the component
        * @param integer $leftoffset Left coordinate for the component
        */
        function addOtherChildren($parentname, $topoffset, $leftoffset)
        {

        }

        /**
        * Code to dump when the Widget accepts children controls.
        *
        * @param integer $topoffset Offset to add to generated components
        * @param integer $leftoffset Offset to add to generated components
        * @param string $ownername Name of the owner of the components
        * @param string $layer Name of the layer for the controls to be shown
        */
        function dumpChildrenControls($topoffset=0, $leftoffset=0, $ownername="", $layer="")
        {
                $aowner=$this->Name;
                if ($ownername!="") $aowner=$ownername;

                $js="";
                reset($this->controls->items);
                while (list($k,$v)=each($this->controls->items))
                {
                    if ($v->Layer==$layer)
                    {
                        if ($v->Visible)
                        {
                                if ($v->inheritsFrom("QWidget"))
                                {
                                        echo "</script>";
                                        $v->show();
                                        echo "<script type=\"text/javascript\">\n";
                                echo "  $v->Name.setLeft(".($v->Left+$leftoffset).");\n";
                                echo "  $v->Name.setTop(".($v->Top+$topoffset).");\n";
                                echo "  $aowner.add($v->Name);\n";
                                        $v->addOtherChildren($aowner, $topoffset, $leftoffset);
                                }
                                else
                                {

                                echo "  var container = new qx.ui.embed.HtmlEmbed(\"";
                                //echo "  var container = new qx.ui.basic.Atom(\"";
                                ob_start();
                                echo "<div id=\"".$v->_name."_outer\">\n";
                                $v->show();
                                echo "</div>\n";
                                $c=ob_get_contents();
                                $c=extractjscript($c);
                                $js.=$c[0];
                                $html=$c[1];
                                ob_end_clean();

                                echo str_replace("\r",'\r',str_replace("\n",'\n',str_replace('"','\"', str_replace('\\','\\\\',$html))));

                                echo "\");\n";
                                echo "  container.setLeft(".($v->Left+$leftoffset).");\n";
                                echo "  container.setTop(".($v->Top+$topoffset).");\n";
                                echo "  container.setWidth($v->Width);\n";
                                echo "  container.setHeight($v->Height);\n";
                                echo "  $aowner.add(container);\n";
                                echo "  container.addEventListener(\"appear\", function(e) { $js }, container); \n";
                                }
                        }
                    }
                }
                return($js);
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

               //For mapshapes
                $this->ControlStyle="csTopOffset=1";
                $this->ControlStyle="csLeftOffset=1";
                $this->ControlStyle="csSlowRedraw=1";
        }

}

/**
 * CustomLabel is the base class for controls that display text on a form.
 *
 * The Caption of the CustomLabel may contain HTML formatted text.
 *
 */
class CustomLabel extends GraphicControl
{
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_link = "";
        protected $_linktarget = "";
        protected $_wordwrap = 1;

        protected $_onclick = null;
        protected $_ondblclick = null;

    protected $_formatasdate="";

    /**
    * This property, if set, specifies the format to apply to the Caption contents
    *
    * Use this property if the contents of the Caption are a date and you want to
    * format it according to date specifiers
    *
    * @return string
    */
    function readFormatAsDate() { return $this->_formatasdate; }
    function writeFormatAsDate($value) { $this->_formatasdate=$value; }
    function defaultFormatAsDate() { return ""; }




        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 75;
                $this->Height = 13;
                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function init()
        {
                parent::init();

                $submitEventValue = $this->input->{$this->readJSWrapperHiddenFieldName()};

                if (is_object($submitEventValue))
                {
                        // check if the a click event has been fired
                        if ($this->_onclick != null && $submitEventValue->asString() == $this->readJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                        // check if the a double-click event has been fired
                        if ($this->_ondblclick != null && $submitEventValue->asString() == $this->readJSWrapperSubmitEventValue($this->_ondblclick))
                        {
                                $this->callEvent('ondblclick', array());
                        }
                }
        }

        function loaded()
        {
                parent::loaded();
                // call writeDataSource() since setDataSource() might not be implemented by the sub-class
                $this->writeDataSource($this->_datasource);
        }

        function dumpContents()
        {
                $events="";

                if($this->Enabled==1)
                {
                        // get the string for the JS Events
                        $events = $this->readJsEvents();

                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                        $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");
                }

                $style="";
                if ($this->Style=="")
                {
                    // get the Font attributes
                    $style = $this->Font->FontString;

                    if ((($this->ControlState & csDesigning) == csDesigning) && ($this->_designcolor != ""))
                    {
                            $style .= "background-color: " . $this->_designcolor . ";";
                    }
                    else
                    {
                            $color = $this->_color;
                            if ($color != "")
                            {
                                    $style .= "background-color: " . $color . ";";
                            }
                    }

                    // add the cursor to the style
                    if ($this->_cursor != "")
                    {
                            $cr = strtolower(substr($this->_cursor, 2));
                            $style .= "cursor: $cr;";
                    }
                }

                // set height and width to the style attribute
                if (!$this->_autosize)
                {
                    if (!$this->_adjusttolayout)
                    {
                        $style .= "height:" . $this->Height . "px;width:" . $this->Width . "px;";
                    }
                    else
                    {
                        $style .= "height:100%;width:100%;";
                    }
                }

                if (!$this->_wordwrap)
                {
                        $style .= "white-space: nowrap; ";
                }

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }


                if ($style != "")  $style = "style=\"$style\"";

                // get the alignment of the Caption inside the <div>
                $alignment = "";
                switch ($this->_alignment)
                {
                        case agNone :
                                $alignment = "";
                                break;
                        case agLeft :
                                $alignment = " align=\"Left\" ";
                                break;
                        case agCenter :
                                $alignment = " align=\"Center\" ";
                                break;
                        case agRight :
                                $alignment = " align=\"Right\" ";
                                break;
                }

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                $target="";
                if (trim($this->LinkTarget)!="") $target="target=\"$this->LinkTarget\"";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                if ($this->_divwrap)
                {
                	echo "<div id=\"$this->_name\" $style $alignment $hint $class";

                	if ($this->_link=="") echo "$events";

                	echo ">";
                }
                else if ($this->_style!='')
                {
                	echo "<div id=\"$this->_name\" class=\"$this->_style\"";

                	if ($this->_link=="") echo "$events";

                	echo ">";
                }

                if ($this->_link != "")  echo "<A HREF=\"$this->_link\" $target $events>";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //The value to show on the field is the one from the table
                                $this->Caption = $this->readDataFieldValue();
                                // dump no hidden fields since the label is read-only
                        }
                }


                $toshow=$this->_caption;

				if (($this->ControlState & csDesigning)!=csDesigning)
                {
                	if ($this->_formatasdate!='')
                    {
       					$time=strtotime($toshow);
       					$toshow=date($this->_formatasdate,$time);
                    }
                }

                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array('formattedcaption'=>$toshow));
                }
                else
                {
                        echo $toshow;
                }

                if ($this->_link != "")  echo "</A>";


                if (($this->_divwrap) || ($this->_style!=''))
                {
	                echo "</div>";
                }
        }

        function dumpFormItems()
        {
                // add a hidden field so we can determine which event for the label was fired
                if ($this->_onclick != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }
        }

        function dumpJavascript()
        {
                parent::dumpJavascript();

                if ($this->_onclick != null && !defined($this->_onclick))
                {
                        // only output the same function once;
                        // otherwise if for example two labels use the same
                        // OnClick event handler it would be outputted twice.
                        $def=$this->_onclick;
                        define($def,1);

                        // output the wrapper function
                        echo $this->getJSWrapperFunction($this->_onclick);
                }

                if ($this->_ondblclick != null && !defined($this->_ondblclick))
                {
                        $def=$this->_ondblclick;
                        define($def,1);

                        // output the wrapper function
                        echo $this->getJSWrapperFunction($this->_ondblclick);
                }
        }



        /**
        * Helper function to strip selected tags.
        * This function will also replace self-closing tags (XHTML <br /> <hr />)
        * and will work if the text contains line breaks.
        *
        * @author Bermi Ferrer @ http://www.php.net/manual/en/function.strip-tags.php
        *
        * @param string $text Text that may contain the tags to strip.
        * @param array $tags All tags that should be stripped from $text.
        * @return string Returns $text without the defined $tags.
        */
        protected function strip_selected_tags($text, $tags = array())
        {
                $args = func_get_args();
                $text = array_shift($args);
                $tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
                foreach ($tags as $tag){
                        if( preg_match_all( '/<'.$tag.'[^>]*>([^<]*)<\/'.$tag.'>/iu', $text, $found) ){
                                $text = str_replace($found[0],$found[1],$text);
                        }
                }

                return preg_replace( '/(<('.join('|',$tags).')(\\n|\\r|.)*\/>)/iu', '', $text);
        }

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
        function readOnClick()
        {
                return $this->_onclick;
        }
        /**
        * Occurs when the user clicks the control.
        * @param mixed $value Event handler or null to unset.
        */
        function writeOnClick($value)
        {
                $this->_onclick = $value;
        }
        function defaultOnClick()
        {
                return null;
        }

        /**
        * Occurs when the user double-clicks the control.
        *
        * Use this event to react when the user double click on the control, this event
        * is usually fired after a set of other events, like mousedown and mouseup
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnDblClick()
        {
                return $this->_ondblclick;
        }
        function writeOnDblClick($value)
        {
                $this->_ondblclick = $value;
        }
        function defaultOnDblClick()
        {
                return null;
        }

        /**
        * DataField is the fieldname to be attached to the control.
        *
        * This property allows you to show/edit information from a table column
        * using this control. To make it work, you must also assign the Datasource
        * property, which specifies the dataset that contain the fieldname to work on
        *
        * @return string
        */
        function readDataField()
        {
                return $this->_datafield;
        }
        /**
        * DataField indicates which field of the DataSource is used to fill in
        * the Caption.
        * @param string $value Data field
        */
        function writeDataField($value)
        {
                $this->_datafield = $value;
        }
        function defaultDataField()
        {
                return "";
        }

        /**
        * DataSource property allows you to link this control to a dataset containing
        * rows of data.
        *
        * To make it work, you must also assign DataField property with
        * the name of the column you want to use
        *
        * @return Datasource
        */
        function readDataSource()
        {
                return $this->_datasource;
        }
        function writeDataSource($value)
        {
                $this->_datasource=$this->fixupProperty($value);
        }
        function defaultDataSource()
        {
                return null;
        }

        /**
        * If Link is set the Caption is rendered as a link.
        *
        * Use this property if you want the label to become and HTML link so the
        * user can redirect the browser to a different page, or recall the same page
        * including some parameters
        *
        * Specify the link as an URL
        *
        * @return string
        */
        function readLink()
        {
                return $this->_link;
        }
        function writeLink($value)
        {
                $this->_link = $value;
        }
        function defaultLink()
        {
                return "";
        }

        /**
        * Target attribute when the label acts as a link.
        *
        * If Link property is set, the label will render as a link the user can
        * click. Use this property to specify the target for the contents retrieved
        * on that link.
        *
        * @link http://www.w3.org/TR/html4/present/frames.html#adef-target
        * @return string
        */
        function readLinkTarget() { return $this->_linktarget; }
        function writeLinkTarget($value) { $this->_linktarget=$value; }
        function defaultLinkTarget() { return ""; }

        /**
        * Specifies whether the label text wraps when it is too long
        * for the width of the label.
        * @return bool
        */
        function readWordWrap()
        {
                return $this->_wordwrap;
        }
        /**
        * Specifies whether the label text wraps when it is too long
        * for the width of the label.
        *
        * Note: white-space: nowrap; is applied to the <div> of the label.
        *
        * @param bool $value True if word wrap is enabled, false otherwise.
        */
        function writeWordWrap($value)
        {
                $this->_wordwrap = $value;
        }
        function defaultWordWrap()
        {
                return 1;
        }
}


/**
* Use Label to add text that the user can't edit to a page. This text can be used
* to label another control specifying about its usage.
* As the Label is text, it can contain HTML markup language, including bold, italic, etc
* or HTML elements, like images. Edit the Caption property using the wysiwyg property
* editor.
*
* To add an object to a form that displays text that a user can scroll or edit, use Edit.
*
*/
class Label extends CustomLabel
{
        /*
        * Publish the events for the Label component
        */
        function getOnClick                     () { return $this->readOnClick(); }
        function setOnClick                     ($value) { $this->writeOnClick($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

	    function getFormatAsDate() { return $this->readformatasdate(); }
    	function setFormatAsDate($value) { $this->writeformatasdate($value); }



        /*
        * Publish the JS events for the Label component
        */
        function getjsOnClick                   () { return $this->readjsOnClick(); }
        function setjsOnClick                   ($value) { $this->writejsOnClick($value); }

        function getjsOnDblClick                () { return $this->readjsOnDblClick(); }
        function setjsOnDblClick                ($value) { $this->writejsOnDblClick($value); }

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


        /*
        * Publish the properties for the Label component
        */

        function getAutosize() { return $this->readautosize(); }
        function setAutosize($value) { $this->writeautosize($value); }

    function getDivWrap() { return $this->readdivwrap(); }
    function setDivWrap($value) { $this->writedivwrap($value); }



        function getAlignment()
        {
                return $this->readAlignment();
        }
        function setAlignment($value)
        {
                $this->writeAlignment($value);
        }

        function getCaption()
        {
                return $this->readCaption();
        }
        function setCaption($value)
        {
                $this->writeCaption($value);
        }

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

        function getDesignColor()
        {
                return $this->readDesignColor();
        }
        function setDesignColor($value)
        {
                $this->writeDesignColor($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getLink()
        {
                return $this->readLink();
        }
        function setLink($value)
        {
                $this->writeLink($value);
        }

        function getLinkTarget()
        {
                return $this->readLinkTarget();
        }
        function setLinkTarget($value)
        {
                $this->writeLinkTarget($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }

        function getWordWrap()
        {
                return $this->readWordWrap();
        }
        function setWordWrap($value)
        {
                $this->writeWordWrap($value);
        }

        function getEnabled() { return $this->readenabled(); }
        function setEnabled($value) { $this->writeenabled($value); }


}


// BorderStyles
define('bsNone', 'bsNone');
define('bsSingle', 'bsSingle');

// CharCase
define('ecLowerCase', 'ecLowerCase');
define('ecNormal', 'ecNormal');
define('ecUpperCase', 'ecUpperCase');

/**
 * Base class for Edit controls.
 *
 * It allows to enter text in a single-line.
 * The Edit control only accepts plain text. All HTML tags are stripped.
 *
 */
class CustomEdit extends FocusControl
{
        protected $_onclick = null;
        protected $_ondblclick = null;
        protected $_onsubmit=null;

        protected $_jsonselect=null;

        protected $_borderstyle=bsSingle;
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_charcase=ecNormal;
        protected $_ispassword = 0;
        protected $_maxlength=0;
        protected $_taborder=0;
        protected $_tabstop=1;
        protected $_text="";
        protected $_readonly=0;

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




        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 121;
                $this->Height = 21;
                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function loaded()
        {
                parent::loaded();
                // use writeDataSource() since setDataSource() might be implemented in the sub-component
                $this->writeDataSource($this->_datasource);
        }

        function preinit()
        {
                //If there is something posted
                $this->input->disable=!$this->_filterinput;
                $submitted = $this->input->{$this->Name};
                if (!is_object($submitted)) $submitted = $this->input->{$this->Name.'_hidden'};
                $this->input->disable=false;
                if (is_object($submitted))
                {
                        //Get the value and set the text field
                        $this->_text = $submitted->asString();

                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_text);
                }
        }

        function init()
        {
                parent::init();

                $this->input->disable=!$this->_filterinput;
                $submitted = $this->input->{$this->Name};
                if (!is_object($submitted)) $submitted = $this->input->{$this->Name.'_hidden'};
                $this->input->disable=false;

                // Allow the OnSubmit event to be fired because it is not
                // a mouse or keyboard event.
                if ($this->_onsubmit != null && is_object($submitted))
                {
                        $this->callEvent('onsubmit', array());
                }

                $submitEvent = $this->input->{$this->readJSWrapperHiddenFieldName()};

                if (is_object($submitEvent) && $this->_enabled == 1)
                {
                        // check if the a click event has been fired
                        if ($this->_onclick != null && $submitEvent->asString() == $this->readJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                        // check if the a double-click event has been fired
                        if ($this->_ondblclick != null && $submitEvent->asString() == $this->readJSWrapperSubmitEventValue($this->_ondblclick))
                        {
                                $this->callEvent('ondblclick', array());
                        }
                }
        }

        /**
        * Get the common HTML tag attributes of a Edit control.
        *
        * This is an internal method used to create the input control.
        *
        * @return string Returns a string with the attributes.
        */
        protected function getCommonAttributes()
        {
                $events = "";
                if ($this->_enabled == 1)
                {
                        // get the string for the JS Events
                        $events = $this->readJsEvents();

                        // add the OnSelect JS-Event
                        if ($this->_jsonselect != null)
                        {
                                $events .= " onselect=\"return $this->_jsonselect(event)\" ";
                        }

                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                        $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");
                }

                // set enabled/disabled status
                $disabled = (!$this->_enabled) ? "disabled" : "";

                // set maxlength if bigger than 0
                $maxlength = ($this->_maxlength > 0) ? "maxlength=$this->_maxlength" : "";

                // set readonly attribute if true
                $readonly = ($this->_readonly == 1) ? "readonly" : "";

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                return "$disabled $maxlength $readonly $taborder $hint $events $class";
        }

        /**
        * Get the common styles of a Edit control.
        *
        * This is an internal function used to build the style for the field.
        *
        * @return string Returns a string with the common styles. It is not wrapped
        *                in the style="" attribute.
        */
        protected function getCommonStyles()
        {
                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;

                        // set the no border style
                        if ($this->_borderstyle == bsNone)
                        {
                                $style .= "border-width: 0px; border-style: none;";
                        }

                        if ($this->Color != "")
                        {
                                $style .= "background-color: " . $this->Color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }

                        // set the char case if not normal
                        if ($this->_charcase != ecNormal)
                        {
                                if ($this->_charcase == ecLowerCase)
                                {
                                        $style .= "text-transform: lowercase;";
                                }
                                else if ($this->_charcase == ecUpperCase)
                                {
                                        $style .= "text-transform: uppercase;";
                                }
                        }
                }

                $h = $this->Height - 1;
                $w = $this->Width;

                $style .= "height:" . $h . "px;width:" . $w . "px;";

                return $style;
        }

        function dumpContents()
        {
                // set type depending on $_ispassword
                $type = ($this->_ispassword) ? 'password' : 'text';

                $attributes = $this->getCommonAttributes();
                $style = $this->getCommonStyles();

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }


                if ($style != "")  $style = "style=\"$style\"";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //The value to show on the field is the one from the table
                                $this->_text = $this->readDataFieldValue();

                                //Dumps hidden fields to know which is the record to update
                                $this->dumpHiddenKeyFields();
                        }
                }

                // call the OnShow event if assigned so the Text property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                $avalue=$this->_text;
                $avalue=str_replace('"','&quot;',$avalue);
                echo "<input type=\"$type\" id=\"$this->_name\" onchange=\"return {$this->Name}_updatehidden(event)\" name=\"$this->_name\" value=\"$avalue\" $style $attributes />";


        }

        function dumpFormItems()
        {
                // add a hidden field so we can determine which event for the edit was fired
                if ($this->_onclick != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }

        		echo "<input type=\"hidden\" name=\"{$this->Name}_hidden\" value=\"$this->_text\">";
        }

        /*
        * Write the Javascript section to the header
        */
        function dumpJavascript()
        {
        ?>
        	function <?php echo $this->Name; ?>_updatehidden(event)
            {
            	edit=findObj('<?php echo $this->Name; ?>');
                hidden=findObj('<?php echo $this->Name; ?>_hidden');
                hidden.value=edit.value;
                <?php
                	if ($this->_jsonchange!='') echo "return(".$this->_jsonchange."(event));\n";
                ?>
            }
        <?php
                parent::dumpJavascript();

                if ($this->_enabled == 1)
                {
                        if ($this->_onclick != null && !defined($this->_onclick))
                        {
                                // only output the same function once;
                                // otherwise if for example two edits use the same
                                // OnClick event handler it would be outputted twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }

                        if ($this->_ondblclick != null && !defined($this->_ondblclick))
                        {
                                $def=$this->_ondblclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_ondblclick);
                        }

                        if ($this->_jsonselect != null)
                        {
                                $this->dumpJSEvent($this->_jsonselect);
                        }
                }
        }



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
        function readOnClick()
        {
                return $this->_onclick;
        }
        /**
        * Occurs when the user clicks the control.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnClick($value)
        {
                $this->_onclick = $value;
        }
        function defaultOnClick()
        {
                return null;
        }

        /**
        * Occurs when the user double-clicks the control.
        *
        * Use this event to react when the user double click on the control, this event
        * is usually fired after a set of other events, like mousedown and mouseup
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnDblClick()
        {
                return $this->_ondblclick;
        }
        /**
        * Occurs when the user double-clicks the control.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnDblClick($value)
        {
                $this->_ondblclick = $value;
        }
        function defaultOnDblClick()
        {
                return null;
        }

        /**
        * Occurs when the form containing the control was submitted.
        *
        * This event is fired when the form is submitted and the control is about
        * to update itself with the information and changes made by the user in the
        * browser
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnSubmit() { return $this->_onsubmit; }
        function writeOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }


        /**
        * JS Event occurs when text in the control was selected.
        *
        * Use this event to provide custom behavior with then text in the control
        * is selected
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readjsOnSelect() { return $this->_jsonselect; }
        function writejsOnSelect($value) { $this->_jsonselect=$value; }
        function defaultjsOnSelect() { return null; }


        /**
        * Determines whether the edit control has a single line border around the
        * client area.
        *
        * Use this property to specify which kind of border the control is going to
        * use. Controls can have a single border (1 pixel wide) or none.
        *
        * @return enum (bsNone, bsSingle)
        */
        function readBorderStyle() { return $this->_borderstyle; }
        function writeBorderStyle($value) { $this->_borderstyle=$value; }
        function defaultBorderStyle() { return bsSingle; }

        /**
        * DataField is the fieldname to be attached to the control.
        *
        * This property allows you to show/edit information from a table column
        * using this control. To make it work, you must also assign the Datasource
        * property, which specifies the dataset that contain the fieldname to work on
        *
        * @return string
        */
        function readDataField() { return $this->_datafield; }
        /**
        * DataField indicates which field of the DataSource is used to fill in
        * the Text.
        */
        function writeDataField($value) { $this->_datafield = $value; }
        function defaultDataField() { return ""; }

        /**
        * DataSource property allows you to link this control to a dataset containing
        * rows of data.
        *
        * To make it work, you must also assign DataField property with
        * the name of the column you want to use
        *
        * @return Datasource
        */
        function readDataSource() { return $this->_datasource; }
        function writeDataSource($value)
        {
                $this->_datasource = $this->fixupProperty($value);
        }
        function defaultDataSource() { return null; }

        /**
        * Determines the case of the text within the edit control.
        * Note: When CharCase is set to ecLowerCase or ecUpperCase,
        *       the case of characters is converted as the user types them
        *       into the edit control. Changing the CharCase property to
        *       ecLowerCase or ecUpperCase changes the actual contents
        *       of the text, not just the appearance. Any case information
        *       is lost and can’t be recaptured by changing CharCase to ecNormal.
        * @return enum (ecLowerCase, ecNormal, ecUpperCase)
        */
        function readCharCase() { return $this->_charcase; }
        function writeCharCase($value)
        {
                $this->_charcase=$value;
                if ($this->_charcase == ecUpperCase)
                {
                        $this->_text = strtoupper($this->_text);
                }
                else if ($this->_charcase == ecLowerCase)
                {
                        $this->_text = strtolower($this->_text);
                }
        }
        function defaultCharCase() { return ecNormal; }

        /**
        * If IsPassword is true then all characters are displayed with a password
        * character defined by the browser.
        * Note: The text is still in readable text in the HTML page!
        * @return bool
        */
        function readIsPassword() { return $this->_ispassword; }
        function writeIsPassword($value) { $this->_ispassword = $value; }
        function defaultIsPassword() { return 0; }

        /**
        * Specifies the maximum number of characters the user can enter into
        * the edit control.
        *
        * A value of 0 indicates that there is no application-defined limit on the length.
        *
        * @return integer
        */
        function readMaxLength() { return $this->_maxlength; }
        function writeMaxLength($value) { $this->_maxlength=$value; }
        function defaultMaxLength() { return 0; }

        /**
        * Set the control to read-only mode. That way the user cannot enter
        * or change the text of the edit control.
        * @return bool
        */
        function readReadOnly() { return $this->_readonly; }
        function writeReadOnly($value) { $this->_readonly=$value; }
        function defaultReadOnly() { return 0; }

        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @return integer
        */
        function readTabOrder() { return $this->_taborder; }
        function writeTabOrder($value) { $this->_taborder=$value; }
        function defaultTabOrder() { return 0; }

        /**
        * Enable or disable the TabOrder property.
        *
        * The browser may still assign a TabOrder by itself internally.
        * This cannot be controlled by HTML.
        *
        * @return bool
        */
        function readTabStop() { return $this->_tabstop; }
        function writeTabStop($value) { $this->_tabstop=$value; }
        function defaultTabStop() { return 1; }

        /**
        * Contains the text string associated with the control.
        *
        * Use this property to specify the text the control is going to
        * store and show.
        *
        * @return string
        */
        function readText() { return $this->_text; }
        function writeText($value)
        {
                $this->_text=$value;
                //Forces case
                $this->CharCase=$this->_charcase;
        }
        function defaultText() { return ""; }

}

/**
 * Use an Edit object to put a standard HTML edit control on a form. Edit controls
 * are used to retrieve text that users type. Edit controls can also display text to the user.
 * When only displaying text to the user, choose an edit control to allow users to select
 * text and copy it to the Clipboard. Choose a label object if the selection capabilities
 * of an edit control are not needed.
 * Edit implements the generic behavior introduced in CustomEdit. Edit publishes
 * many of the properties inherited from TCustomEdit, but does not introduce any
 * new behavior. For specialized edit controls, use other descendant classes of CustomEdit
 * or derive from it.
 */
class Edit extends CustomEdit
{
        /*
        * Publish the events for the Edit component
        */
        function getOnClick                     () { return $this->readOnClick(); }
        function setOnClick                     ($value) { $this->writeOnClick($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

    function getjsOnDragOver() { return $this->readjsondragover(); }
    function setjsOnDragOver($value) { $this->writejsondragover($value); }

    function getjsOnDragStart() { return $this->readjsondragstart(); }
    function setjsOnDragStart($value) { $this->writejsondragstart($value); }



        /*
        * Publish the JS events for the Edit component
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
        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
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

        function getCharCase()
        {
                return $this->readCharCase();
        }
        function setCharCase($value)
        {
                $this->writeCharCase($value);
        }

        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getIsPassword()
        {
                return $this->readIsPassword();
        }
        function setIsPassword($value)
        {
                $this->writeIsPassword($value);
        }

        function getMaxLength()
        {
                return $this->readMaxLength();
        }
        function setMaxLength($value)
        {
                $this->writeMaxLength($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getReadOnly()
        {
                return $this->readReadOnly();
        }
        function setReadOnly($value)
        {
                $this->writeReadOnly($value);
        }

        function getShowHint()
        {
                return $this->readShowHint();
        }
        function setShowHint($value)
        {
                $this->writeShowHint($value);
        }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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

        function getText()
        {
                return($this->readText());
        }
        function setText($value)
        {
                $this->writeText($value);
        }

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
 * CustomMemo is the base class for memo components, which are multiline edit boxes,
 * including Memo.
 *
 * It is inherited from CustomEdit and introduces following new properties:
 * Lines, LineSeparator, Text and WordWrap
 *
 */
class CustomMemo extends CustomEdit
{
        public $_lines = array();
        // The $_lineseparator variable should always be double quoted!!!
        protected $_lineseparator = "\n";
        protected $_wordwrap = 1;
        // The richeditor property is here since it is used in the loaded() function.
        // loaded() needs to know how to treat the input data.
        // Note: Do not publish this variable!
        protected $_richeditor = 0;
        protected $_asspecialchars = 0;

        /**
        * If true, this property makes the memo to process text as special chars.
        *
        * @return boolean
        */
        function getAsSpecialChars() { return $this->_asspecialchars; }
        function setAsSpecialChars($value) { $this->_asspecialchars=$value; }
        function defaultAsSpecialChars() { return 0; }

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



        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 185;
                $this->Height = 89;
        }

        function preinit()
        {
                //If there is something posted
                $this->input->disable=!$this->_filterinput;
                $submitted = $this->input->{$this->Name};
                $this->input->disable=false;
                if (is_object($submitted))
                {
                        // Escape the posted string if sent from a richeditor;
                        // otherwise all tags are stripped and plain text is written to Text
                        if ($this->_asspecialchars)
                        {
                            $this->Text = ($this->_richeditor) ? $submitted->asSpecialChars() : $submitted->asString();
                        }
                        else
                        {
                            $this->Text = $submitted->asUnsafeRaw();
                        }

                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->Text);
                }
        }

        function dumpContents()
        {
                // get the common attributes from the CustomEdit
                $attributes = $this->getCommonAttributes();

                // add the word wrap attribute if set
                $attributes .= ($this->_wordwrap == 1) ? " wrap=\"virtual\"" : " wrap=\"off\"";

                // maxlength has to be check with some JS; it's not supported by HTML 4.0
                if ($this->_enabled && $this->_maxlength > 0)
                {
                        if ($this->_jsonkeyup != null)
                        {
                                $attributes = str_replace("onkeyup=\"return $this->_jsonkeyup(event)\"",
                                                  "onkeyup=\"return checkMaxLength(this, event, $this->_jsonkeyup)\"",
                                                  $attributes);
                        }
                        else
                        {
                                $attributes .= " onkeyup=\"return checkMaxLength(this, event, null)\"";
                        }
                }

                // get the common styles from the CustomEdit
                $style = $this->getCommonStyles();

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }

                if ($style != "")  $style = "style=\"$style\"";

                // if a datasource is set then get the data from there
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //The value to show on the field is the one from the table
                                $this->Text = $this->readDataFieldValue();
                                //Dumps hidden fields to know which is the record to update
                                $this->dumpHiddenKeyFields();
                        }
                }

                // call the OnShow event if assigned so the Lines property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                $lines = $this->Text;

                echo "<textarea id=\"$this->_name\" name=\"$this->_name\" $style $attributes>$lines</textarea>";


        }

        function dumpFormItems()
        {
                // add a hidden field so we can determine which event for the memo was fired
                if ($this->_onclick != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }
        }

        function writeCharCase($value)
        {
            parent::writeCharCase($value);
            $this->updateLinesCase();
        }

        /**
        * This method updates the text of the component according to the case property
        *
        * This is an internal method is called when the text must be updated to
        * the case property
        *
        */
        function updateLinesCase()
        {
          $this->writeText($this->readText());
        }

        function dumpJavascript()
        {
                parent::dumpJavascript();

                // only add this function once
                if (!defined('checkMaxLength') && $this->_enabled && $this->_maxlength > 0)
                {
                        define('checkMaxLength', 1);

                        echo "
function checkMaxLength(obj, event, onKeyUpFunc){
  var maxlength = obj.getAttribute ? parseInt(obj.getAttribute(\"maxlength\")) : \"\";
  if (obj.getAttribute && obj.value.length > maxlength)
    obj.value = obj.value.substring(0, maxlength);
  if (onKeyUpFunc != null)
    onKeyUpFunc(event);
}
";
                }
        }

        /**
        * Add a new line to the Memo. Calls AddLine().
        * @param $line string The content of the new line.
        * @return integer Returns the number of lines defined.
        */
        function Add($line)
        {
                return $this->AddLine($line);
        }
        /**
        * Add a new line to the Memo
        * @param $line string The content of the new line.
        * @return integer Returns the number of lines defined.
        */
        function AddLine($line)
        {
                if ($this->CharCase==ecLowerCase) $line=strtolower($line);
                else if ($this->CharCase==ecUpperCase) $line=strtoupper($line);

                end($this->_lines);
                $this->_lines[] = $line;
                return count($this->_lines);
        }

        /**
        * Deletes all text (lines) from the memo control.
        */
        function Clear()
        {
                $this->Lines = array();
        }

        /**
        * Converts the text of the Lines property into way which can be used
        * in the HTML output.
        * Please have a look at the PHP function nl2br.
        * @return string Returns the Text property with '<br />'
        *                inserted before all newlines.
        */
        function LinesAsHTML()
        {
                return nl2br($this->Text);
        }

        /**
        * LineSeparator is used in the Text property to convert a string into
        * an array and back.
        * Note: Escaped character need to be in a double-quoted string.
        *       e.g. "\n"
        *       See <a href="http://www.php.net/manual/en/language.types.string.php">http://www.php.net/manual/en/language.types.string.php</a>
        * @link http://www.php.net/manual/en/language.types.string.php
        * @return string
        */
        function readLineSeparator() { return $this->_lineseparator; }
        function writeLineSeparator($value) { $this->_lineseparator = $value; }

        /**
        * Contains the individual lines of text in the memo control.
        * Lines is an array, so the PHP array manipulation functions may be used.
        *
        * Note: Do not manipulate the Lines property like this:
        *       $this->Memo1->Lines[] = "add new line";
        *       Various versions of PHP implement the behavior of this differently.
        *       Use following code:
        *       $lines = $this->Memo1->Lines;
        *       $lines[] = "new line";          // more lines may be added
        *       $this->Memo1->Lines = $lines;
        * @return array
        */
        function readLines()
        {
        return($this->_lines);
        }
        function writeLines($value)
        {
                if (is_array($value))
                {
                        $this->_lines = $value;
                }
                else
                {
                        $this->_lines = (empty($value)) ? array() : array($value);
                }
                $this->updateLinesCase();
        }
        function defaultLines() { return array(); }

        /**
        * Text property allows read and write the contents of Lines in a string
        * separated by LineSeparator.
        * @return string
        */
        function readText()
        {
                return(implode($this->_lineseparator, $this->getLines()));
        }
        function writeText($value)
        {
                if (empty($value))
                {
                        $this->Clear();
                }
                else
                {
                      if ($this->CharCase==ecLowerCase) $value=strtolower($value);
                      else if ($this->CharCase==ecUpperCase) $value=strtoupper($value);


                        $lines = explode("$this->_lineseparator", $value);

                        if (is_array($lines))
                        {
                                $this->_lines=$lines;
                        }
                        else
                        {
                                $this->_lines=array($value);
                        }

                }
        }

        /**
        * Determines whether the edit control inserts soft carriage returns
        * so text wraps at the right margin.
        * Note: This may work with the browsers Firefox and Internet Explorer only.
        * @return bool
        */
        function readWordWrap() { return $this->_wordwrap; }
        function writeWordWrap($value) { $this->_wordwrap=$value; }
        function defaultWordWrap() { return 1; }
}


/**
 * Memo is a wrapper for an HTML multiline edit control.
 *
 * Memo publishes many of the properties inherited from CustomMemo,
 * but does not introduce any new behavior. For specialized memo controls,
 * use other descendant classes of CustomMemo (e.g. RichEdit) or derive from it.
 */
class Memo extends CustomMemo
{
        /*
        * Publish the events for the Memo component
        */
        function getOnClick                     () { return $this->readOnClick(); }
        function setOnClick                     ($value) { $this->writeOnClick($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the Memo component
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
        * Publish the properties for the Memo component
        */
        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
        }

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

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

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
                return($this->readLines());
        }
        function setLines($value)
        {
                $this->writeLines($value);
        }

        function getMaxLength()
        {
                return $this->readMaxLength();
        }
        function setMaxLength($value)
        {
                $this->writeMaxLength($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getReadOnly()
        {
                return $this->readReadOnly();
        }
        function setReadOnly($value)
        {
                $this->writeReadOnly($value);
        }

        function getShowHint()
        {
                return $this->readShowHint();
        }
        function setShowHint($value)
        {
                $this->writeShowHint($value);
        }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }

        function getWordWrap()
        {
                return $this->readWordWrap();
        }
        function setWordWrap($value)
        {
                $this->writeWordWrap($value);
        }
}

/**
 * Base class for Listbox controls, such as ListBox and ComboBox.
 *
 * ListBox displays a collection of items in a scrollable list.
 *
 */
class CustomListBox extends CustomMultiSelectListControl
{
        public $_items = array();
        protected $_selitems = array();

        protected $_onchange = null;
        protected $_onclick = null;
        protected $_ondblclick = null;
        protected $_onsubmit = null;

        protected $_borderstyle = bsSingle;
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_size = 4;
        protected $_sorted = 0;
        protected $_taborder=0;
        protected $_tabstop=1;

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

                $this->writeDataSource($this->_datasource);
        }

        function preinit()
        {
                $submitted = $this->input->{$this->Name};

                if (is_object($submitted))
                {
                        $this->ClearSelection();
                        if ($this->_multiselect == 1)
                        {
                                $this->_selitems = $submitted->asStringArray();
                        }
                        else
                        {
                                $changed = ($this->_itemindex != $submitted->asString());
                                // the ItemIndex might be an integer or a string,
                                // so let's get a string
                                $this->_itemindex = $submitted->asString();

                                // only update the data field if the item index was changed
                                if ($changed)
                                {
                                        // following somehow does not work here:
                                        //   if (array_key_exists($this->_itemindex, $this->_items)) { $this->updateDataField($this->_items[$this->_itemindex]); }
                                        // so let's do it like this...
                                        foreach ($this->_items as $key => $item)
                                        {
                                                if ($key == $this->_itemindex)
                                                {
                                                        //If there is any valid DataField attached, update it
                                                        $this->updateDataField($item);
                                                }
                                        }
                                }
                        }
                }
        }

        function init()
        {
                parent::init();

                $submitted = $this->input->{$this->Name};

                // Allow the OnSubmit event to be fired because it is not
                // a mouse or keyboard event.
                if (is_object($submitted))
                {
                        if ($this->_onsubmit != null)
                        {
                                $this->callEvent('onsubmit', array());
                        }
                }

                $submitEvent = $this->input->{$this->readJSWrapperHiddenFieldName()};

                if (is_object($submitEvent) && $this->_enabled == 1)
                {
                        // check if the a click event has been fired
                        if ($this->_onclick != null && $submitEvent->asString() == $this->readJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                        // check if the a double-click event has been fired
                        if ($this->_ondblclick != null && $submitEvent->asString() == $this->readJSWrapperSubmitEventValue($this->_ondblclick))
                        {
                                $this->callEvent('ondblclick', array());
                        }
                        // check if the a change event has been fired
                        if ($this->_onchange != null && $submitEvent->asString() == $this->readJSWrapperSubmitEventValue($this->_onchange))
                        {
                                $this->callEvent('onchange', array());
                        }
                }
        }


        function dumpContents()
        {
                $events = "";
                if ($this->_enabled == 1)
                {
                        // get the string for the JS Events
                        $events = $this->readJsEvents();

                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                        $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");
                        $this->addJSWrapperToEvents($events, $this->_onchange,   $this->_jsonchange,   "onchange");
                }

                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;

                        // set the no border style
                        if ($this->_borderstyle == bsNone)
                        {
                                $style .= "border-width: 0px; border-style: none;";
                        }

                        if ($this->Color != "")
                        {
                                $style .= "background-color: " . $this->Color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                // set enabled/disabled status
                $enabled = (!$this->_enabled) ? "disabled=\"disabled\"" : "";

                // multi-select
                $multiselect = ($this->_multiselect == 1) ? "multiple=\"multiple\"" : "";
                // if multi-select then the name needs to have [] to indicate it will send an array
                $name = ($this->_multiselect == 1) ? "$this->_name[]" : $this->_name;

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();


                $h = $this->Height - 2;
                $w = $this->Width;

                $style .= "height:" . $h . "px;width:" . $w . "px;";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }


                if ($style != "")  $style = "style=\"$style\"";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //check if the value of the current data-field is in the itmes array as value
                                $val = $this->readDataFieldValue();
                                // get the corresponding key to the value read from the data source
                                if (($key = array_search($val, $this->_items)) !== FALSE)
                                {
                                        // if an item was found the overwrite the itemindex
                                        $this->_itemindex = $key;
                                }

                                //Dumps hidden fields to know which is the record to update
                                $this->dumpHiddenKeyFields();
                        }
                }

                // call the OnShow event if assigned so the Items property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }


                echo "<select name=\"$name\" id=\"$name\" size=\"$this->_size\" $style $enabled $multiselect $taborder $hint $events $class>";
                if (is_array($this->_items))
                {
                        reset($this->_items);
                        foreach ($this->_items as $key => $item)
                        {
                                $selected = "";
                                if ($key == $this->_itemindex || ($this->_multiselect == true && in_array($key, $this->_selitems)))
                                {
                                        $selected = " selected";
                                }
                                //htmlentities removed due RAID #253282
                                $item=str_replace('<','&lt;',$item);
                                $item=str_replace('>','&gt;',$item);
                                echo "<option value=\"$key\"$selected>$item</option>";
                        }
                }
                echo "</select>";


        }

        function dumpFormItems()
        {
                // add a hidden field so we can determine which listbox fired the event
                if ($this->_onclick != null || $this->_onchange != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }
        }

        /*
        * Write the Javascript section to the header
        */
        function dumpJavascript()
        {
                parent::dumpJavascript();

                if ($this->_enabled == 1)
                {
                        if ($this->_onclick != null && !defined($this->_onclick))
                        {
                                // only output the same function once;
                                // otherwise if for example two buttons use the same
                                // OnClick event handler it would be outputted twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }
                        if ($this->_ondblclick != null && !defined($this->_ondblclick))
                        {
                                $def=$this->_ondblclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_ondblclick);
                        }
                        if ($this->_onchange != null && !defined($this->_onchange))
                        {
                                $def=$this->_onchange;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onchange);
                        }
                }
        }


        /**
        * Returns the number of items stored in the object
        *
        * Use this property to get the number of items the control stores, use
        * addItem() to add new items to the control and clear() to remove all of
        * them.
        *
        * @return integer
        */
        function readCount()
        {
                return count($this->_items);
        }

        /**
        * Specify which item is selected on the list
        *
        * Use this property to get/set the index of the item in the
        * control that is selected. Use it at design-time to specify the
        * default item selection and use it in run-time to get the
        * user selection.
        *
        * @return integer
        */
        function readItemIndex()
        {
                // Return the first item of the selitems only if
                // the itemindex is -1 and multiselect is enabled and there
                // are some values selected.
                if ($this->_itemindex == -1 && $this->_multiselect == 1 && $this->SelCount > 0)
                {
                        reset($this->_selitems);
                        return key($this->_selitems);
                }
                else
                {
                        return $this->_itemindex;
                }
        }
        function writeItemIndex($value)
        {
                $this->_itemindex = $value;
                // if multi-select then also add it to the selected array
                if ($this->_multiselect == 1)
                {
                        $this->writeSelected($value, true);
                }
        }
        function defaultItemIndex()
        {
                return -1;
        }

        /**
        * Adds an item to the listbox
        *
        * Use this method to add an item to the listbox, items can contain
        * object pointers and also specify the key of the item in the items array.
        *
        * @param string $item Caption of the item to add
        * @param object $object Object to add
        * @param string $itemkey Key of the item in the items array
        *
        * @return integer Number of items in the control
        */
        function AddItem($item, $object = null, $itemkey = null)
        {
                if ($object != null)
                {
                        throw new Exception('Object functionallity for ListBox is not yet implemented.');
                }

                //Set the array to the end
                end($this->_items);

                //Adds the item as the last one
                if ($itemkey != null)
                {
                        $this->_items[$itemkey] = $item;
                }
                else
                {
                        $this->_items[] = $item;
                }

                if ($this->_sorted == 1)
                {
                        $this->sortItems();
                }

                return($this->Count);
        }

        /**
        * This method clear listbox
        *
        * Use this method to clear the items in the listbox and also clear
        * the items selected.
        *
        */
        function Clear()
        {
                $this->_items = array();
                $this->_selitems = array();
        }

        /**
        * Clears selected items in the listbox
        *
        * Use this method when you want to reset the selection of items in the
        * listbox. If multiselection is enabled, all selected items become unselected.
        *
        */
        function ClearSelection()
        {
                if ($this->_multiselect == 1)
                {
                        $this->_selitems = array();
                }
                $this->_itemindex = -1;
        }

        /**
        * Select all items in the control
        *
        * Use this method to include all items in the control as selected.
        * To make it work, MultiSelect property must be set to true.
        *
        */
        function SelectAll()
        {
                if ($this->_multiselect == 1)
                {
                        $this->_selitems = array_keys($this->_items);
                }
        }

        function readSelCount()
        {
                if ($this->_multiselect == 1)
                {
                        return count($this->_selitems);
                }
                else
                {
                        return ($this->_itemindex != -1) ? 1 : 0;
                }
        }
        /**
        * Determines whether the user can select more than one element at a time.
        *
        * Use this property to allow the user to select several items at once.
        *
        * <code>
        * <?php
        *       function Button1Click($sender, $params)
        *       {
        *                echo "Number of selected items:".$this->ListBox1->SelCount."<br>";
        *
        *                $items=$this->ListBox1->Items;
        *
        *                reset($items);
        *                while(list($key, $val)=each($items))
        *                {
        *                        if ($this->ListBox1->readSelected($key))
        *                        {
        *                                echo "Item selected: $key => $val<br>";
        *                        }
        *                }
        *       }
        * ?>
        * </code>
        *
        * Note: MultiSelect does not work if a data source is assigned.
        *
        * @return bool
        */
        function readMultiSelect()
        {
                return $this->_multiselect;
        }
        function writeMultiSelect($value)
        {
                if ($this->_multiselect == 1 && $value == false)
                {
                        $this->ClearSelection();
                }
                $this->_multiselect = $value;

                if ($this->_multiselect == 1)
                {
                        // unset data source if multi select is enabled
                        $this->writeDataSource(null);
                }
        }
        function defaultMultiSelect()
        {
                return 0;
        }
        /*
        * </Implementation of functions from super-class>
        */

        /**
        * Checks if $index is selected.
        * @param mixed $index Index to be checked.
        * @return bool Returns true if $index is selected.
        */
        function readSelected($index)
        {
                if ($this->_multiselect)
                {
                        return in_array($index, $this->_selitems);
                }
                else
                {
                        return $index == $this->_itemindex;
                }
        }
        /**
        * Select or unselect a specific item.
        * @param mixed $index Key or index of the item to select.
        * @param bool $value True if selected, otherwise false.
        */
        function writeSelected($index, $value)
        {
                if ($this->_multiselect == 1)
                {
                        // add it to the selitems
                        if ($value)
                        {
                                // if the index does not already exist
                                if (!in_array($index, $this->_selitems))
                                {
                                        $this->_selitems[] = $index;
                                }
                        }
                        // remove the index from the selitems
                        else
                        {
                                $this->_selitems = array_diff($this->_selitems, array($index));
                        }
                }
                else
                {
                        $this->_itemindex = ($value) ? $index : -1;
                }
        }

        /**
        * Sort the items array.
        */
        private function sortItems()
        {
                // keep the keys when sorting the array (sort does not keep the keys)
                asort($this->_items);
        }



        /**
        * Occurs when the user changed the item of the control.
        *
        * This event is fired when the contents are committed and not while the
        * value is changing. For example, on a text box, this event is not fired
        * while the user is typing, but rather when the user commits the change
        * by leaving the text box that has focus. In addition, this event is
        * executed before the code specified by onblur when the control is also
        * losing the focus.
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnChange() { return $this->_onchange; }
        function writeOnChange($value) { $this->_onchange = $value; }
        function defaultOnChange() { return null; }

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
        function readOnClick() { return $this->_onclick; }
        /**
        * Occurs when the user clicks the control.
        * @param mixed Event handler or null if no handler is set.
        */
        function writeOnClick($value) { $this->_onclick = $value; }
        function defaultOnClick() { return null; }

        /**
        * Occurs when the user double-clicks the control.
        *
        * Use this event to react when the user double click on the control, this event
        * is usually fired after a set of other events, like mousedown and mouseup
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnDblClick() { return $this->_ondblclick; }
        /**
        * Occurs when the user double clicks the control.
        * @param mixed $value Event handler or null if no handler is set.
        */
        function writeOnDblClick($value) { $this->_ondblclick = $value; }
        function defaultOnDblClick() { return null; }

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
        * Determines whether the listbox control has a single line border around the client area.
        *
        * Use this property to specify which kind of border the control is going to
        * use. Controls can have a single border (1 pixel wide) or none.
        *
        * @return enum (bsNone, bsSingle)
        */
        function readBorderStyle() { return $this->_borderstyle; }
        function writeBorderStyle($value) { $this->_borderstyle=$value; }
        function defaultBorderStyle() { return bsSingle; }

        /**
        * DataField is the fieldname to be attached to the control.
        *
        * This property allows you to show/edit information from a table column
        * using this control. To make it work, you must also assign the Datasource
        * property, which specifies the dataset that contain the fieldname to work on
        *
        * @return string
        */
        function readDataField() { return $this->_datafield; }
        function writeDataField($value) { $this->_datafield = $value; }
        function defaultDataField() { return ""; }

        /**
        * DataSource property allows you to link this control to a dataset containing
        * rows of data.
        *
        * To make it work, you must also assign DataField property with
        * the name of the column you want to use
        *
        * @return Datasource
        */
        function readDataSource() { return $this->_datasource; }
        /**
        * If a data source is assigned multi-select cannot be used.
        */
        function writeDataSource($value)
        {
                $this->_datasource = $this->fixupProperty($value);
                // if a data source is assigned then the list box can not be multi-select
                if ($value != null)
                {
                        $this->MultiSelect = 0;
                }
        }
        function defaultDataSource() { return null; }

        /**
        * Contains the strings that appear in the list box.
        *
        * Use this property to set the items that will be shown on the listbox
        * where each item has a key and a value.
        *
        * <code>
        * <?php
        *      function ListBox1BeforeShow($sender, $params)
        *      {
        *               $items=array();
        *
        *               $items['key1']='value1';
        *               $items['key2']='value2';
        *
        *               $this->ListBox1->Items=$items;
        *      }
        * ?>
        * </code>
        * @return array
        */
        function readItems() { return $this->_items; }
        function writeItems($value)
        {
                if (is_array($value))
                {
                        //This must be done this way because report SourceForge #1804137
                        //Keys from serialized arrays from the IDE are strings, if are numeric
                        //PHP is not able to find them
                        $this->_items=array();
                        reset($value);
                        while(list($key, $val)=each($value))
                        {
                                $this->_items[$key]=$val;
                        }
                }
                else
                {
                        $this->_items = (empty($value)) ? array() : array($value);
                }

                // sort the items
                if ($this->_sorted == 1)
                {
                        $this->sortItems();
                }
        }
        function defaultItems() { return array(); }

        /**
        * Size of the listbox. Size defines the number of items that are shown
        * without a need of scrolling.
        * If bigger than 1 most browsers will use Height instead. If Size equals 1
        * the listbox truns into a combobox.
        * @return integer
        */
        function readSize() { return $this->_size; }
        function writeSize($value) { $this->_size=$value; }
        function defaultSize() { return 4; }

        /**
        * Specifies whether the items in the control are arranged alphabetically.
        *
        * If this property is set, items in the control will be sorted alphabetically
        * according to the values of the items, not the keys.
        *
        * @return bool
        */
        function readSorted() { return $this->_sorted; }
        function writeSorted($value)
        {
                $this->_sorted=$value;
                if ($this->_sorted == 1)
                {
                        $this->sortItems();
                }
        }
        function defaultSorted() { return 0; }

        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @return integer
        */
        function readTabOrder() { return $this->_taborder; }
        function writeTabOrder($value) { $this->_taborder=$value; }
        function defaultTabOrder() { return 0; }

        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @return bool
        */
        function readTabStop() { return $this->_tabstop; }
        function writeTabStop($value) { $this->_tabstop=$value; }
        function defaultTabStop() { return 1; }

}


/**
 * ListBox displays a collection of items in a scrollable list.
 *
 * Use ListBox to display a scrollable list of items that users can select, add, or delete.
 * ListBox is a wrapper for the HTML listbox control. For specialized list boxes, use other
 * descendant classes of CustomListBox or derive your own class from CustomListBox.
 *
 * ListBox implements the generic behavior introduced in CustomListBox. ListBox publishes
 * many of the properties inherited from TCustomListBox, but does not introduce any new behavior.
 *
 * @example ListBox/listboxsample.php How to use ListBox control
 */
class ListBox extends CustomListBox
{
        /*
        * Publish the events
        */
        function getOnClick                     () { return $this->readOnClick(); }
        function setOnClick                     ($value) { $this->writeOnClick($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events
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


        /*
        * Publish the properties for the Label component
        */

        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
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

        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getMultiSelect()
        {
                return $this->readMultiSelect();
        }
        function setMultiSelect($value)
        {
                $this->writeMultiSelect($value);
        }

        function getItems()
        {
                return $this->readItems();
        }
        function setItems($value)
        {
                $this->writeItems($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getSize()
        {
                return $this->readSize();
        }
        function setSize($value)
        {
                $this->writeSize($value);
        }

        function getSorted()
        {
                return $this->readSorted();
        }
        function setSorted($value)
        {
                $this->writeSorted($value);
        }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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
 * A class to encapsulate a combobox control.
 *
 * Note: It is directly subclassed from CustomListBox since they are almost
 *       identical in HTML. The only differentce is that no MultiSelect is
 *       possible.
 *
 */
class ComboBox extends CustomListBox
{
        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                // size is always 1 to render a ComboBox in the browser
                $this->_size = 1;
                // no MultiSelect possible
                $this->_multiselect = 0;

                $this->Width = 185;
                $this->Height = 18;
        }

        // Override the parent MultiSelect related functions; no MultiSelect possible.
        function readSelCount()
        {
                // only one or zero items can be selected
                return ($this->_itemindex != -1) ? 1 : 0;
        }

        function readMultiSelect()
        {
                // always return false since MultiSelect can not be used with a ComboBox
                return 0;
        }
        function writeMultiSelect($value)
        {
                // do nothing; MultiSelect can not be used with a ComboBox
        }

        /*
        * Publish the events
        */
        function getOnChange                    () { return $this->readOnChange(); }
        function setOnChange                    ($value) { $this->writeOnChange($value); }

        function getOnDblClick                  () { return $this->readOnDblClick(); }
        function setOnDblClick                  ($value) { $this->writeOnDblClick($value); }

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        function getOnClick()                   { return $this->readOnClick(); }
        function setOnClick($value)             { $this->writeOnClick($value); }


        /*
        * Publish the JS events
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


        /*
        * Publish the properties for the Label component
        */

        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
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

        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getItems()
        {
                return $this->readItems();
        }
        function setItems($value)
        {
                $this->writeItems($value);
        }

        function getItemIndex()
        {
                return $this->readItemIndex();
        }
        function setItemIndex($value)
        {
                $this->writeItemIndex($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getSorted()
        {
                return $this->readSorted();
        }
        function setSorted($value)
        {
                $this->writeSorted($value);
        }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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
 * ButtonControl is a base class for push button controls.
 *
 * This class is used as a base for Button, CheckBox and RadioButton and provides
 * the standard properties, methods an events to easily create a multistate control
 *
 * @link http://www.w3.org/TR/html401/interact/forms.html#h-17.4.1
 *
 */
class ButtonControl extends FocusControl
{
        protected $_onclick = null;
        protected $_onsubmit = null;
        protected $_jsonselect = null;

        protected $_checked = 0;
        protected $_datasource = null;
        protected $_datafield = "";
        protected $_taborder = 0;
        protected $_tabstop = 1;

        // defines which property is set by the datasource
        protected $_datafieldproperty = 'Caption';


        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 75;
                $this->Height = 25;
                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        function loaded()
        {
                parent::loaded();
                $this->writeDataSource($this->_datasource);
        }

        function init()
        {
                $submitted = $this->input->{$this->Name};

                // Allow the OnSubmit event to be fired because it is not
                // a mouse or keyboard event.
                if ($this->_onsubmit != null && is_object($submitted))
                {
                        $this->callEvent('onsubmit', array());
                }

                $submitEventValue = $this->input->{$this->readJSWrapperHiddenFieldName()};

                if (is_object($submitEventValue) && $this->_enabled == 1)
                {
                        // check if the a click event of the current button
                        // has been fired
                        if ($this->_onclick != null && $submitEventValue->asString() == $this->readJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                }
        }

        /**
        * This function was introduced to be flexible with the sub-classed controls.
        * It takes all necessary info to dump the control.
        * @param string $inputType Input type such as submit, button, check, radio, etc..
        * @param string $name Name of the control
        * @param string $additionalAttributes String containing additional attributes that will be included in the <input ..> tag.
        * @param string $surroundingTags Tags that surround the <input ..> tag. Use %s to specify were the <input> tag should be placed.
        * @param bool $composite If true height and width will not be applied to the styles in this function,
        *                        they must be appied at the location where this fucntion is called.
        */
        function dumpContentsButtonControl($inputType, $name,
          $additionalAttributes = "", $surroundingTags = "%s", $composite = false)
        {
                $events = "";
                if ($this->_enabled == 1)
                {
                        // get the string for the JS Events
                        $events = $this->readJsEvents();

                        // add the OnSelect JS-Event
                        if ($this->_jsonselect != null)
                        {
                                $events .= " onselect=\"return $this->_jsonselect(event)\" ";
                        }

                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick, $this->_jsonclick, "onclick");
                }

                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;
                        if ($this->color != "")
                        {
                                $style .= "background-color: " . $this->color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                if (!$composite)
                {
                    if (!$this->_adjusttolayout)
                    {
                        $style .= "height:" . $this->Height . "px;width:" . $this->Width . "px;";
                    }
                    else
                    {
                        $style .= "height:100%;width:100%;";
                    }
                }

                // get the Caption of the button if it is data-aware
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                // depending on the sub-class there is another property to be set by the data-source (e.g. Button = Caption; CheckBox = Checked)
                                $this->{$this->_datafieldproperty} = $this->readDataFieldValue();

                                //Dumps hidden fields to know which is the record to update
                                $this->dumpHiddenKeyFields();
                        }
                }

                // set the checked status
                $checked = ($this->_checked) ? "checked=\"checked\"" : "";

                // set enabled/disabled status
                $enabled = (!$this->_enabled) ? "disabled=\"disabled\"" : "";

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }

                if ($style != "")  $style = "style=\"$style\"";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // call the OnShow event if assigned so the Caption property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                // assemble the input tag
                $avalue=$this->_caption;
                $avalue=str_replace('"','&quot;',$avalue);
                $input = "<input type=\"$inputType\" id=\"$name\" name=\"$name\" value=\"$avalue\" $events $style $checked $enabled $taborder $hint $additionalAttributes $class />";
                // output the control
                printf($surroundingTags, $input);

        }

        function dumpFormItems()
        {
                // add a hidden field so we can determine which button fired the OnClick event
                if ($this->_onclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }
        }

        /*
        * Write the Javascript section to the header
        */
        function dumpJavascript()
        {
                parent::dumpJavascript();

                if ($this->_enabled == 1)
                {
                        if ($this->_jsonselect != null)
                        {
                                $this->dumpJSEvent($this->_jsonselect);
                        }

                        if ($this->_onclick != null && !defined($this->_onclick))
                        {
                                // only output the same function once;
                                // otherwise if for example two buttons use the same
                                // OnClick event handler it would be outputted twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }
                }
        }



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
        function readOnClick() { return $this->_onclick; }
        function writeOnClick($value) { $this->_onclick = $value; }
        function defaultOnClick() { return null; }

        function getHidden() { return $this->readhidden(); }
        function setHidden($value) { $this->writehidden($value); }

        /**
        * JS event when the control gets focus.
        *
        * Use this event to provide custom behavior with then text in the control
        * is selected
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readjsOnSelect() { return $this->_jsonselect; }
        /**
        * JS event when the control gets focus.
        * @param mixed $value Event handler or null to unset.
        */
        function writejsOnSelect($value) { $this->_jsonselect=$value; }
        function defaultjsOnSelect() { return null; }

        /**
        * Occurs when the form containing the control has been submitted.
        *
        * Use this event to react to form submissions to the server, it can be used to validate form input
        * or to perform any other action you want to do when the form is sent.
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnSubmit() { return $this->_onsubmit; }
        function writeOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }

        /**
        * Specifies whether the control is checked.
        *
        * Use Checked to determine whether a button control is checked or to
        * set the control to a checked state. This property is boolean.
        *
        * @return bool
        */
        function readChecked() { return $this->_checked; }
        function writeChecked($value) { $this->_checked=$value; }
        function defaultChecked() { return 0; }

        /**
        * Identifies the field from which the data-aware control displays data.
        *
        * Set DataField to the field name of the field component that the control represents.
        * Access by the control to the dataset in which the field is located is provided by a DataSource component,
        * specified in the DataSource property.
        *
        * @see readDataSource()
        *
        * @return string
        */
        function readDataField() { return $this->_datafield; }
        function writeDataField($value) { $this->_datafield = $value; }
        function defaultDataField() { return ""; }

        /**
        * Links the control to a dataset.
        *
        * Specify the data source component through which the data from a dataset component
        * is provided to the control. To allow the control to represent the data for a field,
        * both the DataSource and the DataField properties must be set.
        *
        * @see readDataField()
        * @return DataSource
        */
        function readDataSource() { return $this->_datasource; }
        function writeDataSource($value)
        {
                $this->_datasource = $this->fixupProperty($value);
        }
        function defaultDataSource() { return null; }

        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @return integer
        */
        function readTabOrder() { return $this->_taborder; }
        function writeTabOrder($value) { $this->_taborder=$value; }
        function defaultTabOrder() { return 0; }

        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @return bool
        */
        function readTabStop() { return $this->_tabstop; }
        function writeTabStop($value) { $this->_tabstop=$value; }
        function defaultTabStop() { return 1; }
}


define('btSubmit', 'btSubmit');
define('btReset', 'btReset');
define('btNormal', 'btNormal');

/**
 * Button is a push button control.
 *
 * Use Button to put a standard push button on a form. Button introduces several
 * properties to control its behavior. Users choose button controls to initiate actions.
 *
 * To use a button that displays a bitmap instead of a label, use BitBtn. To use a
 * button that can remain in a depressed position, use SpeedButton.
 *
 * You can also create Image buttons using the ImageSource property
 *
 * @link http://www.w3.org/TR/html401/interact/forms.html#h-17.4.1
 * @example Button/button.php How to use Button component
 *
 */
class Button extends ButtonControl
{
        protected $_buttontype = btSubmit;
        protected $_default = 0;
        protected $_imagesource = "";
        protected $_action=null;

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                // define which property is set by the datasource
                $this->_datafieldproperty = 'Caption';
        }

        function dumpContents()
        {
                // get the button type
                $buttontype = "submit";
                switch ($this->_buttontype)
                {
                        case btSubmit :
                                $buttontype = "submit";
                                break;
                        case btReset :
                                $buttontype = "reset";
                                break;
                        case btNormal :
                                $buttontype = "button";
                                break;
                }

                // Check if an imagesource is defined, if yes then let's make an
                // image input.
                $imagesrc = "";
                if ($this->_imagesource != "")
                {
                        $buttontype = "image";
                        $imagesrc = "src=\"$this->_imagesource\"";
                }

                // override the buttontype if Default is true
                if ($this->_default == 1)
                {
                        $buttontype = "submit";
                        $imagesrc = "";
                }

                // dump to control with all other parameters
                $this->dumpContentsButtonControl($buttontype, $this->_name, $imagesrc);
        }

        /**
        * Determines the type of button you want to create, this type determines also some built-in functions for buttons inside HTML forms.
        *
        * A standard HTML button can have 3 different types:
        *
        * btSubmit - submits the HTML form
        *
        * btReset - resets the HTML form back to the initial values
        *
        * btNormal - is a regular button, the browser does not submit the form if no OnClick event has been assigned
        *
        * If Default is true then ButtonType is always btSubmit.
        *
        * @return enum (btSubmit, btReset, btNormal)
        */
        function getButtonType() { return $this->_buttontype; }
        function setButtonType($value)
        {
                $this->_buttontype = $value;
                // if ButtonType is not submit and default is set then unset default
                if ($this->_buttontype != btSubmit && $this->_default == 1)
                {
                        $this->Default = 0;
                }
        }
        function defaultButtonType() { return btSubmit; }

        /**
        * Determines whether the button's OnClick event handler executes when the Enter key is pressed.
        *
        * If Default is true, the button's OnClick event handler executes when the user presses Enter, by
        * setting this property to true, the button type will be always btSubmit, this behaviour is controlled
        * by the browser and might vary between different browsers and platforms.
        *
        * @return bool
        */
        function getDefault() { return $this->_default; }
        function setDefault($value)
        {
                $this->_default=$value;
                // If set to default the ButtonType has to be submit
                if ($this->_default == 1)
                {
                        $this->ButtonType = btSubmit;
                }
        }
        function defaultDefault() { return 0; }

        /**
        * If this property is set to an image, will be used as an image for the button surface.
        *
        * An HTML button can be an image button, so you can create buttons that are graphical bitmaps, this is
        * usually done to have a nice graphical interface.
        *
        * To avoid distortion make sure you set the images height and width to button's Height and Width or viceversa.
        *
        * @return string
        */
        function getImageSource() { return $this->_imagesource; }
        function setImageSource($value) { $this->_imagesource = $value; }
        function defaultImageSource() { return ""; }

        /*
        * Publish the events for the Button component
        */
        function getOnClick                   () { return $this->readOnClick(); }
        function setOnClick($value)           { $this->writeOnClick($value); }

        /*
        * Publish the JS events for the Button component
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


        function getCaption()
        {
                return $this->readCaption();
        }
        function setCaption($value)
        {
                $this->writeCaption($value);
        }

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

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }

        /**
        * Reserved for future use
        *
        * The goal of this property is to link ActionList components with visual
        * components to provide an easy way to execute actions.
        *
        * @return string
        */
        function getAction() { return $this->_action; }
        function setAction($value) { $this->_action=$value; }
        function defaultAction() { return null; }


}


/**
 * Base class for Checkbox controls.
 *
 * CheckBox represents a check box that can be on (checked) or off (unchecked).
 *
 */
class CustomCheckBox extends ButtonControl
{

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 121;
                $this->Height = 21;

                // define which property is set by the datasource
                $this->_datafieldproperty = 'Checked';
        }

        function preinit()
        {
                $submittedValue = $this->input->{$this->_name};

                if ($_SERVER['REQUEST_METHOD']=='POST')
                {
                   // check if the CheckBox is checked (compare against the Caption
                   // since it is submitted as value)

                   if (((is_object($submittedValue)) && ($submittedValue->asString() == $this->_caption)) || ($_POST[$this->_name]==$this->_caption))
                   {
                           $this->_checked = 1;
                           //If there is any valid DataField attached, update it
                           $this->updateDataField($this->_checked);
                   }
                   else if (($this->ControlState & csDesigning) != csDesigning)
                   {
                           $this->_checked = 0;
                           //If there is any valid DataField attached, update it
                           $this->updateDataField($this->_checked);
                   }
                }
        }

        function dumpContents()
        {
                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;

                        if ($this->color != "")
                        {
                                $style .= "background-color: ".$this->color.";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                $height = $this->Height - 1;
                $width = $this->Width;

                $style .= "height:".$height."px;width:".$width."px;";

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }


                if ($style != "")  $style = "style=\"$style\"";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                if( $this->_alignment == agCenter )
                    $format = "<tr><td style=\"text-align: center;\">%s</td></tr><tr><td style=\"text-align: center;\"><label for=\"$this->_name\" $hint $class>$this->_caption</label></td></tr>\r\n";
                else if( $this->_alignment == agLeft )
                    $format = "<tr><td><label for=\"$this->_name\" $hint $class>$this->_caption</label></td><td width=\"20\">%s</td></tr>\r\n";
                else
                    $format = "<tr><td width=\"20\">%s</td><td><label for=\"$this->_name\" $hint $class>$this->_caption</label></td></tr>\r\n";

                $surroundingTags = "<table cellpadding=\"0\" cellspacing=\"0\" id=\"{$this->_name}_table\" $style $class>\r\n$format</table>\r\n";

                $this->dumpContentsButtonControl("checkbox", $this->_name,
                  "", $surroundingTags, true);
        }
}

/**
 * CheckBox represents a check box that can be on (checked) or off (unchecked)
 *
 * A CheckBox component presents an option for the user. The user can check the
 * box to select the option, or uncheck it to deselect the option.
 *
 * @link http://www.w3.org/TR/html401/interact/forms.html#h-17.4.1
 *
 */
class CheckBox extends CustomCheckBox
{
        /*
        * Publish the events for the CheckBox component
        */
        function getOnClick                   () { return $this->readOnClick(); }
        function setOnClick($value)           { $this->writeOnClick($value); }

        function getOnSubmit                  () { return $this->readOnSubmit(); }
        function setOnSubmit                  ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the CheckBox component
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
        * Publish the properties for the CheckBox component
        */

        function getAlignment()
        {
                return $this->readAlignment();
        }
        function setAlignment($value)
        {
                $this->writeAlignment($value);
        }

        function getCaption()
        {
                return $this->readCaption();
        }
        function setCaption($value)
        {
                $this->writeCaption($value);
        }

        function getChecked()
        {
                return $this->readChecked();
        }
        function setChecked($value)
        {
                $this->writeChecked($value);
        }

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

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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
 * Use RadioButton to add an indipendent radio button to a form.
 *
 * Use RadioButton to add a radio button to a form. Radio buttons present a set of
 * mutually exclusive options to the user- that is, only one radio button in a set
 * can be selected at a time. When the user selects a radio button, the previously
 * selected radio button becomes unselected. Radio buttons are frequently grouped
 * in a radio group box (RadioGroup). Add the group box to the form first, then
 * get the radio buttons from the Component palette and put them into the group box.
 *
 * Use the Group property to specify which RadioButtons belong to the same group,
 * and that way, only one could be selected at a time.
 *
 */
class RadioButton extends ButtonControl
{
        protected $_group = '';

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 121;
                $this->Height = 21;

                // define which property is set by the datasource
                $this->_datafieldproperty = 'Checked';
        }

        function preinit()
        {
                // get the group-name, if non is set then get the name of the RadioButton
                $groupname = ($this->_group != '') ? $this->_group : $this->_name;

                $submittedValue = $this->input->{$groupname};

                // check if the RadioButton is checked (compare against the Caption
                // since it is submitted as value)
                if (((is_object($submittedValue)) && ($submittedValue->asString() == $this->_caption)) || ($_POST[$this->_name]==$this->_caption))
                {
                        $this->_checked = 1;
                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_checked);
                }
                else if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $this->_checked = 0;
                        //If there is any valid DataField attached, update it
                        $this->updateDataField($this->_checked);
                }
        }

        function dumpContents()
        {
                $style = "";
                if ($this->Style=="")
                {
                        $style .= $this->Font->FontString;

                        if ($this->color != "")
                        {
                                $style .= "background-color: ".$this->color.";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                $height = $this->Height - 1;
                $width = $this->Width;

                $style .= "height:".$height."px;width:".$width."px;";

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }


                if ($style != "")  $style = "style=\"$style\"";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                // get the alignment of the Caption
                $alignment = "";
                switch ($this->_alignment)
                {
                        case agNone :
                                $alignment = "";
                                break;
                        case agLeft :
                                $alignment = "align=\"Left\"";
                                break;
                        case agCenter :
                                $alignment = "align=\"Center\"";
                                break;
                        case agRight :
                                $alignment = "align=\"Right\"";
                                break;
                }

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // get the group-name, if non is set then get the name of the RadioButton
                $groupname = ($this->_group != '') ? $this->_group : $this->_name;

                if (is_numeric($groupname)) $groupname='g'.$groupname;

                $surroundingTags = "<table cellpadding=\"0\" cellspacing=\"0\" id=\"{$this->_name}_table\" $style $class><tr><td width=\"20\">\n";
                $surroundingTags .= "%s\n";
                $surroundingTags .= "</td><td $alignment>\n";
                // Add some JS to the Caption (OnClick).
                $surroundingTags .= ($this->Owner != null) ? "<span id=\"{$this->_name}_caption\" onclick=\"return RadioButtonClick(document.forms[0].$groupname, '$this->_caption');\" $hint $class>" : "<span>";
                $surroundingTags .= $this->_caption;
                $surroundingTags .= "</span>\n";
                $surroundingTags .= "</td></tr></table>\n";

                $this->dumpContentsButtonControl("radio", $groupname,
                  "", $surroundingTags, true);
        }

        /*
        * Write the Javascript section to the header
        */
        function dumpJavascript()
        {
                parent::dumpJavascript();

                // only output the function once
                if (!defined('RadioButtonClick'))
                {
                        define('RadioButtonClick', 1);
                        // Since all names are the same for the same group we
                        // have to check with the value attribute.
                        echo "
function RadioButtonClick(elem, caption)
{
   if (typeof(elem.length) == 'undefined') {
     elem.checked = true;
     return (typeof(elem.onclick) == 'function') ? elem.onclick() : false;
   } else {
     for(var i = 0; i < elem.length; i++) {
       if (elem[i].value == caption) {
         elem[i].checked = true;
         return (typeof(elem[i].onclick) == 'function') ? elem[i].onclick() : false;
       }
     }
   }
   return false;
}
";
                }
        }


        /**
        * Group where the RadioButton belongs to.
        *
        * If group is empty the name of the RadioButton is used, but usually that
        * is not the desired behavior.
        *
        * @return string
        */
        function getGroup()
        {
                return $this->_group;
        }
        function setGroup($value)
        {
                $this->_group = $value;
        }
        function defaultGroup() { return ''; }


        /*
        * Publish the events for the CheckBox component
        */
        function getOnClick                   () { return $this->readOnClick(); }
        function setOnClick($value)           { $this->writeOnClick($value); }

        function getOnSubmit                  () { return $this->readOnSubmit(); }
        function setOnSubmit                  ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the CheckBox component
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
        * Publish the properties for the CheckBox component
        */

        function getAlignment()
        {
                return $this->readAlignment();
        }
        function setAlignment($value)
        {
                $this->writeAlignment($value);
        }

        function getCaption()
        {
                return $this->readCaption();
        }
        function setCaption($value)
        {
                $this->writeCaption($value);
        }

        function getChecked()
        {
                return $this->readChecked();
        }
        function setChecked($value)
        {
                $this->writeChecked($value);
        }

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

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }
}

define ('sbHorizontal', 'sbHorizontal');
define ('sbVertical', 'sbVertical');

/**
* ScrollBar is used to scroll the contents of a window, form, or control.
*
* Use ScrollBar to add a free-standing scroll bar to a form. Many controls have
* properties that add scroll bars which are an integral part of the control.
* ScrollBar allows controls that do not have integrated scroll bars or groupings of
* controls to be scrolled when the user manipulates the ScrollBar object.
*
* @example ScrollBar/uScrollBar.php How ScrollBar work
* @example ScrollBar/uScrollBar.xml.php How ScrollBar work (form)
*
*/
class ScrollBar extends QWidget
{
        protected $_kind = sbHorizontal;
        protected $_min=0;
        protected $_max=500;
        protected $_position=0;
        protected $_pagesize=0;

        protected $_jsonscroll="";

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                if ($this->_kind==sbHorizontal) { $horiz = "true"; }
                else                            { $horiz = "false"; }

                //qooxdoo calculates delphi pagesize using current widget width
                //and maximum value with folowing formula pagesize=(W^2/Max)
                //So, we must calculate Maximum for the control based on current
                //Pagesize, minimum and maximum. By the way minimum doesn´t exist in
                //qooxdoo it is supposed to be allways 0. It is app work to normalize
                //the maximum based on the current minimum knowing that it is harcoded
                //to 0 on qooxdoo.
                $horiz=="true"?$size=$this->Width : $size=$this->Height;
                $Maximum=$this->Max-$this->Min;
                //Make sure no division by 0 will occur
                if(!$Maximum) $Maximum=1;

                $ScaledPageSize=$Maximum/($this->PageSize==0?1:$this->PageSize);
                $QooxDooMaximum=$ScaledPageSize*$size;
                $RelativePos=$this->Position-$this->Min;
                $ScaledPos=$RelativePos/$Maximum;
                $QooxDooPos=$ScaledPos*$QooxDooMaximum;

                //QooxDoo makes width +1 to allow ie compatibility.
                ++$QooxDooMaximum;

                $eventName=$this->getJSWrapperFunctionName($this->_jsonchange);
                echo "  var " . $this->Name . " = new qx.ui.core.ScrollBar($horiz);\n"
//                   . "  $this->Name.setLeft(0);\n"
//                   . "  $this->Name.setTop(0);\n"
                   . "  $this->Name.setWidth($this->Width);\n"
                   . "  $this->Name.setHeight($this->Height);\n"
                   . "  $this->Name.setMaximum(".$QooxDooMaximum.");\n"
                   . "  $this->Name.setValue(".$QooxDooPos.");\n";
                if($this->_jsonchange!="" && $this->_jsonchange!=null)
                        echo " $this->Name.addEventListener(\"changeValue\",$this->_jsonchange);\n";

                if($this->ShowHint==true && $this->Hint!="")
                        echo "  $this->Name.setToolTip(new qx.ui.popup.ToolTip(\"$this->Hint\"));\n";

                $this->dumpCommonQWidgetProperties($this->Name,false);
                $this->dumpCommonQWidgetJSEvents($this->Name,false);

                $this->dumpCommonContentsBottom();

        }



        /**
        * Specifies whether the scroll bar is horizontal or vertical.
        *
        * Set Kind to indicate the orientation of the scroll bar. These are the possible values:
        *
        * sbHorizontal - Scroll bar is horizontal
        *
        * sbVertical - Scroll bar is vertical
        *
        *
        * @return enum (sbHorizontal, sbVertical)
        */
        function getKind()       { return $this->_kind; }
        function setKind($value)
        {
                if ($value != $this->_kind)
        {
                $w = $this->Width;
                $h = $this->Height;

                        if (($value == sbHorizontal) && ($w < $h))
                        {
                                $this->Height = $w;
                                $this->Width = $h;
                        }
                        else
                        if (($value == sbVertical) && ($w > $h))
                        {
                                $this->Height = $w;
                                $this->Width = $h;
                        }

                        $this->_kind = $value;
                }
        }
        function defaultKind() { return sbHorizontal;  }

        /**
        * Check if the PageSize property has a valid value, if not, set it to
        * the max possible value.
        *
        * @see PageSize
        *
        */
        protected function checkPageSize()
        {
                $Range=$this->_max-$this->_min;
                if($this->_pagesize>$Range)
                        $this->_pagesize=$Range;
        }

        /**
        * Check if the Position property is between Min and Max, and if not, fixes it
        *
        * @see Position
        */
        protected function checkPosition()
        {
                if($this->_position<$this->_min || $this->_position>$this->_max)
                {
                        if($this->_position<$this->_min )
                                $this->_position=$this->_min;
                        else
                                $this->_position=$this->_max;
                }
        }

        /**
        * Specifies the minimum position represented by the scroll bar.
        *
        * Set Min to the minimum value the Position property can take. The Min
        * and Max properties define the total range over which Position can vary.
        *
        * @return integer
        */
        function getMin()       { return $this->_min; }
        function setMin($value)
        {
                if($value<=$this->_max && $value>=0)
                {
                        $this->_min=$value;
                        $this->checkPageSize();
                        $this->checkPosition();
                }
        }
        function defaultMin()   { return 0; }

        /**
        * Specifies the maximum position represented by the scroll bar.
        *
        * Set Max to the maximum value the Position property can take. The Max
        * and Min properties define the total range over which Position can vary.
        *
        * @return integer
        */
        function getMax()       { return $this->_max; }
        function setMax($value)
        {
                if($value>=$this->_min && $value>=0)
                {
                        $this->_max=$value;
                        $this->checkPageSize();
                        $this->checkPosition();
                }
        }
        function defaultMax()   { return 500; }

        /**
        * Indicates the current position of the scroll bar.
        *
        * Read Position to determine the current position of the thumb tab. This
        * value can be used to determine how to scroll any components controlled
        * by the scroll bar. When the user scrolls the scroll bar, the value of
        * Position changes. Set Position to programmatically move the thumb tab
        * of the scroll bar.
        *
        * The number of possible positions on the scroll bar is determined by the
        * difference between the Max property and the Min property. If Position
        * has the same value as Min, the thumb tab appears at the far left of a
        * horizontal scroll bar or the top of a vertical scroll bar. If Position
        * has the same value as Max, the thumb tab appears at the far right of a
        * horizontal scroll bar or the bottom of a vertical scroll bar.
        *
        * @return integer
        */
        function getPosition()       { return $this->_position; }
        function setPosition($value)
        {

                $this->_position=$value;
                $this->checkPosition();

        }
        function defaultPosition()   { return 0; }

        /**
        * Specifies the size of the thumb tab.
        *
        * PageSize is the size of the thumb tab, measured in the same units as
        * Position, Min, and Max (not pixels).
        *
        * @return integer
        */
        function getPageSize()       { return $this->_pagesize; }
        function setPageSize($value)
        {
                $this->_pagesize=$value;
                $this->checkPageSize();
        }
        function defaultPageSize()   { return 0; }

        /**
        * Enabled property specifies if this control is reacting to events
        **/
        function getEnabled() { return $this->readEnabled();}
        function setEnabled($value) { $this->writeEnabled($value);}
//        function defaultEnabled() { return true; }*/


        /**
        * Specifies if the Hint this control have will be shown when the user is over it
        */
        function getShowHint() { return $this->readShowHint();}
        function setShowHint($value) { $this->writeShowHint($value);}

        /**
        * Specifies if we will use parent's show hint instead of this control showhint value
        */
        function getParentShowHint() { return $this->readParentShowHint();}
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        /**
        * Specifies if the control is visible or not
        */
        function getVisible() { return $this->readVisible();}
        function setVisible($value) { $this->writeVisible($value); }

        /**
        * PopupMenu also called context menu for this scrollbar
        */
        function getPopupMenu() { return $this->readPopupMenu();}
        function setPopupMenu($value) { $this->writePopupMenu($value); }

        /**
        * OnChange event
        **/
        function getjsOnChange() { return $this->_jsonchange;}
        function setjsOnChange($value) { $this->_jsonchange=$value;}
        function defaultjsOnChange() { return null; }


        function __construct($aowner = null)
                {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 200;
                $this->Height = 17;
        }

}

/**
* Base class for Upload class
*
* Upload component allows the user to upload a file to the server.
*
* @link http://www.w3.org/TR/html401/interact/forms.html#file-select
*/
class CustomUpload extends FocusControl
{

        protected $_onsubmit=null;
        protected $_onclick=null;
        protected $_ondblclick=null;
        protected $_onuploaded=null;

        protected $_jsonselect=null;

        protected $_borderstyle=bsSingle;

        protected $_charcase=ecNormal;
        protected $_maxlength=0;
        protected $_accept='';
        protected $_size="";
        protected $_taborder=0;
        protected $_tabstop=1;
        protected $_readonly=0;

        protected $_filetmpname = null;
        protected $_filename = null;
        protected $_filesize = null;
        protected $_filetype = null;
        protected $_filesubtype = null;

        /* if this data can be obtain by getimagesize these vars will be set*/
        protected $_graphic_width = 0;
        protected $_graphic_height = 0;
        protected $_graphic_typ = 0;



        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->writeMultiFormData($aowner);

                $this->Width = 260;
                $this->Height = 21;

                $this->ControlStyle='csRenderOwner=1';
                $this->ControlStyle='csRenderAlso=StyleSheet';
        }

        /**
         * This function tries to find the next page object owning this component
         * to set the formencoding to multipart/form-data
         *
         * This is an internal method used by this component to set the form
         * encoding to the right value so files can be uploaded.
         *
         */
        protected function writeMultiFormData($aowner)
        {
           if( ! is_object($aowner)) {return;}
           if($aowner->inheritsFrom('Page'))
           {
               $aowner->writeFormEncoding('multipart/form-data');
           } else {
               $this->setMultiFormData($aowner->owner);
           }
        }


        /**
         * Wrapper function for the php intern move_upload_file function
         *
         * Use this method to move the uploaded file to a location of your choice.
         *
         * @param string $destination Path where you want to move the file
         * @param boolean $autoExt if true, the file extension will be appended
         * @return mixed  destination if file was moved successfully, else false will be returned
         */
        function moveUploadedFile($destination, $autoExt=false)
        {
            if($autoExt) $destination .= '.' . $this->getFileExt();
            if (move_uploaded_file($this->_filetmpname, $destination))
            {
                return $destination;
            } else {
                return false;
            }
        }

        /**
         * Wrapper function for the php intern is_uploaded_file function
         *
         * Use this method to check if the file uploaded was correctly uploaded
         *
         * @return boolean if true, file was uploaded ok. False in any other case.
         */
        function isUploadedFile()
        {
                return is_uploaded_file($this->_filetmpname);
        }

        /**
        * Returns the error message the upload process caused, empty string if no error
        *
        * Use this method to get the error message caused by the upload operation, if any.
        * If no error message is returned, the operation was successfully completed.
        *
        * @return string
        */
        function errorMessage()
        {
                if(!isset($_FILES[$this->Name]))
                        return "Unknown error";

                $errorCode=$_FILES[$this->Name]["error"];
                $error="";
                switch($errorCode)
                {
                        case 0:
                                return;
                        case UPLOAD_ERR_PARTIAL:
                             $error= "File was not completly uploaded.";
                             break;
                        case UPLOAD_ERR_NO_FILE:
                             $error= "No file to upload specified.";
                             break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                             $error= "No temp folder find in server.";
                             break;
                        case UPLOAD_ERR_CANT_WRITE:
                             $error= "Temp file filed to write to disc";
                             break;
                        default:
                             $error= "Temp file failed to write to disc";
                }

                return $error;

        }

        function preinit()
        {
            $this->fetchFileData();
        }

        function init()
        {

                $this->fetchFileData();

                parent::init();

                // Allow the OnSubmit event to be fired because it is not
                // a mouse or keyboard event.
                // Event is fired when a valid file was uploaded
                if ($this->_filetmpname)
                {
                        $this->callEvent('onsubmit', array());
                        if($this->_onuploaded) $this->callEvent('onuploaded',array());
                }
        }

        /**
         * Sets filename and types uploaded by this component
         *
         * This method updates internal properties like filename, filesize, etc.
         * If the file is a graphic, also graphic properties are updated.
         */
        protected function fetchFileData()
        {
            /*get it only once*/
            if($this->_filetmpname) return;

            $this->_filetmpname = $_FILES[$this->Name]['tmp_name'];

            if( $this->_filetmpname != '' && is_readable ($this->_filetmpname))
            {
                $this->_filename    = $_FILES[$this->Name]['name'];
                $this->_filesize    = $_FILES[$this->Name]['size'];
                $pos                = strpos ($_FILES[$this->Name]['type'] , '/');
                $this->_filetype    = substr( $_FILES[$this->Name]['type'], 0, $pos);
                $this->_filesubtype = substr( $_FILES[$this->Name]['type'], ($pos+1) );

                if($this->_filetype == 'image')
                {
                    $size = getimagesize($this->_filetmpname);
                    if(sizeof($size) >= 3)
                    {
                        $this->_graphic_width  = $size[0];
                        $this->_graphic_height = $size[1];
                        $this->_graphic_typ    = $size[2];
                    }
                }
            }
        }


        /**
        * Get the common HTML tag attributes of a Upload control.
        * @return string Returns a string with the attributes.
        */
        protected function getCommonAttributes()
        {
                $events = '';
                //JS not supported yet
                if ($this->_enabled == 1)
                {
                        // get the string for the JS Events
                        $events = $this->readJsEvents();

                        // add the OnSelect JS-Event
                        if ($this->_jsonselect != null)
                        {
                                $events .= " onselect=\"return $this->_jsonselect(event)\" ";
                        }

                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                        $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");
                }

                // set the accepted filetypes
                $accept = ($this->_accept != '') ? 'accept="' . $this->_accept . '"' : '';
                // set the input form size
                $size = ($this->_size > 0 ) ? 'size="'. $this->_size .'"' : '';

                // set maxlength if bigger than 0
                $maxlength = ($this->_maxlength > 0) ? 'maxlength="'. $this->_maxlength .'"' : '';


                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? 'tabindex="' . $this->_taborder .'"' : '';

                $class = ($this->Style != '') ? 'class="'. $this->StyleClass .'"' : '';

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                return $accept. ' ' .$size. ' ' .$maxlength .' '. $taborder .' '. $hint .' '. $events .' '. $class;
        }

        /**
        * Get the common styles of a Edit control.
        * @return string Returns a string with the common styles. It is not wrapped
        *                 in the style="" attribute.
        */
        protected function getCommonStyles()
        {
                $style = '';
                if ($this->Style=='')
                {
                        $style .= $this->Font->FontString;
                        // set the no border style
                        if ($this->_borderstyle == bsNone)
                        {
                                $style .= 'border-width: 0px; border-style: none;';
                        }

                        if ($this->Color != '')
                        {
                                $style .= 'background-color: '. $this->Color .';';
                        }

                        // add the cursor to the style
                        if ($this->_cursor != '')
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= 'cursor: '. $cr .';';
                        }


                        // set the char case if not normal
                        if ($this->_charcase != ecNormal)
                        {
                                if ($this->_charcase == ecLowerCase)
                                {
                                        $style .= 'text-transform: lowercase;';
                                }
                                else if ($this->_charcase == ecUpperCase)
                                {
                                        $style .= 'text-transform: uppercase;';
                                }
                        }
                }

                $h = $this->Height - 1;
                $w = $this->Width;
                $style .= 'height:'. $h .'px;width:'. $w .'px;';
                return $style;
        }


        function dumpContents()
        {
                // set type depending on $_ispassword

                $attributes = $this->getCommonAttributes();

                $style = $this->getCommonStyles();

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }


                if ($style != '')  $style = 'style="' . $style . '" ';

                // call the OnShow event if assigned so the Text property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }

                echo '<input type="file" value="Up" id="'. $this->_name .'" name="'. $this->_name .'" '.  $style .' '. $attributes .'/>';


                // add a hidden field so we can determine which event for the edit was fired
                if ($this->_onclick != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo '<input type="hidden" id="'. $hiddenwrapperfield .'" name="'. $hiddenwrapperfield .'" value="" />';
                }
        }

        /**
        * Determines if the uploaded file is a text file
        *
        * @return boolean
        */
        function isText()
        {
            if($this->_filetype == 'text')          return true;
            else                                    return false;
        }

        /**
        * Determines if the uploaded file is a graphic file
        *
        * @return boolean
        */
        function isImage()
        {
            if($this->_filetype == 'image')         return true;
            else                                    return false;
        }

        /**
        * Determines if the uploaded file is a video file
        *
        * @return boolean
        */
        function isVideo()
        {
            if($this->_filetype == 'video')         return true;
            else                                    return false;
        }

        /**
        * Determines if the uploaded file is an application
        *
        * @return boolean
        */
        function isApplication()
        {
            if($this->_filetype == 'application')   return true;
            else                                    return false;
        }


        /**
        * Determines if the uploaded file is a GIF file
        *
        * @return boolean
        */
        function isGIF()
        {
            if($this->_graphic_typ == 1)            return true;
            else                                    return false;
        }

        /**
        * Determines if the uploaded file is a JPEG file
        *
        * @return boolean
        */
        function isJPEG()
        {
            if($this->_graphic_typ == 2)            return true;
            else                                    return false;
        }

        /**
        * Determines if the uploaded file is a PNG file
        *
        * @return boolean
        */
        function isPNG()
        {
            if($this->_graphic_typ == 3)            return true;
            else                                    return false;
        }

        /**
         * Returns the extension of the uploaded file
         *
         * Once the file is uploaded, it returns the extension of the file.
         *
         * @return string
         */
        function readFileExt()
        {
            switch($this->_graphic_typ){
                case 0:
                    return substr( $this->_filename, (strrpos($this->_filename, '.')+1) );
                case 1:
                    return 'gif';
                case 2:
                    return 'jpg';
                case 3:
                    return 'png';
                case 4:
                    return 'swf';
                default:
                    return '';
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
        * JS Event occurs when text in the control was selected.
        *
        * Use this event to provide custom behavior with then text in the control
        * is selected
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readjsOnSelect() { return $this->_jsonselect; }
        function writejsOnSelect($value) { $this->_jsonselect=$value; }
        function defaultjsOnSelect() { return null; }


        /**
        * Determines whether the edit control has a single line border around the client area.
        *
        * Use this property to specify which kind of border the control is going to
        * use. Controls can have a single border (1 pixel wide) or none.
        *
        * @return enum (bsNone, bsSingle)
        */
        function readBorderStyle() { return $this->_borderstyle; }
        function writeBorderStyle($value) { $this->_borderstyle=$value; }
        function defaultBorderStyle() { return bsSingle; }



        /**
        * Specifies the maximum number of characters the user can enter into
        * the edit control. A value of 0 indicates that there is no
        * application-defined limit on the length.
        * @return integer
        */
        function readMaxLength() { return $this->_maxlength; }
        function writeMaxLength($value) { $this->_maxlength=$value; }
        function defaultMaxLength() { return 0; }

        /**
        * Specifies the accept filetypes.
        *
        * Use this property to specify the types of files the upload component
        * accepts.
        *
        * A value of * indicates that there is no application-defined limit on
        * filetypes.
        *
        * @return string
        */
        function readAccept() { return $this->_accept; }
        function writeAccept($value) { $this->_accept=$value; }
        function defaultAccept() { return null; }

        /**
         * Specifies the input size the text field
         *
         * Use this property to set the number of characters the control must
         * resize to. Some browsers don't accept the size of the upload component
         * specified in pixels, so you need to set this property.
         *
         * @return integer
         */
        function readSize() { return $this->_size; }
        function writeSize($value) { $this->_size=$value; }
        function defaultSize() { return ""; }


        /**
        * Set the control to read-only mode. That way the user cannot enter
        * or change the text of the edit control.
        * @return bool
        */
        function readReadOnly() { return $this->_readonly; }
        function writeReadOnly($value) { $this->_readonly=$value; }
        function defaultReadOnly() { return 0; }

        /**
        * TabOrder indicates in which order controls are access when using
        * the Tab key.
        * The value of the TabOrder can be between 0 and 32767.
        * @return integer
        */
        function readTabOrder() { return $this->_taborder; }
        function writeTabOrder($value) { $this->_taborder=$value; }
        function defaultTabOrder() { return 0; }

        /**
        * Enable or disable the TabOrder property. The browser may still assign
        * a TabOrder by itself internally. This cannot be controlled by HTML.
        * @return bool
        */
        function readTabStop() { return $this->_tabstop; }
        function writeTabStop($value) {$this->_tabstop=$value;}
        function defaultTabStop() {return 1;}

        /**
        * onUploaded is a callback that will be executed when a file is uploaded
        */
        function getOnUploaded() { return $this->_onuploaded; }
        function setOnUploaded($value) {$this->_onuploaded=$value; }
        function defaultOnUploaded() { return null; }


        /**
        * This is the temporal filename of the uploaded file
        *
        * Use this property to know the temporal filename of the file just uploaded.
        *
        * @return integer
        */
        function readFileTmpName() {return $this->_filetmpname;}

        /**
        * This is the filename of the uploaded file
        *
        * Use this property to know the name of the file just uploaded.
        *
        * @return string
        */
        function readFileName() { return $this->_filename;}

        /**
        * This is the filesize of the uploaded file
        *
        * Use this property to know the sizew of the file just uploaded.
        *
        * @return string
        */
        function readFileSize() { return $this->_filesize;}

        /**
        * This is the filetype of the uploaded file
        *
        * Use this property to know the type of the file just uploaded.
        *
        * @return string
        */
        function readFileType() { return $this->_filetype;}

        /**
        * This is the subtype of the uploaded file
        *
        * Use this property to know the subtype of the file just uploaded.
        *
        * @return string
        */
        function readFileSubType() { return $this->_filesubtype;}

        /**
        * This is the width of the uploaded graphic
        *
        * Use this property to know the width of the graphic file just uploaded.
        *
        * @return integer
        */
        function readGraphicWidth() { return $this->_graphic_width;}

        /**
        * This is the height of the uploaded graphic
        *
        * Use this property to know the height of the graphic file just uploaded.
        *
        * @return integer
        */
        function readGraphicHeight() { return $this->_graphic_height;}


}


/**
* Allows the user to upload a file to the server.
*
* This component provides you a field where the user can select a local file on their
* computer and when the form is submitted, the file will be uploaded to the server.
*
* <code>
* <?php
*    function Button1Click($sender, $params)
*    {
*       $this->Memo1->AddLine ( 'FileTmpName: ' . $this->Upload1->FileTmpName);
*       $this->Memo1->AddLine ( 'FileName: ' . $this->Upload1->FileName);
*       $this->Memo1->AddLine ( 'FileSize: ' . $this->Upload1->FileSize);
*       $this->Memo1->AddLine ( 'FileType: ' . $this->Upload1->FileType);
*       $this->Memo1->AddLine ( 'FileSubType : ' .  $this->Upload1->FileSubType);
*       $this->Memo1->AddLine ( 'GraphicWidth: ' . $this->Upload1->GraphicWidth);
*       $this->Memo1->AddLine ( 'GraphicHeihgt: ' . $this->Upload1->GraphicHeight);
*       if($this->Upload1->isGIF()) $tmp = ' is gif';
*       if($this->Upload1->isJPEG()) $tmp = ' is jpeg';
*       if($this->Upload1->isPNG()) $tmp = ' is png';
*       $this->Memo1->AddLine ( 'File Ext: ' . $this->Upload1->FileExt . $tmp);
*    }
* ?>
* </code>
* @link http://www.w3.org/TR/html401/interact/forms.html#file-select
*/
class Upload extends CustomUpload
{
        /*
        * Publish the events for the Edit component
        */

        function getOnSubmit                    () { return $this->readOnSubmit(); }
        function setOnSubmit                    ($value) { $this->writeOnSubmit($value); }

        /*
        * Publish the JS events for the Edit component
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
        function getAccept()             { return $this->readAccept(); }
        function setAccept($value)       { $this->writeAccept($value); }

        function getBorderStyle()
        {
                return $this->readBorderStyle();
        }
        function setBorderStyle($value)
        {
                $this->writeBorderStyle($value);
        }

        function getColor()
        {
                return $this->readColor();
        }
        function setColor($value)
        {
                $this->writeColor($value);
        }

        function getEnabled()
        {
                return $this->readEnabled();
        }
        function setEnabled($value)
        {
                $this->writeEnabled($value);
        }

        function getFont()
        {
                return $this->readFont();
        }
        function setFont($value)
        {
                $this->writeFont($value);
        }

        function getMaxLength()
        {
                return $this->readMaxLength();
        }
        function setMaxLength($value)
        {
                $this->writeMaxLength($value);
        }

        function getParentColor()
        {
                return $this->readParentColor();
        }
        function setParentColor($value)
        {
                $this->writeParentColor($value);
        }

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

        function getReadOnly()
        {
                return $this->readReadOnly();
        }
        function setReadOnly($value)
        {
                $this->writeReadOnly($value);
        }

        function getShowHint()
        {
                return $this->readShowHint();
        }
        function setShowHint($value)
        {
                $this->writeShowHint($value);
        }

        function getSize()             { return $this->readSize(); }
        function setSize($value)       { $this->writeSize($value); }


        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

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

        function getVisible()
        {
                return $this->readVisible();
        }
        function setVisible($value)
        {
                $this->writeVisible($value);
        }
}



?>
