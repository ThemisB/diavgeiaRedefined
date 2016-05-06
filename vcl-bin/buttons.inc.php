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

use_unit("extctrls.inc.php");

/**
*
*/
define('blImageBottom', 'blImageBottom');
define('blImageLeft', 'blImageLeft');
define('blImageRight', 'blImageRight');
define('blImageTop', 'blImageTop');


//Button kinds
define('bkCustom','bkCustom');
define('bkOK','bkOK');
define('bkCancel','bkCancel');
define('bkYes','bkYes');
define('bkNo','bkNo');
define('bkHelp','bkHelp');
define('bkClose','bkClose');
define('bkAbort','bkAbort');
define('bkRetry','bkRetry');
define('bkIgnore','bkIgnore');
define('bkAll','bkAll');

/**
 * BitBtn is a push button control that can include a bitmap on its face.
 *
 * Bitmap buttons exhibit the same behavior as button controls. Use them to initiate
 * actions from forms or pages.
 *
 * Bitmap buttons implement properties that specify the bitmap images, along with
 * their appearance and placement on the button. You can use your own customized bitmap for
 * the button. The button can be associated with only one bitmap throught the ImageSource property.
 *
 * You can specify the button’s response by writing an OnClick event handler.
 *
 * @see Button, SpeedButton, QWidget
 *
 */
class BitBtn extends QWidget
{
        protected $_onclick = null;

