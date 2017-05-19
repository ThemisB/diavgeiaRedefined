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
use_unit("graphics.inc.php");
use_unit("imglist.inc.php");


/**
 * Shape.ShapeType
 */
define('stRectangle', 'stRectangle');
define('stSquare', 'stSquare');
define('stRoundRect', 'stRoundRect');
define('stRoundSquare', 'stRoundSquare');
define('stEllipse', 'stEllipse');
define('stCircle', 'stCircle');

/**
 * Bevel.Shape
 */
define('bsBox', 'bsBox');
define('bsFrame', 'bsFrame');
define('bsTopLine', 'bsTopLine');
define('bsBottomLine', 'bsBottomLine');
define('bsLeftLine', 'bsLeftLine');
define('bsRightLine', 'bsRightLine');
define('bsSpacer', 'bsSpacer');

/**
 * Bevel.Style
 */
define('bsLowered', 'bsLowered');
define('bsRaised', 'bsRaised');

/**
 * A class to encapsulate and display an image.
 *
 * Use Image to display a graphical image on a form. Use ImageSource property to
 * specify the actual image resource displayed by Image. Image introduces several
 * properties to determine how the image is displayed within the boundaries of the Image object.
 *
 * To add an image to a form or datamodule so that it is available for display by other controls, such as Menus
 * use a ImageList control instead.
 *
 * @see ImageList
 */
class Image extends FocusControl
{
        protected $_onclick = null;
        protected $_oncustomize = null;

        protected $_autosize=0;
        protected $_border=0;
        protected $_bordercolor="";
        protected $_center=0;
        protected $_datafield="";
        protected $_datasource=null;
        protected $_imagesource;
        protected $_link;
        protected $_linktarget;
        protected $_proportional=0;
        protected $_stretch=0;
        protected $_binary=0;

        /**
        * Specifies if the information to show is binary or an url
        *
        * If true, this component will perform a request to get binary data instead
        * pointing to the image url
        *
        * @see getBinaryType()
        *
        * @return boolean
        */
        function getBinary() { return $this->_binary; }
        function setBinary($value) { $this->_binary=$value; }
        function defaultBinary() { return 0; }

        protected $_binarytype="image/jpeg";

        /**
        * Specifies the type of binary information this component is going to dump
        *
        * Use this property to specify the mime type of binary information this component
        * is going to dump
        *
        * @see getBinary()
        *
        * @return string
        */
        function getBinaryType() { return $this->_binarytype; }
        function setBinaryType($value) { $this->_binarytype=$value; }
        function defaultBinaryType() { return "image/jpeg"; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=105;
                $this->Height=105;

                //For mapshapes
                $this->ControlStyle="csAcceptsControls=1";

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }


        /**
        * Returns the absolute image path, depending if the image is stored on a
        * subfolder relative to the location of the script or in a folder outside
        * script location
        *
        * @see getImageSource()
        *
        * @return string
        */
        private function getImageSourcePath()
        {
                // check if relative
                if (substr($this->_imagesource, 0, 2) == ".." || $this->_imagesource{0} == ".")
                {
                        return dirname($_SERVER['SCRIPT_FILENAME']).'/'.$this->_imagesource;
                }
                else
                {
                        return $this->_imagesource;
                }
        }

        function loaded()
        {
                parent::loaded();

                $this->setDataSource($this->_datasource);

                if ($this->_autosize)
                {

                        if ($this->_imagesource!="")
                        {
                                if (is_file($this->getImageSourcePath()))
                                {
                                    $result = getimagesize($this->getImageSourcePath());

                                    if (is_array($result))
                                    {
                                            $bordersize = ($this->_border == 1) ? 2*1 : 0;

                                            list($width, $height, $type, $attr) = $result;
                                            $this->Width = $width + $bordersize;
                                            $this->Height = $height + $bordersize;
                                    }
                                }
                        }
                }

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
                }

                $key = md5($this->owner->Name.$this->Name.$this->Left.$this->Top.$this->Width.$this->Height);
                $bimg= $this->input->bimg;

