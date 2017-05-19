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
use_unit("extctrls.inc.php");

/**
 * CustomGrid is the base type for all components that present information in a two-dimensional grid.
 *
 * Right now is used only as base of CustomDBGrid, but it's not finished yet.
 */
class CustomGrid extends CustomControl
{
    protected $_columns=array();

    /**
    * Describes the attributes of the columns.
    *
    * Use Columns to read or set the attributes of the columns in grid.
    * Columns is an array where each key specifies a column attributes.
    *
    * Columns can be set at design time through the Columns editor, or
    * programmatically at runtime.
    *
    * @return array
    */
    function readColumns() { return $this->_columns; }
    function writeColumns($value) { $this->_columns=$value; }
    function defaultColumns() { return array(); }
}

?>