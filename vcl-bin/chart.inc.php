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
use_unit('libchart/libchart/libchart.php');

/**
*
*/
define('ctHorizontalChart','ctHorizontalChart');
define('ctLineChart','ctLineChart');
define('ctPieChart','ctPieChart');
define('ctVerticalChart','ctVerticalChart');

/**
 * A class for generating chart graphics.
 *
 * Use this component to show the user a chart with data, data can be obtained
 * from a database or provided using an array.
 *
 * Currently, the chart data can only be modified through code at run-time.
 * The image is dynamically generated on each request.
 *
 * <code>
 * <?php
 *     //This is how to add points to the chart
 *     $this->SimpleChart1->Chart->addPoint(new Point($this->edtLabel->Text, $this->edtValue->Text));
 * ?>
 * </code>
 * @see Control::readControlStyle()
 * @example SimpleChart/simplechart.php How SimpleChart work
 * @example SimpleChart/simplechart.xml.php How SimpleChart work (form)
 */
class SimpleChart extends GraphicControl
{
        protected $_onclick = null;

        protected $_chart = null;
        protected $_charttype = ctVerticalChart;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width = 400;
                $this->Height = 250;

                // Makes sure the framework knows that this component dumps binary image data
                $this->ControlStyle="csImageContent=1";

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";

