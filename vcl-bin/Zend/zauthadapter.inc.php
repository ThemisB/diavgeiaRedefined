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
use_unit("classes.inc.php");
use_unit("controls.inc.php");
use_unit("extctrls.inc.php");

/**
* Base class for adapters to be used with the ZAuth component.
*
* Adapters inherit from this class, which provides a method to authenticate, which is
* called by ZAuth with the appropiated parameters, to know if the specifier used has been
* already authenticated or to authenticate it.
*
* @see ZAuth, ZAuthDB, ZAuthDigest
*/
class ZAuthAdapter extends Component
{

        public    $_userinfo=array();

				/**
				* Public property containing information about the current user
				*/
				function readUserInfo() { return($this->_userinfo); }

				/**
				* Authenticates using specified information, like user, password and realm
				*
				* @param $auth Zend_Auth Zend component used for authentication
				* @param $user string Name of the user to authenticate
				* @param $password string Password of the user to auhenticate
				* @param $realm string Realm of the user to authenticate
				*
				* @returns boolean True if the user/password/realm combination is valid or if the user has been already authenticated
				*/
        function Authenticate($auth,$user, $password, $realm)
        {
        }
}


?>