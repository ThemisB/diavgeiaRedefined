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
use_unit("rtl.inc.php");
use_unit("templateplugins.inc.php");
use_unit("cache.inc.php");
/**
*
*/
define('dtNone','(none)');
define('dtXHTML_1_0_Strict'     ,'XHTML 1.0 Strict');
define('dtXHTML_1_0_Transitional' ,'XHTML 1.0 Transitional');
define('dtXHTML_1_0_Frameset'     ,'XHTML 1.0 Frameset');
define('dtHTML_4_01_Strict'       ,'HTML 4.01 Strict');
define('dtHTML_4_01_Transitional' ,'HTML 4.01 Transitional');
define('dtHTML_4_01_Frameset'     ,'HTML 4.01 Frameset');
define('dtXHTML_1_1'              ,'XHTML 1.1');

define('ddLeftToRight','ddLeftToRight');
define('ddRightToLeft','ddRightToLeft');

/**
 * Shutdown function, called by the PHP engine as the last thing to do before shutdown.
 *
 * This function is automatically called by the PHP engine just before shutdown, and it's the right moment to serialize
 * all components as no more user code is going to be executed.
 *
 * This way, the status of all objects in the aplication is stored to be recovered later without user intervention.
 *
 * @see Application::serializeChildren()
 * @link http://www.php.net/manual/en/function.register-shutdown-function.php
 *
 */
function VCLShutdown()
{
        global $application;

        //This is the moment to store all properties in the session to retrieve them later
        $application->serializeChildren();

        //Uncomment this to get what is stored on the session at the last step of your scripts
        /*
        echo "<pre>";
        print_r($_SESSION);
        echo "<pre>";
        */
}

register_shutdown_function("VCLShutdown");

/**
 * A class to reference all the forms created on your application.
 *
 * The Application class holds a reference to all the forms created in your application
 * because the Owner for them is always the global Application object. This class is also
 * used to switch the language for the whole application by using the Language property.
 *
 * This class is also responsible for session management, if you include a restore_session=1 in
 * your request, the object, when created, will destroy the existing session and will create a
 * new one, so your application will start fresh.
 */
class Application extends Component
{
        protected $_language;

        /**
        * Sets the application language, so all forms in the application will share this setting.
        *
        * If you want to change the Language property for all your forms at once, you can use this
        * property, as forms take this setting into account when switching language.
        *
        * This property is of string type and you can set it to anything you want, provided your
        * language files share the same value and your locale resources also share that setting.
        *
        * <code>
        * <?php
        * global $application;
        * $application->Language="English";
        * //Now, your forms must have a unit.English.xml.php resource file with your translated strings
        * //and also a locale/English/messages.mo to be used for runtime strings
        * ?>
        * </code>
        *
        * @see Page::getLanguage()
        * @link http://www.qadram.com/vcl4php/docwiki/index.php/Developer%27s_Guide_::_Localizing_the_Interface
        * @link http://www.php.net/gettext
        *
        * @return string
        */
        function getLanguage() { return $this->_language; }
        function setLanguage($value) { $this->_language=$value; }

        function __construct($aowner=null)
        {
                parent::__construct($aowner);

                global $startup_functions;

                //Call all startup functions before create the session
                reset($startup_functions);
                while(list($key, $val)=each($startup_functions))
                {
                        $val();
                }


                if (!session_start()) die ("Cannot start session!");
                if (isset($_GET['restore_session']))
                {
                        if (!isset($_POST['xajax']))
                        {
                            $_SESSION = array();
                            session_destroy();
                            if (!session_start()) die ("Cannot start session!");
                        }
                }

                //TODO: Check this for security issues
                reset($_GET);
                while (list($k,$v)=each($_GET))
                {
                        if (strpos($k,'.')===false) $_SESSION[$k]=$v;
                }
        }

        /**
        * Performs an auto detection of the language used by the user browser and set the Language property accordingly.
        *
        * This method performs a detection operation trying to guess which language is used by the user depending on the
        * browser headers and information is sent.
        *
        * Can be used to accomodate automatically your application to the right language the user
        * want to get without prompting for it.
        *
        * Valid languages can be found on language/php_language_detection.php on the function called languages() and you can
        * get such list as an array calling that function in your software
        *
        * <code>
        * <?php
        *      function Button1Click($sender, $params)
        *      {
        *       global $application;
        *
        *       $application->autoDetectLanguage();
        *       echo $application->Language;
        *       //This echoes in the browser "Spanish (Traditional Sort)"
        *      }
        * ?>
        * </code>
        *
        * @see languages()
        *
        */
        function autoDetectLanguage()
        {
                use_unit("language/php_language_detection.php");
                $lang=get_languages('data');
                reset($lang);
                while (list($k,$v)=each($lang))
                {
                        if (array_key_exists(2,$v))
                        {
                                $this->Language=$v[2];
                                break;
                        }
                }
        }

}

global $application;

/**
 * Global $application variable
 */
$application=new Application(null);
$application->Name="vclapp";


/**
 * Base class for controls with scrolling area
 *
 * It doesn't introduce any property/method/event and is reserved for future use.
 */
class ScrollingControl extends FocusControl
{
}

/**
 * Base class for Page component
 *
 * It represents the browser page and provides several properties and methods to customize
 * the appearance of the page.
 */
class CustomPage extends ScrollingControl
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
        }

        function serialize()
        {
            $toserialize=array();
            reset($this->components->items);
            while (list($k,$v)=each($this->components->items))
            {
                $parent="";
                if ($v->inheritsFrom('Control')) $parent=$v->parent->Name;

                if ($v->Name!='') $toserialize[$v->Name]=array($parent,$v->className());
            }

                global $application;

                $_SESSION['comps.'.$application->Name.'.'.$this->className()]=$toserialize;

                //Store last resource read to prevent reloading again in the next post
                $_SESSION[$this->readNamePath().'._reallastresourceread']=$this->reallastresourceread;
                parent::serialize();
        }

}

/**
 * DataModule class, basically a non visible holder for direct Component descendants
 *
 * You can use this class to create non-visible pages which hold non-visible components to
 * be used on another pages, is a way to centralize common reusable code.
 *
 */
class DataModule extends CustomPage
{

}

        /**
        * This function dumps an object into the ajaxresponse, so it's added
        * to be updated when the ajax request is returned
        *
        * This function is used by the internal Ajax system to get the code for a component and
        * add it to the Ajax response, so it gets updated when the response is returned.
        *
        * It relays on the dumpForAjax method that may be implemented by a component to specify
        * which javascript code must be executed in order to update such component.
        *
        * If no dumpForAjax method implementation exists, it tries to get the object code and
        * split the javascript and html code to add it to the response, so it gets correctly processed.
        *
        * @see extractjscript()
        *
        * @param object $object Object to be added
        */
        function ajaxDump($object)
        {
            global $ajaxResponse;

            if ($object->methodExists("dumpForAjax"))
            {
                ob_start();
                $object->dumpForAjax();
                $ccontents=ob_get_contents();
                ob_end_clean();
                $ajaxResponse->addScript($ccontents);
            }
            else
            {
                ob_start();
                $object->show();
                $ccontents=ob_get_contents();
                ob_end_clean();

                $ajaxResponse->addAssign($object->Name."_outer","innerHTML",$ccontents);
                $js=extractjscript($ccontents);
                $ajaxResponse->addScript($js[0]);
            }
        }

/**
 * Function responsible to dispatch ajax requests to the right events
 *
 * This function is used by the Page when UseAjax is true to process the ajax requests and fire the right
 * events.
 *
 * It also creates the response to update the browser according to the component updates.
 *
 * @see ajaxDump()
 *
 * @param string $owner Name of the owner that owns all the components for this request, usually a Page component
 * @param string $sender Object that produced the ajaxCall
 * @param mixed $params Parameters to be sent to the function to be executed
 * @param string $event Name of the PHP function to execute
 * @param array $postvars Variables from the _POST stream
 * @param array $comps Names of the components to add to the stream to get updated
 * @return string
 */
        function ajaxProcess($owner, $sender, $params, $event, $postvars, $comps)
        {
                global $$owner;

                $_POST=$postvars;

                //TODO: Revise this, as it may be initializating twice
                //Initializes all components
                $$owner->unserialize();
                $$owner->unserializeChildren();
                $$owner->loadedChildren();
                $$owner->loaded();
                $$owner->preinit();
                $$owner->init();

                global $ajaxResponse;

                $ajaxResponse = new xajaxResponse();

                $$owner->callEvent('onbeforeajaxprocess',array());
                $$owner->$event($$owner->$sender, $params);

                reset($$owner->controls->items);

                unset($comps['isArray']);

                if (count($comps)>=1)
                {
                    reset($comps);

                    while (list($k,$aname)=each($comps))
                    {
                        $v=$$owner->$aname;
                        if (is_object($v))
                        {
                            ajaxDump($v);
                        }
                    }
                }
                else
                {
                    while (list($k,$v)=each($$owner->controls->items))
                    {
                            ajaxDump($v);
                    }
                }

                $$owner->callEvent('onafterajaxprocess',array());
                $$owner->serialize();
                $$owner->serializeChildren();

                $response=$ajaxResponse->getXML();

                return $response;
        }


define('rmFrame','frame');
define('rmOpaque','opaque');
define('rmLazyOpaque','lazyopaque');
define('rmTranslucent','translucent');

define('mmFrame','frame');
define('mmOpaque','opaque');
define('mmTranslucent','translucent');

/**
 * A class to encapsulate a window living on the browser
 *
 * This component allows you to place a window inside a browser, mimmicking a desktop
 * window, so you can place components inside to give your application a more desktop-like
 * interface.
 *
 * @example Windows/windows.php Using Window component
 * @example Windows/windows.xml.php Using Window component (form)
 */
