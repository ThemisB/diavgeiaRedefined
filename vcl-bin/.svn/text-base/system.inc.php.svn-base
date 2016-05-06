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
 * Exception thrown when trying to access a property not defined
 *
 * This property is raised when trying to access a property which is not defined
 * in the object you are using.
 */
class EPropertyNotFound extends Exception
{
       /**
        * Constructor
        *
        * @param string $message Message to show on the exception
        * @param integer $code Code to use as exception code
        */
        function __construct($message = null, $code = 0)
        {
                $backtrace = debug_backtrace();
                $call = $backtrace[ 1 ];
                $file = basename( $call[ 'file' ] );
                $line = $call[ 'line' ];

                $message=sprintf( 'Trying to access non-existant property %s in %s, line %d.', $message, $file, $line );
                // make sure everything is assigned properly
                parent::__construct($message, $code);
        }
}

/**
 * Object is the ultimate ancestor of all objects and components.
 *
 * Object encapsulates fundamental behavior common to objects by introducing methods that
 *
 * create, maintain and destroy instances of the object by allocating, initializing, and freeing required memory.
 *
 * respond when object instances are created or destroyed.
 *
 * return class-type and instance information on an object and runtime type information (RTTI) about its published properties.
 *
 * Use Object as an immediate base class when declaring simple objects that do not need to persist
 * (are not saved and reloaded in the session) and that do not need to be assigned to other objects.
 *
 * Much of the capability of objects is established by methods that Object introduces.
 * Many of these methods are used internally by IDEs and are not intended for users to
 * call directly. Others are overridden in descendant objects that have more complex behavior.
 *
 * Although Object is the based object of a component framework, not all objects are components.
 * All component classes are descended from Component.
 *
 * To create a class that belongs to the class library, you must, at least, inherit
 * from Object, which provides the basic methods to work.
 */
class Object
{
        /**
        * Global input object, easily accessible without declaring global
        */
        public $input=null;

        /**
        * Constructs an object and initializes its data before the object is first used.
        *
        * Create constructs an object. The purpose, size, and behavior of objects differ
        * greatly. The Create constructor defined by Object allocates memory but does not initialize data.
        *
        * Descendant objects usually define a constructor that creates the particular kind of
        * object and initializes its data.
        *
        * In Object, this constructor basically assigns the globa Input object to be
        * available as a field for all objects.
        *
        * @return Object
        */
        function __construct()
        {
                global $input;

                //Assign the global input object so it can be used from inside
                $this->input=$input;
        }

        /**
         * Returns a string indicating the type of the object instance (as opposed to the type of the variable passed as an argument).
         *
         * Use ClassName to obtain the class name from an object instance.
         * This is useful for differentiating object instances that are assigned to a
         * variable that has the type of an ancestor class.
         *
         * <code>
         * <?php
         *         //Class definition
         *         class Unit467 extends Page
         *         {
         *                function Unit467BeforeShow($sender, $params)
         *                {
         *                 echo $this->className();
         *                 //This will echo Unit467 on the browser
         *                }
         *
         *         }
         * ?>
         * </code>
         *
         * @return string Name of this object class
         */
        function className()
        {
                return(get_class($this));
        }


        /**
         * Determines whether an object is of a specific type.
         *
         * ClassNameIs determines whether an object instance has a class name that matches a specified string.
         *
         * <code>
         * <?php
         *         //Class definition
         *         class Unit467 extends Page
         *         {
         *                function Unit467BeforeShow($sender, $params)
         *                {
         *                  if ($this->classNameIs("Unit467")) echo "This is the right form!";
         *                }
         *
         *         }
         * ?>
         * </code>
         *
         * @param string $name Name to compare
         * @return boolean True if classname of this object is $name
         */
        function classNameIs($name)
        {
                return(strtolower($this->ClassName())==strtolower($name));
        }


        /**
         * Check if a method exists declared on this object instance.
         *
         * <code>
         * <?php
         *         //Class definition
         *         class Unit467 extends Page
         *         {
         *                function Unit467BeforeShow($sender, $params)
         *                {
         *                  if ($this->methodExists("Unit467BeforeShow")) echo "It exists!";
         *                }
         *
         *         }
         * ?>
         * </code>
         *
         * @param string $method Method name to check
         * @return boolean True if $method exists
         */
        function methodExists($method)
        {
                return(method_exists($this,$method));
        }

