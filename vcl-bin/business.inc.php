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

use_unit("classes.inc.php");
use_unit("db.inc.php");

/**
 * Provide a logical representation of a business object to create database
 * applications faster.
 *
 * A base class for business objects, not finished yet.
 * The goal is to provide an object representation of a table and allow
 * creation of business rules to make it easier to work with data
 *
 * This class is not finished, we have plans to integrate a ready made library
 * for this.
 */
class BusinessObject extends Component
{
        protected $_database=null;
        protected $_tablename="";

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
        * Use this property to specify the database component to represent
        *
        * @return Database
        */
        function getDatabase() { return $this->_database;       }
        function setDatabase($value)
        {
                $this->_database=$this->fixupProperty($value);
        }

        function loaded()
        {
                parent::loaded();
                $this->setDatabase($this->_database);
        }

        /**
        * Specifies the name of the table to represent
        *
        * @return string
        */
        function getTableName() { return $this->_tablename;     }
        function setTableName($value) { $this->_tablename=$value; }


}

?>