                // Checks if the request is for this img
                if ((is_object($bimg)) && ($bimg->asString() == $key))
                {
                    $this->dumpGraphic();
                }

        }

        /**
        * Dumps the graphic as binary
        *
        * If Binary is true and BinaryType has been set, this method
        * is called to dump the binary information
        *
        * @see getBinaryType(), getBinary()
        */
        function dumpGraphic()
        {
                // Graphic component that dumps binary data
                header("Content-type: $this->_binarytype");

                // Tries to prevent the browser from caching the image
                header("Pragma: no-cache");
                header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

                if ($this->hasValidDataField())
                {
                    echo $this->readDataFieldValue();
                }

                exit;
        }

        function dumpContents()
        {
                if ($this->_onshow!=null)
                {
                        $this->callEvent('onshow',array());
                }
                else
                {
                        $map="";
                        if ($this->controls->count()>0)
                        {
                                $map = "usemap=\"#map$this->_name\"";
                        }

                        $events = $this->readJsEvents();
                        // add or replace the JS events with the wrappers if necessary
                        $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");

                        $imgwidth = $this->Width;
                        $imgheight = $this->Height;

                        $cwidth=$this->Width;
                        $cheight=$this->Height;
                        $imagecoords=false;

                        // first let's get the image size
                        if ($this->_imagesource != "")
                        {
                            if (is_file($this->getImageSourcePath()))
                            {
                                $result = getimagesize($this->getImageSourcePath());

                                if (is_array($result))
                                {
                                    //list($imgwidth, $imgheight, $type, $attr) = $result;
                                    list($iwidth, $iheight, $type, $attr) = $result;
                                    $imagecoords=true;
                                }
                            }
                        }

                        $attr = "";
                        $divstyle = "";
                        $imgstyle = "";

                        $divstyle .= " width: $this->_width; ";
                        $divstyle .= " height: $this->_height; ";
                        if (($this->ControlState & csDesigning) == csDesigning)
                        {
                                $divstyle .= "border:1px dashed gray;";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "" && $this->Style=="")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $divstyle .= "cursor: $cr;";
                        }

                        $w = $imgwidth;
                        $h = $imgheight;
                        $bordersize = ($this->_border == 1) ? 2*1 : 0;

                        if ((!$this->_stretch) && (!$this->_proportional))
                        {
                            $divstyle .= "overflow: hidden;";
                            if ($imagecoords)
                            {
                                $attr .= " width=\"$iwidth\" ";
                                $attr .= " height=\"$iheight\" ";
                            }
                            else
                            {
                                $attr .= " width=\"$cwidth\" ";
                                $attr .= " height=\"$cheight\" ";
                            }

                        }

                        if (($this->_stretch==1) && (!$this->_proportional))
                        {
                                $attr .= " width=\"$this->Width\" ";
                                $attr .= " height=\"$this->Height\" ";

                        }

                        if ($this->_proportional)
                        {
                            if ($imagecoords)
                            {

                                $hratio=$iwidth / $iheight;
                                $vratio=$iheight / $iwidth;

                                $twidth=$cheight*$hratio;
                                $theight=$cwidth*$vratio;

                                if ($twidth<$cwidth) $attr .= " height=\"$cheight\" ";
                                else $attr .= " width=\"$cwidth\" ";
                            }
                            else
                            {
                                $attr .= " width=\"$this->Width\" ";
                                $attr .= " height=\"$this->Height\" ";
                            }
                        }

                        if ($this->_center == 1)
                        {
                                $divstyle .= "text-align: center;";
                                $margin = floor(($this->_height - $h) / 2);
                                $imgstyle .= "margin-top: $margin;";
                        }

                        $hint = $this->getHintAttribute();
                        $hint .= ($hint != "") ? " alt=\"".(htmlspecialchars($this->_hint, ENT_QUOTES))."\"" : "";

                        if ($this->Style=="")
                        {
                                $attr .= " border=\"$this->_border\" ";

                                if ($this->_bordercolor!="") $attr .= " style=\" border-color: $this->_bordercolor \" ";
                        }

                        $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $divstyle.=" visibility:hidden; ";
                        }
                }


                        echo "<div id=\"{$this->_name}_container\" style=\"$divstyle\" $class>";

                        if ($this->_link != "")
                        {
                                echo "<A HREF=\"".$this->_link."\" $hint ";
                                if ($this->_linktarget!="") echo " target=\"".$this->_linktarget."\"";
                                echo ">";
                        }

                        if ($imgstyle != "") $imgstyle = "style=\"$imgstyle\"";

                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                if ($this->hasValidDataField())
                                {
                                        $this->_imagesource = $this->readDataFieldValue();
                                        // no hidden field to dump since it's a read-only control
                                }
                        }

                        $this->callEvent('oncustomize', array());

                        $source=$this->_imagesource;
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                            if ($this->_binary)
                            {
                                $key = md5($this->owner->Name.$this->Name.$this->Left.$this->Top.$this->Width.$this->Height);
                                $url = $GLOBALS['PHP_SELF'];
                                $source="$url?bimg=$key";
                            }
                        }

                        echo "<img id=\"$this->_name\" src=\"$source\" $attr $imgstyle $class $hint $map $events />";

                        if ($this->_link != "") echo "</A>";
                        echo "</div>";

                        if ($this->controls->count()>0)
                        {
                                echo "<map name=\"map$this->_name\">\n";
                                reset($this->controls->items);
                                while (list($k,$v)=each($this->controls->items))
                                {
                                        if ($v->Visible)
                                        {
                                                $v->show();
                                        }
                                }
                                echo "</map>";
                        }
                }
        }


        function dumpFormItems()
        {
                        // add a hidden field so we can determine which event for the label was fired
                        if ($this->_onclick != null)
                        {
                                $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                                echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                        }
        }
        /**
        * Write the Javascript section to the header
        */
        function dumpJavascript()
        {
                parent::dumpJavascript();

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

        /**
        * Occurs before the image tag is written to the stream sent to the client.
        * Use this event to modifiy the image source.
        * <code>
        * <?php
        *      function Image1Customize($sender, $params)
        *      {
        *               $this->Image1->ImageSource="url/test.jpg";
        *      }
        * ?>
        * </code>
        * @return mixed Event handler or null to unset.
        */
        function getOnCustomize                 () { return $this->_oncustomize; }
        function setOnCustomize                 ($value) { $this->_oncustomize=$value; }
        function defaultOnCustomize             () { return null; }


        /*
        * Publish the JS events for the component
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

        function getjsOnDragStart()             { return $this->readjsondragstart(); }
        function setjsOnDragStart($value)       { $this->writejsondragstart($value); }

        function getjsOnDragOver()              { return $this->readjsondragover(); }
        function setjsOnDragOver($value)        { $this->writejsondragover($value); }





        /*
        * Publish the properties for the component
        */

        /**
        * If Autosize is true the control takes over the size of the image.
        *
        * This way the image is displayed 100%.
        *
        * @see getCenter()
        *
        * @return bool
        */
        function getAutosize() { return $this->_autosize; }
        function setAutosize($value)  { $this->_autosize=$value; }

        /**
        * Adds a border around the image if true.
        *
        * This property specifies if the image is going to have a border around or not
        *
        * @see getLink()
        *
        * @return bool
        */
        function getBorder() { return $this->_border; }
        function setBorder($value) { $this->_border=$value; }

        /**
        * Color of the border, only has an affect if Border is set to true.
        *
        * Use the HTML hex color format. e.g. #FF0000 for red.
        *
        * @return string
        */
        function getBorderColor() { return $this->_bordercolor; }
        function setBorderColor($value) { $this->_bordercolor=$value; }
        function defaultBorderColor() { return ""; }

        /**
        * Indicates whether the image is centered in the image control.
        *
        * When the image does not fit perfectly within the image control,
        * use Center to specify how the image is positioned.
        * When Center is true, the image is centered in the control.
        * When Center is false, the upper left corner of the image is positioned
        * at the upper left corner of the control.
        *
        * Note: Center has no effect if the AutoSize property is true.
        *
        * @see getAutosize()
        *
        * @return bool
        */
        function getCenter() { return $this->_center; }
        function setCenter($value) { $this->_center=$value; }
        function defaultCenter() { return 0; }

        /**
        * DataField is the fieldname to be attached to the control.
        *
        * This property allows you to show/edit information from a table column
        * using this control. To make it work, you must also assign the Datasource
        * property, which specifies the dataset that contain the fieldname to work on
        *
        * @return string
        */
        function getDataField() { return $this->_datafield; }
        function setDataField($value) { $this->_datafield=$value; }
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
        function getDataSource() { return $this->_datasource; }
        function setDataSource($value) { $this->_datasource=$this->fixupProperty($value); }
        function defaultDataSource() { return ""; }

        /**
        * Source of the image denotes a path where the image is located.
        * This path can be relative to the script or absolute.
        *
        * @see getImageSourcePath()
        *
        * @return string
        */
        function getImageSource() { return $this->_imagesource; }
        function setImageSource($value) { $this->_imagesource=$value; }

        /**
        * If Link is set, the Image will link to that URL
        *
        *
        * @see getBorder()
        *
        * @return string Link, if empty string the link is not used.
        */
        function getLink() { return $this->_link; }
        function setLink($value) { $this->_link=$value; }

        /**
        * Target attribute when the label acts as a link.
        *
        * @see getLink()
        *
        * @link http://www.w3.org/TR/html4/present/frames.html#adef-target
        * @return string The link target as defined by the HTML specs.
        */
        function getLinkTarget() { return $this->_linktarget; }
        function setLinkTarget($value) { $this->_linktarget=$value; }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getPopupMenu() { return $this->readPopupMenu(); }
        function setPopupMenu($value) { $this->writePopupMenu($value); }

        /**
        * Indicates whether the image should be changed, without distortion,
        * so that it fits the bounds of the image control.
        *
        * Set Proportional to true to ensure that the image can be fully displayed
        * in the image control without any distortion. When Proportional is true,
        * images that are too large to fit in the image control are scaled down
        * (while maintaining the same aspect ratio) until they fit in the image control.
        * Images that are too small are displayed normally. That is,
        * Proportional can reduce the magnification of the image, but does not increase it.
        *
        * Note: The filesize is equal even the image is scaled down.
        *
        * @see getAutosize(), getCenter()
        *
        * @return bool
        */
        function getProportional() { return $this->_proportional; }
        function setProportional($value) { $this->_proportional=$value; }
        function defaultProportional() { return 0; }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getEnabled() { return $this->readenabled(); }
        function setEnabled($value) { $this->writeenabled($value); }

        /**
        * Indicates whether the image should be changed so that it exactly fits
        * the bounds of the image control.
        *
        * Set Stretch to true to cause the image to assume the size and shape of
        * the image control. When the image control resizes, the image resizes also.
        * Stretch resizes the height and width of the image independently. Thus,
        * unlike a simple change in magnification, Stretch can distort the image
        * if the image control is not the same shape as the image.
        *
        * To resize the control to the image rather than resizing the image to the
        * control, use the AutoSize property instead.
        *
        * The default value for Stretch is false.
        *
        * @return boolean
        */
        function getStretch() { return $this->_stretch; }
        function setStretch($value) { $this->_stretch=$value; }
        function defaultStretch() { return 0; }


}

define('fqLow','fqLow');
define('fqAutoLow','fqAutoLow');
define('fqAutoHigh','fqAutoHigh');
define('fqMedium','fqMedium');
define('fqHigh','fqHigh');
define('fqBest','fqBest');


/**
 * A class to encapsulate a Flash animation.
 *
 * This control may be used to include a flash animation into a page.
 * Use the property SwfFile to point to the URL of the flash file you want this
 * component to show.
 *
 */
class FlashObject extends GraphicControl
{
        protected $_swffile;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=105;
                $this->Height=105;

        }

	    function getColor() { return $this->readcolor(); }
	    function setColor($value) { $this->writecolor($value); }


        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        /**
        * Location of the Flash file (*.swf).
        * Path can be relative to the script or absolute.
        * @return string
        */
        function getSwfFile() { return $this->_swffile; }
        function setSwfFile($value) { $this->_swffile=$value; }

	    protected $_active=1;

	    function getActive() { return $this->_active; }
    	function setActive($value) { $this->_active=$value; }
    	function defaultActive() { return 1; }

    	protected $_loop=1;

    	function getLoop() { return $this->_loop; }
    	function setLoop($value) { $this->_loop=$value; }
    	function defaultLoop() { return 1; }

    protected $_quality=fqHigh;

    function getQuality() { return $this->_quality; }
    function setQuality($value) { $this->_quality=$value; }
    function defaultQuality() { return fqHigh; }



        function dumpContents()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $attr="";
                        if ($this->_width!="") $attr.=" width=\"$this->_width\" ";
                        if ($this->_height!="") $attr.=" height=\"$this->_height\" ";

                        $font = ($this->_parent != null) ? $this->_parent->Font->FontString : "";

                        $bstyle=" style=\"border: 1px dotted #000000; text-align: center; $font\" ";
                        echo "<table $attr $bstyle><tr><td>".basename($this->_swffile)."</td></tr></table>\n";
                }
                else
                {
                        $this->callEvent('onshow',array());

echo '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
echo 'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" ';
echo "id=\"$this->_name\" width=\"$this->_width\" height=\"$this->_height\">";
echo "<param name=\"movie\" value=\"$this->_swffile\">\n";

if ($this->_active) echo '<param name="play" value="true">';
else echo '<param name="play" value="false">';

if ($this->_loop) echo '<param name="loop" value="true">';
else echo '<param name="loop" value="false">';

$quality='high';
switch ($this->_quality)
{
case fqLow: $quality='low'; break;
case fqAutoLow: $quality='autolow'; break;
case fqAutoHigh: $quality='autohigh'; break;
case fqMedium: $quality='medium'; break;
case fqHigh: $quality='high'; break;
case fqBest: $quality='best'; break;
}

echo "<PARAM NAME=\"quality\" VALUE=\"$quality\">";
echo "<PARAM NAME=\"bgcolor\" VALUE=\"$this->_color\">";
echo "<EMBED src=\"$this->_swffile\" quality=\"$quality\" bgcolor=\"$this->_color\" WIDTH=\"$this->_width\" HEIGHT=\"$this->_height\" ";
echo "NAME=\"$this->_name\" ALIGN=\"\" TYPE=\"application/x-shockwave-flash\" ";

if ($this->_active) echo ' play="true" ';
else echo ' play="false" ';

if ($this->_loop) echo ' loop="true" ';
else echo ' loop="false" ';

echo 'PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED></OBJECT> ';
              }

        }
}


