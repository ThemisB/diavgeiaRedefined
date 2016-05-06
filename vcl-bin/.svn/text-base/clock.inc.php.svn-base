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
use_unit("controls.inc.php");
use_unit("extctrls.inc.php");

/**
 * A live clock created using javascript, so it's updated in real time.
 *
 * Use this component to show your users a clock is working in real time, inherits from Panel
 * so there are many properties you can use to customize the look and feel of the clock.
 *
 * It also features an OnAlarm event you can use to react to an specific alarm set.
 *
 * @see Panel, getjsOnAlarm()
 * @example Clock/clock.php How to use Clock component and OnAlarm event
 *
 */
class Clock extends Panel
{
        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->ControlStyle="csDesignEncoding=ISO-8859-1";
                $this->ControlStyle="csAcceptsControls=0";
                $this->ControlStyle="csSlowRedraw=1";
                $this->Font->Align=taCenter;

                $this->Width=90;
                $this->Height=90;
        }

        function dumpHeaderCode()
        {
                if (!defined('DYNAPI'))
                {
                        echo "<script type=\"text/javascript\" src=\"".VCL_HTTP_PATH."/dynapi/src/dynapi.js\"></script>\n";
                }

                if (!defined('DYNAPI_'.strtoupper($this->className())))
                {
                        echo "<script type=\"text/javascript\">\n";
                        if (!defined('DYNAPI'))
                        {
                                echo "dynapi.library.setPath('".VCL_HTTP_PATH."/dynapi/src/');\n";
                                echo "dynapi.library.include('dynapi.api');\n";
                                define('DYNAPI',1);
                        }
                        echo "dynapi.library.include('TemplateManager');\n";
                        echo "dynapi.library.include('HTMLClock');\n";
                        echo "</script>\n";
                        define('DYNAPI_'.strtoupper($this->className()),1);
                }
        }

            private $_alarm="";

            /**
             * Specifies the alarm time for the clock to fire the OnAlarm event
             *
             * Alarm can be set entering an specific date and time or using javascript code:
             *
             * Date.parse(new Date)+5000
             *
             * Which means the alarm is set to the current date plus 5 seconds
             *
             * @see getjsOnAlarm()
             * @return string
             *
             */
            function getAlarm() { return $this->_alarm; }
            function setAlarm($value) { $this->_alarm=$value; }
            function defaultAlarm() { return ""; }


            private $_jsonalarm =null;

            /**
             * This javascript event is fired when the alarm that has been set is fired
             *
             * Use this event to react to the specific setting of the Alarm property
             *
             * @see getAlarm()
             * @example Clock/clock.php How to use Clock component and OnAlarm event
             * @return mixed
             *
             */
            function getjsOnAlarm() { return $this->_jsonalarm; }
            function setjsOnAlarm($value) { $this->_jsonalarm=$value; }
            function defaultjsOnAlarm() { return null; }

        function dumpJsEvents()
        {
                parent::dumpJsEvents();

                $this->dumpJSEvent($this->_jsonalarm);
        }

        function dumpContents()
        {
                $l=0;
                $t=0;

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $l=$this->Left;
                        $t=$this->Top;
                }

                ob_start();
                $ocaption=$this->Caption;
                $this->Caption='<td align="center">{@fld}</td>';
                parent::dumpContents();
                $this->Caption=$ocaption;
                $template=ob_get_contents();
                ob_end_clean();

                $template=str_replace("'","\'",$template);
                $template=str_replace("\n","",$template);

                echo "<script type=\"text/javascript\">\n";
//                echo "var ".$this->Name."tp = new Template('<table border=\"0\"><tr><td width=\"$this->Width\" height=\"$this->Height\" align=\"center\">{@fld}</td></tr></table></center>',$l,$t,$this->Width,$this->Height,'');\n";
                echo "var ".$this->Name." = new Template('$template',$l,$t,$this->Width,$this->Height,'');\n";
                echo $this->Name.".addChild(new HTMLClock(),'fld');\n";
                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        if (trim($this->Alarm)!="")
                        {
                                echo "$this->Name".".fld.setAlarm($this->Alarm);\n";
                        }

                        if ($this->_jsonalarm!="")
                        {
                                echo "$this->Name".".fld.addEventListener({ onalarm : $this->_jsonalarm });";
                        }
                }

//                echo $this->Name."tp.fld.HTMLContainer.setSize(".$this->width.",".$this->Height.");\n";
                echo "dynapi.document.addChild(".$this->Name.");\n";
                echo "</script>\n";
        }

}


?>