class Window extends QWidget
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
                $this->ControlStyle="csSlowRedraw=1";
        }

            protected $_modal=0;

        /**
        * Specifies if the window is modal or not.
        *
        * A modal window is the one that forces the user to make an action (close
        * the window, click a button, etc) before it can continue with the program.
        *
        * Use this kind of windows for notifications to the user, or to request some action
        *
        * @see getIsVisible()
        *
        * @return boolean
        */
            function getModal() { return $this->_modal; }
            function setModal($value) { $this->_modal=$value; }
            function defaultModal() { return 0; }

            protected $_isvisible=true;

        /**
        * Specifies if the window is visible or not.
        *
        * Modal windows are not visible and should be shown using code on a javascript event
        *
        * @see getModal()
        *
        * @return boolean
        */
            function getIsVisible() { return $this->_isvisible; }
            function setIsVisible($value) { $this->_isvisible=$value; }
            function defaultIsVisible() { return true; }

            function getCaption() { return $this->readCaption(); }
            function setCaption($value) { $this->writeCaption($value); }

            protected $_resizeable=1;

        /**
        * Specifies if the window allows to be resized.
        *
        * This property determines if the window component must allow the user to
        * resize the window in the browser.
        *
        * @see getMoveable()
        *
        * @return boolean
        */
            function getResizeable() { return $this->_resizeable; }
            function setResizeable($value) { $this->_resizeable=$value; }
            function defaultResizeable() { return 1; }

            protected $_moveable=1;

        /**
        * Specifies if the window allows to be moved.
        *
        * This property determines if the window component must allow the user to
        * move the window, if false, the window will state at the location it was
        * designed.
        *
        * @see getResizeable()
        *
        * @return boolean
        */
            function getMoveable() { return $this->_moveable; }
            function setMoveable($value) { $this->_moveable=$value; }
            function defaultMoveable() { return 1; }

            protected $_showminimize=1;

        /**
        * Specifies if the window shows the minimize button or not.
        *
        * Use this property to specify if the minimize button is shown or not, if
        * false, the user won't be able to minimize the window.
        *
        * @see getShowMaximize(), getShowClose()
        *
        * @return boolean
        */
            function getShowMinimize() { return $this->_showminimize; }
            function setShowMinimize($value) { $this->_showminimize=$value; }
            function defaultShowMinimize() { return 1; }

            protected $_showmaximize=1;

		    function getVisible() { return $this->readvisible(); }
    		function setVisible($value) { $this->writevisible($value); }



        /**
        * Specifies if the window shows the maximize button or not
        *
        * Use this property to specify if the maximize button is shown or not, if
        * false, the user won't be able to maximize the window.
        *
        * @see getShowMinimize(), getShowClose()
        *
        * @return boolean
        */
            function getShowMaximize() { return $this->_showmaximize; }
            function setShowMaximize($value) { $this->_showmaximize=$value; }
            function defaultShowMaximize() { return 1; }

            protected $_showclose=1;

        /**
        * Specifies if the window shows the close button or not
        *
        * Use this property to specify if the close button is shown or not, if
        * false, the user won't be able to close the window.
        *
        * @see getShowMaximize(), getShowMinimize()
        *
        * @return boolean
        */
            function getShowClose() { return $this->_showclose; }
            function setShowClose($value) { $this->_showclose=$value; }
            function defaultShowClose() { return 1; }

            protected $_showicon=1;

        /**
        * Specifies if the window shows the top left icon or not on the title bar
        *
        * Use this property to specify if the top left icon is shown or not, if
        * false, no icon will be shown.
        *
        * To specify which icon is shown, check IconSource property
        *
        * @see getShowCaption(), getIconSource()
        *
        * @return boolean
        */
            function getShowIcon() { return $this->_showicon; }
            function setShowIcon($value) { $this->_showicon=$value; }
            function defaultShowIcon() { return 1; }

            protected $_showcaption=1;

        /**
        * Specifies if the window shows a caption on the title bar
        *
        * Use this property to specify if the top caption is shown or not, if
        * false, no caption will be shown.
        *
        * To specify the caption to show, check Caption property
        *
        * @see getShowIcon(), getCaption()
        *
        * @return boolean
        */
            function getShowCaption() { return $this->_showcaption; }
            function setShowCaption($value) { $this->_showcaption=$value; }
            function defaultShowCaption() { return 1; }

            protected $_movemethod="mmOpaque";

        /**
        * Specifies the method used to move the window, these are the available values:
        *
        * mmFrame - The windows shows a rectangular frame with the new position
        *
        * mmOpaque - The window moves at the same time the user moves the mouse
        *
        * mmTranslucent - The window becomes translucent when moving
        *
        * Default value is mmOpaque
        *
        * @return enum
        */
            function getMoveMethod() { return $this->_movemethod; }
            function setMoveMethod($value) { $this->_movemethod=$value; }
            function defaultMoveMethod() { return "mmOpaque"; }

            protected $_resizemethod="rmFrame";

        /**
        * Specifies the method used to resize the window
        *
        * rmFrame - A frame is shown with the new size
        *
        * rmOpaque - The window size is changed with the mouse movement
        *
        * rmLazyOpaque - The size is changed with the mouse movement, but is less updated
        *
        * rmTranslucent - The size is changed with the mouse movement and the window becomes translucent
        *
        *
        * Default value is rmFrame
        *
        * @return enum
        */
            function getResizeMethod() { return $this->_resizemethod; }
            function setResizeMethod($value) { $this->_resizemethod=$value; }
            function defaultResizeMethod() { return "rmFrame"; }

            protected $_showstatusbar=0;

        /**
        * Specifies if the window shows a status bar or not at the bottom
        *
        * Use this property to specify if the bottom statusbar is shown or not, if
        * false, no status bar will be shown.
        *
        * @return boolean
        */
            function getShowStatusBar() { return $this->_showstatusbar; }
            function setShowStatusBar($value) { $this->_showstatusbar=$value; }
            function defaultShowStatusBar() { return 0; }

        protected $_iconsource="";

        /**
        * Specifies the path to the icon used by the window
        *
        * Use this property to specify the image to be shown at the top left
        * corner of the window, if none assigned, a default will be used.
        *
        * To specify if the icon is shown or not, check ShowIcon property
        *
        * @see getShowIcon()
        *
        * @return string
        */
        function getIconSource() { return $this->_iconsource; }
        function setIconSource($value) { $this->_iconsource = $value; }
        function defaultIconSource() { return ""; }

        function getjsOnClick() { return $this->_jsonclick; }
        function setjsOnClick($value) { $this->_jsonclick = $value; }

        protected $_jsonminimize=null;

        /**
        * Fires when the window is minimized
        *
        * Use this event to get notified when the Window component is minimized
        * inside the browser. Here you can write javascript code to react to that
        * event.
        *
        * @see getjsOnRestore(), getjsOnMaximize()
        *
        * @return mixed
        */
        function getjsOnMinimize() { return $this->_jsonminimize; }
        function setjsOnMinimize($value) { $this->_jsonminimize = $value; }

        protected $_jsonrestore=null;

        /**
        * Fires when the window is restored
        *
        * Use this event to get notified when the Window component is restored from
        * minimized state. Here you can write javascript code to react to that
        * event.
        *
        * @see getjsOnMinimize(), getjsOnMaximize()
        *
        * @return mixed
        */
        function getjsOnRestore() { return $this->_jsonrestore; }
        function setjsOnRestore($value) { $this->_jsonrestore = $value; }

        protected $_jsonmaximize=null;

        /**
        * Fires when the window is maximized
        *
        * Use this event to get notified when the Window component is maximized
        * inside the browser. Here you can write javascript code to react to that
        * event.
        *
        * @see getjsOnMinimize(), getjsOnRestore()
        *
        * @return mixed
        */
        function getjsOnMaximize() { return $this->_jsonmaximize; }
        function setjsOnMaximize($value) { $this->_jsonmaximize = $value; }

        protected $_jsonclose=null;


        /**
        * Fires when the window is closed
        *
        * Use this event to get notified when the Window component is closed
        * inside the browser. Here you can write javascript code to react to that
        * event.
        *
        * @return mixed
        */
        function getjsOnClose() { return $this->_jsonclose; }
        function setjsOnClose($value) { $this->_jsonclose = $value; }

        protected $_jsonmove=null;

        /**
        * Fires when the window is moved
        *
        * Use this event to get notified when the Window component is moved
        * inside the browser. Here you can write javascript code to react to that
        * event.
        *
        * @return mixed
        */
        function getjsOnMove() { return $this->_jsonmove; }
        function setjsOnMove($value) { $this->_jsonmove = $value; }

        protected $_jsonresize=null;

        /**
        * Fires when the window is resized
        *
        * Use this event to get notified when the Window component is resized
        * inside the browser. Here you can write javascript code to react to that
        * event.
        *
        * @return mixed
        */
        function getjsOnResize() { return $this->_jsonresize; }
        function setjsOnResize($value) { $this->_jsonresize = $value; }

        function dumpJsEvents()
        {
                $result = parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonminimize);
                $this->dumpJSEvent($this->_jsonrestore);
                $this->dumpJSEvent($this->_jsonmaximize);
                $this->dumpJSEvent($this->_jsonclose);
                $this->dumpJsEvent($this->_jsonmove);
                $this->dumpJsEvent($this->_jsonresize);

                return $result;
        }

        function dumpJavascript()
        {
                parent::dumpJavascript();

                $def = $this->Name . 'ModeChangeHandler';
                if (!defined($def) && ($this->_jsonminimize != null || $this->_jsonrestore != null || $this->_jsonmaximize != null))
                {
                        define($def, 1);
                        echo "function $def(e) {\n";
                        if ($this->_jsonminimize) echo "  if (e.getData() == \"minimized\") return $this->_jsonminimize();\n";
                        if ($this->_jsonrestore)  echo "  if (e.getData() === null) return $this->_jsonrestore();\n";
                        if ($this->_jsonmaximize) echo "  if (e.getData() == \"maximized\") return $this->_jsonmaximize();\n";
                        echo "}\n\n";
                }

                $def = $this->Name . 'MoveHandler';
                if (!defined($def) && ($this->_jsonmove != null))
                {
                        define($def, 1);
                        echo "function $def(e) {\n";
                        echo "  return $this->_jsonmove();\n";
                        echo "}\n\n";
                }

                $def = $this->Name . 'ResizeHandler';
                if (!defined($def) && ($this->_jsonresize != null))
                {
                        define($def, 1);
                        echo "function $def(e) {\n";
                        echo "  return $this->_jsonresize();\n";
                        echo "}\n\n";
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
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        echo "  $this->Name.setModal(" . boolToStr($this->Modal) . ");\n";
                        echo "  $this->Name.setResizeable(" . boolToStr($this->Resizeable) . ");\n";
                        echo "  $this->Name.setMoveable(" . boolToStr($this->Moveable) . ");\n";
                        echo "  $this->Name.setMoveMethod(\"".constant($this->MoveMethod)."\");\n";
                        echo "  $this->Name.setResizeMethod(\"".constant($this->ResizeMethod)."\");\n";
                }

                echo "  $this->Name.setShowClose(" . boolToStr($this->ShowClose) . ");\n";
                echo "  $this->Name.setShowMinimize(" . boolToStr($this->ShowMinimize) . ");\n";
                echo "  $this->Name.setShowMaximize(" . boolToStr($this->ShowMaximize) . ");\n";
                echo "  $this->Name.setShowIcon(" . boolToStr($this->ShowIcon) . ");\n";
                echo "  $this->Name.setShowCaption(" . boolToStr($this->ShowCaption) . ");\n";
                echo "  $this->Name.setShowStatusbar(" . boolToStr($this->ShowStatusBar) . ");\n";
                $this->dumpChildrenControls(-22,-3);
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
                echo "<script type=\"text/javascript\">\n";
                echo "  var d = qx.ui.core.ClientDocument.getInstance();\n";
                echo "  var $this->Name = new qx.ui.window.Window(\"$this->Caption\", \"" . ($this->IconSource ? $this->IconSource : "icon/16/apps/accessories-disk-usage.png") . "\");\n";

                if (($this->ControlState & csDesigning) != csDesigning) {
                        echo "  $this->Name.setLocation($this->Left, $this->Top);\n";
                }
                else
                {
                        echo "  $this->Name.setLocation(0, 0);\n";
                }
                echo "  $this->Name.setWidth($this->Width);\n";
                echo "  $this->Name.setHeight($this->Height);\n";
                $this->commonScript();

                if ($this->_jsonclick) echo "  $this->Name.addEventListener(\"click\", $this->_jsonclick, $this->Name);\n";
                if ($this->_jsonminimize || $this->_jsonrestore || $this->_jsonmaximize) echo "  $this->Name.addEventListener(\"changeMode\", {$this->Name}ModeChangeHandler, $this->Name);\n";
                //TODO: Fix jsOnMove and jsOnResize because they are being fired twice
                if ($this->_jsonmove)
                {
                        echo "  $this->Name.addEventListener(\"changeTop\", {$this->Name}MoveHandler, $this->Name);\n";
                        echo "  $this->Name.addEventListener(\"changeLeft\", {$this->Name}MoveHandler, $this->Name);\n";
                }
                if ($this->_jsonresize)
                {
                        echo "  $this->Name.addEventListener(\"changeWidth\", {$this->Name}ResizeHandler, $this->Name);\n";
                        echo "  $this->Name.addEventListener(\"changeHeight\", {$this->Name}ResizeHandler, $this->Name);\n";
                }
                if ($this->_jsonclose) echo "  $this->Name._closeButton.addEventListener(\"execute\", $this->_jsonclose, $this->Name);\n";

                echo "  d.add($this->Name)\n";

                if (($this->ControlState & csDesigning) != csDesigning)
                {
                       if ($this->IsVisible)
                       {
                               if (!$this->Modal)
                               {
                                       echo "  $this->Name.open();\n";
                               }
                       }
               }

               else
               {
                       echo "  $this->Name.open();\n";
               }
               echo "</script>";
        }

}

