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
use_unit("js/json.php");

/**
 * Specifies to the IDE the title of this package, use it on a package.php and
 * set the parameter with the Title of the package to show on Component | Packages
 *
 * @see setIconPath()
 *
 * @param string $packageTitle Title of the package to be shown on the IDE
 */
function setPackageTitle($packageTitle)
{
        echo "packageTitle=$packageTitle\n";
}

/**
 * Specifies to the IDE the path to the icons for the components contained in
 * this package (relative to the VCL path). Icons must be 16x16 bitmaps.
 *
 * @see setPackageTitle()
 *
 * @param string $iconPath Path where to find icons for this package
 */
function setIconPath($iconPath)
{
        echo "iconPath=$iconPath\n";
}

/**
 * Registers components inside the IDE and places into the right palette page,
 * it also allows the IDE to add the right unit to the source.
 *
 * Using this function, you install a component inside the IDE and allows it
 * to add the right unit to your source code using Code Insight.
 *
 * @see registerAsset(), registerComponentEditor(), registerPropertyEditor()
 *
 * @param string $page Page where to put these components
 * @param array $components Array of component class names
 * @param string $unit Unit where to find these components
 */
function registerComponents($page,$components,$unit)
{
   echo "page=$page\n";
   reset($components);
   while (list($k,$v)=each($components))
   {
        echo "$v=$unit\n";
   }
}

function registerPropertiesInCategory($category, $properties)
{
    echo "propcategory=$category\n";
   reset($properties);
   while (list($k,$v)=each($properties))
   {
        echo "propname=$v\n";
   }
}

/**
 * Registers an asset for the Deployment wizard, if your component needs extra
 * folder(s) to be added for deployment, you can use this function to notify
 * Deployment Wizard which folders do you want to get added
 *
 * <code>
 * <?php
 *     registerAsset(array("MainMenu","PopupMenu"),array("qooxdoo","dynapi"));
 * ?>
 * </code>
 *
 * @link http://www.qadram.com/vcl4php/docwiki/index.php/Component_Writer%27s_Guide_::_Deployment
 *
 * @see registerComponents(), registerComponentEditor(), registerPropertyEditor()
 *
 * @param array $components Array of components you want to register the asset
 * @param array $assets Array of folders you want to get copied when this component is used
 */
function registerAsset($components, $assets)
{
        reset($components);
        while (list($k,$v)=each($components))
        {
                echo "asset=$v\n";
                reset($assets);
                while (list($c,$asset)=each($assets))
                {
                        echo "value=".$asset."\n";
                }
        }
}

/**
 * Registers a component editor to be used by a component when right clicking on it
 *
 * <code>
 * <?php
 *     registerComponentEditor("Database","DatabaseEditor","designide.inc.php");
 * ?>
 * </code>
 * @link http://www.qadram.com/vcl4php/docwiki/index.php/Component_Writer%27s_Guide_::_Component_Editors
 *
 * @see registerComponents(), registerAsset(), registerPropertyEditor()
 *
 * @param string $classname Name of the component class for which register this editor
 * @param string $componenteditorclassname Name of the class for the component editor
 * @param string $unitname Unit where the component editor resides
 */
function registerComponentEditor($classname,$componenteditorclassname,$unitname)
{
   echo "componentclassname=$classname\n";
   echo "componenteditorname=$componenteditorclassname\n";
   echo "componenteditorunitname=$unitname\n";
}

/**
 * Registers a property editor to edit an specific property
 *
 * <code>
 * <?php
 *     registerPropertyEditor("Control","Color","TSamplePropertyEditor","native");
 * ?>
 * </code>
 * @link http://www.qadram.com/vcl4php/docwiki/index.php/Component_Writer%27s_Guide_::_Property_Editors
 *
 * @see registerComponents(), registerAsset(), registerComponentEditor()
 *
 * @param string $classname It can be an ancestor, property editors are also inherited
 * @param string $property Property Name
 * @param string $propertyclassname Property Editor class name
 * @param string $unitname Unit that holds the property editor class
 */