                // Creates the chart
                $this->createChart();
        }

        /**
        * Creates a new chart with the defined ChartType and updates the protected chart variable.
        *
        * Internal chart object is a different instance depending on the type of chart you want to create
        * and this method creates the right one depending on the ChartType property.
        *
        * You don't need to call this method directly, as it is called everytime the ChartType property
        * is changed.
        *
        * @see getChartType()
        *
        * @return object Chart object.
        */
        function createChart()
        {
                switch($this->_charttype)
                {
                        case ctHorizontalChart: $this->_chart = new HorizontalChart($this->Width, $this->Height); break;
                        case ctLineChart: $this->_chart = new LineChart($this->Width, $this->Height); break;
                        case ctPieChart: $this->_chart = new PieChart($this->Width, $this->Height); break;
                        case ctVerticalChart: $this->_chart = new VerticalChart($this->Width, $this->Height); break;
                }

                return $this->_chart;
        }

        /**
        * Calls fillDummyValues() to fill the chart with some dummy values.
        * Only fills dummy values at design time.
        */
        function fillDummyValues()
        {
                if (($this->ControlState & csDesigning) == csDesigning)
                {
                        $this->_chart->setTitle("Preferred Web Language");

                        $this->_chart->addPoint(new Point("Perl", 50));
                        $this->_chart->addPoint(new Point("PHP", 75));
                        $this->_chart->addPoint(new Point("Java", 30));
                }
        }

        /**
        * Clears all chart data (including titles, points, axes, ..).
        *
        * Call this method to get an empty chart, as it resets all chart data
        * and starts with a fresh chart.
        *
        * @see createChart()
        */
        function clearChart()
        {
                // Only calls the reset function
                $this->_chart->reset();
        }

        function init()
        {
                parent::init();

                $submitEventValue = $this->input->{$this->readJSWrapperHiddenFieldName()};

                if (is_object($submitEventValue))
                {
                        // Checks if the a click event has been fired
                        if ($this->_onclick != null && $submitEventValue->asString() == $this->readJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
                // Dumps only the header if not in design mode
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        // Tries to prevent the browser from caching the image
                        echo "<META HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\" />\n";
                }
        }

        /**
         * Dumps the chart graphic.
         *
         * This method dumps the chart graphic by dumping binary image data to the
         * browser. The browser is instructed to show image data because of the headers
         * sent first. You don't need to call this method directly.
         *
         * @see Control::readControlStyle()
         * @link http://www.php.net/manual/en/function.header.php
         */
        function dumpGraphic()
        {
                // Graphic component that dumps binary data
                header("Content-type: image/png");

                // Tries to prevent the browser from caching the image
                header("Pragma: no-cache");
                header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

                $this->_chart->height = $this->Height;
                $this->_chart->width = $this->Width;

                $this->_chart->render();
        }

        function serialize()
        {
                parent::serialize();

                // Serializes the chart manually since libchart does not support
                //  serialization
                $owner = $this->readOwner();
                if ($owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".Chart.";

                        if (is_object($this->_chart->text))
                        {
                                $_SESSION[$prefix."Text"] = $this->_chart->text;
                        }
                        if (is_array($this->_chart->point))
                        {
                                $_SESSION[$prefix."Points"] = $this->_chart->point;
                        }

                        $_SESSION[$prefix."Title"] = $this->_chart->title;
                        $_SESSION[$prefix."LogoFileName"] = $this->_chart->logoFileName;
                        $_SESSION[$prefix."Margin"] = $this->_chart->margin;
                        $_SESSION[$prefix."LowerBound"] = $this->_chart->lowerBound;
                        $_SESSION[$prefix."LabelMarginLeft"] = $this->_chart->labelMarginLeft;
                        $_SESSION[$prefix."LabelMarginRight"] = $this->_chart->labelMarginRight;
                        $_SESSION[$prefix."LabelMarginTop"] = $this->_chart->labelMarginTop;
                        $_SESSION[$prefix."LabelMarginBottom"] = $this->_chart->labelMarginBottom;
                }
        }

        function unserialize()
        {
                parent::unserialize();

                // First unserializes the chart manually
                $owner = $this->readOwner();
                if ($this->_chart != null && $owner != null)
                {
                        $prefix = $owner->readNamePath().".".$this->_name.".Chart.";

                        if (is_object($_SESSION[$prefix."Text"]))
                                $this->_chart->text = $_SESSION[$prefix."Text"];
                        if(is_array($_SESSION[$prefix."Points"]))
                                $this->_chart->point = $_SESSION[$prefix."Points"];

                        if (isset($_SESSION[$prefix."Title"]))
                                $this->_chart->title = $_SESSION[$prefix."Title"];
                        if (isset($_SESSION[$prefix."LogoFileName"]))
                                $this->_chart->logoFileName = $_SESSION[$prefix."LogoFileName"];
                        if (isset($_SESSION[$prefix."Margin"]))
                                $this->_chart->margin = $_SESSION[$prefix."Margin"];
                        if (isset($_SESSION[$prefix."LowerBound"]))
                                $this->_chart->lowerBound = $_SESSION[$prefix."LowerBound"];
                        if (isset($_SESSION[$prefix."LabelMarginLeft"]))
                                $this->_chart->labelMarginLeft = $_SESSION[$prefix."LabelMarginLeft"];
                        if (isset($_SESSION[$prefix."LabelMarginRight"]))
                                $this->_chart->labelMarginRight = $_SESSION[$prefix."LabelMarginRight"];
                        if (isset($_SESSION[$prefix."LabelMarginTop"]))
                                $this->_chart->labelMarginTop = $_SESSION[$prefix."LabelMarginTop"];
                        if (isset($_SESSION[$prefix."LabelMarginBottom"]))
                                $this->_chart->labelMarginBottom = $_SESSION[$prefix."LabelMarginBottom"];
                }

                $key = md5($this->owner->Name.$this->Name.$this->Left.$this->Top.$this->Width.$this->Height);
                $bchart = $this->input->bchart;

                // Checks if the request is for this chart
                if ((is_object($bchart)) && ($bchart->asString() == $key))
                {
                        $this->dumpGraphic();
                }
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning) == csDesigning)
                {
                        $this->fillDummyValues();
                        $this->dumpGraphic();
                }
                else
                {
                        $events = $this->readJsEvents();
                        // Adds or replaces the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");

                        $hint = $this->getHintAttribute();
                        $alt = htmlspecialchars($this->_chart->title);
                        $style = "";
                        if ($this->Style=="")
                        {
                                // Adds the cursor to the style
                                if ($this->_cursor != "")
                                {
                                        $cr = strtolower(substr($this->_cursor, 2));
                                        $style .= "cursor: $cr;";
                                }
                        }

                        $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                        if ($style != "") $style = "style=\"$style\"";

                        if ($this->_onshow != null)
                        {
                                $this->callEvent('onshow', array());
                        }

                        $key = md5($this->owner->Name.$this->Name.$this->Left.$this->Top.$this->Width.$this->Height);
                        $url = $GLOBALS['PHP_SELF'];
                        // Outputs an image generated by a URL requesting this script
                        echo "<img src=\"$url?bchart=$key\" width=\"$this->Width\" height=\"$this->Height\" id=\"$this->_name\" name=\"$this->_name\" alt=\"$alt\" $hint $style $class $events />";


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

        function dumpJavascript()
        {
                parent::dumpJavascript();

                if ($this->_onclick != null && !defined($this->_onclick))
                {
                        // Outputs the same function only once in case two
                        // or more objects use the same OnClick event handler.
                        // Otherwise, if for example two buttons use the same
                        // OnClick event handler, it would be output twice.
                        $def=$this->_onclick;
                        define($def,1);

                        // Outputs the wrapper function
                        echo $this->getJSWrapperFunction($this->_onclick);
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
        * @return mixed
        */
        function getOnClick                     () { return $this->_onclick; }
        function setOnClick                     ($value) { $this->_onclick=$value; }
        function defaultOnClick                 () { return null; }


        /*
        * Publishes the JS events for the Chart component
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


        /**
        * Chart object
        * See the libchart class to understand the functionallity
        * of the chart object.
        *
        * @link http://naku.dohcrew.com/libchart/pages/documentation/
        *
        * @see getChartType()
        *
        * @return object
        */
        function readChart() { return $this->_chart; }

        /**
        * This property determines the type of Chart to display
        *
        * Use this property to change the look and feel of the chart, you can use
        * one of the following values.
        *
        * ctHorizontalChart - Data is shown using stacked bars
        *
        * ctLineChart - Data is shown using a line connecting all points
        *
        * ctPieChart - Data is show using a pie, in which each value is a portion of the total
        *
        * ctVerticalChart - Data is show using vertical bars, this is the default value
        *
        *
        * Note: Each time the chart type is changed, the internal chart object is recreated.
        *
        * @see createChart()
        *
        * @return enum
        */
        function getChartType() { return $this->_charttype; }
        function setChartType($value)
        {
                if ($value != $this->_charttype)
                {
                        $this->_charttype = $value;
                        // Recreates the chart since the chart type changed
                        $this->createChart();
                }
        }
        function defaultChartType() { return ctVerticalChart; }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }
}

?>