/**
 * A class to encapsulate a web page.
 *
 * This class is the foundation of the VCL, it's
 * the main container in which all controls that make up your interface are placed.
 * In the web world, the Page class, in short, generates an HTML document and is responsible
 * to render all controls it holds inside.
 *
 * If you use Delphi for PHP, Pages are created by the IDE and you drop components inside them,
 * which are stored in an .xml.php file that is read by the Page.
 *
 * @example Inheritance/index.php How to use Master Pages (child)
 * @example Inheritance/index.xml.php How to use Master Pages (child page)
 * @example Inheritance/masterpage.php How to use Master Pages (master)
 * @example Inheritance/masterpage.xml.php How to use Master Pages (master page)
 */
class Page extends CustomPage
{
    protected $_showheader=1;
    protected $_showfooter=1;
    protected $_ismaster="0";
    protected $_marginwidth="0";
    protected $_marginheight="0";
    protected $_leftmargin="0";
    protected $_topmargin="0";
    protected $_rightmargin="0";
    protected $_bottommargin="0";
    protected $_useajax=0;
    protected $_useajaxdebug=0;
    protected $_dynamic=false;
    protected $_templateengine="";
    protected $_templatefilename="";

    protected $_onbeforeshowheader=null;
    protected $_onstartbody=null;
    protected $_onshowheader=null;
    protected $_onaftershowfooter=null;
    protected $_oncreate=null;

    protected $_isform=true;
    protected $_action="";

    protected $_background="";
    protected $_language="(default)";

    protected $_jsonload=null;
    protected $_jsonunload=null;


        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content.
        * @return mixed
        */
        function getjsOnLoad() { return $this->_jsonload; }
        function setjsOnLoad($value) { $this->_jsonload=$value; }
        function defaultjsOnLoad() { return null; }

        /**
        * The javascript OnUnload event is called after all nested framesets and
        * frames are finished with unloading their content.
        * @return mixed
        */
        function getjsOnUnload() { return $this->_jsonunload; }
        function setjsOnUnload($value) { $this->_jsonunload=$value; }
        function defaultjsOnUnload() { return null; }


        function getLayout() { return $this->readLayout(); }
        function setLayout($value) { $this->writeLayout($value); }

        protected $_framespacing=0;
        protected $_frameborder=fbNo;
        protected $_borderwidth=0;
        protected $_border="";

    protected $_icon="";

        /**
        * Specifies the icon to be used on the address bar when loading this page and for bookmarks.
        *
        * @return string
        */
    function getIcon() { return $this->_icon; }
    function setIcon($value) { $this->_icon=$value; }
    function defaultIcon() { return ""; }



        /**
        * Sets or retrieves the amount of additional space between the frames, this
        * value is used only when Frames or Framesets are placed inside the Page.
        * When this happens, the Page control, instead generate an HTML document
        * generates a Frameset and renders all the Frames and Framesets inside depending
        * on the align property.
        *
        * @see getFrameBorder()
        *
        * @return integer
        */
        function getFrameSpacing() { return $this->_framespacing;       }
        function setFrameSpacing($value) { $this->_framespacing=$value; }
        function defaultFrameSpacing() { return 0; }

        /**
        * Specifies the frameborder when the page generates Frames, this value is used
        * only when Frames or Framesets are placed inside the Page
        *
        * fbDefault - Inset border is drawn
        *
        * fbNo - No border is drawn
        *
        * fbYes - Inset border is drawn
        *
        * @see getFrameSpacing()
        *
        * @return enum
        */
        function getFrameBorder() { return $this->_frameborder; }
        function setFrameBorder($value) { $this->_frameborder=$value; }
        function defaultFrameBorder() { return fbNo; }

        /**
        * The BorderWidth property sets the width of all four borders of the page.
        *
        * You can set this property to a value which will be used as width for the border
        * of the page.
        *
        * @return integer
        */
        function getBorderWidth() { return $this->_borderwidth; }
        function setBorderWidth($value) { $this->_borderwidth=$value; }
        function defaultBorderWidth() { return 0; }


    protected $_encoding='Western European (ISO)     |iso-8859-1';

        /**
        * Specifies the encoding to use for the page.
        *
        * Use this property to specify the encoding to use when generating this page, this
        * encoding is set on the charset of the generated HTML and it's different from the
        * Charset you setup PHP to work on.
        *
        * @link http://www.w3.org/TR/html4/charset.html
        *
        * @return enum
        */
    function getEncoding() { return $this->_encoding; }
    function setEncoding($value) { $this->_encoding=$value; }
    function defaultEncoding() { return "Western European (ISO)     |iso-8859-1"; }

    protected $_doctype="dtNone";

        /**
        * Specifies the doctype to include on the generation of the page.
        *
        * DocType specifies the type of document you want to generate,
        * components are responsible to adapt to this property and generate valid code,
        * the Page simply sets the doctype for the HTML document and expects components
        * use it to determine the kind of valid HTML must generate
        *
        * @link http://www.w3.org/QA/2002/04/valid-dtd-list.html
        *
        * @return enum
        */
    function getDocType() { return $this->_doctype; }
    function setDocType($value) { $this->_doctype=$value; }
    function defaultDocType() { return dtNone; }


    protected $_formencoding="";

        /**
        * Specifies the encoding to use the form generated by the Page.
        *
        * Every Page component generates a Form (unless IsForm is false) to allow process events,
        * you can modify this property to set the encoding to a different value.
        *
        * This is useful, for example, to allow you upload data to the server
        *
        * @return enum
        */
    function readFormEncoding() { return $this->_formencoding; }
    function writeFormEncoding($value) { $this->_formencoding=$value; }
    function defaultFormEncoding() { return ""; }



        function getAlignment() { return $this->readAlignment(); }
        function setAlignment($value) { $this->writeAlignment($value); }

        function getColor() { return $this->readColor(); }
        function setColor($value) { $this->writeColor($value); }

        function getShowHint() { return $this->readShowHint(); }
        function setShowHint($value) { $this->writeShowHint($value); }

        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        function getCaption() { return $this->readCaption(); }
        function setCaption($value) { $this->writeCaption($value); }

        function getFont() { return $this->readFont(); }
        function setFont($value) { $this->writeFont($value); }