define('skRectangle', 'skRectangle');
define('skCircle', 'skCircle');
define('skDefault','skDefault');

/**
 * Encapsulates a shape for images, to create mapped images.
 *
 * This control is to be placed inside Image controls, so you can create zones inside
 * it and set a link or use javascript
 */
class MapShape extends Control
{
        //TODO: Add more shape types

        protected $_kind=skRectangle;
        protected $_link="#";

        protected $_onclick=null;
        protected $_ondblclick=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=20;
                $this->Height=20;

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

                        if ($this->_ondblclick != null && $submitEventValue->asString() == $this->readJSWrapperSubmitEventValue($this->_ondblclick))
                        {
                                $this->callEvent('ondblclick', array());
                        }
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

	    protected $_target="";

	    function getTarget() { return $this->_target; }
    	function setTarget($value) { $this->_target=$value; }
    	function defaultTarget() { return ""; }



        function dumpContents()
        {

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $attr="";
                        if ($this->_width!="") $attr.=" width=\"$this->_width\" ";
                        if ($this->_height!="") $attr.=" height=\"$this->_height\" ";

                        $bstyle=" style=\"border: 1px dotted #000000\" ";
                        echo "<table $attr $bstyle><tr><td>\n";
                }

                $l=$this->_left;
                $t=$this->_top;
                $w=$this->_left+$this->_width;
                $h=$this->_top+$this->_height;
                $centerx=$this->_left+$this->_width/2;
                $centery=$this->_top+$this->_height/2;
                $minimum=$this->_width>=$this->_height?$this->_width:$this->_height;
                $radius=$minimum/2;

                $events=$this->readJsEvents();

                $shape="";
                $coords="";

                switch($this->_kind)
                {
                        case skRectangle:
                                $shape='rect';
                                $coords="$l,$t,$w,$h";
                                break;
                        case skCircle:
                                $shape='circle';
                                $coords="$centerx,$centery,$radius";
                                break;
                        case skDefault:
                                $shape='default';
                                break;
                        default:
                                exit('Shape kind not valid.');

                }

                $target="";
                if ($this->_target!='') $target=' target="'.$this->_target.'" ';

                 // add or replace the JS events with the wrappers if necessary
                $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");

                $hint=$this->Hint!="" & $this->ShowHint?$this->Hint:"";
                echo "<area id=\"$this->_name\" shape=\"$shape\" coords=\"$coords\" title=\"$hint\" href=\"$this->_link\" $target $events />\n";

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo "</table>\n";
                }




                // add a hidden field so we can determine which event for the Paintbox was fired
                if ($this->_onclick != null || $this->_ondblclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }


        }


        //Javascript events
        function getjsOnMouseOut() { return $this->readjsOnMouseOut(); }
        function setjsOnMouseOut($value) { $this->writejsOnMouseOut($value); }

        function getjsOnMouseOver() { return $this->readjsOnMouseOver(); }
        function setjsOnMouseOver($value) { $this->writejsOnMouseOver($value); }

        function getjsOnClick() { return $this->readjsonclick(); }
        function setjsOnClick($value) { $this->writejsonclick($value); }

        function getjsOnDblClick() { return $this->readjsondblclick(); }
        function setjsOnDblClick($value) { $this->writejsondblclick($value); }


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
        function getOnClick() { return $this->_onclick; }
        function setOnClick($value) { $this->_onclick=$value; }
        function defaultOnClick() { return null; }
        function getOnDblClick() { return $this->_ondblclick; }
        function setOnDblClick($value) { $this->_ondblclick=$value; }
        function defaultOnDblClick() { return null; }


        /**
        * Specifies the type of shape to create on the Image
        *
        * Use this property to change the type of shape to create inside the
        * Image. You can create a rectangle or a circle inside the control bounds
        *
        * @return enum (skRectangle, skCircle, skDefault)
        */
        function getKind() { return $this->_kind; }
        function setKind($value) { $this->_kind=$value; }
        function defaultKind() { return skRectangle; }


        /**
        * The link to point the user to when clicking on the shape
        *
        * Use this property to set the link the user will go when clicking on the
        * shape.
        *
        * @return string
        */
        function getLink() { return $this->_link; }
        function setLink($value) { $this->_link=$value; }
        function defaultLink() { return "#"; }

        function getParentShowHint() { return $this->readparentshowhint(); }
        function setParentShowHint($value) { $this->writeparentshowhint($value); }

        function getShowHint() { return $this->readshowhint(); }
        function setShowHint($value) { $this->writeshowhint($value); }










}

/**
 * Base class for Panel
 *
 * Implements most of the functionality of a Panel and can be used as a grouping
 * zone for other components.
 */
class CustomPanel extends CustomControl
{
        protected $_include="";
        protected $_dynamic=0;

        protected $_background="";
        protected $_borderwidth=0;
        protected $_bordercolor="";
        protected $_backgroundrepeat="";
        protected $_backgroundposition="";

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";

                $this->ControlStyle="csRenderOwner=1";
                $this->ControlStyle="csRenderAlso=StyleSheet";
        }

        protected $_activelayer=0;

        /**
        * Specifies the Layer this panel has active, only controls with their
        * Layer property set to ActiveLayer, are shown
        *
        * @see Control::getLayer()
        *
        * @return string
        */
        function getActiveLayer() { return $this->_activelayer; }
        function setActiveLayer($value) { $this->_activelayer=$value; }
        function defaultActiveLayer() { return 0; }

        /**
        * Specifies the Background property for this panel, which can be an
        * image filename, so the image will be used as the background, check also
        * BackgroundRepeat and BackgroundPosition
        *
        * @see readBackgroundRepeat(), readBackgroundPosition()
        *
        * @return string
        */
        function readBackground() { return $this->_background; }
        function writeBackground($value) { $this->_background=$value; }
        function defaultBackground() { return ""; }

        //TODO: Add property editor to this property
        /**
        * Specifies the way the brackground is repeated, valid values for this
        * property are CSS values for the background-repeat
        *
        * @link http://www.w3.org/TR/REC-CSS2/colors.html#propdef-background-repeat
        *
        * @see readBackground(), readBackgroundPosition()
        *
        * @return string
        */
        function readBackgroundRepeat() { return $this->_backgroundrepeat; }
        function writeBackgroundRepeat($value) { $this->_backgroundrepeat=$value; }
        function defaultBackgroundRepeat() { return ""; }

        //TODO: Add property editor to this property

        /**
        * Specifies the position the brackground is placed, valid values for this
        * property are CSS values for the background-position
        *
        * @link http://www.w3.org/TR/REC-CSS2/colors.html#propdef-background-position
        *
        * @see readBackground(), readBackgroundRepeat()
        *
        * @return string
        */
        function readBackgroundPosition() { return $this->_backgroundposition; }
        function writeBackgroundPosition($value) { $this->_backgroundposition=$value; }
        function defaultBackgroundPosition() { return ""; }

        /**
        * Specifies the width for the border in pixels, by setting this property
        * you specify a border for the panel, check also BorderColor property
        *
        * @see readBorderColor()
        *
        * @return string
        */
        function readBorderWidth() { return $this->_borderwidth; }
        function writeBorderWidth($value) { $this->_borderwidth=$value; }
        function defaultBorderWidth() { return 0; }

        /**
        * Color for the border, the width of the Border must not be zero.
        *
        * Use this property to set the color with which the border is going to be
        * drawn. Use BorderWidth to specify the size, in pixels of the border.
        *
        * @see readBorderWidth()
        *
        * @return string
        */
        function readBorderColor() { return $this->_bordercolor; }
        function writeBorderColor($value) { $this->_bordercolor=$value; }
        function defaultBorderColor() { return ""; }

        /**
        * Specifies anything you want to include inside the panel, can be anything valid to include
        * on PHP, usually another .php file. Contents will be shown on design time
        *
        * @link http://www.php.net/manual/en/function.include.php
        *
        * @return string
        */
        function readInclude() { return $this->_include; }
        function writeInclude($value) { $this->_include=$value; }
        function defaultInclude() { return ""; }

        /**
        * Deprecated, not used
        * @return boolean
        */
        function readDynamic() { return $this->_dynamic; }
        function writeDynamic($value) { $this->_dynamic=$value; }
        function defaultDynamic() { return 0; }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                    //if (!$this->Visible) return;
                }
                $alignment="";
                $background="";
                $width="";
                $height="";
                $color="";
                $style="";

                switch ($this->_alignment)
                {
                        case agNone: $alignment=""; break;
                        case agLeft: $alignment=" align=\"Left\" "; break;
                        case agCenter: $alignment=" align=\"Center\" "; break;
                        case agRight: $alignment=" align=\"Right\" "; break;

                }

                if ($this->Style=="")
                {
                        if ($this->Color!="") $color=" bgcolor=\"$this->Color\" ";
                        if ($this->Background!="") $background=" background=\"$this->Background\" ";

                        $style.=" border: ".$this->_borderwidth."px solid $this->_bordercolor; ";

                        if ($this->BackgroundRepeat!="") $style.=" background-repeat: $this->BackgroundRepeat; ";
                        if ($this->BackgroundPosition!="") $style.=" background-position: $this->BackgroundPosition; ";
                }

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }

                if ($style!='') $style=" style=\"$style\" ";

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                if ($this->Width!="") $width=" width=\"$this->Width\" ";
                if ($this->Height!="") $height=" height=\"$this->Height\" ";

                $bstyle="";

                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        if (count($this->controls->items==0))
                        {
                                if ($this->_include=='')
                                {
                                        if (($this->_borderwidth!="") && ($this->_borderwidth!="0px") && ($this->_bordercolor!=""))
                                        {
                                        }
                                        else
                                        {
                                                $bstyle=" style=\"border: 1px dotted #000000\" ";
                                        }
                                }
                        }
                }

                $hint = $this->getHintAttribute();

                if ($this->_islayer)
                {
                        echo "<div id=\"$this->_name\" style=\"top: ".$this->_top."px; left: ".$this->_left."px; position: absolute; width: ".$this->_width."px; height: ".$this->_height."px; visibility: hidden\" $hint >\n";
                }

                if ($this->_adjusttolayout)
                {
                    $width=" width=\"100%\" ";
                    $height=" height=\"100%\" ";
                }
                if ($this->_include!="")
                {
                    include($this->_include);
                }
                else
                {
                    echo "<table id=\"{$this->_name}_table\" $width $height border=\"0\" $bstyle cellpadding=\"0\" cellspacing=\"0\" $alignment $color $background $style $class $hint>\n";
                echo "<tr>\n";
                if ((($this->ControlState & csDesigning)==csDesigning) || ($this->controls->count()==0))
                {
                        $spanstyle = ($this->Style=="") ? "style=\"".$this->Font->FontString."\"" : "class=\"$this->StyleClass\"";
                        echo "<td $spanstyle><span $spanstyle>$this->Caption</span>\n";
                }
                else
                {
                echo "<td valign=\"top\">\n";
                }
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $this->callEvent('onshow',array());
                        $this->Layout->dumpLayoutContents();
                }
                echo "</td>\n";
                echo "</tr>\n";
                echo "</table>\n";
                }

        }


}


