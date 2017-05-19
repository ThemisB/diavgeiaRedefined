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
        use_unit("classes.inc.php");

        /**
        * This component provides an easy way to validate your form
        *
        * Use this component to get an easy way to validate your form, by
        * checking for specific data.
        *
        * Rules for validation are stored on the Rules property, which is
        * an array, in which every element is a rule to check.
        *
        * After that, you can use javascript to call the validation function,
        * which is named as the component plus _validate, for example fvValidate_validate().
        *
        * That function shows any message if required and returns false if validation is not
        * met, true otherwise.
        *
        *
        * <code>
        * <?php
        *      function Unit464JSSubmit($sender, $params)
        *      {
        *      ?>
        *               return(fvValidate_validate());
        *      <?php
        *
        *      }
        * ?>
        * </code>
        */
        class FormValidator extends Component
        {
            function __construct($aowner = null)
            {
                parent::__construct($aowner);
            }

            protected $_rules=array();

            /**
            * This property specifies the rules to validate the form
            *
            * Use this property to specify the validation rules to test against.
            * In Delphi for PHP, there is a property editor you can use to setup
            * this property, if you want do it in runtime, you can setup this array
            * dynamically.
            *
            * <code>
            * <?php
            *  function Unit464BeforeShow($sender, $params)
            *  {
            *   $rules=array();
            *   $rules[]=array
            *   (
            *           'Control'=>'Edit1',
            *           'Equals'=>'Edit2',
            *           'ErrorMessage'=>'Edit1 and Edit2 must match and are required',
            *           'Name'=>'FieldsMustMatch',
            *           'Required'=>true,
            *           'MaxLength'=>'0',
            *           'MinLength'=>'0',
            *           'MaxValue'=>'0',
            *           'MinValue'=>'0'
            *   );
            *   $this->fvValidate->Rules=$rules;
            *  }
            * ?>
            * </code>
            *
            * @return array
            */
            function getRules() { return $this->_rules; }
            function setRules($value) { $this->_rules=$value; }
            function defaultRules() { return array(); }

            protected $_validatecompleteform=0;

            /**
            * Specifies if the validation is to be perform on the complete for or field by field
            *
            * If this property is set to true, all rules will be checked against the
            * form, if false, will be checked from top to bottom and if one is not matched,
            * the process will be aborted and a message will be shown.
            *
            * @return boolean
            */
            function getValidateCompleteForm() { return $this->_validatecompleteform; }
            function setValidateCompleteForm($value) { $this->_validatecompleteform=$value; }
            function defaultValidateCompleteForm() { return false; }


            function dumpJavascript()
            {
                parent::dumpJavascript();
                reset($this->_rules);
                while(list($key, $val)=each($this->_rules))
                {
                    $jsevent=trim($val['OnValidate']);
                    if ($jsevent!='')
                    {
                        $this->dumpJSEvent($jsevent);
                    }
                }
            }

            function dumpHeaderCode()
            {
                if (!defined('JSVAL'))
                {
                ?>
                <script language="javascript" src="<?php echo VCL_HTTP_PATH; ?>/jsval/jsval.js"></script>
                <?php
                }
?>
<script language="javascript" type="text/javascript">
<!--
function <?php echo $this->_name; ?>_validate()
{
<?php
        reset($this->_rules);
        while(list($key, $val)=each($this->_rules))
        {
            $cname=trim($val['Control']);
            if ($cname!='')
            {
                echo "var obj=findObj('$cname');\n";

                $required=$val['Required'];
                if ($required=='true') $required=1;
                else $required=0;
                echo "obj.required=$required;\n";

                $equals=trim($val['Equals']);
                if ($equals!='')
                {
                    echo "obj.equals='$equals';\n";
                }

                $err=trim($val['ErrorMessage']);
                if ($err!='')
                {
                    $err=str_replace("'","\\'",$err);
                    echo "obj.err='$err';\n";
                }

                $realname=trim($val['FieldName']);
                if ($realname!='')
                {
                    echo "obj.realname='$realname';\n";
                }

                $minlength=trim($val['MinLength']);
                if ($minlength!='0')
                {
                    echo "obj.minlength=$minlength;\n";
                }

                $maxlength=trim($val['MaxLength']);
                if ($maxlength!='0')
                {
                    echo "obj.maxlength=$maxlength;\n";
                }

                $minvalue=trim($val['MinValue']);
                if ($minvalue!='0')
                {
                    echo "obj.minvalue=$minvalue;\n";
                }

                $maxvalue=trim($val['MaxValue']);
                if ($maxvalue!='0')
                {
                    echo "obj.maxvalue=$maxvalue;\n";
                }

                $regexp=trim($val['ValidationType']);
                if ($regexp!='')
                {
                        switch($regexp)
                        {
                                case 'email': $regexp='JSVAL_RX_EMAIL'; break;
                                  case 'telephone':$regexp='JSVAL_RX_TEL'; break;
                                  case 'zip':$regexp='JSVAL_RX_ZIP'; break;
                                  case 'money':$regexp='JSVAL_RX_MONEY'; break;
                                  case 'creditcard':$regexp='JSVAL_RX_CREDITCARD'; break;
                                  case 'postalzip':$regexp='JSVAL_RX_POSTALZIP'; break;
                                  case 'postalcode':$regexp='JSVAL_RX_PC'; break;
                        }

                    echo "obj.regexp=\"$regexp\";\n";
                }

                $callback=trim($val['OnValidate']);
                if ($callback!='')
                {
                    echo "obj.callback='$callback';\n";
                }
            }
        }

        if ($this->_validatecompleteform)
        {
?>
    return validateCompleteForm(findObj('<?php echo $this->owner->Name; ?>'));
<?php
        }
        else
        {
?>
    return validateStandard(findObj('<?php echo $this->owner->Name; ?>'));
<?php
        }
?>
}
-->
</script>
<?php
            }


        }

?>