        /**
        * Specifies the background to be used when generating the HTML document.
        *
        * The background should be an image file, and will be used to fill the
        * page background with it. For example: images/mybackground.gif
        *
        * @return string
        */
        function getBackground() { return $this->_background; }
        function setBackground($value) { $this->_background=$value; }

        /**
        * Specifies the engine to be used to render this page using templates.
        *
        * Valid values for this property are registered Template Plugins, at this time, only
        * Smarty is included, checkout here to know more:
        *
        * @link http://www.qadram.com/vcl4php/docwiki/index.php/Developer%27s_Guide_::_Smarty_Templates
        * @see getTemplateFilename()
        *
        * @example Templates/templatesample.php Working with Templates
        * @example Templates/templatesample.xml.php Working with Templates (page)
        * @example Templates/index.html Working with Templates (template)
        *
        * @return string
        */
        function getTemplateEngine() { return $this->_templateengine; }
        function setTemplateEngine($value) { $this->_templateengine=$value; }
        function defaultTemplateEngine() { return ""; }

        /**
        * This property allows you to override the action parameter for the form
        * that is generated by the Page component.
        *
        * Usually, the action for the form is the script that generates the page
        * i.e. "unit1.php", but if you need to override this behaviour, you can
        * use this property for that.
        *
        * This property is useful to create forms that post information to another
        * script for further processing.
        *
        * @return string
        */
        function getAction() { return $this->_action; }
        function setAction($value) { $this->_action=$value; }
        function defaultAction() { return ""; }

        /**
        * Specifies the name of the template file to be used to render this page.
        *
        * Usually is an HTML file with some placeholders to allow insert information inside.
        * To insert components inside templates, you must add a placeholder with the name
        * of the component you want to insert, i.e. {$Button1}
        *
        * @link http://www.qadram.com/vcl4php/docwiki/index.php/Developer%27s_Guide_::_Smarty_Templates
        * @see getTemplateEngine()
        *
        * @example Templates/templatesample.php Working with Templates
        * @example Templates/templatesample.xml.php Working with Templates (page)
        * @example Templates/index.html Working with Templates (template)
        *
        * @return string
        */
        function getTemplateFilename() { return $this->_templatefilename; }
        function setTemplateFilename($value) { $this->_templatefilename=$value; }
        function defaultTemplateFilename() { return ""; }

        /**
        * This property allows the Page, if set, to process and handle Ajax requests
        * performed using Component::ajaxCall.
        *
        * If you want to use Ajax with the built-in engine, you need to use ajaxCall and
        * set this property to true, to inform the page that must process any ajax
        * requests. If set to false, ajax calls won't be processed.
        *
        * @link http://www.qadram.com/vcl4php/docwiki/index.php/Component_Writer%27s_Guide_::_Ajax_Integration
        * @see getUseAjaxDebug(), Component::ajaxCall()
        * @example Ajax/Basic/basicajax.php How to use ajaxCall
        *
        * @return boolean
        */
        function getUseAjax() { return $this->_useajax; }
        function setUseAjax($value) { $this->_useajax=$value; }
        function defaultUseAjax() { return 0; }

        /**
        * This property enables a debug window, to show ajax calls information
        *
        * When set to true, ajax calls will make a popup window to be shown with
        * information about all ajax requests. UseAjax must also be set to true.
        *
        * @link http://www.qadram.com/vcl4php/docwiki/index.php/Component_Writer%27s_Guide_::_Ajax_Integration
        * @see getUseAjax()
        *
        * @return boolean
        */
        function getUseAjaxDebug() { return $this->_useajaxdebug; }
        function setUseAjaxDebug($value) { $this->_useajaxdebug=$value; }
        function defaultUseAjaxDebug() { return 0; }

        protected $_useajaxuri="";

        function getUseAjaxUri() { return $this->_useajaxuri; }
        function setUseAjaxUri($value) { $this->_useajaxuri=$value; }
        function defaultUseAjaxUri() { return ""; }



        /**
        * Specifies the language to be used when rendering this page.
        *
        * By setting it to a different value than (default), the Page will look for a file
        * named [language].xml.php to be loaded. That file must contain the properties
        * need to be changed to localize the interface to that specific language
        *
        * Check here to know more:
        * @link http://www.qadram.com/vcl4php/docwiki/index.php/Developer%27s_Guide_::_Localizing_the_Interface
        * @see Application::getLanguage()
        * @example I18N/index.php How to use Language property to translate interface
        * @example I18N/index.xml.php How to use Language property to translate interface (form, default language)
        * @example I18N/index.English (United States).xml.php How to use Language property to translate interface (english resources)
        * @example I18N/index.Spanish (Traditional Sort).xml.php How to use Language property to translate interface (spanish resources)
        *
        * @return string
        */
        function getLanguage() { return $this->_language; }
        function setLanguage($value)
        {
                if ($value!=$this->_language)
                {
                        $this->_language=$value;
                        if ((($this->ControlState & csDesigning) != csDesigning) && (($this->ControlState & csLoading) != csLoading))
                        {
                                $resourcename=$this->lastresourceread;
                                if ($value=='(default)') $l="";
                                else $l=".".$value;

                                $resourcename=str_replace('.php',$l.'.xml.php',$resourcename);

                                //This is to allow gettext usage
                                if ($value=='(default)') $l='';
                                else $l=$value;

                                putenv ("LANG=$l");
                                putenv ("LANGUAGE=$l");
                                putenv ("LC_ALL=$l");
                                setlocale(6,$l);
                                putenv ("LC_MESSAGES=$l");
                                $domain="messages";
                                bindtextdomain($domain, "./locale");
                                textdomain($domain);

                                if (file_exists($resourcename))
                                {
                                        $this->readFromResource($resourcename, false, false);
                                }
                        }
                }
        }
        function defaultLanguage() { return "(default)"; }

    //Constructor
    function __construct($aowner=null)
    {
                        //Inherited constructor
                        parent::__construct($aowner);

    }

    protected $_cache=null;

    function getCache() { return $this->_cache; }
    function setCache($value) { $this->_cache=$this->fixupProperty($value); }
    function defaultCache() { return null; }


    function loaded()
    {
    	$this->setCache($this->_cache);
        //Once the component has been loaded, calls the oncreate event, if assigned
        $this->callEvent('oncreate',array());
    }

    protected $_jsonsubmit=null;

        /**
        * Fired when the page is going to be submitted to the form, return false
        * to prevent the form from being posted
        */
    function getjsOnSubmit() { return $this->_jsonsubmit; }
    function setjsOnSubmit($value) { $this->_jsonsubmit=$value; }
    function defaultjsOnSubmit() { return null; }

    protected $_jsonreset=null;

        /**
        * Fired when the page is going to be reset using a reset input button
        */
    function getjsOnReset() { return $this->_jsonreset; }
    function setjsOnReset($value) { $this->_jsonreset=$value; }
    function defaultjsOnReset() { return null; }

    protected $_target="";

    function getTarget() { return $this->_target; }
    function setTarget($value) { $this->_target=$value; }
    function defaultTarget() { return ""; }



        function dumpJsEvents()
        {
                parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonsubmit);
                $this->dumpJSEvent($this->_jsonreset);
                $this->dumpJSEvent($this->_jsonload);
                $this->dumpJSEvent($this->_jsonunload);
        }

        /**
        * Dumps the opening form tag
        *
        * This property, depending on the settings of IsForm and ShowHeader properties
        * returns the opening form tag, it also checks for Action property to know if
        * it must point the action for the form to the script itself or to another place.
        *
        * It also dumps code to process page events like OnSubmit and OnReset and sets
        * the form enconding according to the FormEncoding property.-
        *
        * @see readEndForm()
        *
        * @return string
        */
    function readStartForm()
    {
        $result="";
        if (($this->_isform) && ($this->_showheader))
        {
                $action="";
                if (isset($_SERVER['PHP_SELF'])) $action=$_SERVER['PHP_SELF'];

                   if ($this->_action!='') $action=$this->_action;

                   $formevents='';

                   if ($this->_jsonsubmit!="")
                   {
                        $formevents.=" onsubmit=\"return $this->_jsonsubmit();\" ";
                   }

                   if ($this->_jsonreset!="")
                   {
                        $formevents.=" onreset=\"return $this->_jsonreset();\" ";
                   }

                   $enctype = "";
                   if ($this->_formencoding != "")
                   {
                        $enctype = " enctype=\"$this->_formencoding\"";
                   }


               $target='';
               if ($this->_target!='') $target=' target="'.$this->_target.'" ';

               $result='<form style="margin-bottom: 0" id="'.$this->name.'" name="'.$this->name.'" method="post" '.$formevents.' '.$target.' action="'.$action.'"'.$enctype.'>';
        }
        return($result);
    }

        /**
        * Returns the ending form tag
        *
        * This property, depending on the settings of IsForm and ShowFooter will
        * dump the ending form tag.
        *
        * @see readStartForm()
        *
        * @return string
        */
    function readEndForm()
    {
        if (($this->_isform) && ($this->_showfooter))
        {
            return("</form>");
        }
    }

