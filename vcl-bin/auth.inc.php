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

use_unit("forms.inc.php");
use_unit("classes.inc.php");
use_unit("dbtables.inc.php");

/**
 * A common base class for user authentication. Inherit from this class to create new
 * types of authentication
 *
 * The basic usage is, call the Authenticate method with the username/password
 * combination and then, check for the Logged property to know if the operation
 * has been successful or not
 *
 * Pending implementations for LDAP and maybe PAM authentication. Also, this class
 * will be used for the pending ACL system.
 *
 * @see DatabaseUser, BasicAuthentication
 */
class User extends Component
{
        protected $_logged;

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
         * Specifies whether the user is logged or not, this property should be
         * updated by the Authenticate method
         *
         * Use this property to know if the user has been authenticated successfully
         * or not
         *
         * @see Authenticate()
         *
         * @return boolean
         */
        function readLogged() { return $this->_logged;   }
        function writeLogged($value) { $this->_logged=$value; }

         /**
         * Authenticate the user in the system with the specified username
         * and password.
         *
         * This method should updated Logged property of the component
         * to let you know about the success of the authentication
         *
         * @see readLogged()
         *
         * @param string $username Name of the user to authenticate
         * @param string $password Password of the user to authenticate
         */
        function authenticate($username, $password)
        {
        }

}

/**
 * DatabaseUser can be used to authenticate a user against a database table.
 *
 * Use this class to authenticate an user against a database, in which are stored all
 * user details, like username and password.
 *
 * To make it work, set DriverName, Host, User, Password, FieldName and TableName to
 * allow the component to find the information to authenticate.
 *
 * @see User, BasicAuthentication, getDriverName(), getHost(), getUser(), getPassword(), getFieldName(), getUsersTable()
 */
class DatabaseUser extends User
{
        protected $_logged;

        protected $_drivername="";
        protected $_databasename="";
        protected $_host="";
        protected $_user="";
        protected $_password="";

        protected $_userstable="";
        protected $_usernamefieldname="";
        protected $_passwordfieldname="";

        /**
         * Table that stores the user information, the table must have columns
         * to store usernames and passwords, the name for that columns can be set
         * using UserNameFieldName and PasswordFieldName properties
         *
         * @see getDriverName(), getHost(), getPasswordFieldName(), getUserNameFieldName()
         *
         * @return string
         */
        function getUsersTable() { return $this->_userstable;   }
        function setUsersTable($value) { $this->_userstable=$value; }

        /**
         * Field name of the column that stores the user name, this property will
         * be used to determine the field to look for usernames
         *
         * @see getDriverName(), getHost(), getPasswordFieldName(), getUsersTable()
         *
         * @return string
         */
        function getUserNameFieldName() { return $this->_usernamefieldname;     }
        function setUserNameFieldName($value) { $this->_usernamefieldname=$value; }

        /**
         * Field name of the column that stores the password, this property will
         * be used to determine the field to look for passwords
         *
         * @see getDriverName(), getHost(), getUsersTable(), getUserNameFieldName()
         *
         * @return string
         */
        function getPasswordFieldName() { return $this->_passwordfieldname;     }
        function setPasswordFieldName($value) { $this->_passwordfieldname=$value; }

        /**
         * Type of database server that stores the table that holds usernames and passwords,
         * it uses a Database component, so the value for this property is the same
         * as the Database::DriverName property
         *
         * @see getPasswordFieldName(), getHost(), getUsersTable(), getUserNameFieldName()
         *
         * @return string
         */
        function getDriverName() { return $this->_drivername;   }
        function setDriverName($value) { $this->_drivername=$value; }

        /**
         * Name of the database that holds the table to use to authenticate users
         *
         * @see getPasswordFieldName(), getHost(), getUsersTable(), getUserNameFieldName(), getDriverName()
         *
         * @return string
         */
        function getDatabaseName() { return $this->_databasename;       }
        function setDatabaseName($value) { $this->_databasename=$value; }

        /**
         * Host of the server of the internal Database component to access the
         * table holding username/password combinations
         *
         * @see getPasswordFieldName(), getDatabaseName(), getUsersTable(), getUserNameFieldName(), getDriverName()
         *
         * @return string
         */
        function getHost() { return $this->_host;       }
        function setHost($value) { $this->_host=$value; }

        /**
         * Username to access the database server looking for username/password
         * table
         *
         * @see getPasswordFieldName(), getDatabaseName(), getHost(), getUserNameFieldName(), getDriverName()
         *
         * @return string
         */
        function getUser() { return $this->_user;       }
        function setUser($value) { $this->_user=$value; }