/**
 * A component to group another controls
 *
 * Use Panel to put an empty panel on a form. Panels have properties and methods
 * to help manage the placement of child controls embedded in the panel.
 *
 * You can also use panels to group controls together, similar to the way you can
 * use a group box, but with a border (or no border) rather than the group box outline.
 * Panels are typically used for groups of controls within a single form.
 *
 * Although you can use a panel to implement a tool bar, it is recommended that you use the ToolBar class instead.
 */
class Panel extends CustomPanel
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getParentColor() { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }


        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getBackground() { return $this->readBackground(); }
        function setBackground($value) { $this->writeBackground($value); }

        function getBackgroundRepeat() { return $this->readBackgroundRepeat(); }
        function setBackgroundRepeat($value) { $this->writeBackgroundRepeat($value); }

        function getBackgroundPosition() { return $this->readBackgroundPosition(); }
        function setBackgroundPosition($value) { $this->writeBackgroundPosition($value); }

        function getBorderWidth() { return $this->readBorderWidth(); }
        function setBorderWidth($value) { $this->writeBorderWidth($value); }

        function getBorderColor() { return $this->readBorderColor(); }
        function setBorderColor($value) { $this->writeBorderColor($value); }

        function getLayout() { return $this->readLayout(); }
        function setLayout($value) { $this->writeLayout($value); }

        function getInclude() { return $this->readInclude(); }
        function setInclude($value) { $this->writeInclude($value); }

        function getIsLayer() { return $this->readIsLayer(); }
        function setIsLayer($value) { $this->writeIsLayer($value); }

        function getDynamic() { return $this->readDynamic(); }
        function setDynamic($value) { $this->writeDynamic($value); }

        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

}

/**
 * Control to group another controls inside a frame
 *
 * @example GroupBox/groupbox.php How to use GroupBox component
 */
class GroupBox extends QWidget
{
        function dumpContents()
        {
                $this->dumpCommonContentsTop();
                $avalue=str_replace('"','\"',$this->Caption);
                echo "        var ".$this->Name."    = new qx.ui.groupbox.GroupBox(\"$avalue\");\n";
//                echo "        $this->Name.setLeft(0);\n";
//                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";

                // add the common JS events to the QWidget (0 = no JS OnChange event added)
                $this->dumpCommonQWidgetJSEvents($this->Name, 0);

                 if($this->ShowHint==true && $this->Hint!="")
                        echo "  $this->Name.setToolTip(new qx.ui.popup.ToolTip(\"$this->Hint\"));\n";

                if ($this->Color != "")
                {
                        echo "        $this->Name.setBackgroundColor(new qx.renderer.color.Color(\"$this->Color\"));\n";
                        // set background color the the groupbox caption
                        echo "        var obj = $this->Name.getLegendObject();\n";
                        echo "        if (obj) obj.setBackgroundColor(new qx.renderer.color.Color(\"$this->Color\"));\n";
                }
                $js=$this->dumpChildrenControls(-23,-13);

                //if this control is disabled, all bellow it are too (all widget subtree)

                $this->dumpCommonContentsBottom();
        }

        //Publish some properties
        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getParentColor() { return $this->readParentColor(); }
        function setParentColor($value) { $this->writeParentColor($value); }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getPopupMenu() { return $this->readpopupmenu(); }
        function setPopupMenu($value) { $this->writepopupmenu($value); }

        function getEnabled() { return $this->readenabled(); }
        function setEnabled($value) { $this->writeenabled($value); }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=200;
                $this->Height=200;

                //This control can hold another controls
                $this->ControlStyle="csAcceptsControls=1";
        }

        function getjsOnBlur                    () { return $this->readjsOnBlur(); }
        function setjsOnBlur                    ($value) { $this->writejsOnBlur($value); }

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


}

define("btTop","btTop");
define("btRight","btRight");
define("btBottom","btBottom");
define("btLeft","btLeft");

/**
 * Base class for ButtonView class
 *
 * The typical apple-like tabview-replacements which could also be found
 * in more modern versions of the settings dialog in Mozilla Firefox.
 */
class CustomButtonView extends QWidget
{
        protected $_position=btLeft;
        protected $_items=array();
        protected $_images = null;

        function loaded()
        {
                parent::loaded();
                $this->writeImageList($this->_images);
        }

        /**
        * This is an internal method used to dump the buttons that make up
        * the ButtonView component
        *
        */
        private function dumpButtons($name, $items)
        {
                $event=$this->jsOnClick;
                if ($event!='') $event=", $event";
                else $event=", function dummy(){}";

                if (($this->ControlState & csDesigning) == csDesigning) $event=", function dummy(){}";

                reset($items);
                if (isset($items))
                {
                        echo "\n";
                        echo "  <!-- Define Buttons - Start -->\n";
                }
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

                        if ($image === "null")
                        {
                                $avalue=str_replace('"','\"',$caption);
                                echo "    var $itemname = new qx.ui.pageview.buttonview.Button(\"$avalue\");\n";
                        }
                        else
                        {
                                $avalue=str_replace('"','\"',$caption);
                                echo "    var $itemname = new qx.ui.pageview.buttonview.Button(\"$avalue\", $image);\n";
                        }
                        __QLibrary_SetCursor($itemname, $this->Cursor);
//                        echo "    $itemname.addEventListener(\"execute\", " . $this->Name . "_clickwrapper);\n";
                        echo "    $itemname.tag=$tag;\n";
                        echo "    $itemname.addEventListener(\"click\"$event);\n";

                        $elements[] = $itemname;
                }