/**
 * Dump the page using a template, it doesn't generate an HTML page.

 * It uses the template and tries to insert components inside it. To make it work you
 * need to assign TemplateEngine and TemplateFilename properties with the right
 * values, check here to know more:
 * @link http://www.qadram.com/vcl4php/docwiki/index.php/Developer%27s_Guide_::_Smarty_Templates
 * @see getTemplateEngine(), getTemplateFilename()
 *
 */
    function dumpUsingTemplate()
    {
        //Check here for templateengine and templatefilename
        if (($this->ControlState & csDesigning) != csDesigning)
        {
                $tclassname=$this->_templateengine;

                $template=new $tclassname($this);
                $template->FileName=$this->_templatefilename;

                $template->initialize();
                $this->callEvent("ontemplate",array("template"=>$template));
                $template->assignComponents();
                $template->dumpTemplate();
        }
    }

    protected $_ontemplate=null;

    /**
    * Fired when the template is about to be rendered.
    *
    * This event is only fired
    * if TemplateEngine and TemplateFilename are correctly set and it provides you
    * with an opportunity to access to the internal template object, check here:
    * @link http://www.qadram.com/vcl4php/docwiki/index.php/Developer%27s_Guide_::_Smarty_Templates#Accessing_the_internal_Smarty_object
    * @see getTemplateEngine(), getTemplateFilename()
    *
    * @return mixed
    */
    function getOnTemplate() { return $this->_ontemplate; }
    function setOnTemplate($value) { $this->_ontemplate=$value; }
    function defaultOnTemplate() { return null; }

    protected $_onbeforeajaxprocess=null;

    /**
    * Fired just before the routine specified in ajaxcall is about to be called
    *
    * Use this event to perform any operation just before the routine specified in
    * ajaxcall is going to be called.
    *
    * @see ajaxCall()
    *
    * @return mixed
    */
    function getOnBeforeAjaxProcess() { return $this->_onbeforeajaxprocess; }
    function setOnBeforeAjaxProcess($value) { $this->_onbeforeajaxprocess=$value; }
    function defaultOnBeforeAjaxProcess() { return null; }

    protected $_onafterajaxprocess=null;

    /**
    * Fired just after the routine specified in ajaxcall is about to be called
    *
    * Use this event to perform any operation just after the routine specified in
    * ajaxcall is going to be called.
    *
    * @see ajaxCall()
    *
    * @return mixed
    */
    function getOnAfterAjaxProcess() { return $this->_onafterajaxprocess; }
    function setOnAfterAjaxProcess($value) { $this->_onafterajaxprocess=$value; }
    function defaultOnAfterAjaxProcess() { return null; }



    /**
    * This method is called to setup the Ajax functionality when dumping Page code
    *
    * When generating the page code, if ajax support is enabled, this method dumps
    * the right code to create the xajax object, setup xajax debug support if required
    * and to register the processing function for ajax requests as ajaxProcess(), and
    * finally, processes all the incomming ajax requests
    *
    * @see getUseAjaxDebug(), getUseAjax()
    */
    function processAjax()
    {
        if (($this->ControlState & csDesigning) != csDesigning)
        {
                use_unit("xajax/xajax.inc.php");
                //AJAX support
                global $xajax;

                $xajaxuri=$_SERVER['REQUEST_URI'];

                if ($this->UseAjaxUri!='') $xajaxuri=$this->UseAjaxUri;

                // Instantiate the xajax object.  No parameters defaults requestURI to this page, method to POST, and debug to off
                $xajax = new xajax($xajaxuri);

                if ($this->_useajaxdebug) $xajax->debugOn(); // Uncomment this line to turn debugging on

                // Specify the PHP functions to wrap. The JavaScript wrappers will be named xajax_functionname
                $xajax->registerFunction("ajaxProcess");

                // Process any requests.  Because our requestURI is the same as our html page,
                // this must be called before any headers or HTML output have been sent
                $xajax->processRequests();
                //AJAX support
        }
    }



    public $hasframes=false;

    /**
    * This method is used internally by the Page component to dump all javascript
    * must be located at the header.
    *
    * This method iterates through all components to dump all children javascript
    * inside the header section of the document.
    *
    * It also dumps common javascript stored in js/common.js and if ajax is enabled for the page
    * with the UseAjax property, it also includes the xajax library.
    *
    * @param boolean $return_contents If true, contents are returned by the function instead being dumped
    * @return string
    */
    function dumpHeaderJavascript($return_contents=false)
    {
        global $output_enabled;

        if ($output_enabled)
        {
                ob_start();
                $this->dumpChildrenJavascript();
                $js=ob_get_contents();
                ob_end_clean();
                $sp='';
                if (!defined('COMMON_JS'))
                {
                  $sp="<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/js/common.js\"></script>\n";
                  define('COMMON_JS',1);
                }
                $sp.="<script type=\"text/javascript\">var $this->Name=new Object(Object);</script>\n";
                if (trim($js)!="")
                {
                        $sp.="<script type=\"text/javascript\">\n";
                        $sp.="<!--\n";
                        $sp.=$js;
                        $sp.="-->\n";
                        $sp.="</script>\n";
                }

                // ajax js
                if ($this->_useajax)
                {
                        if (($this->ControlState & csDesigning) != csDesigning)
                        {
                          global $xajax;
                          $sp=$xajax->getJavascript("",VCL_HTTP_PATH."/xajax/xajax_js/xajax.js").$sp;
                        }
                }
                //
                if ($return_contents)
                {
                    return($sp);
                }
                else echo $sp;
        }
    }

    protected $_directionality=ddLeftToRight;

    /**
    * Set the text directionality of the page
    *
    * Use this property to set the directionality of the text inside the page.
    *
    * @return enum(ddLeftToRight,ddRightToLeft)
    */
    function getDirectionality() { return $this->_directionality; }
    function setDirectionality($value) { $this->_directionality=$value; }
    function defaultDirectionality() { return ddLeftToRight; }

    function dumpContents()
    {
        global $scriptfilename;

        acl_addresource(basename($scriptfilename));
        //TODO: Provide an opportunity to process acl failouts
        if (!acl_isallowed(basename($scriptfilename), "Show")) return;

        //TODO: XHTML support
        //TODO: Isolate all elements of a page into properties
        //Calls beforeshowheader event, if any
        $this->callEvent('onshow',array());

        if (($this->_ismaster=='true') || ($this->_ismaster=='1')) return;

        if ($this->_templateengine!="")
        {
                if ($this->_useajax) $this->processAjax();
                $this->dumpUsingTemplate();
                return;
        }

        if ($this->_useajax) $this->processAjax();

        $dtd="";
        $extra="";

        switch (constant($this->_doctype))
        {
            case dtNone: $dtd=""; $extra=""; break;

            case dtXHTML_1_0_Strict: $dtd='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'; $extra='xmlns="http://www.w3.org/1999/xhtml"'; break;
            case dtXHTML_1_0_Transitional: $dtd='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'; $extra='xmlns="http://www.w3.org/1999/xhtml"'; break;
            case dtXHTML_1_0_Frameset: $dtd='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">'; $extra='xmlns="http://www.w3.org/1999/xhtml"'; break;

            case dtHTML_4_01_Strict: $dtd='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'; break;
            case dtHTML_4_01_Transitional: $dtd='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'; break;
            case dtHTML_4_01_Frameset: $dtd='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">'; break;

            case dtXHTML_1_1: $dtd='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'; $extra='xmlns="http://www.w3.org/1999/xhtml"'; break;

        }


        $this->hasframes=false;

        //Iterates through controls to get the frames
        reset($this->controls->items);
        while (list($k,$v)=each($this->controls->items))
        {
                if (($v->inheritsFrom('Frame')) || ($v->inheritsFrom('Frameset')))
                {
                        $this->hasframes=true;
                }
        }

        //Calls beforeshowheader event, if any
        $this->callEvent('onbeforeshowheader',array());

        //Removed as it inteferes with DOCTYPE
        //echo "<!-- $this->name begin -->\n";
        //If must dump the header
        if ($this->_showheader)
        {
                if ($dtd!="") echo "$dtd\n";

                if ($this->_directionality==ddLeftToRight) $extra.=" DIR=ltr ";
                else $extra.=" DIR=rtl ";

                echo "<html $extra>\n";
                echo "<head>\n";

                if ($this->Icon!="")
                {
                        echo "<link rel=\"shortcut icon\" href=\"$this->Icon\" type=\"image/x-icon\" />\n";
                }

                $this->callEvent('onshowheader',array());

                $title=$this->Caption;
                echo "<title>$title</title>\n";

                $cs=explode('|',$this->_encoding);
                echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$cs[1]\" ";
                if (($this->DocType!='dtHTML_4_01_Strict') && ($this->DocType!='dtHTML_4_01_Transitional'))
                {
                    echo "/";
                }
                echo ">\n";

                $this->dumpHeaderJavascript();

                $this->dumpChildrenHeaderCode();

                echo "</head>\n";
                echo "\n";

                $attr="";

                $st="";


                if ($this->_leftmargin!="") $st.=" margin-left: ".$this->_leftmargin."px; ";
                if ($this->_topmargin!="") $st.=" margin-top: ".$this->_topmargin."px; ";
                if ($this->_rightmargin!="") $st.=" margin-right: ".$this->_rightmargin."px; ";
                if ($this->_bottommargin!="") $st.=" margin-bottom: ".$this->_bottommargin."px; ";

                if ($st!="") $st=" style=\"$st\" ";

                if ($this->color!="") $attr.=" bgcolor=\"$this->color\" ";
                if ($this->Background!="") $attr.=" background=\"$this->Background\" ";

                // add the defined JS events to the body
                if ($this->_jsonload!=null) $attr.=" onload=\"return $this->_jsonload(event)\" ";
                if ($this->_jsonunload!=null) $attr.=" onunload=\"return $this->_jsonunload(event)\" ";

            if (!$this->hasframes)
            {
                        echo "<body $st $attr>\n";
            }
        }
        else
        {
                echo "<script type=\"text/JavaScript\">\n";
                echo "<!--\n";
                $this->dumpChildrenJavascript();
                echo "-->\n";
                echo "</script>\n";

                        $this->dumpChildrenHeaderCode();
        }


        if (!$this->hasframes) echo $this->readStartForm();

        $this->dumpChildrenFormItems();

        $this->callEvent('onstartbody',array());


        //Dump children controls
        if (!$this->hasframes) $this->dumpChildren();
        else $this->dumpFrames();

        if (($this->_isform) && ($this->_showfooter))
        {
               if (!$this->hasframes) echo $this->readEndForm();
        }

        $this->callEvent('onaftershowfooter',array());

        //If must dump the footer
        if (!$this->hasframes)
        {
                if ($this->_showfooter)
                {
                        echo "</body>\n";
                        echo "</html>\n";
                }
        }

        if ($this->hasframes)
        {
                echo "<noframes><body>\n";
                echo $this->readStartForm();
                //Dump children controls
                $this->dumpChildren();
                echo $this->readEndForm();
                echo "</body></noframes>\n";
        }

        echo "<!-- $this->name end -->\n";

    }


    function dumpChildrenFormItems($return_contents=false)
    {
        $result=parent::dumpChildrenFormItems($return_contents);

        // fixup to allow initialization of visual stuff in case
        // if non-visual Q lib classes are used
        if ($return_contents)
        {
          ob_start();
        }
        if (defined('QOOXDOO'))
        {
                echo "\n"
                   . "<script type=\"text/javascript\">\n"
                   . "    var d = qx.ui.core.ClientDocument.getInstance();\n"
                   // If overflow is active, cursor is not shown on the edit controls
                   //                   . "    d.setOverflow(\"scrollY\");\n"
                   . "    d.setBackgroundColor(null);\n"
                   . "</script>\n";
        }
        if ($return_contents)
        {
          $result.=ob_get_contents();
          ob_end_clean();
        }
        return($result);
    }

    /**
     * Dump al children controls
     *
     */
    function dumpChildren()
    {
        $width="";
        $height="";
        $color="";

        $alignment="";

        switch ($this->_alignment)
        {
                case agNone: $alignment=""; break;
                case agLeft: $alignment=" align=\"Left\" "; break;
                case agCenter: $alignment=" align=\"Center\" "; break;
                case agRight: $alignment=" align=\"Right\" "; break;
        }

        if ($this->Color!="") $color=" bgcolor=\"$this->Color\" ";
        if ($this->Background!="") $background=" background=\"$this->Background\" ";
        if ($this->Width!="") $width=" width=\"$this->Width\" ";
        if ($this->Height!="") $height=" style=\"height:".$this->Height."px\" ";

        if (($this->ControlState & csDesigning) != csDesigning)
        {
            if (($this->Layout->Type==GRIDBAG_LAYOUT) || ($this->Layout->Type==ROW_LAYOUT) || ($this->Layout->Type==COL_LAYOUT))
            {
                $width=" width=\"100%\" ";
//                $height="";
            }
        }

        echo "\n<table $width $height border=\"0\" cellpadding=\"0\" cellspacing=\"0\" $color $alignment><tr><td valign=\"top\">\n";

        if (($this->ControlState & csDesigning) != csDesigning)
        {
                $this->Layout->dumpLayoutContents(array('Frame', 'Frameset'));
        }

        echo "</td></tr></table>\n";

        reset($this->controls->items);
        while (list($k,$v)=each($this->controls->items))
        {
                if (($v->Visible) && ($v->IsLayer))
                {
                        $v->show();
                }
        }

    }

        /**
        * Dump the page using frames, it's called when the Page contain Frame or Frameset components
        *
        * This method is called internally by the Page component when it detects it has
        * Frames or Framesets inside, so the code it generates must be different
        *
        * @see getFrameSpacing(), getFrameBorder(), getBorderWidth()
        */
    function dumpFrames()
    {
          $frameset=new Frameset(null);
          $frameset->Align=alClient;
          $frameset->FrameSpacing=$this->FrameSpacing;
          $frameset->FrameBorder=$this->FrameBorder;
          $frameset->BorderWidth=$this->BorderWidth;
          $frameset->controls=$this->controls;
          $frameset->show();
    }

        /**
        * Sets or retrieves the height of the top margin of the object.
        *
        * Use this property to specify the margin at the top of the page.
        *
        * @see getLeftMargin(), getBottomMargin(), getRightMargin()
        * @return integer
        */
    function getTopMargin() { return $this->_topmargin; }
    function setTopMargin($value) { $this->_topmargin=$value; }
    function defaultTopMargin() { return 0; }

        /**
        * Sets or retrieves the width of the left margin of the object.
        *
        * Use this property to specify the margin at the left of the page.
        *
        * @see getTopMargin(), getBottomMargin(), getRightMargin()
        * @return integer
        */
    function getLeftMargin() { return $this->_leftmargin; }
    function setLeftMargin($value) { $this->_leftmargin=$value; }
    function defaultLeftMargin() { return 0; }

        /**
        * Sets or retrieves the height of the bottom margin of the object.
        *
        * Use this property to specify the margin at the bottom of the page.
        *
        * @see getTopMargin(), getLeftMargin(), getRightMargin()
        * @return integer
        */
    function getBottomMargin() { return $this->_bottommargin; }
    function setBottomMargin($value) { $this->_bottommargin=$value; }
    function defaultBottomMargin() { return 0; }

        /**
        * Sets or retrieves the width of the right margin of the object.
        *
        * Use this property to specify the margin at the right of the page.
        *
        * @see getTopMargin(), getLeftMargin(), getBottomMargin()
        * @return integer
        */
    function getRightMargin() { return $this->_rightmargin; }
    function setRightMargin($value) { $this->_rightmargin=$value; }
    function defaultRightMargin() { return 0; }

        /**
        * If false, the form doesn't dump any header code.
        *
        * This property  is useful, for example if you want to include your form inside
        * another form, so it doesn't generate a full HTML document.
        *
        * When the Page generates the HTML document, it starts
        * from top to bottom, first dumps the header, after that, the body and at the end,
        * the footer. By setting this property to false, you tell the Page to don't generate
        * the footer and also, events for the footer won't be generated.
        *
        * @see getIsForm(), getShowFooter()
        * @return boolean
        */
    function getShowHeader() { return $this->_showheader; }
    function setShowHeader($value) { $this->_showheader=$value; }
    function defaultShowHeader() { return 1; }

        /**
        * If false, the form doesn't generate any <form> tag, but events won't be processed
        *
        * To allow VCL for PHP process events, there must be a form on the html document
        * that allows the document to be posted to the server, but, for example, if you want
        * to include your page into another page, you should set this property to false
        * to prevent generate nested <form> tags, as that is not allowed by HTML
        *
        * @see getShowHeader(), getShowFooter()
        * @return boolean
        */
    function getIsForm() { return $this->_isform; }
    function setIsForm($value) { $this->_isform=$value; }
    function defaultIsForm() { return 1; }

        /**
        * If true, this page doesn't render itself, but it's meant to be used as base for another forms
        *
        * This property is useful to create Master pages, when set to true, the page won't be shown
        * and you can create a new page and inherit from it.
        *
        * You can get more details here:
        * @link http://www.qadram.com/vcl4php/docwiki/index.php/Developer%27s_Guide_::_Page_Inheritance
        *
        * @return boolean
        */
    function getIsMaster() { return $this->_ismaster; }
    function setIsMaster($value) { $this->_ismaster=$value; }

        /**
        * If false, the form doesn't dump any footer code.
        *
        * This property is useful, for example if you want to include your form inside another
        * form, so it doesn't generate a full HTML document.
        *
        * When the Page generates the HTML document, it starts
        * from top to bottom, first dumps the header, after that, the body and at the end,
        * the footer. By setting this property to false, you tell the Page to don't generate
        * the footer and also, events for the footer won't be generated.
        *
        * @see getShowHeader(), getIsForm()
        * @return boolean
        */
    function getShowFooter() { return $this->_showfooter; }
    function setShowFooter($value) { $this->_showfooter=$value; }
    function defaultShowFooter() { return 1; }

        /**
        * Fired before the page is going to render the header, this is useful to add
        * contents on that document location
        */
    function getOnBeforeShowHeader() { return $this->_onbeforeshowheader; }
    function setOnBeforeShowHeader($value) { $this->_onbeforeshowheader=$value; }
    function defaultOnBeforeShowHeader() { return null; }

        /**
        * Fired after show the footer, which should be the last oportunity for you to
        * add code to the html document
        */
    function getOnAfterShowFooter() { return $this->_onaftershowfooter; }
    function setOnAfterShowFooter($value) { $this->_onaftershowfooter=$value; }
    function defaultOnAfterShowFooter() { return null; }

        /**
        * Fired when showing the header, this event is the right place if you want to
        * add CSS styles or Javascript scripts to your HTML using code, as the code you
        * dump in this event, will be placed inside the HTML header
        */
    function getOnShowHeader() { return $this->_onshowheader; }
    function setOnShowHeader($value) { $this->_onshowheader=$value; }
    function defaultOnShowHeader() { return null; }

        /**
        * Fired just right after dump the <body> tag, so you can add anything you may need
        * there
        */
    function getOnStartBody() { return $this->_onstartbody; }
    function setOnStartBody($value) { $this->_onstartbody=$value; }
    function defaultOnStartBody() { return null; }

    /**
    * Fired when the page is created and all components have been loaded, this is
    * the right event to perform initialization stuff, the other event for this is
    * OnBeforeShow
    */
    function getOnCreate() { return $this->_oncreate; }
    function setOnCreate($value) { $this->_oncreate=$value; }
    function defaultOnCreate() { return null; }

}

