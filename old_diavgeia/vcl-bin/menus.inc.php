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
use_unit("extctrls.inc.php");


/**
 * Base class for MainMenu
 *
 * MainMenu encapsulates a menu bar and its accompanying drop-down menus for an HTML page.
 * To begin designing a menu, add a main menu to a form, and edit its Items property
 * in the property editor, you can create a complete structure for all the options you want to show.
 *
 * You are not limited to a single menu component on a page, you can use as many you need.
 *
 */
class CustomMainMenu extends QWidget
{
        protected $_items=array();
        protected $_onclick=null;
        protected $_images=null;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=300;
                $this->Height=24;
        }

        function init()
        {
                //TODO: Read this from input
                if (!$this->owner->UseAjax)
                {
                        if ((isset($_POST[$this->Name."_state"])) && ($_POST[$this->Name."_state"]!=''))
                        {
                                $this->callEvent('onclick',array('tag'=>$_POST[$this->Name."_state"]));
                        }
                }
        }

        function dumpHeaderCode()
        {
                parent::dumpHeaderCode();
                //This function is used as a common click processor for all item clicks
                echo '<script type="text/javascript">';
                echo "function $this->Name"."_clickwrapper(e)\n";
                echo "{\n";
                echo " submit=true; \n";
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->JsOnClick!=null)
                        {
                                echo "   submit=".$this->JsOnClick."(e);\n";
                        }
                }
                echo "var tag=e.getTarget().tag;\n";
                echo "if ((tag!=0) && (submit))\n";
                echo "  {\n";
                echo "  var hid=findObj('$this->Name"."_state');\n";
                echo "  if (hid) hid.value=tag;\n";
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        $form = "document.".$this->owner->Name;
                        echo "  if (($form.onsubmit) && (typeof($form.onsubmit) == 'function')) { $form.onsubmit(); }\n";
                        echo "  $form.submit();\n";
                }
                echo "  }\n";
                echo "}\n";
                echo '</script>';
        }


            function loaded()
            {
                parent::loaded();
                $this->setImages($this->_images);
            }



        /**
         * Dump all menu items
         *
         * @param array $items Array of items to dump
         * @param integer $level Level to use when dumping items
         * @param boolean $create Creates a top menu object or not
         *
         *
         * <code>
         * <?php
         *     function MainMenu1BeforeShow($sender, $params)
         *     {
         *       $items=array();
         *
         *       $subitems=array();
         *       $subitems[]=array(
         *              'Caption'=>'Sub Menu1',
         *              'ImageIndex'=>0,
         *              'SelectedIndex'=>0,
         *              'StateIndex'=>-1,
         *              'Tag'=>1
         *       );
         *
         *       $subitems[]=array(
         *              'Caption'=>'Sub Menu2',
         *              'ImageIndex'=>0,
         *              'SelectedIndex'=>0,
         *              'StateIndex'=>-1,
         *              'Tag'=>2
         *       );
         *
         *       $items[]=array(
         *              'Caption'=>'Top Menu',
         *              'ImageIndex'=>0,
         *              'SelectedIndex'=>0,
         *              'StateIndex'=>-1,
         *              'Tag'=>0,
         *              'Items'=>$subitems
         *       );
         *
         *       $this->MainMenu1->Items=$items;
         *     }
         * ?>
         * </code>
         *
         * @return string
         */
        function dumpMenuItems($items,$level,$create=true)
        {
                if ($create)
                {
                        echo "  var m$level = new qx.ui.menu.Menu;\n";
                        echo "  d.add(m$level);\n";
                }
                reset($items);
                while(list($k,$v)=each($items))
                {
                        $caption=$v['Caption'];
                        $tag=$v['Tag'];
                        if ($tag=='') $tag=0;

                        if ($caption=='-')
                        {
                                echo "var mb$level"."_$k = new qx.ui.menu.Separator();\n";
                        }
                        else
                        {
                                $sub='null';

                                if ((isset($v['Items'])) && (count($v['Items'])))
                                {
                                  $sub="m".($level+1);
                                        echo "  var $sub = new qx.ui.menu.Menu;\n";
                                        echo "  d.add($sub);\n";
                                }


                        $img='null';
                if (($this->ControlState & csDesigning)!==csDesigning)
                {
                        if (isset($v['ImageIndex']))
                        {
                                $img=$v['ImageIndex'];
                                if ($img<>'')
                                {
                                        if ($this->Images!=null)
                                        {
                                                $path=$this->Images->readImage($img);
                                                if ($path===false)
                                                {
                                                        $img='null';
                                                }
                                                else
                                                {
                                                        $img='"'.$path.'"';
                                                }
                                        }
                                }
                                else $img='null';
                        }
                }

                                $avalue=str_replace('"','\"',$caption);
                                echo "  var mb$level" . "_$k = new qx.ui.menu.Button(\"$avalue\", $img, null, $sub);\n";
                                echo "  mb$level" . "_$k.addEventListener(\"execute\", " . $this->Name . "_clickwrapper);\n";
                                echo "  mb$level" . "_$k.tag=$tag;\n";
                        }

                        echo "  m$level.add(mb$level" . "_$k);\n";

                        if ((isset($v['Items'])) && (count($v['Items'])))
                        {
                                $this->dumpMenuItems($v['Items'],$level+1, false);
                        }
                }
                return('m'.$level);
        }

        /**
         * Dump the top items
         *
         */
        function dumpTopButtons()
        {
                reset($this->_items);
                while(list($k,$v)=each($this->_items))
                {
                        echo "  <!-- Topbutton Start -->\n";
                        $caption=$v['Caption'];
                        $m='null';

                        $avalue=str_replace('"','\"',$caption);
                        if ((isset($v['Items'])) && (count($v['Items']))) $m=$this->dumpMenuItems($v['Items'],0);
                        echo "  var mb = new qx.ui.toolbar.MenuButton(\"$avalue\",$m);\n";
                        __QLibrary_SetCursor("mb", $this->Cursor);
                        echo "  $this->Name.add(mb);\n";
                        echo "  <!-- Topbutton End -->\n";
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
                echo "        $this->Name.removeAll();\n";
//                echo "        $this->Name.setLeft(0);\n";
//                echo "        $this->Name.setTop(0);\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight(".($this->Height-1).");\n";

                __QLibrary_SetCursor($this->Name, $this->Cursor);

                $this->dumpTopButtons();
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

        function dumpContents()
        {
                $this->dumpCommonContentsTop();
                echo "        var ".$this->Name."    = new qx.ui.toolbar.ToolBar;\n";
                $this->commonScript();
                $this->dumpCommonContentsBottom();
        }

        /**
         * Lists the images that can appear beside individual menu items.
         *
         * Use this property if you want to add images to your items. Set it to
         * an ImageList object containing the images you want to use and use the
         * ImageIndex of each item to set the image you want to show.
         *
         * @return ImageList
         */
        function getImages() { return $this->_images; }
        function setImages($value) { $this->_images=$this->fixupProperty($value); }
        function defaultImages() { return ""; }

        /**
         * Describes the elements of the menu.
         * Use Items to access information about the elements in the menu.
         * Item contain information about Caption, associated image and Tag.
         *
         * @return array
         */

        function getItems()             { return $this->_items; }
        function setItems($value)       { $this->_items=$value; }
        /**
         * OnClick event
         * Occurs when the user clicks menu item.
         *
         *
         * <code>
         * <?php
         *     function MainMenu1Click($sender, $params)
         *     {
         *              if ($params['tag']==20)
         *              {
         *                      $this->Memo1->Lines=array("PHP Event");
         *              }
         *     }
         * ?>
         * </code>
         * @return mixed
         */
        function readOnClick()          { return $this->_onclick; }
        function writeOnClick($value)   { $this->_onclick=$value; }
}

/**
 * MainMenu encapsulates a menu bar and its accompanying drop-down menus for an HTML page.
 * To begin designing a menu, add a main menu to a form, and edit its Items property
 * in the property editor, you can create a complete structure for all the options you want to show.
 *
 * You are not limited to a single menu component on a page, you can use as many you need.
 *
 * @example MainMenu/mainmenu.php How to use MainMenu
 * @example MainMenu/mainmenu.xml.php How to use MainMenu (form)
 *
 * @example MainMenu2/mainmenu2.php How to use MainMenu (another sample)
 * @example MainMenu2/mainmenu2.xml.php How to use MainMenu (another sample, form)
 *
 */
class MainMenu extends CustomMainMenu
{
        //Publish some properties
        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getOnClick()           { return $this->readOnClick(); }
        function setOnClick($value)     { $this->writeOnClick($value); }

        function getjsOnClick()         { return $this->readjsOnClick(); }
        function setjsOnClick($value)   { $this->writejsOnClick($value); }
}

/**
* Base class for PopupMenu.
*
* Use PopupMenu to define the pop-up menu that appears when the user clicks on
* a control with the right mouse button.
*
* To make a pop-up menu available, assign the PopupMenu object to the control's
* PopupMenu property.
*/
class CustomPopupMenu extends Component
{
        protected $_items=array();
        protected $_onclick=null;
        protected $_jsonclick=null;
        protected $_images = null;

        function dumpJavascript()
        {
                $this->dumpJSEvent($this->_jsonclick);
        }

        /**
        * Dump the menu items, private function for the component, not for usage
        */
        private function dumpMenuItems($name, $items, $level)
        {
                if (isset($elements)) unset($elements);

                reset($items);                     // $this->_items -> $k
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

                        $itemname = $name . "_it" . $level . "_" . $index;

                        if ($caption=='-')
                        {
                                echo "    var $itemname = new qx.ui.menu.Separator();\n";
                        }
                        else
                        {
                                $submenu = "null";
                                $subitems = $item['Items'];
                                // check if has subitems

                                if ((isset($subitems)) && (count($subitems)))
                                {
                                        $submenu = $name . "_sm" . $level . "_" . $index;
                                        $this->dumpMenuItems($submenu, $subitems, ($level + 1));

                                        $avalue=str_replace('"','\"',$caption);
                                        echo "    var $itemname = new qx.ui.menu.Button(\"$avalue\", $image, null, $submenu);\n";
                                }
                                else
                                {
                                        $avalue=str_replace('"','\"',$caption);
                                        echo "    var " . $itemname . "Cmd = new qx.client.Command();\n"
                                           . "    " . $itemname . "Cmd.addEventListener(\"execute\", function (e) {  SubmitMenuEvent(e, $tag); });\n\n"
                                           . "    var $itemname = new qx.ui.menu.Button(\"$avalue\", $image, " . $itemname . "Cmd);\n";
                                }
                        }
                        $elements[] = $itemname;
                }

                if (isset($elements))
                {
                        echo "      ";
                        if ($level != 0) echo "var ";
                        echo "$name = new qx.ui.menu.Menu();\n"
                           . "    $name.add(" . implode(",", $elements) . ");\n"
                           . "    d.add($name);\n\n";
                        unset($elements);
                }
                else
                        echo "$name = null;\n";

        }

        function loaded()
        {
                parent::loaded();
                $this->writeImages($this->_images);
        }

        function init()
        {
                if (!$this->owner->UseAjax)
                {
                        if ((isset($_POST[$this->Name."_state"])) && ($_POST[$this->Name."_state"]!=''))
                        {
                                $this->callEvent('onclick',array('tag'=>$_POST[$this->Name."_state"]));
                        }
                }
        }

        function dumpFormItems()
        {
                echo "<input type=\"hidden\" id=\"$this->Name"."_state\" name=\"$this->Name"."_state\" value=\"\" />\n";
        }

        function dumpHeaderCode()
        {
                __QLibrary_InitLib();

                parent::dumpHeaderCode();

                if (($this->ControlState & csDesigning)!==csDesigning)
                {
                        echo "<script type=\"text/javascript\">\n"
                           . "<!--\n"
                           . "  var $this->Name;\n"
                           . "\n"
                           . "  function ".$this->Name."CreateMenu()\n"
                           . "  {\n"
                           . "    if (typeof $this->Name == 'undefined')\n"
                           . "    {\n"
                           . "      var d = qx.ui.core.ClientDocument.getInstance();\n\n"
                           . "\n";

                        $this->dumpMenuItems($this->Name, $this->_items, 0);

                        echo "    }\n"
                           . "  }\n"
                           . "\n"
                           . "  function SubmitMenuEvent(e, tag)\n"
                           . "{\n"
                           . "    submit=true;\n"
                           . "    e.tag=tag;\n";

                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                                if ($this->JsOnClick!=null)
                                {
                                        echo "    submit=" . $this->JsOnClick . "(e);\n";
                                }

                                $form = "document." . $this->owner->Name;
                                echo "    if ((tag!=0) && (submit)) {\n"
                                   . "      var hid=findObj('$this->Name"."_state');\n"
                                   . "      if (hid) hid.value=tag;\n"
                                   . "      if (($form.onsubmit) && (typeof($form.onsubmit)) == 'function') { $form.onsubmit(); }\n"
                                   . "      $form.submit();\n"
                           . "}\n";
                        }
                        echo "  }\n\n";

                        echo "  function Show$this->Name(event, type)\n"
                           . "  {\n"
                           . "    ".$this->Name."CreateMenu();\n"
                           . "    if($this->Name!=null){\n"
                           . "    if (type == 0) {\n"
                           . "      var tempX = 0\n"
                           . "      var tempY = 0\n"
                           . "      if(event.pageX || event.pageY){"
                           . "        tempX = event.pageX\n"
                           . "        tempY = event.pageY\n"
                           . "      } else {\n"
                           . "        tempX = event.clientX + document.body.scrollLeft - document.body.clientLeft\n"
                           . "        tempY = event.clientY + document.body.scrollTop - document.body.clientTop\n"
                           . "      }\n"
                           . "    } else {\n"
                           . "      tempX = event.getPageX()\n"
                           . "      tempY = event.getPageY()\n"
                           . "    }\n"
                           . "    if (tempX < 0){tempX = 0}\n"
                           . "    if (tempY < 0){tempY = 0}\n"
                           . "\n"
                           . "    $this->Name.setLeft(tempX);\n"
                           . "    $this->Name.setTop(tempY);\n"
                           . "    $this->Name.show();\n"
                           . "  }\n"
                           . "  }\n"
                           . "-->\n"
                           . "</script>\n";
                }
        }

        /**
         * Lists the images that can appear beside individual menu items.
         *
         * Use this property if you want to add images to your items. Set it to
         * an ImageList object containing the images you want to use and use the
         * ImageIndex of each item to set the image you want to show.
         *
         * @return ImageList
         */
        protected function readImages()         { return $this->_images; }
        protected function writeImages($value)  { $this->_images = $this->fixupProperty($value); }
        function defaultImages()                { return null; }
        /**
         * Describes the elements of the menu.
         * Use Items to access information about the elements in the menu.
         * Item contain information about Caption, associated image and Tag.
         *
         * <code>
         * <?php
         *
         *     function Unit467BeforeShow($sender, $params)
         *     {
         *     $items=array();
         *
         *     $subitems=array();
         *     $subitems[]=array(
         *            'Caption'=>'Sub Menu1',
         *            'ImageIndex'=>0,
         *            'SelectedIndex'=>0,
         *            'StateIndex'=>-1,
         *            'Tag'=>1
         *     );
         *
         *     $subitems[]=array(
         *            'Caption'=>'Sub Menu2',
         *            'ImageIndex'=>0,
         *            'SelectedIndex'=>0,
         *            'StateIndex'=>-1,
         *            'Tag'=>2
         *     );
         *
         *     $items[]=array(
         *            'Caption'=>'Top Menu',
         *            'ImageIndex'=>0,
         *            'SelectedIndex'=>0,
         *            'StateIndex'=>-1,
         *            'Tag'=>0,
         *            'Items'=>$subitems
         *     );
         *
         *     $this->PopupMenu1->Items=$items;
         *
         *     }
         *
         * ?>
         * </code>
         *
         * @return item collection
         */
        protected function readItems()          { return $this->_items; }
        protected function writeItems($value)   { $this->_items=$value; }

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
        protected function readOnClick()        { return $this->_onclick; }
        protected function writeOnClick($value) { $this->_onclick=$value; }
        /**
         * OnJsClick event
         * Occurs when the user clicks menu item.
        * @return mixed
         */
        protected function readjsOnClick()      { return $this->_jsonclick; }
        protected function writejsOnClick($value) { $this->_jsonclick = $value; }
}

/**
* Use PopupMenu to define the pop-up menu that appears when the user clicks on
* a control with the right mouse button.
*
* To make a pop-up menu available, assign the PopupMenu object to the control's
* PopupMenu property.
*/
class PopupMenu extends CustomPopupMenu
{
        // publish properties
        function getImages()                    { return $this->readImages(); }
        function setImages($value)              { $this->writeImages($value); }

        function getItems()                     { return $this->readItems(); }
        function setItems($value)               { $this->writeItems($value); }

        // publish events
        function getOnClick()                   { return $this->readOnClick(); }
        function setOnClick($value)             { $this->writeOnClick($value); }

        function getjsOnClick()                 { return $this->readjsOnClick(); }
        function setjsOnClick($value)           { $this->writejsOnClick($value); }
}

?>