                if (isset($elements))
                {
                        echo "  <!-- Define Buttons - Start -->\n";
                        echo "\n";
                        echo "  $name.getBar().add(" . implode(",", $elements) . ");\n";
                        unset($elements);

                        echo "  $name" . "_0.setChecked(true);\n";
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
                //This function is used as a common click processor for all item clicks
//                echo '<script type="text/javascript">';
//                echo "function $this->Name"."_clickwrapper(e)\n";
//                echo "{\n";
//                echo "  submit=true; \n";
//                if (($this->ControlState & csDesigning) != csDesigning)
//                {
//                        if ($this->JsOnClick!=null)
//                        {
//                                echo "  submit=".$this->JsOnClick."(e);\n";
//                        }
//                }
//                echo "  var tag=e.getTarget().tag;\n";
//                echo "  if ((tag!=0) && (submit))\n";
//                echo "  {\n";
//                echo "    var hid=findObj('$this->Name"."_state');\n";
//                echo "    if (hid) hid.value=tag;\n";
//                if (($this->ControlState & csDesigning) != csDesigning)
//                {
//                        $form = "document.".$this->owner->Name;
//                        echo "    if (($form.onsubmit) && (typeof($form.onsubmit) == 'function')) { $form.onsubmit(); }\n";
//                        echo "    $form.submit();\n";
//                }
  //              echo "    }\n";
//                echo "}\n";
//                echo '</script>';
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();

                $position = "top";
                switch ($this->_position)
                {
                        case btRight:  $position = "right"; break;
                        case btBottom: $position = "bottom"; break;
                        case btLeft:   $position = "left"; break;
                }

                echo "  var i = new qx.ui.basic.Inline(\"$this->Name\");\n";
                echo "  i.setHeight(\"auto\");\n";
                echo "  i.setWidth(\"auto\");\n";
                echo "  var $this->Name = new qx.ui.pageview.buttonview.ButtonView;\n";

//                echo "  $this->Name.setLeft(0);\n";
//                echo "  $this->Name.setTop(0);\n";
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight($this->Height);\n";

                echo "  $this->Name.setBarPosition(\"$position\");\n";

              $this->dumpButtons($this->Name, $this->_items);

                $this->dumpCommonContentsBottom();
          }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=63;
                $this->Height=335;

                $this->ControlStyle="csSlowRedraw=1";
        }

        /**
         * ImageList to be used when rendering each button, the list must
         * contain the image paths to the files to be used.
         * You can specify which image each button is going to use by setting
         * the ImageIndex property on the items structure array
         *
         * @return ImageList
         */
        protected function readImageList()      { return $this->_images; }
        protected function writeImageList($value) { $this->_images=$this->fixupProperty($value); }
        function defaultImageList()             { return null; }

        /**
         * Describes the buttons.
         * Use Items to access information about the elements in the menu.
         * Item contain information about Caption, associated image and Tag.
         *
         * @see readImageList()
         *
         * @return item collection
         */
        protected function readItems()          { return $this->_items; }
        protected function writeItems($value)   { $this->_items=$value; }

        /**
         * Defines a position/orientation of the ButtonView
         *
         * Use this property to set the orientation the control should use
         * when placed on a form.
         *
         * @see readItems()
         *
         * @return enum (btTop, btBottom, btLeft, btRight)
         */
        function readPosition()                 { return $this->_position; }
        function writePosition($value)
        {
            if ($this->_position!=$value)
            {
                /*
                $w=$this->Width;
                $h=$this->Height;

                switch ($value)
                {
                        case btTop:
                        case btBottom:
                                if (($this->_position = btLeft) || ($this->_position = btRight))
                                {
                                    $this->Height=$w; $this->Width=$h;
                                }
                                break;
                        case btLeft:
                        case btRight:
                                if (($this->_position = btTop) || ($this->_position = btBottom))
                                {
                                    $this->Height=$w; $this->Width=$h;
                                }
                                break;
                }
                */
                $this->_position=$value;
            }
        }
        function defaultPosition()              { return btLeft; }
}

/**
 * A set of buttons grouped together
 *
 * The typical apple-like tabview-replacements which could also be found
 * in more modern versions of the settings dialog in Mozilla Firefox.
 *
 * @example ButtonView/unit3.php How to use ButtonView component
 */
class ButtonView extends CustomButtonView
{
        //Publish common properties
        function getFont()              { return $this->readFont(); }
        function setFont($value)        { $this->writeFont($value); }

        function getParentFont()        { return $this->readParentFont(); }
        function setParentFont($value)  { $this->writeParentFont($value); }

        function getAlignment()         { return $this->readAlignment(); }
        function setAlignment($value)   { $this->writeAlignment($value); }

        function getCaption()           { return $this->readCaption(); }
        function setCaption($value)     { $this->writeCaption($value); }

        function getColor()             { return $this->readColor(); }
        function setColor($value)       { $this->writeColor($value); }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

        // Common events
        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }

        //Publish properties
        function getImageList()         { return $this->readImageList(); }
        function setImageList($value)   { $this->writeImageList($value); }

        function getItems()             { return $this->readItems(); }
        function setItems($value)       { $this->writeItems($value); }

        function getPosition()          { return $this->readPosition(); }
        function setPosition($value)    { $this->writePosition($value); }
}

define('orHorizontal', 'orHorizontal');
define('orVertical', 'orVertical');

/**
* CustomRadioGroup is the base class for radio-group components.
* When the user checks a radio button, all other radio buttons in its group become unchecked.
*
*/
class CustomRadioGroup extends FocusControl
{
        protected $_onclick = null;
        protected $_onsubmit = null;

        protected $_datasource = null;
        protected $_datafield = "";
        protected $_itemindex = -1;
        protected $_items = array();
        protected $_orientation = orVertical;
        protected $_taborder=0;
        protected $_tabstop=1;
        protected $_columns=1;

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