/**
 * A component to generate an html hidden field.
 *
 * This component is useful to send information to another script, set the value
 * for it on the Value property.
 *
 * The component is only visible at design time.
 *
 * You can use hidden field for many purposes, in the following example you can
 * use it to store the customer_id selected by the user on the dbgrid and when
 * the user presses the button, then issue an sql sentence to delete it:
 *
 * <code>
 * <?php
 *      class Unit465 extends Page
 *      {
 *             public $btnDelete = null;
 *             public $selectedcustomer = null;
 *             public $ddcustomers1 = null;
 *             public $dscustomers1 = null;
 *             public $dbnew_db1 = null;
 *             public $tbcustomers1 = null;
 *             function btnDeleteClick($sender, $params)
 *             {
 *                      global $input;
 *                      $selectedcustomer=$input->selectedcustomer;
 *
 *                      if (is_object($selectedcustomer))
 *                      {
 *                              echo "Delete customer:".$selectedcustomer->asInteger();
 *                      }
 *             }
 *
 *             function ddcustomers1JSRowChanged($sender, $params)
 *             {
 *             ?>
 *                      //The value for the hidden field selected customer is set
 *                      //to the selected customer id, which is the first row of
 *                      //the dbgrid
 *                      document.Unit465.selectedcustomer.value=ddcustomers1.getTableModel().getValue(0, ddcustomers1.getFocusedRow());
 *             <?php
 *             }
 *
 *      }
 * ?>
 * </code>
 *
 * @link http://www.w3.org/TR/html401/interact/forms.html#edef-INPUT
 *
 */