        /**
         * Password to the database server holding the table to be used for authentication
         *
         * @see getPasswordFieldName(), getDatabaseName(), getHost(), getUserNameFieldName(), getUser()
         *
         * @return string
         */
        function getPassword() { return $this->_password;       }
        function setPassword($value) { $this->_password=$value; }

        /**
        * Authenticate a user against the database table, after call this method,
        * check Logged property to know if the operation was successful or not
        *
        * @see getLogged()
        *
        * @param string $username Username to authenticate
        * @param string $passwrod Password of the user
        */
        function authenticate($username, $password)
        {
                $this->Logged=false;

                //create a database
                $db=new Database(null);
                $db->DriverName=$this->DriverName;
                $db->DatabaseName=$this->DatabaseName;
                $db->Host=$this->Host;
                $db->User=$this->User;
                $db->Password=$this->Password;

                //open it
                $db->open();

                //create a table
                $tb=new Table(null);
                $tb->Database=$db;
                $tb->Filter=" ".$this->UserNameFieldName." = '".$username."' ";
                $tb->TableName=$this->UsersTable;
                $tb->open();

                $fname=$this->UserNameFieldName;
                $pname=$this->PasswordFieldName;

                //check if the user&password combination exists
                if ($tb->RowCount>0)
                {
                        if (($tb->$fname==$username) && ($tb->$pname==$password))
                        {
                                $this->Logged=true;
                        }
                }
                $this->serialize();
        }
}

/**
 * Performs authentication using basic HTTP
 *
 * This component is useful for protecting web pages easily by just dropping a component.
 * For basic usage, just set UserName and Password to the valid value to log in
 * and call the Execute() method in the OnBeforeShow event of your page.
 *
 * For more advance usage, OnAuthenticate event it allows you to authenticate using your
 * own rules.
 *
 * @link http://www.w3.org/Protocols/HTTP/1.0/draft-ietf-http-spec.html#Code401
 *
 * @see getOnAuthenticate()
 * @example BasicAuthentication/basicauthentication.php How to use Basic Authentication component
 */
class BasicAuthentication extends Component
{
        protected $_title="Login";
        protected $_errormessage="Unauthorized";
        protected $_username="";
        protected $_password="";


        /**
         * Password to request to the user, the password entered by the user
         * will be checked against the value of this property
         *
         * Use this property to specify a valid password the user will need to provide
         * in order to access the page this component is located on.
         *
         * If you need to provide several valid passwords, check OnAuthenticate event as
         * you can write there any validation code to the password sent by the user.
         *
         * Remember this password is stored in clear text in the .xml.php of your form, so
         * you will need to protect properly such file against unauthorized access to prevent them
         * get the password.
         *
         * <code>
         * <?php
         *       function BasicAuthentication1Authenticate($sender, $params)
         *       {
         *                //You can use the Username and Password properties to automatically check for that
         *                //But if you want to search in a list/database, you can use the OnAuthenticate event
         *                if (($params['username']=='delphiforphp') && ($params['password']=='rules'))
         *                {
         *                        return(true);
         *                }
         *                else return(false);
         *       }
         * ?>
         * </code>
         *
         * @see getOnAuthenticate()
         *
         * @return string
         *
         */
        function getPassword() { return $this->_password;       }
        function setPassword($value) { $this->_password=$value; }
        function defaultPassword() { return "";    }

        /**
         * Valid username to authenticate against the username entered by the user
         *
         * Use this property to specify a valid username the user will need to provide
         * in order to access the page this component is located on.
         *
         * If you need to provide several valid usernames, check OnAuthenticate event as
         * you can write there any validation code to the username sent by the user.
         *
         * Remember this property is stored in clear text in the .xml.php of your form, so
         * you will need to protect properly such file against unauthorized access to prevent them
         * get the username.
         *
         * <code>
         * <?php
         *       function BasicAuthentication1Authenticate($sender, $params)
         *       {
         *                //You can use the Username and Password properties to automatically check for that
         *                //But if you want to search in a list/database, you can use the OnAuthenticate event
         *                if (($params['username']=='delphiforphp') && ($params['password']=='rules'))
         *                {
         *                        return(true);
         *                }
         *                else return(false);
         *       }
         * ?>
         * </code>
         *
         * @see getOnAuthenticate()
         *
         * @return string
         */
        function getUsername() { return $this->_username;       }
        function setUsername($value) { $this->_username=$value; }
        function defaultUsername() { return ""; }