        function init()
        {
                parent::init();

                $submitted = $this->input->{$this->Name};

                if (is_object($submitted))
                {
                        // Allow the OnSubmit event to be fired because it is not
                        // a mouse or keyboard event.
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
                }

                $style="";
                if ($this->Style=="")
                {
                        // get the Font attributes
                        $style .= $this->Font->FontString;

                        if ($this->Color != "")
                        {
                                $style  .= "background-color: " . $this->Color . ";";
                        }

                        // add the cursor to the style
                        if ($this->_cursor != "")
                        {
                                $cr = strtolower(substr($this->_cursor, 2));
                                $style .= "cursor: $cr;";
                        }
                }

                $spanstyle = $style;

                $h = $this->Height - 2;
                $w = $this->Width;

                $style .= "height:" . $h . "px;width:" . $w . "px;";

                // set enabled/disabled status
                $enabled = (!$this->_enabled) ? "disabled=\"disabled\"" : "";

                // set tab order if tab stop set to true
                $taborder = ($this->_tabstop == 1) ? "tabindex=\"$this->_taborder\"" : "";

                //Add correct layout table for the grouping
                $style.="table-layout:fixed";

                // get the hint attribute; returns: title="[HintText]"
                $hint = $this->getHintAttribute();

                if ($this->readHidden())
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style.=" visibility:hidden; ";
                        }
                }

                if ($style  != "")  $style  = "style=\"$style\"";
                if ($style  != "")  $spanstyle  = "style=\"$spanstyle\"";


                // get the alignment of the Items
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

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->hasValidDataField())
                        {
                                //check if the value of the current data-field is in the itmes array as value
                                $val = $this->readDataFieldValue();
/*
                                $ds = $this->_datasource->DataSet;
                                $df = $this->_datafield;

                                //TODO: Save the position of the current record so we can reset it after the loop
                                //$ds->memorizeCurrentRecord();

                                $ds->first();
                                // iterate through all records and add them
                                while (!$ds->EOF)
*/
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

                $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                // call the OnShow event if assigned so the Items property can be changed
                if ($this->_onshow != null)
                {
                        $this->callEvent('onshow', array());
                }



                $hinttext=$this->_hint!=$this->defaultHint()&& $this->ShowHint==true?$this->_hint:$this->defaultHint();
                echo "<table id=\"{$this->_name}_table\" cellpadding=\"0\" title=\"$hinttext\" cellspacing=\"0\" width=\"$w\" $style $class>";
                if (is_array($this->_items) && count($this->_items)>0)
                {
                        // if horizontal then only add one row
                        //echo ($this->_orientation == orHorizontal) ? "<tr>" : "";
                        // $index is used to call the JS RadioGroupClick function
                        $index = 0;

                        $columnsWidth=$w/$this->_columns;
                        $numItems=count($this->items);

                        $itemsPerColumn=ceil($numItems/$this->_columns);

                        $rowHeight= $h/$itemsPerColumn;

                        $itemsPerRow=ceil($numItems/$itemsPerColumn);


                        for($row=0; $row<$itemsPerColumn; ++$row)
                        {
                                echo "<tr>\n";

                                for($column=0; $column<$itemsPerRow; ++ $column)
                                {
                                        echo "<td width=\"20\" height=\"$rowHeight\">\n";
                                        //do we have more items to place in this <td>?
                                        if($row+$itemsPerColumn*$column<$numItems)
                                        {
                                                $key=$row+$itemsPerColumn*$column;
                                                $item=$this->_items[$key];
                                                // add the checked attribut if the itemindex is the current item
                                                $checked = ($this->_itemindex == $key) ? "checked=\"checked\"" : "";
                                                // only allow an OnClick if enabled
                                                $itemclick = ($this->_enabled == 1 && $this->Owner != null) ? "onclick=\"return RadioGroupClick(document.forms[0].$this->_name, $index);\"" : "";
                                                echo "<input type=\"radio\" id=\"{$this->_name}_{$key}\" name=\"$this->_name\" value=\"$key\" $events $checked $enabled $taborder $hinttext $class />\n";
                                                $itemWidth=$columnsWidth-20;
                                                //ie needs cell style just in a span inside <td>, firefox needs them in the <td> amazing... ¬¬
                                                echo "</td><td $alignment width=\"$itemWidth\ height=\"$rowHeight\" style=\"overflow:hidden;white-space:nowrap\">\n";
                                                echo "<span id=\"{$this->_name}_{$key}_caption\"  style=\"white-space:nowrap\" $itemclick $hinttext $spanstyle $class>$item</span>\n";
                                        }
                                        echo "</td>\n";
                                }
                                echo "</tr>\n";
                        }

        /*                foreach ($this->_items as $key => $item)
                        {
                                // add the checked attribut if the itemindex is the current item
                                $checked = ($this->_itemindex == $key) ? "checked=\"checked\"" : "";
                                // only allow an OnClick if enabled
                                $itemclick = ($this->_enabled == 1 && $this->Owner != null) ? "onclick=\"return RadioGroupClick(document.forms[0].$this->_name, $index);\"" : "";

                                // add a new row for every item
//                                echo ($this->_orientation == orVertical) ? "<tr>\n" : "";

//                                echo "<td width=\"20\">\n";
                                if(!$index%$itemsPerColumn)
                                        echo "<tr>\n";
                                echo "<td width=\"$columnsWidth\">\n";
                                echo "<input type=\"radio\" id=\"{$this->_name}_{$key}\" name=\"$this->_name\" value=\"$key\" $events $checked $enabled $taborder $hint $class />\n";
                                echo "</td><td $alignment>\n";
                                echo "<span id=\"{$this->_name}_{$key}_caption\" $itemclick $hint $spanstyle $class>$item</span>\n";
                                echo "</td>\n";

                                echo ($this->_orientation == orVertical) ? "</tr>\n" : "";
                                $index++;
                        }
                        echo ($this->_orientation == orHorizontal) ? "</tr>" : "";*/
                }
                echo "</table>";

        }


        function dumpFormItems()
        {
                // add a hidden field so we can determine which radiogroup fired the event
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
                        if ($this->_onclick != null && !defined($this->_onclick))
                        {
                                // only output the same function once;
                                // otherwise if for example two radio groups use the same
                                // OnClick event handler it would be outputted twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }

                        // only output the function once
                        if (!defined('RadioGroupClick'))
                        {
                                define('RadioGroupClick', 1);

                                echo "
function RadioGroupClick(elem, index)
{
   if (!elem.disabled) {
     if (typeof(elem.length) == 'undefined') {
       elem.checked = true;
       return (typeof(elem.onclick) == 'function') ? elem.onclick() : false;
     } else {
       if (index >= 0 && index < elem.length) {
         elem[index].checked = true;
         return (typeof(elem[index].onclick) == 'function') ? elem[index].onclick() : false;
       }
     }
   }
   return false;
}
";
                        }
                }
        }


        /**
        * number of itens in the radio group, it returns the count of the internal
        * items array
        *
        * @return integer
        */
        function readCount()
        {
                return count($this->_items);
        }

        /**
        * Adds an item to the radio group control.
        *
        * @param mixed $item Value of item to add.
        * @param mixed $object Object to assign to the $item. is_object() is used to
        *                      test if $object is an object.
        * @param mixed $itemkey Key of the item in the array. Default key is used if null.
        * @return integer Return the number of items in the list.
        */
        function AddItem($item, $object = null, $itemkey = null)
        {
                if ($object != null)
                {
                        throw new Exception('Object functionallity for RadioGroup is not yet implemented.');
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

                return($this->Count);
        }

        /**
        * Deletes all of the items from the list control.
        */
        function Clear()
        {
                $this->_items = array();
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

        /**
        * Occurs when the control was submitted.
        *
        * Use this event to react when the form is submitted and the control
        * is about to update its contents using the user input
        *
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function readOnSubmit() { return $this->_onsubmit; }
        function writeOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }

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
        function writeDataSource($value)
        {
                $this->_datasource = $this->fixupProperty($value);
        }
        function defaultDataSource() { return null; }

        /**
        * Returns the value of the ItemIndex property.
        *
        * Use this property to get/set the index of the radio button in the
        * radio group that is selected. Use it at design-time to specify the
        * default radio button selection and use it in run-time to get the
        * user selection.
        *
        * @return mixed Return the ItemIndex of the list.
        */
        function readItemIndex() { return $this->_itemindex; }
        function writeItemIndex($value) { $this->_itemindex = $value; }
        function defaultItemIndex() { return -1; }

        /**
        * Contains the strings that appear in the radio group, use the AddItem
        * method to add a new one or assign a new structure array
        *
        * @return array
        */
        function readItems() { return $this->_items; }
        function writeItems($value)
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
        function defaultItems() { return array(); }

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

        /**
        * Sets the radiogroup layout to use this number of columns.
        */

        function getColumns() { return $this->_columns; }
        function setColumns($value){ $value>0?$this->_columns=$value:1; }
        function defaultColumns() { return 1; }
}

/**
* RadioGroup represents a group of radio buttons that function together.
*
* A RadioGroup object is a special group box that contains only radio buttons.
* Radio buttons that are placed directly in the same control component are said
* to be “grouped.” When the user checks a radio button, all other radio buttons
* in its group become unchecked. Hence, two radio buttons on a form can be
* checked at the same time only if they are placed in separate containers,
* such as group boxes.
*
* To add radio buttons to a TRadioGroup, edit the Items property in the Object
* Inspector. Each string in Items makes a radio button appear in the group box
* with the string as its caption. The value of the ItemIndex property determines
* which radio button is currently selected.
*
* Display the radio buttons in a single column or in multiple columns by setting the
* Columns property.
*
*/
class RadioGroup extends CustomRadioGroup
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


        function getItemIndex()
        {
                return $this->readItemIndex();
        }
        function setItemIndex($value)
        {
                $this->writeItemIndex($value);
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
 * Shape represents a geometric shape that can be drawn on a form.
 *
 * Add a Shape object to a form to draw a simple geometric shape on the form. Shape
 * introduces properties to describe the pen used to outline the shape and the brush
 * used to fill it.
 *
 * If the shape is only part of the image of a custom control, use the methods of the
 * control’s canvas instead.
 */
class Shape extends Control
{
        protected $_shape=stRectangle;
        protected $_pen=null;
        protected $_brush=null;
        protected $_canvas=null;

        function dumpHeaderCode()
        {
                $this->_canvas->InitLibrary();
                if (( $this->ControlState & csDesigning ) == csDesigning )
                {
                        echo "<div id=\"" . $this->Name . "_outer\" style=\"Z-INDEX: 2; WIDTH: "
                            . $this->Width . "px; HEIGHT: " . $this->Height . "px\">";
                }
        }

        function dumpContents()
        {
                $this->_canvas->BeginDraw();

                $penwidth = max($this->Pen->Width, 1);
                switch ($this->_shape)
                {
                        case stCircle:
                        case stSquare:
                        case stRoundSquare:
                                // need to center the shape
                                $size = min($this->Width, $this->Height) / 2 - $penwidth * 4;
                                $xc= $this->Width / 2;
                                $yc= $this->Height / 2;
                                $x1 = $xc - $size;
                                $y1 = $yc - $size;
                                $x2= $xc + $size;
                                $y2= $yc + $size;
                                break;
                        default:
                                $x1=$penwidth;
                                $y1=$penwidth;
                                $x2=max($this->Width, 2) - $penwidth * 2;
                                $y2=max($this->Height, 2) - $penwidth * 2;
                                $size=max($x2, $y2);
                                break;
                };

                $w = max($this->Width, 1);
                $h = max($this->Height, 1);

                $this->_canvas->Pen->Color = $this->Pen->Color;
//                $this->_canvas->Pen->Style = $this->Pen->Style;
                $this->_canvas->Pen->Width = $this->Pen->Width;
                $this->_canvas->Brush->Color = $this->Brush->Color;

                switch ($this->_shape)
                {
                        case stRectangle:
                        case stSquare:
                                $this->_canvas->FillRect($x1, $y1, $x2, $y2);
                                $this->_canvas->Rectangle($x1, $y1, $x2, $y2);
                                break;
                        case stRoundRect:
                        case stRoundSquare:
                                if ($w < $h) $s = $w;
                                else $s = $h;
                                $this->_canvas->RoundRect($x1, $y1, $x2, $y2, $s / 4, $s / 4);
                                break;
                        case stCircle:
                                $this->_canvas->Ellipse($x1, $y1, $x2 - 1, $y2 - 1);
                                break;
                        case stEllipse:
                                $this->_canvas->Ellipse($x1, $y1, $x2, $y2);
                                break;
                }

                $this->_canvas->EndDraw();
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=65;
                $this->Height=65;
                $this->_pen=new Pen();
                $this->_pen->_control=$this;
                $this->_brush=new Brush();
                $this->_brush->_control=$this;
                $this->_canvas = new Canvas($this);
        }

        /**
         * Specifies the shape the control is going to render, it can be any of the types
         * specified.
         *
         * Use this property to specify the shape that this component is going to draw
         * inside. Valid values for this property are:
         *
         * stCircle        The shape is a circle.
         *
         * stEllipse       The shape is an ellipse.
         *
         * stRectangle     The shape is a rectangle. (Default)
         *
         * stRoundRect     The shape is a rectangle with rounded corners.
         *
         * stRoundSquare   The shape is a square with rounded corners.
         *
         * stSquare        The shape is a square.
         *
         * @return enum
         */
        function getShape()                    { return $this->_shape; }
        function setShape($value)             { $this->_shape=$value; }
        function defaultShape()                 { return stRectangle; }

        /**
         * Specifies the pen used to outline the shape control, checkout Pen class
         * to know which subproperties you can use
         *
         * @see getBrush()
         *
         * @return Pen object
         */
        function getPen()            { return $this->_pen;       }
        function setPen($value)     { if (is_object($value)) $this->_pen=$value; }

        /**
         * Specifies the color and pattern used for filling the shape control, checkout
         * Brush class to know which subproperties you can use
         *
         * @see getPen()
         *
         * @return Brush object
         */
        function getBrush()          { return $this->_brush;       }
        function setBrush($value)   { if (is_object($value)) $this->_brush=$value; }

        // Published common properties
        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }

}

/**
 * Bevel represents a beveled outline.
 *
 * Use Bevel to create beveled boxes, frames, or lines. The bevel can appear raised or lowered.
 *
 * @see Shape
 *
 */
class Bevel extends GraphicControl
{
        protected $_shape=bsBox;
        protected $_bevelstyle=bsLowered;
        public $_canvas=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->_canvas = new Canvas($this);
        }

        function dumpHeaderCode()
        {
                $this->_canvas->InitLibrary();
                if (( $this->ControlState & csDesigning ) == csDesigning )
                {
                        echo "<div id=\"" . $this->Name . "_outer\" style=\"Z-INDEX: 2; WIDTH: "
                            . $this->Width . "px; HEIGHT: " . $this->Height . "px\">";
                }
        }

        function dumpContents()
        {
                $this->_canvas->BeginDraw();
                $w = max($this->Width, 1);
                $h = max($this->Height, 1);

                if (( $this->ControlState & csDesigning ) == csDesigning )
                {
/*
//                        $this->_canvas->Pen->Color = "#000000";
                        if ($this->_shape == bsSpacer)
                        {
//                                $this->_canvas->Pen->Style = psDot;
                                $this->_canvas->Pen->Color = "#FFFFFF";
                                $this->_canvas->Rectangle(0, 0, $w, $h);
                        }
                        else
                        {
//                                $this->_canvas->Pen->Style = psSolid;
                        }
*/
                }

                if ($this->_bevelstyle == bsLowered)
                {
                        $color1 = "#000000";
                        $color2 = "#EEEEEE";
                }
                else
                {
                        $color1 = "#EEEEEE";
                        $color2 = "#000000";
                };

                switch ($this->_shape)
                {
                        case bsFrame:
                                $temp = $color1;
                                $color1 = $color2;
                                $this->_canvas->BevelRect(1, 1, $w - 1, $h - 1, $color1, $color2);
                                $color2 = $temp;
                                $color1 = $temp;
                                $this->_canvas->BevelRect(0, 0, $w - 2, $h - 2, $color1, $color2);
                                break;
                        case bsTopLine:
                                $this->_canvas->BevelLine($color1, 0, 0, $w, 0);
                                $this->_canvas->BevelLine($color2, 0, 1, $w, 1);
                                break;
                        case bsBottomLine:
                                $this->_canvas->BevelLine($color1, 0, $h - 2, $w, $h - 2);
                                $this->_canvas->BevelLine($color2, 0, $h - 1, $w, $h - 1);
                                break;
                        case bsLeftLine:
                                $this->_canvas->BevelLine($color1, 0, 0, 0, $h);
                                $this->_canvas->BevelLine($color2, 1, 0, 1, $h);
                                break;
                        case bsRightLine:
                                $this->_canvas->BevelLine($color1, $w - 2, 0, $w - 2, $h);
                                $this->_canvas->BevelLine($color2, $w - 1, 0, $w - 1, $h);
                                break;
                        case bsSpacer:
                                break;
                        default:        // bsBox
                                $this->_canvas->BevelRect(0, 0, $w - 1, $h - 1, $color1, $color2);
                                break;
                }
                $this->_canvas->EndDraw();
        }


        /**
        * Determines the shape of the bevel
        *
        * bsBox - The bevel draws a box on the client area
        *
        * bsFrame  - The bevel draws a frame on the client area
        *
        * bsTopLine - A top line is drawn at the top of the client area
        *
        * bsBottomLine - A top line is drawn at the bottom of the client area
        *
        * bsLeftLine - A top line is drawn at the left of the client area
        *
        * bsRightLine - A top line is drawn at the right of the client area
        *
        * bsSpacer - Anything is drawn
        *
        * Set Shape to specify whether the bevel appears as a line, box, frame,
        * or space. For shapes that can appear either raised or lowered, the BevelStyle
        * property indicates which effect is used.
        *
        * The default value for Shape is bsBox.
        *
        * @see getBevel()
        *
        * @return enum
        */
        function getShape()            { return $this->_shape; }
        function setShape($value)     { $this->_shape=$value; }
        function defaultShape()         { return bsBox; }

        /**
        * Determines whether the bevel appears raised or lowered.
        *
        * bsLowered - The style used drawing the shape will be lowered
        *
        * bsRaised - The style used drawing the shape will be raised
        *
        * Set BevelStyle to indicate whether the bevel should create a raised or a
        * lowered effect. When the Shape property is bsBox, the entire client area
        * appears raised or lowered. For all other values of Shape, the bevel displays
        * a raised or lowered line along the edge or edges of the client area.
        *
        * The default value of Style is bsLowered.
        *
        * <code>
        * <?php
        *      function Button1Click($sender, $params)
        *      {
        *               //Toggles bevel style everytime the user clicks a button
        *               if ($this->Bevel1->BevelStyle==bsRaised)
        *               {
        *                       $this->Bevel1->BevelStyle=bsLowered;
        *               }
        *               else
        *               {
        *                       $this->Bevel1->BevelStyle=bsRaised;
        *               }
        *      }
        * ?>
        * </code>
        *
        * @see getShape()
        *
        * @return enum
        */
        function getBevelStyle()       { return $this->_bevelstyle; }
        function setBevelStyle($value){ $this->_bevelstyle=$value; }
        function defaultBevelStyle()    { return bsLowered; }

        function getVisible()           { return $this->readVisible(); }
        function setVisible($value)     { $this->writeVisible($value); }
}

