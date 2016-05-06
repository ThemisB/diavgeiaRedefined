<?php
/**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2008 qadram software S.L. <support@qadram.com>
*
*  Checkout the AUTHORS file for more information on the developers.
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
 * A list of actions for processing web requests.
 *
 * Currently the ActionList is just a list of strings (actions), and when matched
 * by a web request, the OnExecute event is fired.
 *
 * If an ActionList1 is defined in unit1.php, and the Actions property contains
 * an entry called "showmessage", the following URL will trigger an OnExecute:
 *
 * http://localhost/unit1.php/?ActionList1=showmessage
 *
 * Then, you can use the $params["action"] of the OnExecute event handler to
 * distinguish between actions and write your working code.
 *
 * <code>
 * <?php
 *
 * function ActionList1Execute($sender, $params)
 * {
 *   if ($params['action']=='youraction') echo "Now execute your action!";
 * }
 *
 * ?>
 * </code>
 *
 * @link http://www.qadram.com/vcl4php/docwiki/index.php/Developer%27s_Guide_::_Using_ActionLists
 * @see getOnExecute()
 */
class ActionList extends Component
{
        protected $_actions = array();
        protected $_onexecute = null;


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        function init()
        {
                parent::init();

                $action = $this->input->{$this->_name};
                if (is_object($action))
                {
                        $this->executeAction($action->asString());
                }
        }

        /**
        * Adds a new action to the Actions array.
        *
        * Use this method to add a new operation to be processed by this component.
        * ActionList will only fire OnExecute if the value for the action parameter is
        * found on this list.
        *
        * <code>
        * <?php
        * //Add the action to the list so it's available to be used
        * $this->ActionList1->addAction('youraction');
        *
        * //Now you can use in your links ActionList1=youraction to fire the
        * //OnExecute event
        * ?>
        * </code>
        *
        * @see deleteAction()
        *
        * @param string $action  Name of the action to be added
        */
        function addAction($action)
        {
                $this->_actions[] = $action;
        }

        /**
        * Deletes an action from the Actions array.
        *
        * Use this method to delete an existing operation from the Actions property,
        * it doesn't perform any check to know if the property exists or not.
        *
        * <code>
        * <?php
        * //After this line, youraction won't be a valid action any more
        * $this->ActionList1->deleteAction('youraction');
        *
        * ?>
        * </code>
        *
        * @see addAction()
        *
        * @param string $action  Name of the action to be deleted
        */
        function deleteAction($action)
        {
                if (in_array($action, $this->_actions))
                {
                        $key = array_search($action, $this->_actions);
                        array_splice($this->_actions, $key, 1);
                }
        }


        /**
        * Forces a call to the OnExecute event, if attached and if the action to be called exists on the Actions array
        *
        * This method fires the OnExecute event, provided all conditions are met.
        * First, the OnExecute event must be assigned, after that, $action specified
        * must exist on the Actions array.
        *
        * <code>
        * <?php
        * //Executing this line will cause the OnExecute event to be fired
        * $this->ActionList1->executeAction('youraction');
        *
        * function ActionList1Execute($sender, $params)
        * {
        *   if ($params['action']=='youraction') echo "Now execute your action!";
        * }
        *
        * ?>
        * </code>
        *
        * @see addAction(), deleteAction(), getOnExecute()
        *
        * @param string $action  Name of the action to execute
        * @return bool Returns the value returned by the event handler, it can
        * also return false if no conditions for execution are met
        */
        function executeAction($action)
        {
                // Only executes the action if a handler has been assigned and
                // the action is in the list.
                if ($this->_onexecute != null && in_array($action, $this->_actions))
                {
                        return $this->callEvent('onexecute', array("action" => $action));
                }
                // Action was not handled.
                return false;
        }

        /**
        * Adds an action to the URL sent
        *
        * Use this method to easily generate the parameter you need to add to an URL
        * to force the execution of an specific action.
        *
        * Currently only one action per ActionList and URL can be added, if more
        * actions on the same list are added, the behavior is undefined.
        *
        * <code>
        * <?php
        * $url='http://www.yourwebsite.com/form1.php';
        * $this->ActionList1->expandActionToURL('youraction',$url);
        * //Now $url contains http://www.yourwebsite.com/form1.php?ActionList1=youraction
        *
        * ?>
        * </code>
        *
        * @param string $action  Name of the action to add
        * @param string &$url     A URL to another script If empty, the same
        *                        script as ActionList is defined and will be called.
        * @return bool Returns true if the action was successfully added to the
        *              URL, false otherwise
        */
        function expandActionToURL($action, &$url)
        {
                // Get the key of the action (if it exists).
                if (in_array($action, $this->_actions))
                {
                        $key = array_search($action, $this->_actions);

                        // Check if the query has started.
                        $url .= (strpos($url, '?') === false) ? "?" : "&";
                        // Expand the URL with the action.
                        $url .= urlencode($this->_name)."=".urlencode($this->_actions[$key]);
                        return true;
                }

                // attachActionToURL failed to expand the URL.
                return false;
        }

        /**
        * Fired when a web request contains a parameter named like the component
        * name and the value is an action contained on the Actions array.
        *
        * This event allows you to split the logic process of your application in actions,
        * so you can freely use links in your web pages that fire events on your code.
        *
        * To know which action to execute, user the $params parameter, which is an array,
        * and the action key, this way:
        *
        * <code>
        * <?php
        * //Executing this line will cause the OnExecute event to be fired
        * $this->ActionList1->executeAction('youraction');
        *
        * function ActionList1Execute($sender, $params)
        * {
        *   if ($params['action']=='youraction') echo "Now execute your action!";
        * }
        *
        * ?>
        * </code>
        *
        * @see addAction(), deleteAction(), executeAction()
        *
        * @return mixed
        */
        function getOnExecute() { return $this->_onexecute; }
        function setOnExecute($value) { $this->_onexecute=$value; }
        function defaultOnExecute() { return null; }

        /**
        * Array holding all the actions in the list.
        *
        * This property represents a list of all the action the component allows
        * you to use to control the flow of your program.
        *
        * Use addAction() and deleteAction() to modify the array easily.
        *
        * <code>
        * <?php
        * function ActionList1Execute($sender, $params)
        * {
        *   if ($params['action']=='youraction') echo "Now execute your action!";
        * }
        * ?>
        * </code>
        *
        * @see addAction(), deleteAction()
        *
        * @return array
        */
        function getActions() { return $this->_actions; }
        function setActions($value) { $this->_actions=$value; }
        function defaultActions() { return array(); }

}

?>