        protected $_imagesource = "";
        protected $_imagedisabled = "";
        protected $_imageclicked = "";
        protected $_buttonlayout = blImageLeft;
        protected $_kind=bkCustom;
        protected $_buttontype = btSubmit;
        protected $_spacing=4;
        protected $_default;
        protected $_cancel;
        protected $_action;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=75;
                $this->Height=25;
        }

        /**
        * Returns the right path to the image to show
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

        function init()
        {
                parent::init();

                $submitEventValue = $this->input->{$this->readJSWrapperHiddenFieldName()};

                if (is_object($submitEventValue) && $this->_enabled == 1)
                {
                        // check if the a click event has been fired
                        if ($this->_onclick != null && $submitEventValue->asString() == $this->readJSWrapperSubmitEventValue($this->_onclick))
                        {
                                $this->callEvent('onclick', array());
                        }
                }
        }

        function dumpJavascript()
        {
                parent::dumpJavascript();

                if ($this->_enabled == 1)
                {
                        if ($this->_onclick != null && !defined($this->_onclick))
                        {
                                // only output the same function once;
                                // otherwise, if for example two buttons use the same
                                // OnClick event handler it would be output twice.
                                $def=$this->_onclick;
                                define($def,1);

                                // output the wrapper function
                                echo $this->getJSWrapperFunction($this->_onclick);
                        }
                }

                if (!defined('updateButtonTheme') && $this->classNameIs("BitBtn"))
                {
                        define('updateButtonTheme', 1);

                        echo "
function updateButtonTheme() {
  var theme =  qx.manager.object.AppearanceManager.getInstance().getAppearanceTheme();
  var apar = theme.getAppearance('button');
  if (!apar) {
     return;
  }
  var oldState = apar.state;
  apar.state = function(vTheme, vStates) {
    var res = oldState ? oldState.apply(this, arguments):{};

    if (typeof(res) != 'undefined' && typeof(res.backgroundColor) != 'undefined')
      delete res.backgroundColor;

    return res;
  }
}
";

}
        }

        /**
        * This is an internal method you don't need to call directly
        *
        * This method is called by the Ajax engine to get the code to update the
        * component after an ajax call
        *
        * @see commonScript()
        *
        */
        function dumpForAjax()
        {
                $this->commonScript();
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        echo "<script type=\"text/javascript\">updateButtonTheme();</script>\n";
                }

                $this->dumpCommonContentsTop();

                $imgwidth = 0;
                $imgheight = 0;

                $imsource=$this->_imagesource;
                $predefimage='';
                if ($this->_kind!=bkCustom)
                {
                  switch($this->_kind)
                  {
                      case bkOK:
                        $predefimage='/images/ok.gif';
                        break;
                      case bkCancel:
                        $predefimage='/images/cancel.gif';
                        break;
                      case bkYes:
                        $predefimage='/images/yes.gif';
                        break;
                      case bkNo:
                        $predefimage='/images/no.gif';
                        break;
                      case bkHelp:
                        $predefimage='/images/help.gif';
                        break;
                      case bkClose:
                        $predefimage='/images/close.gif';
                        break;
                      case bkAbort:
                        $predefimage='/images/abort.gif';
                        break;
                      case bkRetry:
                        $predefimage='/images/retry.gif';
                        break;
                      case bkIgnore:
                        $predefimage='/images/ignore.gif';
                        break;
                      case bkAll:
                        $predefimage='/images/all.gif';
                        break;
                  }
                }

                if ($predefimage!='') $this->_imagesource=VCL_FS_PATH.$predefimage;
                // first get the image size
                if ($this->_imagesource != "")
                {
                        $result = getimagesize($this->getImageSourcePath());

                        if (is_array($result))
                        {
                                list($imgwidth, $imgheight, $type, $attr) = $result;
                        }
                }

                if ($predefimage!='') $this->_imagesource=VCL_HTTP_PATH.$predefimage;

                $btnimage = "";
                if ($imgwidth > 0 && $imgheight > 0)
                {
                        //If spacing=-1 must be done
                        $finalsize=$imgwidth+$this->_spacing;
                        $btnimage = ",\"$this->_imagesource\",$finalsize,$imgheight";
                }

                $this->_imagesource=$imsource;

                // set teh general properties of the button
                $avalue=$this->Caption;
                $avalue=str_replace('"','\"',$avalue);
                echo "        var ".$this->Name." = new qx.ui.form.Button(\"$avalue\"$btnimage);\n";
                //We need to set this here before commonScripts are dumped, this way when Enabled is initialized
                //correct image will be shown
                if((($this->ControlState & csDesigning) != csDesigning) && $this->_imagedisabled!=$this->defaultImageDisabled())
                {
                        echo "$this->Name.addEventListener(\"changeEnabled\", function()
                        {       if($this->Name.getEnabled()==false)
                                        $this->Name.setIcon(\"$this->_imagedisabled\");
                                else
                                        $this->Name.setIcon(\"$this->ImageSource\");
                        } );\n";
                }

                $this->commonScript();

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        // add the onclick wrapper to the event listener
                        if ($this->_onclick != null && $this->Owner != null)
                        {
                                $wrapperEvent = $this->getJSWrapperFunctionName($this->_onclick);
                                $submitEventValue = $this->readJSWrapperSubmitEventValue($this->_onclick);
                                $hiddenfield = $this->readJSWrapperHiddenFieldName();
                                $hiddenfield = "findObj('$hiddenfield')";
                                echo "        $this->Name.addEventListener(\"execute\", function(){var event = event || window.event; return $wrapperEvent(event, $hiddenfield, '$submitEventValue', null) } );\n";


                        }

                        if($this->_imageclicked!=$this->defaultImageClicked())
                        {

                                echo "  $this->Name.addEventListener(\"mousedown\", function()
                                      {

                                        this.setIcon(\"$this->_imageclicked\");

                                      } );\n";
                        }

                        $upImage="";
                        $this->ImageSource!=$this->defaultImageSource() ? $upImage=$this->ImageSource: $upImage=$this->defaultImageSource();
                        echo "
                                      $this->Name.addEventListener(\"mouseup\", function()
                                      {
                                              this.setIcon(\"$upImage\");

                                      } );\n";

                        // add the common JS events to the QWidget (0 = no JS OnChange event added)
                        $this->dumpCommonQWidgetJSEvents($this->Name, 0);

                        //dump JS event for click, and add a event handler to the event chain
                        switch($this->_buttontype)
                        {
                                case btSubmit:
                                        //this function will return false to avoid more events to be executed
                                        echo "$this->Name.addEventListener(\"execute\",function(e)\n
                                                {\n
                                                    document.forms[0].submit();
                                                    return false;
                                                });";
                                        break;
                                case btNormal:
                                        //Nothing to do, this will be dumped in the dumpCommonQWidgetJSEvents()
                                        break;
                                case btReset:
                                        //this function will return false to avoid more events to be executed
                                        echo "$this->Name.addEventListener(\"execute\",function(e)\n
                                                {\n
                                                    document.forms[0].reset();
                                                    return false;
                                                });";
                                        break;
                                default:
                                        echo "$this->_buttontype is not a correct type for BitBtn";
                                        exit();
                        }


                }


                // Call the OnShow event handler after all settings of the BitBtn
                // have been output so it is possible to reset them in the OnShow event.
                $this->callEvent('onshow', array());
                $this->dumpCommonContentsBottom();

                // add a hidden field so we can determine which event was fired for the button
                if ($this->_onclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
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
                function CommonScript()
                {
//                echo "        $this->Name.setLeft(0);\n";
//                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";

                // adds Enabled, Visible, Font and Color property
                $this->dumpCommonQWidgetProperties($this->Name, 0);

                // set font the the button's label
                echo "        var lblobj = $this->Name.getLabelObject();\n";
                echo "        if (lblobj) lblobj.setFont(\"{$this->Font->Size} '{$this->Font->Family}' {$this->Font->Weight}\");\n";
                // set the font color
                if ($this->Font->Color != "")
                        echo "        $this->Name.setColor(new qx.renderer.color.Color('{$this->Font->Color}'));\n";

                // set the layout
                if ($this->_buttonlayout != blImageLeft)
                {
                        $iconPos = "";
                        switch ($this->_buttonlayout)
                        {
                                case blImageBottom: $iconPos = "bottom"; break;
                                case blImageRight:  $iconPos = "right"; break;
                                case blImageTop:    $iconPos = "top"; break;
                        }
                        echo "        $this->Name.setIconPosition('$iconPos');\n";
                }

                // set hint
                $hint = $this->getHintAttribute();
                if ($hint != "")
                        echo "        $this->Name.setHtmlAttribute('title', '$this->Hint');\n";

                // set cursor
                if ($this->Cursor != "")
                        echo "        $this->Name.setStyleProperty('cursor', '".strtolower(substr($this->Cursor, 2))."');\n";

                // set background color
                if ($this->Color != "")
                        echo "        ".$this->Name.".setBackgroundColor(new qx.renderer.color.Color('$this->Color'));\n";
                else
                        echo "        ".$this->Name.".setBackgroundColor(new qx.renderer.color.ColorObject('buttonface'));\n";
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

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        function getEnabled() { return $this->readEnabled(); }
        function setEnabled($value) { return $this->writeEnabled($value); }


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






        /**
        * Specifies the image that appears on the bitmap button.
        *
        * This property determines the URL where to find the image to be used as bitmap for this button.
        * If empty no image is rendered on the button and you have to be sure the image is accesible to the web server.
        * The image will be placed according to the setting of ButtonLayout property.
        *
        * <code>
        * <?php
        *      function Button1Click($sender, $params)
        *      {
        *               //Assigns an image to be shown on the bitbtn
        *               $this->BitBtn1->ImageSource="images/btnok.gif";
        *      }
        * ?>
        * </code>
        *
        * @see getButtonLayout()
        *
        * @return string
        */
        function getImageSource() { return $this->_imagesource; }
        function setImageSource($value) { $this->_imagesource = $value; }
        function defaultImageSource() { return ""; }

        /**
        * Specifies the position where the image appears on the bitmap button.
        *
        * ButtonLayout indicates whether the text appears on the left of the button (blImageLeft),
        * the right of the button (blImageRight), the top (blImageTop) or the bottom (blImageBottom).
        * To specify the image will be shown, check ImageSource property.
        *
        * Possible values for this property are:
        *
        * blImageBottom - Image will be placed at the bottom
        *
        * blImageLeft - Image will be placed at the left
        *
        * blImageRight - Image will be placed at the right
        *
        * blImageTop - Image will be placed at the top
        *
        *
        * @see getImageSource()
        *
        * @return enum
        */
        function getButtonLayout() { return $this->_buttonlayout; }
        function setButtonLayout($value) { $this->_buttonlayout=$value; }
        function defaultButtonLayout() { return blImageLeft; }

        /**
        *  Specifies the kind of bitmap button.
        *
        * Use Kind to specify the appearance of the BitBtn control.
        *
        * The images (such as the green check mark on the OK button) appear on
        * the button when using this version of BitBtn.
        *
        * @return enum(bkCustom, bkOK, bkCancel, bkYes, bkNo, bkHelp, bkClose, bkAbort, bkRetry, bkIgnore, bkAll)
        */
        function getKind() { return $this->_kind; }
        function setKind($value) { $this->_kind=$value; }
        function defaultKind() { return bkCustom; }

        /**
        * This image usually appears dimmed to indicate that the button can't be selected.
        */
        function getImageDisabled() { return $this->_imagedisabled; }
        function setImageDisabled($value) { $this->_imagedisabled=$value;}
        function defaultImageDisabled() { return ""; }

        /**
        * This image appears when the button is clicked. The Up image reappears when the user releases the mouse button.
        */
        function getImageClicked() { return $this->_imageclicked; }
        function setImageClicked($value) { $this->_imageclicked=$value;}
        function defaultImageClicked() { return ""; }


        /**
        * Determines where the image and text appear on a bitmap button.
        *
        * Spacing determines the number of pixels between the image (specified in
        * the Image properties) and the text (specified in the Caption property).
        * The default value is 4 pixels.
        *
        * If Spacing is a positive number, its value is the number of pixels between
        * the image and text. If Spacing is 0, no pixels will be between the image and
        * text. If Spacing is -1, the text appears centered between the image and the
        * button edge. The number of pixels between the image and text is equal to
        * the number of pixels between the text and the button edge opposite the glyph.
        *
        * @return integer
        */
        function getSpacing() { return $this->_spacing; }
        function setSpacing($value) { $this->_spacing=$value; }
        function defaultSpacing() { return 4; }

        function getParentColor() { return $this->readparentcolor(); }
        function setParentColor($value) { $this->writeparentcolor($value); }


        function getParentFont() { return $this->readParentFont(); }
        function setParentFont($value) { $this->writeParentFont($value); }

        function getParentShowHint() { return $this->readParentShowHint(); }
        function setParentShowHint($value) { $this->writeParentShowHint($value); }

        function getPopupMenu() { return $this->readPopupMenu(); }
        function setPopupMenu($value) { $this->writePopupMenu($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

/*        function getDefault() { return $this->_default; }
        function setDefault($value) { $this->_default=$value; }
        function defaultDefault() {return false;}

        function getCancel() { return $this->_cancel; }
        function setCancel($value) { $this->_cancel=$value; }
        function defautCancel() {return false;}*/

        /**
        * Determines the type of button you want to create, this type determines also some built-in functions
        * for buttons inside HTML forms.
        *
        * A BitBtn can have 3 different types:
        *
        * btSubmit - submits the HTML form
        *
        * btReset - resets the HTML form back to the initial values
        *
        * btNormal - is a regular button, the browser does not submit the form if no OnClick event has been assigned
        *
        * @return enum (btSubmit, btReset, btNormal)
        */
        function getButtonType() { return $this->_buttontype; }
        function setButtonType($value) { $this->_buttontype=$value; }
        function defaultButtonType() {return btSubmit;}
}

/**
 * SpeedButton is a button that is used to execute commands or set modes.
 *
 * Use SpeedButton to add a button to a group of buttons in a form. SpeedButton
 * also introduces properties that allow speed buttons to work together as a group.
 * Speed buttons are commonly grouped in panels to create specialized tool bars
 * and tool palettes.
 *
 * @see BitBtn, QWidget
 */
class SpeedButton extends BitBtn
{
        private $_updating = 0;

        protected $_allowallup=0;
        protected $_down=0;
        protected $_flat=0;
        protected $_groupindex=0;


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width  = 25;
                $this->Height = 25;

                $this->ControlStyle = "csRenderOwner=1";
                $this->ControlStyle = "csRenderAlso=SpeedButton";
        }

        function loaded()
        {
                parent::loaded();

                $submitteddown = $this->input->{"{$this->Name}Down"};
                if (is_object($submitteddown) && $submitteddown->asString() != "")
                {
                        $this->Down = ($submitteddown->asString() == "1") ? 1 : 0;
                }
        }

        function dumpContents()
        {
                $down = ($this->Down) ? 1 : 0;
                echo "<input type=\"hidden\" name=\"{$this->Name}Down\" id=\"{$this->Name}Down\" value=\"$down\" />";

                $this->dumpCommonContentsTop();

                $btnimage = ($this->_imagesource != "") ? ",\"$this->_imagesource\"" : "";

                // set the general properties of the button
                $avalue=$this->Caption;
                $avalue=str_replace('"','\"',$avalue);
                echo "        var $this->Name = new qx.ui.toolbar.RadioButton(\"$avalue\"$btnimage);\n";
                echo "        $this->Name.setAppearance('$this->Name');\n";
//                echo "        $this->Name.setLeft(0);\n";
//                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";

                // add an changeChecked event listener so the hidden field can be updated
                //$hiddenfield = ($this->owner != null) ? "document.forms[0].{$this->Name}Down" : "";
                $hiddenfield = ($this->owner != null) ? "findObj(\"{$this->Name}Down\")" : "";
                if ($hiddenfield != "")
                {
                        echo "        $this->Name.addEventListener(\"changeChecked\", function() { $hiddenfield.value = (this && this.getChecked()) ? 1 : 0; }, $this->Name);\n";
                }



                // user cannot unselect a selected button
                if ($this->_allowallup == 0 && $this->_groupindex > 0)
                {
                        echo "        $this->Name.setDisableUncheck(true);\n";
                }

                // add radio manager only if group index is greater than 0 and the radio manager was not already output
                if ($this->_groupindex > 0)
                {
                        if (!defined("sbmanager_$this->_groupindex"))
                        {
                                define("sbmanager_$this->_groupindex", 1);
                                // Radio Mananger
                                echo "        var sbmanager_$this->_groupindex = new qx.manager.selection.RadioManager(null, [$this->Name]);\n";
                        }
                        else
                        {
                                echo "        sbmanager_$this->_groupindex.add($this->Name);\n";
                        }

                        if ($this->_down == 1)
                        {
                                echo "        $this->Name.setChecked(true);\n";
                        }
                }


                // if not in a group, then always uncheck it after a click
                if ($this->_groupindex == 0)
                {
                        if ($this->_enabled == 1)
                        {
                                echo "        $this->Name.addEventListener(\"execute\", function() { this.setChecked(false); }, $this->Name);\n";
                        }
                }


                // adds Enabled, Visible, Font, and Color property
                $this->dumpCommonQWidgetProperties($this->Name, 0);

                // set font for the button label
                echo "        var lblobj = $this->Name.getLabelObject();\n";
                echo "        if (lblobj) lblobj.setFont(\"{$this->Font->Size} '{$this->Font->Family}' {$this->Font->Weight}\");\n";
                // set the font color
                if ($this->Font->Color != "")
                        echo "        $this->Name.setColor(new qx.renderer.color.Color('{$this->Font->Color}'));\n";

                // set the layout
                if ($this->_buttonlayout != blImageLeft)
                {
                        $iconPos = "";
                        switch ($this->_buttonlayout)
                        {
                                case blImageBottom: $iconPos = "bottom"; break;
                                case blImageRight:  $iconPos = "right"; break;
                                case blImageTop:    $iconPos = "top"; break;
                        }
                        echo "        $this->Name.setIconPosition('$iconPos');\n";
                }

                // set hint
                $hint = $this->getHintAttribute();
                if ($hint != "")
                        echo "        $this->Name.setHtmlAttribute('title', '$this->Hint');\n";

                // set cursor
                if ($this->Cursor != "")
                        //echo "        $this->Name.setStyleProperty('cursor', '$this->Cursor');\n";
                        echo "        $this->Name.setStyleProperty('cursor', '".strtolower(substr($this->Cursor, 2))."');\n";

                // set background color
                if ($this->Color != "")
                        echo "        ".$this->Name.".setBackgroundColor(new qx.renderer.color.Color('$this->Color'));\n";
                else
                        echo "        ".$this->Name.".setBackgroundColor(new qx.renderer.color.ColorObject('buttonface'));\n";


                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        // add the onclick wrapper to the event listener
                        if ($this->_onclick != null && $this->Owner != null)
                        {
                                $wrapperEvent = $this->getJSWrapperFunctionName($this->_onclick);
                                $submitEventValue = $this->readJSWrapperSubmitEventValue($this->_onclick);
                                $hiddenfield = $this->readJSWrapperHiddenFieldName();
                                $hiddenfield = "findObj('$hiddenfield')";
                                echo "        $this->Name.addEventListener(\"execute\", function(){ var event = event || window.event; return $wrapperEvent(event, $hiddenfield, '$submitEventValue', null) } );\n";
                        }

                        // add the common JS events to the QWidget (0 = no JS OnChange event added)
                        $this->dumpCommonQWidgetJSEvents($this->Name, 0);
                }

                // Call the OnShow event handler after all settings of the BitBtn
                // have been output so it is possible to reset them in the OnShow event.
                $this->callEvent('onshow', array());

                $this->dumpCommonContentsBottom();

                // add a hidden field so we can determine which event was fired for the button
                if ($this->_onclick != null)
                {
                        $hiddenwrapperfield = $this->readJSWrapperHiddenFieldName();
                        echo "<input type=\"hidden\" id=\"$hiddenwrapperfield\" name=\"$hiddenwrapperfield\" value=\"\" />";
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();

                if (!defined("appr $this->Name"))
                {
                        define("appr $this->Name", 1);

                        $color = "this.bgcolor_default = ";
                        $color .= ($this->Color == "") ? "new qx.renderer.color.ColorObject(\"buttonface\");" : "new qx.renderer.color.Color('$this->Color');";

                        $border = "      this.border_pressed = qx.renderer.border.BorderPresets.getInstance().".($this->Flat ? "thinInset" : "inset").";\n"
                                . "      this.border_over = qx.renderer.border.BorderPresets.getInstance().".($this->Flat ? "thinOutset" : "outset").";\n"
                                . "      this.border_default = qx.renderer.border.BorderPresets.getInstance().".($this->Flat ? "none" : "outset").";\n";

                        echo "
<script type=\"text/javascript\">
  var theme = qx.manager.object.AppearanceManager.getInstance().getAppearanceTheme();
  theme.registerAppearance('$this->Name',
  {
    setup : function()
    {
      $color
      this.bgcolor_left = new qx.renderer.color.Color(\"#FFF0C9\");
      $border
      this.checked_background = \"static/image/dotted_white.gif\";
    },

    initial : function(vTheme)
    {
      var ret = vTheme.initialFrom(\"toolbar-button\");
    },

    state : function(vTheme, vStates)
    {
      var vReturn = vTheme.stateFrom(\"toolbar-button\", vStates);
      vReturn.backgroundColor = vStates.abandoned ? this.bgcolor_left : this.bgcolor_default;
      vReturn.backgroundImage = vStates.checked && !vStates.over ? this.checked_background : null;

      if (vStates.pressed || vStates.checked || vStates.abandoned) {
        vReturn.border = this.border_pressed;
      } else if (vStates.over) {
        vReturn.border = this.border_over;
      } else {
        vReturn.border = this.border_default;
      }

      return vReturn;
    }
  });
  theme.setupAppearance(theme.getAppearance('$this->Name'));
</script>
";
                }
        }

        /**
        * Increments a counter used to allow all up, this is an internal function
        * and it's not meant to be used to develop applications.
        *
        * @see endUpdateProperties()
        */
        function beginUpdateProperties()
        {
                $this->_updating++;
        }

        /**
        * Decrements a counter used to allow all up, this is an internal function
        * and it's not meant to be used to develop applications.
        *
        * @see beginUpdateProperties()
        */
        function endUpdateProperties()
        {
                $this->_updating--;
        }

        /**
        * Updates common properties of the group, this method is called whenever
        * a property that affects other members of the group is changed to a
        * different value
        *
        * @see getGroupIndex(), getAllowAllUp()
        */
        protected function updateExclusive()
        {
                // this prevents a recursive endless-loop (only one speed button can update the others at a time)
                if ($this->_updating == 0 && $this->GroupIndex > 0)
                {
                        if ($this->Owner != null && $this->Name != "")
                        {
                                $items=$this->owner->components->items;
                                reset($items);
                                foreach ($items as $k => $v)
                                {
                                        // only update SpeedButtons which are in the same group, don't update itself
                                        if ($v->Name != $this->Name && $v->className() == "SpeedButton" && $v->GroupIndex == $this->_groupindex)
                                        {
                                                $v->beginUpdateProperties();

                                                if ($this->_down == 1)
                                                {
                                                        $v->Down = 0;
                                                }
                                                $v->AllowAllUp = $this->_allowallup;

                                                $v->endUpdateProperties();
                                        }
                                }
                        }
                }
        }

        /**
        * Specifies whether all speed buttons in the group that contains this
        * speed button can be unselected at the same time.
        *
        * Use AllowAllUp with a group of buttons that belong to the same group.
        * Speed buttons belong to the same group if they have the same value on
        * their GroupIndex property. Buttons in the same group behave in a mutually
        * exclusive fashion: when one button in the group is selected (down), all
        * other buttons in the group become unselected (up).
        *
        * If AllowAllUp is true, all of the speed buttons in a group can be unselected at
        * the same time. Clicking the single selected button in the group will deselect
        * that button without selecting another. If AllowAllUp is false, exactly one
        * of the buttons in the group must be selected at any time. Clicking a down
        * button won't return the button to its up state.
        *
        * Changing the value of the AllowAllUp property for one speed button in a group changes
        * the AllowAllUp value for all buttons in the group.
        *
        * Note:   If GroupIndex is zero, AllowAllUp has no effect.
        *
        * @see updateExclusive(), getAllowAllUp(), getGroupIndex()
        *
        * @return bool
        */
        function getAllowAllUp() { return $this->_allowallup; }
        function setAllowAllUp($value)
        {
                if ($value != $this->_allowallup)
                {
                        $this->_allowallup = $value;
                        $this->updateExclusive();
                }
        }
        function defaultAllowAllUp() { return 0; }

        /**
        * Specifies whether the button is selected (down) or unselected (up).
        *
        * Read Down to determine whether a speed button is selected. The Down
        * property only applies if the GroupIndex property of the button is nonzero.
        *
        * When GroupIndex is greater than 0, set Down to true to select a button.
        * When the user clicks on a button in the unselected (up) state, the button
        * is selected and Down is set to true. When the user clicks on a button in
        * the selected (down) state, if Caption is true, the button becomes unselected
        * and Down is set to false.
        *
        * At design time, specify which button in a group is the initially selected button
        * by setting the Down property of the selected button to true.
        *
        * Note:   When GroupIndex is 0, buttons do not remain in the selected state when clicked.
        *
        * @see getGroupIndex(), getAllowAllUp(), updateExclusive()
        *
        * @return bool
        */
        function getDown() { return $this->_down; }
        function setDown($value)
        {
                if ($this->_groupindex == 0)
                {
                        $this->_down = 0;
                }
                else if ($value != $this->_down)
                {
                        if (!($this->_down == 1 && $this->_allowallup == 0))
                        {
                                $this->_down = $value;

                                if ($value == 1)
                                {
                                        $this->updateExclusive();
                                }
                        }
                }
        }
        function defaultDown() { return 0; }

        /**
        * Determines whether the button has a 3D border that provides a raised
        * or lowered look.
        *
        * Set Flat to true to remove the raised border when the button is unselected
        * and the lowered border when the button is clicked or selected. When Flat
        * is true, use separate bitmaps for the different button states to provide
        * visual feedback to the user about the button state.
        *
        * @return bool
        */
        function getFlat() { return $this->_flat; }
        function setFlat($value) { $this->_flat=$value; }
        function defaultFlat() { return 0; }

        /**
        * Allows speed buttons to work together as a group.
        *
        * Set GroupIndex to determine how the button behaves when clicked.
        *
        * When GroupIndex is 0, the button behaves independently of all other
        * buttons on the form. When the user clicks such a speed button, the
        * button appears pressed (in its clicked state) and then returns to its
        * normal up state when the user releases the mouse button.
        *
        * When GroupIndex is greater than 0, the button remains selected (in its
        * down state) when clicked by the user. When the user clicks a selected
        * button, it returns to the up state, unless Caption is false. Setting
        * the GroupIndex property of a single speed button to a value greater
        * than 0 causes the button to behave as a two-state button when Caption
        * is true.
        *
        * Speed buttons with the same GroupIndex property value (other than 0),
        * work together as a group. When the user clicks one of these buttons,
        * it remains selected until the user clicks another speed button
        * belonging to the same group. Speed buttons used in this way can present
        * mutually exclusive choices to the user.
        *
        * @see updateExclusive()
        *
        * @return integer
        */
        function getGroupIndex() { return $this->_groupindex; }
        function setGroupIndex($value)
        {
                if ($value != $this->_groupindex)
                {
                        $this->_groupindex=$value;
                        $this->updateExclusive();
                }
        }
        function defaultGroupIndex() { return 0; }


}

?>