function registerPropertyEditor($classname,$property,$propertyclassname,$unitname)
{
   echo "classname=$classname\n";
   echo "property=$property\n";
   echo "propertyeditor=$propertyclassname\n";
   echo "propertyeditorunitname=$unitname\n";
}

/**
 * Register values to be shown for a dropdown property, this function provides
 * you a way to offer possibilities to the component user to setup a property
 *
 * <code>
 * <?php
 *     registerPropertyValues("DBPaginator","Orientation",array('noHorizontal','noVertical'));
 *     registerPropertyValues("Datasource","DataSet",array('DataSet'));
 * ?>
 * </code>
 * @link http://www.qadram.com/vcl4php/docwiki/index.php/Component_Writer%27s_Guide_::_Property_Editors
 *
 * @see registerBooleanProperty()
 *
 * @param string $classname Name of the class for which component we want to register these values
 * @param string $property Property name for which register this values
 * @param array $values Array of valid values will be shown in the Object Inspector
 */
function registerPropertyValues($classname,$property,$values)
{
   echo "classname=$classname\n";
   echo "property=$property\n";

   reset($values);
   while (list($k,$v)=each($values))
   {
        echo "value=$v\n";
   }
}

/**
 * Registers a boolean property, so the Object Inspector offers a true/false dropdown
 *
 * <code>
 * <?php
 *     registerBooleanProperty("Control","Visible");
 * ?>
 * </code>
 * @see registerPropertyValues()
 * @param string $classname Name of the component class for which register this property
 * @param string $property Property name
 */
function registerBooleanProperty($classname,$property)
{
   $values=array('false','true');

   echo "classname=$classname\n";
   echo "property=$property\n";

   reset($values);
   while (list($k,$v)=each($values))
   {
        echo "value=$v\n";
   }
}

/**
 * Registers a password property, so the Object Inspector doesn't show the value
 * showing asterisks instead
 *
 * <code>
 * <?php
 *     registerPasswordProperty("CustomConnection","UserPassword");
 * ?>
 * </code>
 * @param string $classname Name of the component class for which register this property
 * @param string $property Name of the property to be password like
 */
function registerPasswordProperty($classname,$property)
{
   echo "classname=$classname\n";
   echo "property=$property\n";
   echo "value=password_protected\n";
}

/**
 * Register a component to be available but not visible on the Tool Palette
 *
 * <code>
 * <?php
 *        registerNoVisibleComponents(array("Page"),"forms.inc.php");
 *        registerNoVisibleComponents(array("DataModule"),"forms.inc.php");
 * ?>
 * </code>
 * @see registerComponents()
 *
 * @param array $components Array of component class names that are going to be no visible
 * @param string $unit Unit where to find those components
 */
function registerNoVisibleComponents($components,$unit)
{
   echo "page=no\n";
   reset($components);
   while (list($k,$v)=each($components))
   {
        echo "$v=$unit\n";
   }
}

function addSplashBitmap($caption,$bitmap)
{
    echo "splashcaption=$caption\n";
    echo "splashbitmap=$bitmap\n";
}

function registerDropDatasource($components)
{
   reset($components);
   while (list($k,$v)=each($components))
   {
        echo "multiline=$v\n";
   }
}

function registerDropDatafield($components)
{
   reset($components);
   while (list($k,$v)=each($components))
   {
        echo "singleline=$v\n";
   }
}

/**
 * Base class for property editors
 *
 * Use this class if you want to wrote Property Editors in pure PHP.
 *
 */
class PropertyEditor extends Object
{
        public $value;

        /**
         * Return specific attributes for the OI
         *
         * Override this method and return an array of properties to specify the
         * IDE how to show and handle this property editor.
         *
         * @link http://www.qadram.com/vcl4php/docwiki/index.php/Component_Writer%27s_Guide_::_Property_Editors
         * @return array
         */
        function getAttributes()
        {
        }

