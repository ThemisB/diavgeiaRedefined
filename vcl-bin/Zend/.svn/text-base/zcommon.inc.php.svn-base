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

// This file is used to start the Zend session *before* the VCL for PHP session starts,
// that way, we don't change the Zend Framework source code and their components work
// without any problem
        require_once("vcl/vcl.inc.php");

				//Just do it once
        if (!defined('ZSESSION'))
        {
                define('ZSESSION',1);

                function ZSession_start()
                {
                        use_unit('Zend/framework/library/Zend/Session.php');
                        Zend_Session::start(true); // attempt auto-start (throws exception if strict option set)
                }

								//Register this function to be executed at startup
                register_startup_function('ZSession_start');
        }
?>