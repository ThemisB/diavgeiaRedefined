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
        use_unit("designide.inc.php");

        /**
         * Component editor for the phpBB component
         *
         */
        class phpBBEditor extends ComponentEditor
        {
                function getVerbs()
                {
                        echo "Install...\n";
                        echo "About...\n";
                }

                function executeVerb($verb)
                {
                        switch($verb)
                        {
                                case 0:
                                //TODO: Exec the setup SQL
                                echo "The phpBB forum has been installed successfully!!\n";
                                break;
                                case 1: echo "phpBB VCL wrapper component. Copyright (c) qadram software 2006.\n";
                                echo "phpBB2 Copyright © 2002 phpBB Group, All Rights Reserved.\n";
                                break;
                        }
                }

        }



?>
