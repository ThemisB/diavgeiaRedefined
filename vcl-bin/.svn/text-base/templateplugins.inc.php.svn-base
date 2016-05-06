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

/**
 * Base class for template engines.
 *
 * Inherit from it and override initialize(), assignComponents() and dumpTemplate()
 *
 *
 * @example Templates/templatesample.php Working with Templates
 * @example Templates/templatesample.xml.php Working with Templates (page)
 * @example Templates/index.html Working with Templates (template)
 */
class PageTemplate extends Component
{
        protected $_filename='';

        /**
         * Template filename
         *
         * Use this property to specify the filename in your system that has the
         * template to use when rendering the page.
         *
         * @return string
         */
        function readFileName() { return $this->_filename; }
        function writeFileName($value) { $this->_filename=$value; }

        /**
         * Called to initialize the template system
         *
         * Override this method to provide initialization code for your
         * template system, this process is usually create the template object
         *
         * <code>
         * <?php
         *      function initialize()
         *      {
         *              require_once("smarty/libs/Smarty.class.php");
         *              $this->_smarty = new Smarty;
         *              $this->_smarty->template_dir = '';
         *      }
         * ?>
         * </code>
         *
         */
        function initialize() {}

        /**
         * Called to assign component code to template holes
         *
         * Override this method to iterate through all components in the
         * form and place the code in the holes of your template.
         *
         * <code>
         * <?php
         *      function assignComponents()
         *      {
         *              $form=$this->owner;
         *              ob_start();
         *              $form->callEvent('onshowheader',array());
         *              $contents=ob_get_contents();
         *              ob_end_clean();
         *              $this->_smarty->assign('HeaderCode', $contents.$form->dumpChildrenHeaderCode(true).$form->dumpHeaderJavascript(true));
         *              $this->_smarty->assign('StartForm', $form->readStartForm());
         *              $this->_smarty->assign('EndForm', $form->readEndForm());
         *              reset($form->controls->items);
         *              while (list($k,$v)=each($form->controls->items))
         *              {
         *                      $dump = false;
         *                      if( $v->Visible && !$v->IsLayer )
         *                      {
         *                          if( $v->Parent->methodExists('getActiveLayer') )
         *                          {
         *                              $dump = ( (string)$v->Layer == (string)$v->Parent->Activelayer );
         *                          }
         *                          else
         *                          {
         *                              $dump = true;
         *                          }
         *                      }
         *                      if ($dump)
         *                      {
         *                          $code="<div id=\"".$v->Name."_outer\">\n";
         *                          $code.=$v->show(true);
         *                          $code.="\n</div>\n";
         *                          $this->_smarty->assign($v->Name, $code);
         *                      }
         *              }
         *      }
         * ?>
         * </code>
         */
        function assignComponents() {}

        /**
         * Called to dump the parsed Template to the output stream
         *
         * Override this method to dump the template with all the contents
         * to the output.
         * <code>
         * <?php
         *      function dumpTemplate()
         *      {
         *              $this->_smarty->display($this->FileName);
         *      }
         * ?>
         * </code>
         */
        function dumpTemplate() {}

        function __construct($aowner=null)
        {
                parent::__construct($aowner);
        }

}

/**
 * Template Manager to register all available template engines
 *
 * This is the main class used by the template engine to register and get existing
 * page templates. You only need to use this class if you are creating new plugins
 * for template engines.
 *
 * <code>
 * <?php
 * //Template registration
 * global $TemplateManager;
 * $TemplateManager->registerTemplate('SmartyTemplate','smartytemplate.inc.php');
 * ?>
 * </code>
 *
 * @example Templates/templatesample.php Working with Templates
 * @example Templates/templatesample.xml.php Working with Templates (page)
 * @example Templates/index.html Working with Templates (template)
 */
class TemplateManager extends Component
{
        protected $_templates=null;

        function __construct($aowner=null)
        {
                parent::__construct($aowner);
                $templates=array();
        }

        /**
         * Registers a new template engine to be available on the IDE.
         *
         * <code>
         * <?php
         * //Template registration
         * global $TemplateManager;
         * $TemplateManager->registerTemplate('SmartyTemplate','smartytemplate.inc.php');
         * ?>
         * </code>
         *
         * @param string $classname Class for the template engine
         * @param string $unitname  Unit that holds the class
         */
        function registerTemplate($classname, $unitname)
        {
                $this->_templates[$classname]=$unitname;
        }

        /**
         * Return an array of engines
         *
         * This property is used by the IDE to get a list of available and
         * registered template engines, you don't need to use this property
         * directly.
         *
         * @see registerTemplate()
         *
         * @return array Array with all template engine names
         */
        function getEngines()
        {
                $keys=array_keys($this->_templates);
                $ret=array('');
                $ret=array_merge($ret,$keys);
                return($ret);
        }
}

/**
* Global variable for the Template Manager, checkout TemplateManager::registerTemplate
*/
global $TemplateManager;

$TemplateManager=new TemplateManager(null);

//Add here all the template engines available to forms
use_unit("smartytemplate.inc.php");

?>