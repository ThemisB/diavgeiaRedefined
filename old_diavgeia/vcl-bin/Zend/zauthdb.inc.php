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
use_unit("controls.inc.php");
use_unit("extctrls.inc.php");

require_once ('Zend/Db/Adapter/Pdo/Mysql.php');
require_once ('Zend/Db/Adapter/Pdo/Mssql.php');
require_once ('Zend/Db/Adapter/Pdo/Pgsql.php');
require_once ('Zend/Auth/Adapter/DbTable.php');
use_unit("Zend/zauthadapter.inc.php");

class ZAuthDB extends ZAuthAdapter
{

        protected $_drivername="";
        protected $_databasename="";
        protected $_host="";
        protected $_username="";
        protected $_userpassword="";
        protected $_passwordfunction="";
        protected $_usertable="";
        protected $_usernamefieldname="";
        protected $_userpasswordfieldname="";
        protected $_dbadapter=null;
        protected $_realmfieldname="";

        function getDriverName() { return $this->_drivername; }
        function setDriverName($value) { $this->_drivername=$value; }
        function defaultDriverName() { return ""; }

        function getDatabaseName() { return $this->_databasename; }
        function setDatabaseName($value) { $this->_databasename=$value; }
        function defaultDatabaseName() { return ""; }

        function getHost() { return $this->_host; }
        function setHost($value) { $this->_host=$value; }
        function defaultHost() { return ""; }

        function getUserName() { return $this->_username; }
        function setUserName($value) { $this->_username=$value; }
        function defaultUserName() { return ""; }

        function getUserPassword() { return $this->_userpassword; }
        function setUserPassword($value) { $this->_userpassword=$value; }
        function defaultUserPassword() { return ""; }

        function getPasswordFunction() { return $this->_passwordfunction; }
        function setPasswordFunction($value) { $this->_passwordfunction=$value; }
        function defaultPasswordFunction() { return ""; }

        function getUserTable() { return $this->_usertable; }
        function setUserTable($value) { $this->_usertable=$value; }
        function defaultUserTable() { return ""; }

        function getUserNameFieldName() { return $this->_usernamefieldname; }
        function setUserNameFieldName($value) { $this->_usernamefieldname=$value; }
        function defaultUserNameFieldName() { return ""; }

        function getUserPasswordFieldName() { return $this->_userpasswordfieldname; }
        function setUserPasswordFieldName($value) { $this->_userpasswordfieldname=$value; }
        function defaultuserPasswordFieldName() { return ""; }

        function getUserRealmFieldName() { return $this->_realmfieldname; }
        function setUserRealmFieldName($value) { $this->_realmfieldname=$value; }
        function defaultUserRealmFieldName() { return ""; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

        }

        protected  function CreateAdapter()
        {

                switch($this->_drivername)
                {
                        case 'mysql':
                                $this->_dbadapter = new Zend_Db_Adapter_Pdo_Mysql(array(
                                    'host'     => $this->_host,
                                    'username' => $this->_username,
                                    'password' => $this->_userpassword,
                                    'dbname'   => $this->_databasename
                                    ));
                                break;
                        case 'sqlserver':
                                $this->_dbadapter = new Zend_Db_Adapter_Pdo_Mssql(array(
                                    'host'     => $this->_host,
                                    'username' => $this->_username,
                                    'password' => $this->_userpassword,
                                    'dbname'   => $this->_databasename
                                    ));
                                break;
                        case 'postgre':
                                $this->_dbadapter = new Zend_Db_Adapter_Pdo_Pssql(array(
                                    'host'     => $this->_host,
                                    'username' => $this->_username,
                                    'password' => $this->_userpassword,
                                    'dbname'   => $this->_databasename
                                    ));
                                break;
                }

                $authAdapter = new Zend_Auth_Adapter_DbTable($this->_dbadapter, $this->_usertable, $this->_usernamefieldname, $this->_userpasswordfieldname,$this->_passwordfunction);

                return $authAdapter;
        }

        function Authenticate($auth,$username,$password,$realm)
        {

                if($username!="")
                {

                        $authAdapter=$this->CreateAdapter();


                        $authAdapter->setIdentity($username)
                                    ->setCredential($password);

                        $result =$auth->authenticate($authAdapter);

                        if($result->IsValid())
                        {
                                $data=$authAdapter->getResultRowObject(array($this->_realmfieldname));


                                if($realm==$data->{$this->_realmfieldname})
                                {
                                        return true;
                                }
                                else
                                {
                                        return false;
                                }
                        }
                        else
                                return false;
                }
                else
                        return false;
        }

}


?>