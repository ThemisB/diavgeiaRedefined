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

require_once("vcl/vcl.inc.php");
use_unit("Zend/zcommon.inc.php");
use_unit("classes.inc.php");

use_unit("Zend/framework/library/Zend/Auth.php");
use_unit("Zend/framework/library/Zend/Auth/Storage/Session.php");

/**
* ZAuth provides a component able to authenticate using dispatchers, so changing the
* dispatcher, allows you to authenticate using different mechanisms.
*
*/
class ZAuth extends Component
{
        protected $_title="Login";
        protected $_errormessage="Unauthorized";
        protected $_username="";
        protected $_userpassword="";
        protected $_userrealm="";
        protected $_authadapter=null;


        protected $_onlogin=null;

        /**
        * Specifies the password to be used for authentication purposes
        *
        * @return string
        */
        function getUserPassword() { return $this->_userpassword;       }
        function setUserPassword($value) { $this->_userpassword=$value; }
        function defaultUserPassword() { return "";    }

        /**
        * Specifies the user name to be used for authentication purposes
        *
        * @return string
        */
        function getUserName() { return $this->_username;       }
        function setUserName($value) { $this->_username=$value; }
        function defaultUsername() { return ""; }

        /**
        * The error message to show if the authentication failed
        *
        * @return string
        */
        function getErrorMessage() { return $this->_errormessage; }
        function setErrorMessage($value) { $this->_errormessage=$value; }
        function defaultErrorMessage() { return "Unauthorized"; }

        /**
        * Realm to be used when authenticating
        *
        * @return string
        */
        function getUserRealm() { return $this->_userrealm; }
        function setUserRealm($value) { $this->_userrealm=$value; }
        function defaultUserRealm() { return ""; }


        function getTitle() { return $this->_title; }
        function setTitle($value) { $this->_title=$value; }
        function defaultTitle() { return "Login"; }

        /**
        * Specifies the adapter to be used when authenticating
        *
        * @return ZAuthAdapter
        */
        function getAuthAdapter() { return $this->_authadapter; }
        function setAuthAdapter($value) { $this->_authadapter=$this->fixupProperty($value); }
        function defaultAuthAdapter() { return null; }


        function loaded()
        {
            parent::loaded();
            $this->setAuthAdapter($this->_authadapter);
        }

        /**
        * Call this method to perform authentication
        */
        function Execute()
        {

                if($this->_authadapter==null)
                        throw new Exception('An adapter is needed for authentication to work');

                //Get singleton
                $auth = Zend_Auth::getInstance();


                if ($auth->hasIdentity())
                {
                         return true;
                }

                $result= $this->_authadapter->Authenticate($auth,$this->_username,$this->_userpassword,$this->_userrealm);

                if($result==true)
                {
                        return $result;
                }
                else
                {
                        //Make sure identify is not stored. We must do this because authentication for db's doesn´t
                        //use realm, so we could return false from the adapter but the identity be authenticated
                        //because login/passwords matches the one we supply but realm is different
                        $auth->clearIdentity();

                        if ($this->_onlogin!=null)
                        {
                          $this->callEvent("onlogin",null);
                        }
                        else die($this->_errormessage);
                }
        }

        /**
        * Fired when the user cannot be authenticated, a nice opportunity to show a login dialog.
        *
        * @return mixed
        */
        function getOnLogin() { return $this->_onlogin; }
        function setOnLogin($value) { $this->_onlogin=$value; }
        function defaultOnLogin() { return null; }
}

?>