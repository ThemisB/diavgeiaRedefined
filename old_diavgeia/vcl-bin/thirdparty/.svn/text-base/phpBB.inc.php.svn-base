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
        use_unit("controls.inc.php");

        /**
         * phpBB control
         *
         */
        class phpBB extends FocusControl
        {
            private $_databasetype="mysql4";

            function getDatabaseType() { return $this->_databasetype; }
            function setDatabaseType($value) { $this->_databasetype=$value; }
            function defaultDatabaseType() { return "mysql4"; }

            private $_host="";

            function getHost() { return $this->_host; }
            function setHost($value) { $this->_host=$value; }
            function defaultHost() { return ""; }

            private $_databasename="";

            function getDatabaseName() { return $this->_databasename; }
            function setDatabaseName($value) { $this->_databasename=$value; }
            function defaultDatabaseName() { return ""; }

            private $_user="";

            function getUser() { return $this->_user; }
            function setUser($value) { $this->_user=$value; }
            function defaultUser() { return ""; }

            private $_password="";

            function getPassword() { return $this->_password; }
            function setPassword($value) { $this->_password=$value; }
            function defaultPassword() { return ""; }


                function __construct($aowner=null)
                {
                        parent::__construct($aowner);

                        $this->Width=600;
                        $this->Height=800;

                        $this->ControlStyle="csNoDiv=1";

                        if ($this->owner!=null)
                        {
                                setRawCookie('phpbb_vcl_include',$this->owner->lastresourceread);
                                setRawCookie('phpbb_vcl_form',$this->owner->Name);
                        }
                }

                function setName($value)
                {
                        parent::setName($value);
                        if (($this->ControlState & csDesigning)!=csDesigning)
                        {
                                setRawCookie('phpbb_vcl_object',$this->Name);
                        }
                }

                function dumpHeaderCode()
                {
                        ?>
                        <script language="JavaScript" src="<?php echo VCL_HTTP_PATH; ?>/js/iframe.js"></script>
                        <?php
                }

                function dumpContents()
                {
                        if (($this->ControlState & csDesigning)==csDesigning)
                        {
                                $attr="";
                                if ($this->_width!="") $attr.=" width=\"$this->_width\" ";
                                if ($this->_height!="") $attr.=" height=\"$this->_height\" ";

                                $bstyle=" style=\"border: 1px dotted #000000\" ";
                                echo "<table $attr $bstyle><tr><td align=\"center\">\n";
                                echo "<img src=\"".VCL_HTTP_PATH."/thirdparty/phpBB2/templates/subSilver/images/logo_phpBB.gif\">";
                                echo "<td></tr></table>\n";
                        }
                        else
                        {
                                echo "<iframe id=\"$this->Name\" src=\"".VCL_HTTP_PATH."/thirdparty/phpBB2/index.php\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"0\" vspace=\"0\" hspace=\"0\" style=\"overflow:visible; width:$this->Width;display:none;\"></iframe>";
                                echo "<script language=\"Javascript\">resizeIframe('$this->Name');</script>";
                        }
                }
        }
?>