        /**
         * If required, returns a path to become the document root for the webserver to call the property editor
         *
         * If your property editor requires some POST, is better to provide a document
         * root to the IDE so it knows how to work.
         *
         * @return string
         */
        function getOutputPath()
        {

        }

        /**
         * Executes the property editor
         *
         * This method is called when executing a property editor from the
         * IDE, and in $current_value, you get the property value in string
         * format.
         *
         * @param string $current_value  Current property value
         */
        function Execute($current_value)
        {

        }
}

/**
 * Base class for component editors
 *
 */
class ComponentEditor extends Object
{
        public $component=null;

        /**
         * Return here an array of items to show when right clicking a component
         *
         * Use this method to return the IDE the array of options to show when the
         * user right clicks a component.
         * Each element on the array will become an item on the popup menu shown.
         * If you want to perform an specific action when clicking on an option,
         * use the executeVerb method.
         *
         * @return array
         */
        function getVerbs()
        {

        }

        /**
         * Depending on the verb, perform any action you want
         *
         * This method is called by the IDE when the user selects an option
         * of the popup menu shown when the user right clicks on it.
         *
         * The option the user selects is specified on the $verb param and
         * you must use the getVerbs method to tell the IDE which options to
         * show.
         *
         * @param integer $verb Index of the verb the IDE wants to execute
         */
        function executeVerb($verb)
        {

        }

}

/**
 * Editor for Color properties
 *
 */
class ColorPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=0\n";
                $result.="width=557\n";
                $result.="height=314\n";
                $result.="caption=Color Property editor\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/coloreditor/');
        }

        function Execute($current_value)
        {
                $this->value=$current_value;

                if (isset($_POST['selcolor']))
                {
                        echo "newvalue:\n";
                        echo urldecode($_POST['selcolor']);
                }
                else
                {
                        if ($this->value=="") $this->value="#FFFFFF";
                        use_unit("resources/coloreditor/coloreditor.php");
                }
        }
}

/**
 * Property Editor for StringLists
 *
 */
class StringListPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=0\n";
                $result.="width=583\n";
                $result.="height=410\n";
                $result.="caption=StringList Editor\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/stringlisteditor/');
                return false;
        }

        function Execute($current_value)
        {
                $this->value=$current_value;

                if (isset($_POST['listeditor']))
                {
                        echo "newvalue:\n";
                        if (trim($_POST['action'])=='OK')
                        {
                                $value=$_POST['listeditor'];
                                //Carriage returns must be converted properly
                                $value=str_replace("\r",'',$value);
                                $value=str_replace("\n",'\n',$value);
                                echo $value;
                        }
                        else
                        {
                                echo $this->value;
                        }
                }
                else
                {
                        use_unit("resources/stringlisteditor/stringlisteditor.php");
                }
        }
}

/**
 * Array editor
 *
 * This editor is intended to be used to edit array properties, it's a pure PHP
 * property editor, not used right now in the IDE.
 *
 */
class ArrayPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=0\n";
                $result.="height=320\n";
                $result.="width=513\n";
                $result.="caption=Array Editor\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/arrayeditor/');
                return false;
        }

        function Execute($current_value)
        {
                global $ArrayEditor;

                $this->value=$current_value;

                if (isset($_POST['btnOk']))
                {
                        ob_start();
                        use_unit("resources/arrayeditor/arrayeditor.php");
                        ob_end_clean();

                        $items=$ArrayEditor->tvItems->Items;
                        echo "newvalue:\n".serialize($items)."\n";
                }
                elseif (isset($_POST['btnCancel']))
                {
                        echo "newvalue:\n";
                        echo $this->value;
                }
                else
                {
                        use_unit("resources/arrayeditor/arrayeditor.php");
                }
        }
}

/**
 * Items property editor, for menus and treeviews
 *
 * This editor is intended to be used to edit array properties in a tree structure,
 * it's a pure PHP property editor, not used right now in the IDE.
 */
class ItemsPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=1\n";
                $result.="height=320\n";
                $result.="width=513\n";
                $result.="caption=Items Editor\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/menuitemeditor/');
                return false;
        }

        /**
        * Converts a JS array to a PHP array
        *
        * This function is used to take a javascript array as input and convert it
        * to a PHP array.
        *
        * @param array $input Array in Javascript format
        * @return string
        */
        function JSArrayToPHPArray($input)
        {
                $output=array();
                $children=array();

                reset($input);
                list($k,$props)=each($input);
                while (list($k,$child)=each($input))
                {
                        $c=$this->JSArrayToPHPArray($child[0]);
                        $children[]=$c[0];
                }

                $caption=$props[0];
                if (isset($props[1])) $tag=$props[1];
                else $tag=0;

                if (count($children)!=0)
                {
                        $output[]=array('Caption'=>$caption,'Tag'=>$tag, 'Items'=>$children);
                }
                else
                {
                        $output[]=array('Caption'=>$caption, 'Tag'=>$tag);
                }

                return($output);
        }


        function Execute($current_value)
        {
                global $MenuItemEditor;

                $this->value=$current_value;

                if (isset($_POST['items']))
                {
                        $json_string=$_POST['items'];
                        $json = new Services_JSON();

                        $array=$json->decode($json_string);
                        $phparray=$this->JSArrayToPHPArray($array[0]);
                        $finalarray=$phparray[0]['Items'];
                        echo "newvalue:\n".serialize($finalarray)."\n";
                }
                else
                {
                        use_unit("resources/menuitemeditor/menuitemeditor.php");
                }
        }
}

/**
 * HTML property editor, for captions and so on
 *
 * This editor is intended to be used to edit HTML enabled properties, it's a pure PHP
 * property editor, not used right now in the IDE.
 *
 */
class HTMLPropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
                $result="sizeable=1\n";
                $result.="width=740\n";
                $result.="height=540\n";
                $result.="caption=HTML Property editor (Xinha based)\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/xinha/');
        }

        function Execute($current_value)
        {
                $this->value=$current_value;

                if (isset($_POST['myTextArea']))
                {
                        echo "newvalue:\n";
                        echo urldecode($_POST['myTextArea']);
                }
                else
                {
                        use_unit("resources/xinha/htmlpropertyeditor.php");
                }
        }
}

/**
 * Image property editor - not finished
 *
 * This editor is intended to be used to edit image properties, it's a pure PHP
 * property editor, not used right now in the IDE.
 *
 */

class ImagePropertyEditor extends PropertyEditor
{
        function getAttributes()
        {
//                $result="sizeable=1\n";
//                $result.="width=740\n";
//                $result.="height=540\n";
                $result.="caption=Image Property editor (Xinha based)\n";

                return($result);
        }

        function getOutputPath()
        {
                return(dirname(__FILE__).'/resources/xinha/plugins/ImageManager/');
        }

        function Execute($current_value)
        {
                $this->value=$current_value;

                if (isset($_POST['f_url']))
                {
                        echo "newvalue:\n";
                        echo urldecode($_POST['f_url']);
                }
                else
                {
                        use_unit("resources/xinha/plugins/ImageManager/imagepropertyeditor.php");
                }
        }
}

/**
 * Database component editor, to show right-click menu options
 *
 * This componenteditor is used by the Database component, when right clicking on it,
 * to show a set of options to be used from the IDE, like create a data dictionary.
*/

class DatabaseEditor extends ComponentEditor
{
        function getVerbs()
        {
                echo "Create Dictionary\n";
        }

        function executeVerb($verb)
        {
                switch($verb)
                {
                        case 0:
                                $this->component->ControlState=0;
                                $this->component->open();
                                if ($this->component->createDictionaryTable())
                                {
                                        echo "Dictionary created";
                                }
                                else
                                {
                                    echo "Error creating Dictionary. Please check the connection settings and the Dictionary property.";
                                }
                                break;
                }
        }
}

?>