        /**
        * Error message to show when the user is not authenticated, this is the
        * string shown on the browser when the authentication fails
        *
        * Use this property to show an specific error message when the authentication cannot be performed due
        * wrong username/password combinations are provided by the user. The error message will be shown on the top
        * of a blank page in most browsers, but that depends on the browser.
        *
        * The default value for this property is "Unauthorized"
        *
        * @see getTitle()
        *
        * @return string
        */
        function getErrorMessage() { return $this->_errormessage; }
        function setErrorMessage($value) { $this->_errormessage=$value; }
        function defaultErrorMessage() { return "Unauthorized"; }

        /**
        * Title of the authentication dialog to show the user
        *
        * When the browser tries to authenticate the user, in most cases will show a dialog requesting
        * for username and password, and this property specifies the caption for such dialog, or part of it,
        * depending on the browser.
        *
        * The default value is "Login", which will be fine for most cases.
        *
        * @see getErrorMessage()
        *
        * @return string
        */
        function getTitle() { return $this->_title; }
        function setTitle($value) { $this->_title=$value; }
        function defaultTitle() { return "Login"; }



        protected $_onauthenticate=null;

        /**
        * Event fired after the user has entered username and password
        *
        * This event is fired when the component needs to authenticate the user by code.
        *
        * In $params['username'] you will get the username entered by the user
        *
        * In $params['password'] you will get the password entered by the user
        *
        * This event is the right place for you to write customize authentication code, you can, for example
        * query a database to know if the username/password combination is valid. To allow the user access the page, simply
        * return true, and return false if the input information is not valid
        *
        * <code>
        * <?php
        *       function BasicAuthentication1Authenticate($sender, $params)
        *       {
        *                //You can use the Username and Password properties to automatically check for that
        *                //But if you want to search in a list/database, you can use the OnAuthenticate event
        *                if (($params['username']=='delphiforphp') && ($params['password']=='rules'))
        *                {
        *                        return(true);
        *                }
        *                else return(false);
        *       }
        * ?>
        * </code>
        *
        * @see getUsername(), getPassword()
        * @example BasicAuthentication/basicauthentication.php How to use Basic Authentication component
        *
        * @return mixed
        */
        function getOnAuthenticate() { return $this->_onauthenticate; }
        function setOnAuthenticate($value) { $this->_onauthenticate=$value; }
        function defaultOnAuthenticate() { return null; }

        /**
         * Executes the authentication and checks if the user has been authenticated or not.
         *
         * This method tries to perform the user authentication, if the user has not been already authenticated,
         * requests the username/password using a browser dialog, but if the user has been authenticated, does nothing.
         *
         * If the event OnAuthenticate is assigned, the valid username/password will be provided by code
         * if not, the Username/Password properties will be used to authenticate
         *
         * <code>
         * <?php
         * function PasswordProtectedPageBeforeShow($sender, $params)
         * {
         *    //Before the page is shown, call Execute to force user authentication
         *    $this->BasicAuthentication1->Execute();
         * }
         * ?>
         * </code>
         *
         * @link http://www.w3.org/Protocols/HTTP/1.0/draft-ietf-http-spec.html#Code401
         *
         * @see getOnAuthenticate(), getUsername(), getPassword()
         *
         */
        function Execute()
        {
                $result=false;

                //If authorization not set, requests it
                if(!isset($_SERVER['PHP_AUTH_USER']))
                {
                        header('WWW-Authenticate: Basic realm="' . $this->_title. '"');
                        header('HTTP/1.0 401 Unauthorized');
                        die($this->_errormessage);
                }
                else
                {
                        //If not the right username/password combination, requests it
                        if ($this->OnAuthenticate!=null)
                        {
                                $result=$this->callEvent('onauthenticate', array('username'=>$_SERVER['PHP_AUTH_USER'],'password'=>$_SERVER['PHP_AUTH_PW']));
                                if (!$result)
                                {
                                        header('WWW-Authenticate: Basic realm="' . $this->_title. '"');
                                        header('HTTP/1.0 401 Unauthorized');
                                        die($this->_errormessage);
                                }
                        }
                        else
                        {
                                if (($_SERVER['PHP_AUTH_USER'] != $this->_username) || ($_SERVER['PHP_AUTH_PW'] != $this->_password))
                                {
                                        header('WWW-Authenticate: Basic realm="' . $this->_title. '"');
                                        header('HTTP/1.0 401 Unauthorized');
                                        die($this->_errormessage);
                                }
                                else $result=true;
                        }
                }
                return($result);
        }
}

?>