/**
 * Timer encapsulates the javascript timer functions.
 *
 * Timer is used to simplify calling the javascript timer functions settimeout() and cleartimeout(),
 * and to simplify processing the timer events. Use one timer component for each timer in the application.
 *
 * The execution of the timer occurs through its OnTimer event. Timer has an Interval property
 * that determines how often the timer’s OnTimer event occurs. Interval corresponds to the parameter
 * for the javascript settimeout() function.
 *
 * @link http://developer.mozilla.org/en/docs/DOM:window.setTimeout
 * @link http://developer.mozilla.org/en/docs/DOM:window.clearTimeout
 */
class Timer extends Component
{
        protected $_interval = 1000;
        protected $_enabled = true;
        //protected $_ontimer = null;
        protected $_jsontimer = null;

        function dumpJavascript()
        {
                parent::dumpJavascript();

                if (($this->ControlState & csDesigning) == csDesigning) Break;

                if (($this->_enabled) && ($this->_jsontimer != null))
                {
                        $this->dumpJSEvent($this->_jsontimer);

                        echo "  var " . $this->Name . "_TimerID = null;\n";
                        echo "  var " . $this->Name . "_OnLoad = null;\n";
                        echo "\n\n";

                        echo "  function addEvent(obj, evType, fn)\n";
                        echo "  { if (obj.addEventListener)\n";
                        echo "    { obj.addEventListener(evType, fn, false);\n";
                        echo "      return true;\n";
                        echo "    }\n";
                        echo "    else if (obj.attachEvent)\n";
                        echo "    { var r = obj.attachEvent(\"on\"+evType, fn);\n";
                        echo "      return r;\n";
                        echo "    } else {\n";
                        echo "      return false;\n";
                        echo "    }\n";
                        echo "  }\n\n";

                        echo "  function " . $this->Name . "_InitTimer()\n";
                        echo "  {  if (" . $this->Name . "_OnLoad != null) " . $this->Name . "_OnLoad();\n";
                        echo "     " . $this->Name . "_DisableTimer();\n";
                        echo "     " . $this->Name . "_EnableTimer();\n";
                        echo "  }\n\n";

                        echo "  function " . $this->Name . "_DisableTimer()\n";
                        echo "  {  if (" . $this->Name . "_TimerID)\n";
                        echo "     { clearTimeout(" . $this->Name . "_TimerID); \n";
                        echo "       " . $this->Name . "_TimerID  = null;\n";
                        echo "     }\n";
                        echo "  }\n\n";

                        echo "  function " . $this->Name . "_Event()\n";
                        echo "  { \n";
                        echo "  var event = event || window.event; \n";
                        echo "  if (" . $this->Name . "_TimerID)\n";
                        echo "    {  " . $this->Name . "_DisableTimer();\n";
                        echo "       " . $this->_jsontimer . "(event);\n";
                        echo "       " . $this->Name . "_EnableTimer();\n";
                        echo "    }\n";
                        echo "  }\n\n";

                        echo "  function " . $this->Name . "_EnableTimer()\n";
                        echo "  { " . $this->Name . "_TimerID = self.setTimeout(\"" . $this->Name . "_Event()\", $this->_interval);\n";
                        echo "  }\n\n";

                        echo "  if (window.onload) " . $this->Name . "_OnLoad=window.onload;\n";
                        echo "  addEvent(window, 'load', " . $this->Name . "_InitTimer);\n";
                }
        }