        /**
         * Returns the type of the immediate ancestor of a class.
         *
         * ClassParent returns the name of the parent class for an object instance.
         * For Object, ClassParent returns false.
         * Avoid using ClassParent in application code.
         *
         * <code>
         * <?php
         *         //Class definition
         *         class Unit467 extends Page
         *         {
         *                function Unit467BeforeShow($sender, $params)
         *                {
         *                   echo $this->classParent();
         *                   //This will echo Page
         *                }
         *
         *         }
         * ?>
         * </code>
         *
         * @return class Class from which this object inherits
         */
        function classParent()
        {
                return(get_parent_class($this));
        }

        /**
         * Determines the relationship of two object types.
         *
         * Use InheritsFrom to determine if a particular class type or object is an
         * instance of a class or one of its descendants. InheritsFrom returns true
         * if the object type specified in the class parameter is an ancestor of the
         * object type or the type of the object itself. Otherwise, it returns false.
         *
         * <code>
         * <?php
         *         //Class definition
         *         class Unit467 extends Page
         *         {
         *                function Unit467BeforeShow($sender, $params)
         *                {
         *                   if ($this->inheritsFrom("Page")) echo "This is a page!";
         *                }
         *
         *         }
         * ?>
         * </code>
         *
         * @param string $class Class name to check
         * @return boolean True if this object inherits from $class
         */
        function inheritsFrom($class)
        {
                return(is_subclass_of($this,$class)  || $this->classNameIs($class));
        }

        /**
         * Reads a property from the streams
         * @param string $propertyname Name of the property to read
         * @param string $valuename Value name to read
         * @param string $stream Stream to read from
         */
        function readProperty($propertyname,$valuename,$stream='post')
        {
                //TODO: Use also get array
                //TODO: Use the input object
                if (isset($_POST[$valuename]))
                {
                        $value=$_POST[$valuename];
                        $this->$propertyname=$value;
                }
        }


         /**
         * To virtualize properties
         *
         * This PHP magic method is used on the class library to allow you
         * create property (public and published) so you can write setters and
         * getters and use property names in your code.
         *
         * @param string $nm Property name
         * @return mixed
         */
        function __get($nm)
        {
                $method='get'.$nm;

                //Search first for get$nm
                if (method_exists($this,$method))
                {
                        return ($this->$method());
                }
                else
                {
                        $method='read'.$nm;

                        //Search for read$nm
                        if (method_exists($this,$method))
                        {
                                return ($this->$method());
                        }
                        else
                        {
                                //If not, search a component owned by it, with that name
                                if ($this->inheritsFrom('Component'))
                                {
                                        /*
                                        reset($this->components->items);
                                        while (list($k,$v)=each($this->components->items))
                                        {
                                                if (strtolower($v->Name)==strtolower($nm)) return($v);
                                        }
                                        */
                                        if( isset( $this->_childnames[ $nm ] ) )
                                            return $this->_childnames[ $nm ];
                                }
                                throw new EPropertyNotFound($this->ClassName().'->'.$nm);
                        }
                }
        }

  /**
  * To virtualize properties
  *
  * This PHP magic method is used on the class library to allow you
  * create property (public and published) so you can write setters and
  * getters and use property names in your code.
  *
  * @param string $nm Property name
  * @param mixed $val Property value
  */
  function __set($nm, $val)
  {
        $method='set'.$nm;

        if (method_exists($this,$method))
        {
                $this->$method($val);
        }
        else
        {
                $method='write'.$nm;

                if (method_exists($this,$method))
                {
                        $this->$method($val);
                }
                else
                {
                        throw new EPropertyNotFound($this->ClassName().'->'.$nm);
                }
        }
  }


}


define('sGET',0);
define('sPOST',1);
define('sREQUEST',2);
define('sCOOKIES',3);
define('sSERVER',4);

global $filter_func;

/**
* Native Input Filter, not working yet
*/
class InputFilter
{
        /**
        * Process user input to be clean
        * @param string $input Input to be cleaned
        * @return string
        */
        function process($input)
        {
                //TODO: Our own input filtering class in native PHP code
                //NOTE: Comment this line to don't raise the exception an get the unfiltered input
                throw new Exception("The Input Filter PHP extension is not setup on this PHP installation, so the contents returned by Input is *not* filtered");
                return($input);
        }
}

/**
* Represents an input parameter from the user, it doesn't inherit from Object to
* be faster and smaller.
*
* Objects of this type are returned from the Input object and you must use any of the
* available methods like asString() to get the value filtered properly.
*/
class InputParam
{
        public $name='';
        public $stream;
        public $filter_extension=false;
        public $filter=null;