class HiddenField extends Control
{
        protected $_onsubmit = null;

        protected $_value = "";

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=200;
                $this->Height=18;
        }

        function preinit()
        {
                parent::preinit();

                //If there is something posted
                $submitted = $this->input->{$this->Name};
                if (is_object($submitted))
                {
                        //Set the value
                        $this->_value = $submitted->asString();
                }
        }

        function init()
        {
                parent::init();

                $submitted = $this->input->{$this->Name};

                // Allow the OnSubmit event to be fired because it is not
                // a mouse or keyboard event.
                if ($this->_onsubmit != null && is_object($submitted))
                {
                        $this->callEvent('onsubmit', array());
                }
        }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->_onshow != null)
                        {
                                $this->callEvent('onshow', array());
                        }
                        else
                        {
                                echo "<input type=\"hidden\" id=\"$this->Name\" name=\"$this->Name\" value=\"$this->Value\" />";
                        }
                }
                else
                {
                        echo "<table width=\"$this->width\" cellpadding=\"0\" cellspacing=\"0\" height=\"$this->height\"><tr><td style=\"background-color: #FFFF99; border: 1px solid #666666; font-size:10px; font-family:verdana,tahoma,arial\" align=\"center\">$this->Name=$this->Value</td></tr></table>";
                }
        }

        /*
        * Publish the events for the component
        */

        /**
        * Occurs when the form containing the control was submitted.
        * @return mixed Returns the event handler or null if no handler is set.
        */
        function getOnSubmit() { return $this->_onsubmit; }
        /**
        * Occurs when the form containing the control was submitted.
        * @param mixed Event handler or null if no handler is set.
        */
        function setOnSubmit($value) { $this->_onsubmit=$value; }
        function defaultOnSubmit() { return null; }


        /*
        * Publish the JS events for the component
        */

        function getjsOnChange                  () { return $this->readjsOnChange(); }
        function setjsOnChange                  ($value) { $this->writejsOnChange($value); }


        /*
        * Publish the properties for the component
        */

        /**
        * Specifies the value for the HTML hidden field
        *
        * and you will be able to
        * read this value on the script that receives the information.
        * @return string
        */
        function getValue() { return $this->_value; }
        function setValue($value) { $this->_value=$value; }
        function defaultValue() { return ""; }
}


define('fbNo','fbNo');
define('fbYes','fbYes');
define('fbDefault','fbDefault');

/**
 * A class to encapsulate a frame set and generate frames.
 *
 * This class is also used in the Page component to generate a frameset.
 *
 * For further information about HTML framesets and frames please visit following link:
 *
 * @link http://www.w3.org/TR/html401/present/frames.html
 * @see Frame
 * @example Frames/framesample.php How to use Frames and Framesets
 * @example Frames/framesample.xml.php How to use Frames and Framesets (form)
 */
class Frameset extends ScrollingControl
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
        }

        protected $_align=alClient;
        protected $_borderwidth=0;
        protected $_border="";
        protected $_framespacing=0;
        protected $_frameborder=fbNo;

        protected $_jsonload=null;
        protected $_jsonunload=null;


        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content.
        *
        * <code>
        * <?php
        * class Unit464 extends Page
        * {
        *        public $Frame2 = null;
        *        public $Frame1 = null;
        *        public $Frameset1 = null;
        *        function Frameset1JSLoad($sender, $params)
        *        {
        *
        *        ?>
        *        //Add your javascript code here
        *             alert("All frames have been loaded!");
        *        <?php
        *
        *        }
        * }
        * ?>
        * </code>
        * @return mixed
        */
        function getjsOnLoad() { return $this->_jsonload; }
        function setjsOnLoad($value) { $this->_jsonload=$value; }
        function defaultjsOnLoad() { return null; }

        /**
        * The javascript OnUnload event is called after all nested framesets and
        * frames are finished with unloading their content.
        * @return mixed
        */
        function getjsOnUnload() { return $this->_jsonunload; }
        function setjsOnUnload($value) { $this->_jsonunload=$value; }
        function defaultjsOnUnload() { return null; }

        function getAlign() { return $this->_align; }
        function setAlign($value) { $this->_align=$value; }
        function defaultAlign() { return alClient; }

        /**
        * Specifies the amount of additional space between the frames.
        *
        * When the page contain Frames or Framesets, the Page generates a Frameset
        * instead a plain HTML document, use this property to specify the spacing between frames.
        *
        * The amount of space defined for frameSpacing does not include the width of the
        * frame border. Frame spacing can be set on one or more frameSet objects
        * and applies to all contained frameSet objects, unless the contained
        * object defines a different frame spacing. The default spacing is 2 pixels.
        *
        * @return integer
        */
        function getFrameSpacing() { return $this->_framespacing;       }
        function setFrameSpacing($value) { $this->_framespacing=$value; }
        function defaultFrameSpacing() { return 0; }

        /**
        * This property specifies if the frameset is going to have border and which
        * method is used to draw it.
        *
        * When the page contain Frames or Framesets, the Page generates a Frameset
        * instead a plain HTML document, use this property to specify the border for the
        * generated frameset.
        *
        * fbDefault - Inset border is drawn.
        *
        * fbNo - No border is drawn.
        *
        * fbYes - Inset border is drawn.
        *
        *
        */
        function getFrameBorder() { return $this->_frameborder; }
        function setFrameBorder($value) { $this->_frameborder=$value; }
        function defaultFrameBorder() { return fbNo; }

        /**
        * Width of the left, right, top, and bottom borders of the object.
        * @return integer
        */
        function getBorderWidth() { return $this->_borderwidth; }
        function setBorderWidth($value) { $this->_borderwidth=$value; }
        function defaultBorderWidth() { return 0; }


    /**
    * Returns the defined JS events for the frameset.
    * @return string If empty no JS events are set.
    */
    function readFramesetJSEvents()
    {
        $result = "";

        if ($this->_jsonload!=null)  { $event=$this->_jsonload;  $result.=" onload=\"return $event(event)\" "; }
        if ($this->_jsonunload!=null)  { $event=$this->_jsonunload;  $result.=" onunload=\"return $event(event)\" "; }

        return $result;
    }

    function dumpJavascript()
    {
        parent::dumpJavascript();

        $this->dumpJSEvent($this->_jsonload);
        $this->dumpJSEvent($this->_jsonunload);
    }

    /**
    * Dump the frames inside the frameset that are aligned to alClient
    */
    function dumpClientFrames()
    {
        $fakeframe=true;
        reset($this->controls->items);
        while (list($k,$v)=each($this->controls->items))
        {
                if (($v->inheritsFrom('Frame')) || ($v->inheritsFrom('Frameset')))
                {
                        if ($v->Align==alClient)
                        {
                                $v->show();
                                $fakeframe=false;
                        }
                }
        }

        if ($fakeframe)
        {
                echo "<frame />";
        }
    }

    /**
    * Dump the frames inside the frameset that are aligned to alLeft or alRight
    *
    * @param array $hframes Frame objects to be dumped
    * @param boolean $outputevents If true, events for the frames will be generated
    */
    function dumpHorizontalFrames($hframes, $outputevents)
    {
                if (count($hframes)!=0)
                {
                        reset($hframes);
                        $leftwidths="";
                        $rightwidths="";
                        while(list($key, $val)=each($hframes))
                        {
                          if ($val->Align==alLeft) $leftwidths.=$val->Width.",";
                          if ($val->Align==alRight) $rightwidths.=",".$val->Width;
                        }

                        // only output events when they have an affect
                        // (only the most outer frameset will receive the onload event)
                        $events = ($outputevents) ? $this->readFramesetJSEvents() : "";

                        $frameborder = "";  // fbDefault
                        switch ($this->FrameBorder)
                        {
                                case fbNo: $frameborder = "no"; break;
                                case fbYes: $frameborder = "yes"; break;
                        }

                        echo "<frameset cols=\"$leftwidths*$rightwidths\" rows=\"*\" frameborder=\"$frameborder\" border=\"$this->BorderWidth\" framespacing=\"$this->FrameSpacing\" $events>\n";
                        reset($hframes);
                        while(list($key, $val)=each($hframes))
                        {
                          if ($val->Align==alLeft) $val->show();
                        }
                        //Dump here the alClient frames
                        $this->dumpClientFrames();

                        reset($hframes);
                        while(list($key, $val)=each($hframes))
                        {
                          if ($val->Align==alRight) $val->show();
                        }
                        echo "</frameset>\n";
                }
                else
                {
                        $this->dumpClientFrames();
                }
    }

    /**
    * Dump the whole frameset, with the alignment algorithm
    */
    function dumpContents()
    {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $msg=$this->Name;
                        $msg="$this->Name<br>place Frames inside this Frameset";

                        $bstyle=" style=\"border: 1px dotted #000000;font-size:10px; font-family:verdana,tahoma,arial\" ";
                        echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"$this->width\" height=\"$this->height\"><tr><td $bstyle align=\"center\">$msg</td></tr></table>";
                }
                else
                {
        reset($this->controls->items);
        $vframes=array();
        $hframes=array();
        while (list($k,$v)=each($this->controls->items))
        {
                if (($v->inheritsFrom('Frame')) || ($v->inheritsFrom('Frameset')))
                {
                        if (($v->Align==alTop) || ($v->Align==alBottom))
                        {
                                $vframes[$v->Top]=$v;
                        }
                        if (($v->Align==alLeft) || ($v->Align==alRight))
                        {
                                $hframes[$v->Left]=$v;
                        }
                }
        }

        ksort($vframes,SORT_NUMERIC);
        ksort($hframes,SORT_NUMERIC);

        //Dump rows
        if (count($vframes)!=0)
        {
                reset($vframes);
                $topheights="";
                $bottomheights="";
                while(list($key, $val)=each($vframes))
                {
                  if ($val->Align==alTop) $topheights.=$val->Height.",";
                  if ($val->Align==alBottom) $bottomheights.=",".$val->Height;
                }

                $events = $this->readFramesetJSEvents();

                echo "<frameset rows=\"$topheights*$bottomheights\" cols=\"*\" frameborder=\"$this->FrameBorder\" border=\"$this->BorderWidth\" framespacing=\"$this->FrameSpacing\" $events>\n";
                reset($vframes);
                while(list($key, $val)=each($vframes))
                {
                  if ($val->Align==alTop) $val->show();
                }
                //Dump here the horizontal frameset
                //**********************************
                $this->dumpHorizontalFrames($hframes, false);
                //**********************************
                reset($vframes);
                while(list($key, $val)=each($vframes))
                {
                  if ($val->Align==alBottom) $val->show();
                }
                echo "</frameset>\n";
        }
        else
        {
                $this->dumpHorizontalFrames($hframes, true);
        }
        }

    }

}

