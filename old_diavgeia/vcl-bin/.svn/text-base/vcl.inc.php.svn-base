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

/**
* Major version of the VCL
*/
define('VCL_VERSION_MAJOR',2);
/**
* Minor version of the VCL
*/
define('VCL_VERSION_MINOR',0);

/**
* Version of the VCL, use this define to make work your components between VCL versions
*/
define('VCL_VERSION',VCL_VERSION_MAJOR.'.'.VCL_VERSION_MINOR);

        require_once("acl.inc.php");

        $scriptfilename='';

        if (isset($_SERVER['SCRIPT_FILENAME'])) $scriptfilename= $_SERVER['SCRIPT_FILENAME'];
        else
        {
                        global $HTTP_SERVER_VARS;

                        $scriptfilename=$HTTP_SERVER_VARS["SCRIPT_NAME"];
        }

        //Defines the PATH where the VCL resides
        $fs_path=relativePath(realpath(dirname(__FILE__)),dirname(realpath($scriptfilename)));
        $http_path=$fs_path;

        //If the vcl folder is not a subfolder of the VCL, then it uses vcl-bin as an alias to find the assets
        if (substr($fs_path,0,2)=='..')
        {
            if (!array_key_exists('FOR_PREVIEW',$_SERVER)) $http_path='/vcl-bin';
        }

        /**
         * Filesystem path to the VCL
         *
         */
        define('VCL_FS_PATH',$fs_path);

        /**
         * Webserver path to the VCL
         *
         */
        define('VCL_HTTP_PATH',$http_path);

        /**
         * Returns a relative path
         *
         * This function calculates the relative path of an input path to allow you
         * point to the right one even if you move scripts. This is for internal VCL for PHP use
         *
         * @param string $path Base path
         * @param string $root Path to adapt
         * @param string $separator Separator to be used
         * @return string Relative path
         */
        function relativePath($path, $root, $separator = '/')
        {
                $path=str_replace('\\','/',$path);
                $root=str_replace('\\','/',$root);

                $dirs = explode($separator, $path);
                $comp = explode($separator, $root);

                foreach ($comp as $i => $part)
                {
                        if (isset($dirs[$i]) && strtolower($part) == strtolower($dirs[$i]))
                        {
                                unset($dirs[$i], $comp[$i]);
                        }
                        else
                        {
                                //TODO: Check this with UNC
                                //TODO: If the .php file to be executed resides on a UNC, the webserver it doesn't start,
                                //fix or warn users about the correct usage of the library and the location
                                if ((strpos($part,':')) && (strpos($dirs[$i],':')))
                                {
                                        //This fixes the problem with having the code to be run
                                        //and the library in different drives, but it only works with IE
                                        //FF throws a security warning
                                        //TODO: Must fix another way
                                        $result='file:///'.$path;
                                        return($result);
                                }
                                break;
                        }
                }

                                $result=str_repeat('..' . $separator, count($comp)) . implode($separator, $dirs);

                return($result);
        }

        /**
         * Includes an VCL unit
         *
         * This function uses the VCL for PHP path to include a unit that resides on the VCL folder, so you don't have to worry
         * about VCL for PHP library location if you use this function. Included units are included require_once so you will get an
         * error if required units doesn't exists and double inclusions won't be performed.
         *
         * <code>
         * <?php
         *    use_unit("controls.inc.php");
         *    use_unit("subpath/myfunctions.inc.php");
         * ?>
         * </code>
         *
         * @link http://www.php.net/manual/en/function.require-once.php
         *
         * @param string $path Relative to VCL root path
         *
         */
        function use_unit($path)
        {
                $apath=VCL_FS_PATH;
                if ($apath!="") $apath.="/";
                require_once($apath.$path);
        }


        global $startup_functions;

        $startup_functions=array();

        /**
         * Registers a function to be called just before the session is started
         * by Application
         *
         * This function can be used to perform any processing that must be done
         * before start the session. It can be useful to integrate packages like
         * Zend framework, which doesn't allow a session to be registered before.
         *
         * It doesn't perform any check to know if your function has been already
         * registered, so be sure you call it only once, or your function will be called
         * multiple times.
         *
         * <code>
         * <?php
         *    function MyStartup()
         *    {
         *         //My custom session start
         *         session_start();
         *    }
         *    register_startup_function("MyStartup");
         * ?>
         * </code>
         *
         * @param string $function Name of the function to be called
         */
        function register_startup_function($function)
        {
                //Add the function to the list
                global $startup_functions;
                $startup_functions[]=$function;
        }
?>