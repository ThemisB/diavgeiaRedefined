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
* Converts PHP boolean into a JavaScript compatible boolean string
*
* This function takes a PHP boolean value and echoes a valid javascript boolean value (true/false) to the output.
* You can use it when writting PHP code that generates Javascript code so you don't have to mess with boolean values
*
*
* <code>
* <?php
*
* echo boolToStr(($a==1));
*
* ?>
* </code>
*
*
* @param boolean $value PHP boolean value to convert
* @return string
*/
function boolToStr( $value )
{
    return $value ? 'true' : 'false';
}

/**
* Converts plain text to html
*
* This function takes plain text as input, including carriage returns and non html chars, and returns the text in HTML form, by changing
* carriage returns to <br> and all non html chars exchanged by their corresponding entity.
*
* <code>
* <?php
*
* echo textToHtml("this is plain-text\nIncluding áéíóú chars\n");
* // This will produce "this is plain-text<br>Incluiding &aacute;&eacute;&iacute;&oacute;&uacute; chars<br>"
*
* ?>
* </code>
*
* @see htmlToText()
* @link http://www.php.net/manual/en/function.nl2br.php
*
* @param string $text Plain text to convert to HTML
* @param string $charset Use if you want to specify the charset to use when converting
* @return string
*/
function textToHtml( $text, $charset=null )
{
    if( isset($charset) )
    {
      return nl2br( htmlentities($text, ENT_QUOTES, $charset) );
    }
    else
    {
      return nl2br( htmlentities( $text ) );
    }
}

/**
* Converts HTML to plain text
*
* This function takes HTML as input, including line breaks and entities, and returns the text in plain text form, by changing
* <br> to carriage returns and all entities to their corresponding character.
*
* <code>
* <?php
*
* echo htmlToText("this is HTML<br />Including &aacute;&eacute;&iacute;&oacute;&uacute; chars<br />");
* // This will produce "this is HTML\nIncluding áéíóú chars\n"
*
* ?>
* </code>
*
* @see textToHtml()
* @link http://www.php.net/manual/en/function.html-entity-decode.php
*
* @param string $text HTML to conver to plain text
* @return string
*/
function htmlToText( $text )
{
          //TODO: Check also for <br> and all its variants
    return html_entity_decode( str_replace( '<br />', "\r\n", $text ) );
}

/**
* Redirects the browser to a project file
*
* Use this function to redirect to a script that is in the same project without worring about host or anything else,
* as the function calculates the right URI to redirect to.
*
* <code>
* <?php
*
* redirect("unit2.php");
*
* ?>
* </code>
*
* @link http://www.php.net/manual/en/function.header.php
*
* @param string $file File to redirect to
*/
function redirect( $file )
{
    $host = $_SERVER[ 'HTTP_HOST' ];
    $uri = rtrim( dirname( $_SERVER[ 'PHP_SELF' ] ), '/\\' );
    header( 'Location: http://' . $host . $uri . '/' . $file );
    exit();
}

/**
* Check if an object is not null
*
* This function is the Delphi for Windows equivalent for assigned, and in this case, it checks for a variable if assigned to null or not.
* Note that $var can contain anything, it doesn't check if it's an object or not.
*
*
* @param object $var Object to check
* @return boolean
*/
function assigned($var)
{
    return($var!=null);
}

/**
* EAbort is the exception class for errors that should not display an error message.
*
* Use EAbort to raise an exception without displaying an error message. If applications do not trap such “silent” exceptions,
* the EAbort exception is passed to the standard exception handler.
*
* The Abort procedure provides a simple, standard way to raise EAbort.
*
* @see Abort()
*
*/
class EAbort extends Exception
{
}

/**
* Throws a silent exception
*
* Use Abort to escape from an execution path without reporting an error.
*
* Abort raises a special "silent exception" (EAbort), which operates like any other exception, but does not display an error message to the end user.
* Abort redirects execution to the end of the last exception block.
*
* <code>
* <?php
*        function CheckOperation($Operation, $ErrorEvent)
*        {
*            $Done = false;
*            do
*            {
*                try
*                {
*                  $this->$Operation();
*                  $Done=true;
*                }
*                catch (EDatabaseError $e)
*                {
*                    $Action=daFail;
*                    $Action=$this->callEvent($ErrorEvent, array('Exception'=>$e, 'Action'=>$Action));
*                    if ($Action==daFail) throw $e;
*                    if ($Action==daAbort) Abort();
*                }
*
*            }
*            while(!$Done);
*        }
* ?>
* </code>
*
* @see EAbort
*/
function Abort()
{
    throw new EAbort();
}

/**
* Extracts the javascript code from an html document
*
* This function is used to automatically extract all javascript code from an HTML chunk, the splitted code
* is returned in an array, in which the first item (key 0) is the javascript code and the second item (key 1) is the
* HTML code without the javascript.
*
* <code>
* <?php
*   $result=extractjscript($htmlwithjavascript);
*   $js=$result[0];
*   $html=$result[1];
* ?>
* </code>
*
* @param string $html HTML document to extract the javascript from
* @return array
*/
function extractjscript( $html )
{
    $result = '';
    $pattern = '/<script[^>]*?>.*?<\/script>/si';
    $scripts = preg_match_all( $pattern, $html, $out);
    $onlyhtml = preg_replace( $pattern, '', $html );
    $pattern = '/^<script[^>]*?>(.*?)<\/script>$/si';

    foreach( $out[ 0 ] as $script )
    {
        if( preg_match( $pattern, $script, $arr ) )
            $result .= trim( $arr[ 1 ] );
    }

    return array( $result, $onlyhtml );
}

/**
* DBCS friendly unserialize, it modifies the length of all strings with the correct size
*
* This function allows you to unserialize serialized objects/arrays/variables when working with DBCS (Double Byte Character Sets) because it fixes
* the length of strings to the real length before unserializing.
*
* If not doing it this way, unserialize will throw an error due incorrect string lengths.
*
* @link http://www.php.net/manual/en/function.unserialize.php
* @see safeunserialize()
*
* @param string $sObject String to unserialize
* @return mixed
*/
function __unserialize($sObject)
{
    $__ret =preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $sObject );

    return unserialize($__ret);
}

/**
* Unserializes and if it gets an error, uses __unserialize
*
* This function first tries to unserialize the $input using the built-in PHP function, and if there is any error, it tries to unserialize
* using the DBCS safe function __unserialize to try get the value because it may be encoded as DBCS.
*
* @link http://www.php.net/manual/en/function.unserialize.php
* @see __unserialize()
*
* @param string $input String to unserialize
* @return mixed
*/
function safeunserialize($input)
{
    $result=unserialize($input);
    if ($result===false)
    {
        $result=__unserialize($input);
    }
    return($result);
}

?>