        /**
         * Controls whether the timer generates OnTimer events periodically, so you can react
         * to them programatically
         *
         * Use Enabled to enable or disable the timer. If Enabled is true, the timer responds normally.
         * If Enabled is false, the timer does not generate OnTimer events. The default is true.
         *
         * @return boolean
         */
        function getEnabled()        { return $this->_enabled; }
        function setEnabled($value) { $this->_enabled=$value; }
        function defaultEnabled()     { return true; }


        /**
         * Determines the amount of time, in milliseconds, that passes before
         * the timer component initiates another OnTimer event.
         *
         * Interval determines how frequently the OnTimer event occurs. Each time
         * the specified interval passes, the OnTimer event occurs.
         *
         * Use Interval to specify any cardinal value as the interval between
         * OnTimer events. The default value is 1000 (one second).
         *
         * Note: A 0 value is valid, however the timer will not call an OnTimer event for a value of 0.
         *
         * @see getjsOnTimer()
         *
         * @return integer
         */
        function getInterval()       { return $this->_interval; }
        function setInterval($value) { $this->_interval=$value; }
        function defaultInterval()    { return 1000; }

        /**
         * Occurs when a specified amount of time, determined by the Interval
         * property, has passed.
         *
         * Write an OnTimer event handler to execute an action at regular intervals.
         * The Interval property of a timer determines how frequently the OnTimer event
         * occurs. Each time the specified interval passes, the OnTimer event occurs.
         *
         * @see getInterval()
         *
         * @return mixed
         */
        function getjsOnTimer()      { return $this->_jsontimer; }
        function setjsOnTimer($value) { $this->_jsontimer=$value; }
        function defaultjsOnTimer()   { return null; }
}

/**
 * PaintBox provides a canvas that applications can use for rendering an image.
 *
 * Use PaintBox to add custom images to a form. Unlike Image, which displays an
 * image that is stored in a file, PaintBox requires an application to draw the
 * image directly on a canvas. Use the OnPaint event handler to draw on the paint
 * box’s Canvas, the drawing surface of the paint box.
 *
 * @example Canvas/TestCanvas.php How to use Canvas
 */
class PaintBox extends Control
{
        protected $_canvas = null;
        protected $_onpaint = null;
        protected $_onclick=null;
        protected $_ondblclick=null;

        /**
        * This is an internal method you don't need to call directly
        *
        * This method is called by the Ajax engine to get the code to update the
        * component after an ajax call
        *
        */

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

        /**
        * This is an internal method you don't need to call directly
        *
        * This method is called by the Ajax engine to get the code to update the
        * component after an ajax call
        *
        */
        function dumpForAjax()
        {
                // $this->Canvas implicitly calls $this->_canvas->SetCanvasProperties($this->Name);
                $this->callEvent('onpaint', $this->Canvas);
                $this->_canvas->Paint();
        }

        function dumpHeaderCode()
        {
                if (($this->ControlState & csDesigning)!==csDesigning)
                {
                        $this->_canvas->InitLibrary();
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

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        echo "<table width=\"$this->Width\" height=\"$this->Height\" border=\"0\" style=\"border: 1px dotted #000000\" cellpadding=\"0\" cellspacing=\"0\">\n";
                        echo "<tr>\n";
                        echo "<td align=\"center\">$this->Name</td>\n";
                        echo "</tr>\n";
                        echo "</table>\n";
                }
                else
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                $style="";

                                $hint=$this->ShowHint?$this->Hint:"";
                                $hint="title=\"".$hint."\" ";

                                // set height and width to the style attribute
                                if (!$this->_adjusttolayout)
                                {
                                    $style .= "height:" . $this->Height . "px;width:" . $this->Width . "px;";
                                }
                                else
                                {
                                    $style .= "height:100%;width:100%;";
                                }
                                $events = $this->readJsEvents();

                                // add or replace the JS events with the wrappers if necessary
                                $this->addJSWrapperToEvents($events, $this->_onclick,    $this->_jsonclick,    "onclick");
                                $this->addJSWrapperToEvents($events, $this->_ondblclick, $this->_jsondblclick, "ondblclick");

                                echo "<div id=\"$this->_name\" $hint style=\"$style\" $events >";
                                $this->_canvas->BeginDraw();
                                $this->callEvent('onpaint', $this->_canvas);
                                $this->_canvas->EndDraw();

                                // add a hidden field so we can determine which event for the Paintbox was fired
                                if ($this->_onclick != null || $this->_ondblclick != null)
                                {
                                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                                }
                                echo "</div>";
                        }
                }
        }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->_canvas = new Canvas($this);
                $this->Width = 100;
                $this->Height = 100;
        }

        /**
        * Provides the Canvas to use to draw on the OnPaint event
        *
        * Use this property to get the Canvas object you need to use when
        * drawing on the PaintBox object.
        *
        * @example Canvas/TestCanvas.php How to use Canvas
        *
        * @return Canvas
        */
        function readCanvas() {
          // This is needed to allow drawing directly from JavaScript events
          // without the need of beginDraw and endDraw.
          $this->_canvas->SetCanvasProperties($this->Name);
          return $this->_canvas;
        }

        function getPopupMenu() { return $this->readPopupMenu(); }
        function setPopupMenu($value) { $this->writePopupMenu($value); }

        function getParentShowHint() { return $this->readparentshowhint(); }
        function setParentShowHint($value) { $this->writeparentshowhint($value); }

        function getVisible() { return $this->readvisible(); }
        function setVisible($value) { $this->writevisible($value); }

        function getShowHint() { return $this->readshowhint(); }
        function setShowHint($value) { $this->writeshowhint($value); }



        /**
        * Fired when the control requires you to paint its contents.
        *
        * The canvas you can use to draw is sent on the $params parameter of the event,
        * checkout the Canvas class to know the methods and properties you have available to draw
        *
        * @example Canvas/TestCanvas.php How to use Canvas
        * @see Canvas
        * @return mixed
        */
        function getOnPaint()        { return $this->_onpaint; }
        function setOnPaint($value) { $this->_onpaint=$value; }


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
        function getOnClick(){ return $this->_onclick; }
        function setOnClick($value){ $this->_onclick=$value; }
        function defaultOnClick() { return null ; }

        function getOnDblClick(){ return $this->_ondblclick; }
        function setOnDblClick($value){ $this->_ondblclick=$value; }
        function defaultOnDblClick() { return null ; }


        //JS events
        function getjsOnClick() { return $this->readjsonclick(); }
        function setjsOnClick($value) { $this->writejsonclick($value); }

        function getjsOnDblClick() { return $this->readjsOnDblClick (); }
        function setjsOnDblClick($value) { $this->writejsOnDblClick ($value); }

        function getjsOnDragOver() { return $this->readjsOnDragOver(); }
        function setjsOnDragOver($value) { $this->writejsOnDragOver($value); }

        function getjsOnDragStart() { return $this->readjsondragstart(); }
        function setjsOnDragStart($value) { $this->writejsondragstart($value); }


        function getjsOnMouseDown() { return $this->readjsonmousedown(); }
        function setjsOnMouseDown($value) { $this->writejsonmousedown($value); }

        function getjsOnMouseEnter() { return $this->readjsonmouseenter(); }
        function setjsOnMouseEnter($value) { $this->writejsonmouseenter($value); }

        function getjsOnMouseLeave() { return $this->readjsonmouseleave(); }
        function setjsOnMouseLeave($value) { $this->writejsonmouseleave($value); }

        function getjsOnMouseMove() { return $this->readjsonmousemove(); }
        function setjsOnMouseMove($value) { $this->writejsonmousemove($value); }

        function getjsOnMouseUp() { return $this->readjsonmouseup(); }
        function setjsOnMouseUp($value) { $this->writejsonmouseup($value); }




}

?>