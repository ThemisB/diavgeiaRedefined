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

use_unit("Zend/zauthadapter.inc.php");

use_unit("Zend/framework/library/Zend/Auth/Adapter/Digest.php");

class ZAuthDigest extends ZAuthAdapter
{

        protected $_filename="";
/*        protected $_realm="";

        function getUserRealm() { return $this->_realm; }
        function setUserRealm($value) { $this->_realm=$value; }
        function defaultUserRealm() { return ""; }*/

        function getFileName() { return $this->_filename; }
        function setFileName($value) { $this->_filename=$value; }
        function defaultFileName() { return ""; }

        //$realm is not used here because it is provided by file
        function Authenticate($auth,$username,$password,$realm)
        {
                if($this->_filename!="")
                {
                        $adapter = new Zend_Auth_Adapter_Digest($this->_filename, $realm, $username, $password);

                        $result = $auth->authenticate($adapter);

                        if($result->IsValid())
                        {
                                return true;
                        }
                        else
                        {
                                return false;
                        }
                }
                else
                        return null;
        }


        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

        }
}


?>