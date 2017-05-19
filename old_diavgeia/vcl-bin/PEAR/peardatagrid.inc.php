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
        *
        */
        require_once("vcl/vcl.inc.php");
        use_unit("controls.inc.php");
        use_unit("PEAR/Structures/DataGrid.php");

        /**
        * This grid uses PEAR objects to provide tabular information
        *
        * @package PEAR
        * @example PEAR/DataGrid/datagrid_sample.php How PEAR DataGrid work
        * @example PEAR/DataGrid/datagrid_sample.php How PEAR DataGrid work (form)
        */
        class PearDataGrid extends Control
        {
                public $datagrid=null;

            function __construct($aowner = null)
            {
                parent::__construct($aowner);
            }

            function dumpHeaderCode()
            {
?>
<style type="text/css">
<!--
table.datagrid {
    border-left: solid 1px #330099;
    border-top: solid 1px #330099;
    border-bottom: solid 1px #330099;
    font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 10px;
    border-collapse: collapse;
    width: 100%;
    margin-left: 1em;
}

table.datagrid th {
    text-align: center;
    border-right: solid 1px #330099;
    border-bottom: solid 1px #330099;
    background: #330099;
    padding: 2px;
    color: white;
    padding-left: 1em;
    padding-right: 1em;
}

table.datagrid th a {
    color: white;
    text-decoration: none;
}

table.datagrid th a:hover {
    color: #EEEEEE;
}

table.datagrid td {
    text-align: right;
    border-right: solid 1px #330099;
    padding: 2px;
}

table.datagrid tr.odd {
    background: #F4F4F4;
}

div.datagrid_paging {
    font-weight: bold;
    font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
    font-size: 11px;
}

div.datagrid_paging a {
    color: #330099;
}
-->
</style>
<?php
            }

            function dumpContents()
            {
                if (($this->ControlState & csDesigning) == csDesigning)
                {
                        echo "<table width=\"$this->Width\" height=\"$this->Height\" style=\"border: 1px dotted #000000\"><tr><td>$this->Name</td></tr></table>";
                }
                else
                {
                        $query="";
                        if (is_array($this->_sql)) $query=implode('',$this->_sql);
                        else $query=$this->_sql;

                        if (($this->_dsn!='') && ($query!=""))
                        {
                                $datagrid = new Structures_DataGrid($this->_recordsperpage);
                                $options = array('dsn' => $this->_dsn);
                                $res = $datagrid->bind($query, $options);

                                if (PEAR::isError($res))
                                {
                                        echo $res->getMessage();
                                }
                                $renderer =$datagrid->getRenderer();
                                $renderer->setTableAttribute("class", "datagrid");
                                $renderer->setTableOddRowAttributes(array ("class" => "odd"));
                                $pagingHtml = $renderer->getPaging();
                                $dg = $datagrid->render();
                                $pagingHtml=str_replace('\/','/',$pagingHtml);
                                echo "<div width=\"$this->Width\" align=\"right\" class=\"datagrid_paging\">$pagingHtml</div>";
                                if (PEAR::isError($dg))
                                {
                                        echo $dg->getMessage();
                                }
                        }
                        else
                        {
                                echo "Missing DSN or SQL";
                        }
                }
            }

            protected $_recordsperpage=10;

            /**
            * Specifies the number of records per page
            *
            * Use this property to specify how many records you want to get per page
            *
            * @return integer
            */
            function getRecordsPerPage() { return $this->_recordsperpage; }
            function setRecordsPerPage($value) { $this->_recordsperpage=$value; }
            function defaultRecordsPerPage() { return 10; }

            protected $_showpaginator="1";

            /**
            * Determines if a paginator is shown or not
            *
            * Use this property to specify if a paginator is shown at the bottom of the control or not
            *
            * @return boolean
            */
            function getShowPaginator() { return $this->_showpaginator; }
            function setShowPaginator($value) { $this->_showpaginator=$value; }
            function defaultShowPaginator() { return "1"; }



            protected $_dsn="";

            /**
            * The data connection string to use to connect to a database
            *
            * Use this property the data connection string to use when connecting to a database
            *
            * @return string
            */
            function getDSN() { return $this->_dsn; }
            function setDSN($value) { $this->_dsn=$value; }
            function defaultDSN() { return ""; }

            protected $_sql=array();

            /**
            * SQL to execute to show results on the grid
            *
            * Use this property to specify the SQL sentence to execute to get
            * results to show on the grid
            *
            * @return array
            */
            function getSQL() { return $this->_sql; }
            function setSQL($value) { $this->_sql=$value; }
            function defaultSQL() { return array(); }

        }

?>