define('fsAuto','fsAuto');
define('fsYes','fsYes');
define('fsNo','fsNo');

/**
 * A frame represents a view of a document embedded into a parent document
 *
 * Frames allow developers to present documents in multiple views, which may be
 * independent windows or subwindows. Multiple views offer designers a way to
 * keep certain information visible, while other views are scrolled or replaced.
 * For example, within the same window, one frame might display a static banner,
 * a second a navigation menu, and a third the main document that can be scrolled
 * through or replaced by navigating in the second frame. A frame is a sub-component
 * of a Frameset. It should only be used within a Frameset control. For further
 * information about HTML frames please visit following link:
 *
 * @link http://www.w3.org/TR/html401/present/frames.html
 * @see Frameset
 * @example Frames/framesample.php How to use Frames and Framesets
 * @example Frames/framesample.xml.php How to use Frames and Framesets (form)
 */
class Frame extends ScrollingControl
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
                $this->ControlStyle="csAcceptsControls=1";
        }

        protected $_source="";

        /**
        * Defines the URL of the file/document to show inside the frame.
        * The frame, when rendered, will load the contents specified by the URL
        * set on this property, it can be an URL to internet, intranet, a file
        * on your system, etc.
        *
        * <code>
        * <?php
        * //This line sets the Frame::Source property to an external document
        * $this->Frame1->Source="http://vcl4php.sourceforge.net";
        * ?>
        * </code>
        *
        * @return string
        */
        function getSource() { return $this->_source; }
        function setSource($value) { $this->_source=$value; }
        function defaultSource() { return ""; }

        protected $_borders=1;

        /**
        * Specifies whether or not to display a border around the frame
        *
        * Possible values for this property are:
        *
        * true  - This value specifies to the browser to draw a separator between
        *         this frame and every adjoining frame. This is the default value
        *
        * false - This value specifies to the browser not to draw a separator between
        *         this frame and every adjoining frame. Note that separators may be drawn
        *         next to this frame nonetheless if specified by other frames
        *
        * @return integer
        */
        function getBorders() { return $this->_borders; }
        function setBorders($value) { $this->_borders=$value; }
        function defaultBorders() { return 1; }

        protected $_align=alLeft;

        function getAlign() { return $this->_align; }
        function setAlign($value) { $this->_align=$value; }
        function defaultAlign() { return alLeft; }

        protected $_marginwidth=0;

       /**
       * This property specifies the amount of space to be left between the frame's
       * contents in its left and right margins.
       *
       * The value must be greater than zero (pixels). The default value depends on the browser.
       *
       * @return integer
       */
        function getMarginWidth() { return $this->_marginwidth; }
        function setMarginWidth($value) { $this->_marginwidth=$value; }
        function defaultMarginWidth() { return 0; }

        protected $_marginheight=0;

        /**
        * This property specifies the amount of space to be left between the frame's
        * contents in its top and bottom margins.
        *
        * The value must be greater than zero (pixels). The default value depends on the browser.
        *
        * @return integer
        */
        function getMarginHeight() { return $this->_marginheight; }
        function setMarginHeight($value) { $this->_marginheight=$value; }
        function defaultMarginHeight() { return 0; }

        protected $_resizeable=1;

        /**
        * Specifies if the frame is able to be resized by the user or not.
        *
        * When set to false the user cannot resize the frame, when true, the user
        * has an option, by placing the mouse over the margin of the frame, to adjust
        * the size of the control. You have to check also the Borders property of
        * the Frameset that holds this frame, as must be set to true for borders to show.
        *
        * @see Frameset::getBorders()
        *
        * @return bool
        */
        function getResizeable() { return $this->_resizeable; }
        function setResizeable($value) { $this->_resizeable=$value; }
        function defaultResizeable() { return 1; }

        protected $_scrolling=fsAuto;

        /**
        * Determines if the frame is going to have scrollbars to allow the user
        * navigate through all the content.
        *
        * fsAuto will show scrollbars when needed, that is, when the content is
        * outside the viewport of the frame. fsYes will always show scrollbars
        * and fsNo won't show any.
        *
        * fsAuto - This value tells the browser to provide scrolling devices for the frame window when necessary. This is the default value.
        * fsYes  - This value tells the browser to always provide scrolling devices for the frame window.
        * fsNo   - This value tells the browser not to provide scrolling devices for the frame window.
        *
        * @return enum (fsAuto, fsYes, fsNo)
        */
        function getScrolling() { return $this->_scrolling; }
        function setScrolling($value) { $this->_scrolling=$value; }
        function defaultScrolling() { return fsAuto; }


        protected $_jsonload=null;

        /**
        * The javascript OnLoad event is called after all nested framesets and
        * frames are finished with loading their content. At this point, all of
        * the objects in the document are in the DOM, and all the images and
        * sub-frames have finished loading.
        *
        * <code>
        * <?php
        *      function Frame1JSLoad($sender, $params)
        *      {
        *      ?>
        *      //Add your javascript code here
        *               alert("frame has been loaded");
        *      <?php
        *
        *      }
        * ?>
        * </code>
        *
        * @return mixed
        */
        function getjsOnLoad() { return $this->_jsonload; }
        function setjsOnLoad($value) { $this->_jsonload=$value; }
        function defaultjsOnLoad() { return null; }

        /**
        * Returns the defined JS events for the frame. You don't need to call this
        * method directly, is called by the component when generating the header code
        * to add all the required events to the document. Used in this case to generate
        * the OnLoad javascript event and the rest of standard events defined in Control
        *
        * @return string If empty no JS events are set.
        */
        function FrameJSEvents()
        {
            $result = "";

            if ($this->_jsonload!=null)  { $event=$this->_jsonload;  $result.=" onload=\"return $event(event)\" "; }

            $events = $this->readJsEvents();

            return $result.$events;
        }

        function dumpJavascript()
        {
            parent::dumpJavascript();

            $this->dumpJSEvent($this->_jsonload);
        }


        function getjsOnBlur                    () { return $this->readjsOnBlur(); }
        function setjsOnBlur                    ($value) { $this->writejsOnBlur($value); }

        function getjsOnFocus() { return $this->readjsonfocus(); }
        function setjsOnFocus($value) { $this->writejsonfocus($value); }

        function getjsOnResize() { return $this->readjsonresize(); }
        function setjsOnResize($value) { $this->writejsonresize($value); }

        protected $_longdesc="";

        /**
        * This property specifies a link to a long description of the frame.
        * This description should supplement the short description provided
        * using the title attribute, and may be particularly useful for non-visual
        * user agents.
        *
        * @return string
        */
        function getLongDesc() { return $this->_longdesc; }
        function setLongDesc($value) { $this->_longdesc=$value; }
        function defaultLongDesc() { return ""; }

        protected $_title="";

        /**
        * This property offers advisory information about the frame component.
        *
        * Values of this property may be rendered by browsers in a variety of ways.
        * For instance, visual browsers frequently display the title as a "tool tip"
        * (a short message that appears when the pointing device pauses over an object).
        * Audio user agents may speak the title information in a similar context.
        *
        * @return string
        */
        function getTitle() { return $this->_title; }
        function setTitle($value) { $this->_title=$value; }
        function defaultTitle() { return ""; }


        function getStyle()             { return $this->readstyle(); }
        function setStyle($value)       { $this->writestyle($value); }

        function dumpContents()
        {
                if (($this->ControlState & csDesigning)==csDesigning)
                {
                        $msg=$this->Name;
                        if (trim($this->Source)=='')
                        {
                                $msg="Fill Source property with the URL you want to show on this Frame";
                        }

                        $bstyle=" style=\"border: 1px dotted #000000;font-size:10px; font-family:verdana,tahoma,arial\" ";
                        echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"$this->width\" height=\"$this->height\"><tr><td $bstyle align=\"center\">$msg</td></tr></table>";
                }
                else
                {
                        $resizeable="";

                        if ($this->Resizeable!=1)
                        {
                                $resizeable="noresize";
                        }

                        if (($this->ControlState & csDesigning)==csDesigning)
                        {
                                echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\" \"http://www.w3.org/TR/html4/frameset.dtd\">\n";
                                echo "<HTML>\n";
                                echo "<HEAD>\n";
                                echo "</HEAD>\n";
                                echo "<FRAMESET cols=\"$this->Width\">\n";
                        }

                        $scrolling = "auto";    //fsAuto
                        switch ($this->Scrolling)
                        {
                                case fsYes: $scrolling = "yes"; break;
                                case fsNo: $scrolling = "no"; break;
                        }

                        $events = $this->FrameJSEvents();

                        $class = ($this->Style != "") ? "class=\"$this->StyleClass\"" : "";

                        $title= ($this->Title != "") ? "title=\"$this->Title\"" : "";

                        $longdesc= ($this->LongDesc!= "") ? "longdesc=\"$this->LongDesc\"" : "";

                        echo "<frame src=\"".$this->Source."\" name=\"".$this->name."\" id=\"".$this->name."\" scrolling=\"$scrolling\" $resizeable marginwidth=\"$this->MarginWidth\" marginheight=\"$this->MarginHeight\" frameborder=\"$this->Borders\" $events $class $title $longdesc>\n";

                        if (($this->ControlState & csDesigning)==csDesigning)
                        {
                                echo "</FRAMESET>\n";
                                echo "</HTML>\n";
                        }
                }

        }
}



?>