        /**
        * Create the object
        * @param $name   Key of the stream to look form
        * @param $stream Stream to look for
        */
        function __construct($name, $stream=SGET)
        {
                global $filter_func;

                $this->filter_extension=($filter_func!='');

                //If not, creates the native filter
                if (!$this->filter_extension)
                {
                        //TODO: Use a global native filter to reduce overhead
                        $this->createNativeFilter();
                }

                $this->name=$name;

                //Set the stream to look for
                switch($stream)
                {
                        case sGET: $this->stream=&$_GET; break;
                        case sPOST: $this->stream=&$_POST; break;
                        case sREQUEST: $this->stream=&$_REQUEST; break;
                        case sCOOKIES: $this->stream=&$_COOKIES; break;
                        case sSERVER: $this->stream=&$_SERVER; break;
                }

        }

        /**
        * Creates the native Input Filter to be used when there is no available extension
        */
        function createNativeFilter()
        {
                $this->filter = new InputFilter();
        }

        //TODO: Add filtering without the filtering extension installed

        /**
        * Returns the input filtered as a string
        *
        * Use this property to get the value from the input as a string value.
        * The input is sanitized to strip out dangerous content.
        *
        * @return string
        */
        function asString()
        {
                global $filter_func;

                //Filter this out
                if ($this->filter_extension)
                {
                        return $filter_func($this->stream[$this->name],FILTER_SANITIZE_STRING);
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a string array
        *
        * Use this property to get the value from the input as a string array.
        * The input is sanitized to strip out dangerous content.
        *
        * @return array
        */
        function asStringArray()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        $data=$this->stream[$this->name];
                        reset($data);
                        $result=array();
                        while (list($k,$v)=each($data))
                        {
                                $result[$filter_func($k,FILTER_SANITIZE_STRING)]=$filter_func($v,FILTER_SANITIZE_STRING);
                        }
                        return($result);
                }
                else
                {
                        //TODO: Filter using a native library
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a integer
        * @return integer
        */
        function asInteger()
        {
                global $filter_func;

                if ($this->filter_extension)
                {
                        return($filter_func($this->stream[$this->name],FILTER_SANITIZE_NUMBER_INT));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a boolean
        *
        * Use this property to get the value from the input as a boolean value.
        * The input is validated and if it's not a boolean, an empty string is
        * returned.
        *
        * @return boolean
        */
        function asBoolean()
        {
                global $filter_func;

                if ($this->filter_extension)
                {
                        if ($filter_func($this->stream[$this->name],FILTER_VALIDATE_BOOLEAN)) return($this->stream[$this->name]);
                        else return('');
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a float
        *
        * Use this property to get the value from the input as a float value.
        * The input is sanitized to remove anything that might not be part of
        * a float number.
        *
        * @param integer $flags Flags to be sent when getting the value asfloat
        * @return float
        */
        function asFloat($flags=0)
        {
                global $filter_func;

                if ($this->filter_extension)
                {
                        return($filter_func($this->stream[$this->name],FILTER_SANITIZE_NUMBER_FLOAT, $flags));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as a regular expression
        *
        * Use this property to get the value from the input as a float value.
        * The input is validated and if it's not a regular expression, an empty
        * string is returned.
        *
        * @return string
        */
        function asRegExp()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        if ($filter_func($this->stream[$this->name],FILTER_VALIDATE_REGEXP)) return($this->stream[$this->name]);
                        else return('');
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as an URL
        *
        * Use this property to get the value from the input as an URL.
        * The input is sanitized to remove anything that might not be part of
        * a URL.
        *
        * @return string
        */
        function asURL()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        return($filter_func($this->stream[$this->name],FILTER_SANITIZE_URL));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as an email address
        *
        * Use this property to get the value from the input as an email.
        * The input is sanitized to remove anything that might not be part of
        * an email.
        *
        * @return string
        */
        function asEmail()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        return($filter_func($this->stream[$this->name],FILTER_SANITIZE_EMAIL));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as an IP address
        *
        * Use this property to get the value from the input as an IP number.
        * The input is validated to see if it's a valid IP and if not, an empty
        * string is returned.
        *
        * @return string
        */
        function asIP()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        if ($filter_func($this->stream[$this->name],FILTER_VALIDATE_IP)) return($this->stream[$this->name]);
                        else return('');
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Returns the input filtered as an string
        *
        * Use this property to get the value from the input as string.
        * The input is sanitized to remove anything that may cause a security
        * issue.
        *
        * @return string
        */
        function asStripped()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        return($filter_func($this->stream[$this->name],FILTER_SANITIZE_STRIPPED));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * URL-encode string, optionally strip or encode special characters.
        *
        * Use this property to get the value from the input as an encoded URL.
        * The input is sanitized to remove anything that might not be part of
        * an encoded url.
        *
        * @return string
        */
        function asEncoded()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        return($filter_func($this->stream[$this->name],FILTER_SANITIZE_ENCODED));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * HTML-escape '"<>& and characters with ASCII value less than 32, optionally
        * strip or encode other special characters.
        *
        * @return string
        */
        function asSpecialChars()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        return($filter_func($this->stream[$this->name],FILTER_SANITIZE_SPECIAL_CHARS));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }

        /**
        * Do nothing with the input
        *
        * Use it to get the input as-is, use it when you know, for sure, the
        * input is safe.
        *
        * @return string
        */
        function asUnsafeRaw()
        {
                global $filter_func;
                //Filter this out
                if ($this->filter_extension)
                {
                        return($filter_func($this->stream[$this->name],FILTER_UNSAFE_RAW));
                }
                else
                {
                        return $this->filter->process($this->stream[$this->name]);
                }
        }
}

/**
* This class represents an input param with no filtering at all.
*
* This kind of params are created when input filtering is disabled.
*
*/
class RawInputParam extends InputParam
{
        function asString()
        {
                return $this->stream[$this->name];
        }

        function asStringArray()
        {
                return $this->stream[$this->name];
        }

        function asInteger()
        {
                return $this->stream[$this->name];
        }

        function asBoolean()
        {
                return $this->stream[$this->name];
        }

        function asFloat($flags=0)
        {
                return $this->stream[$this->name];
        }

        function asRegExp()
        {
                return $this->stream[$this->name];
        }

        function asURL()
        {
                return $this->stream[$this->name];
        }

        function asEmail()
        {
                return $this->stream[$this->name];
        }

        function asIP()
        {
                return $this->stream[$this->name];
        }

        function asStripped()
        {
                return $this->stream[$this->name];
        }

        function asEncoded()
        {
                return $this->stream[$this->name];
        }

        function asSpecialChars()
        {
                return $this->stream[$this->name];
        }
        function asUnsafeRaw()
        {
                return $this->stream[$this->name];
        }
}

/**
 * Input class, offers an easy way to get filtered input from the user.
 *
 * This is a sample on how to use it
 * <code>
 * <?php
 * global $input;
 * $action=$input->action;
 * if (is_object($action))
 * {
 *     $toperform=$action->asString();
 * }
 * ?>
 * </code>
 */
class Input
{
        public $disable=false;

        /**
         * Magic method to search for the input from the user,
         * checkout the order in which the variable is searched for:
         * $_GET, $_POST, $_REQUEST, $_COOKIES, $_SERVER
         *
         * @return InputParam object or null if it's not found
         *
         */
        function __get($nm)
        {
                if (!$this->disable)
                {
                        if (isset($_GET[$nm]))
                        {
                                return(new InputParam($nm, sGET));
                        }
                        else
                        if (isset($_POST[$nm]))
                        {
                                return(new InputParam($nm, sPOST));
                        }
                        else
                        if (isset($_REQUEST[$nm]))
                        {
                                return(new InputParam($nm, sREQUEST));
                        }
                        else
                        if (isset($_COOKIES[$nm]))
                        {
                                return(new InputParam($nm, sCOOKIES));
                        }
                        else
                        if (isset($_SERVER[$nm]))
                        {
                                return(new InputParam($nm, sSERVER));
                        }
                        else
                        {
                                return(null);
                        }
                }
                else
                {
                        if (isset($_GET[$nm]))
                        {
                                return(new RawInputParam($nm, sGET));
                        }
                        else
                        if (isset($_POST[$nm]))
                        {
                                return(new RawInputParam($nm, sPOST));
                        }
                        else
                        if (isset($_REQUEST[$nm]))
                        {
                                return(new RawInputParam($nm, sREQUEST));
                        }
                        else
                        if (isset($_COOKIES[$nm]))
                        {
                                return(new RawInputParam($nm, sCOOKIES));
                        }
                        else
                        if (isset($_SERVER[$nm]))
                        {
                                return(new RawInputParam($nm, sSERVER));
                        }
                        else
                        {
                                return(null);
                        }
                }
          }

          function __construct()
          {
                global $filter_func;

                //Checkout if filter extension has been installer or not
                //Starting with PHP 5.2.1, filter_data is filter_var
                if (function_exists('filter_var')) $filter_func='filter_var';
                else if (function_exists('filter_data')) $filter_func='filter_data';
          }
}

/**
 * Global $input variable, use it to get filtered/sanitized input from the user
 */
global $input;

$input=new Input();

?>