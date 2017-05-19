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
use_unit("nusoap/nusoap.php");

/**
 * This component represents a web service.
 *
 * This component allows you to publish specific application functionality using SOAP
 * technology, so you can write clients that consume that functionality in other languages
 * that share the same technology.
 *
 * @link http://www.w3.org/TR/soap/
 *
 * @example Web Service/soapserver.php Creating web services
 * @example Web Service/soapserver.xml.php Creating web services (form)
 *
 */
class Service extends Component
{
        private $_server = null;

        protected $_active = false;

        /**
        * Specifies if the webservice is active or not.
        *
        * If this property is set to true, the component will fire the events
        * to get the functions to register and any complex type required and
        * will publish the WSDL and process service requests
        *
        * @return boolean
        */
        function getActive() { return $this->_active; }
        function setActive($value) { $this->_active = $value; }
        function defaultActive() { return false; }

        protected $_servicename = "VCL";

        /**
        * Specifies the Name of the service you want to create
        *
        * This property determines the name of the service you are going to
        * publish. The default value is VCL
        *
        * @return string
        */
        function getServiceName() { return $this->_servicename; }
        function setServiceName($value) { $this->_servicename = $value; }
        function defaultServiceName() { return "VCL"; }

        protected $_namespace = "http://localhost";

        /**
        * Specifies the Name Space for the WSDL
        *
        * This property is used to provide the namespace used when generating the
        * web service description (WSDL)
        *
        * @return string
        */
        function getNameSpace() { return $this->_namespace; }
        function setNameSpace($value) { $this->_namespace = $value; }
        function defaultNameSpace() { return false; }

        protected $_schematargetnamespace = "http://localhost/xsd";

        /**
        * Specifies the Target Name Space for the WSDL
        *
        * This property is used to provide the target namespace used when gene3rating
        * the webservice description (WSDL)
        *
        * @return string
        */
        function getSchemaTargetNamespace() { return $this->_schematargetnamespace; }
        function setSchemaTargetNamespace($value) { $this->_schematargetnamespace = $value; }
        function defaultSchemaTargetNamespace() { return ""; }


        protected $_onregisterservices = null;

        /**
        * Fired when the service needs to register the functions to be published by the service.
        *
        * Use this event to call register method and specify which methods do you want
        * to publish so are available by users of the webservice.
        *
        * <code>
        * <?php
        *      function MyWebServiceRegisterServices($sender, $params)
        *      {
        *               //Register the echo service
        *               $this->MyWebService->register(
        *               "serviceEcho",
        *               array('input'=>'xsd:string'),
        *               array('return'=>'xsd:string'),
        *               'http://localhost/'
        *               );
        *
        *
        *               //Register the conversion service
        *               $this->MyWebService->register(
        *               "StringArrayToIntArray",
        *               array('input'=>'tns:ArrayOfstring'),
        *               array('return'=>'tns:ArrayOfinteger'),
        *               'http://localhost/'
        *               );
        *
        *      }
        * ?>
        * </code>
        * @see register()
        * @return mixed
        */
        function getOnRegisterServices() { return $this->_onregisterservices; }
        function setOnRegisterServices($value) { $this->_onregisterservices = $value; }
        function defaultOnRegisterServices() { return null; }

        protected $_onaddcomplextypes = null;

        /**
        * Fired when the service needs to register complex types.
        *
        * Use this event to register all complex types your functions need by calling
        * addComplexType method. Complex types are built using simple types.
        *
        * <code>
        * <?php
        *      function MyWebServiceAddComplexTypes($sender, $params)
        *      {
        *       //Add the complex type array of strings
        *       $this->MyWebService->addComplexType
        *       (
        *               'ArrayOfstring',
        *               'complexType',
        *               'array',
        *               '',
        *               'SOAP-ENC:Array',
        *               array(),
        *               array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'string[]')),
        *               'xsd:string'
        *       );
        *
        *       //Add the complex type array of integers
        *       $this->MyWebService->addComplexType
        *       (
        *               'ArrayOfinteger',
        *               'complexType',
        *               'array',
        *               '',
        *               'SOAP-ENC:Array',
        *               array(),
        *               array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'integer[]')),
        *               'xsd:integer'
        *       );
        *      }
        * ?>
        * </code>
        * @see addComplexType()
        * @return mixed
        */
        function getOnAddComplexTypes() { return $this->_onaddcomplextypes; }
        function setOnAddComplexTypes($value) { $this->_onaddcomplextypes = $value; }
        function defaultOnAddComplexTypes() { return null; }

        function init()
        {
                if (($this->ControlState & csDesigning) != csDesigning)
                {
                        if ($this->_active)
                        {
                                //If the webservice is active, create the nusoap object
                                $this->_server = new soap_server();
                                $this->_server->configureWSDL($this->_servicename, $this->_namespace);
                                $this->_server->wsdl->schemaTargetNamespace = $this->_schematargetnamespace;

                                //Call events
                                $this->callEvent('onaddcomplextypes', array());
                                $this->callEvent('onregisterservices', array());

                                global $HTTP_RAW_POST_DATA;

                                $HTTP_RAW_POST_DATA=isset($HTTP_RAW_POST_DATA)?$HTTP_RAW_POST_DATA:file_get_contents("php://input");

                                $this->_server->service($HTTP_RAW_POST_DATA);

                                global $log;

                                if(isset($log) and $log != '')
                                {
                                        harness('nusoap_r2_base_server', $this->_server->headers['User-Agent'], $this->_server->methodname, $this->_server->request, $this->_server->response, $this->_server->result);
                                }
                        }
                }
        }

        function __construct($aowner = null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);
        }

        /**
        * Register a service function with the server
        *
        * Use this method on the OnRegisterServices event to register all
        * methods you want to publish.
        *
        * <code>
        * <?php
        *               //Register the echo service
        *               $this->MyWebService->register(
        *               "serviceEcho",
        *               array('input'=>'xsd:string'),
        *               array('return'=>'xsd:string'),
        *               'http://localhost/'
        *               );
        * ?>
        * </code>
        *
        * @param    string $name the name of the PHP function, class.method or class..method
        * @param    array $in assoc array of input values: key = param name, value = param type
        * @param    array $out assoc array of output values: key = param name, value = param type
        * @param    mixed $namespace the element namespace for the method or false
        * @param    mixed $soapaction the soapaction for the method or false
        * @param    mixed $style optional (rpc|document) or false Note: when 'document' is specified, parameter and return wrappers are created for you automatically
        * @param    mixed $use optional (encoded|literal) or false
        * @param    string $documentation optional Description to include in WSDL
        * @param    string $encodingStyle optional (usually 'http://schemas.xmlsoap.org/soap/encoding/' for encoded)
        *
        */
        function register($name,$in=array(),$out=array(),$namespace=false,$soapaction=false,$style=false,$use=false,$documentation='',$encodingStyle='')
        {
                if ($namespace==false) $namespace=$this->_namespace;

                $this->_server->register($name,$in,$out,$namespace,$soapaction,$style,$use,$documentation,$encodingStyle);
        }

        /**
        * Adds a complex type to the schema
        *
        * Use this method on the OnAddComplexTypes event to provide a description
        * for your complex types.
        *
        * <code>
        * <?php
        *
        * //Adding a string array type
        * addComplexType(
        *       'ArrayOfstring',
        *       'complexType',
        *       'array',
        *       '',
        *       'SOAP-ENC:Array',
        *       array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'string[]'),
        *       'xsd:string'
        * );
        *
        * //Adding a PHP associative array ( SOAP Struct )
        * addComplexType(
        *       'SOAPStruct',
        *       'complexType',
        *       'struct',
        *       'all',
        *       array('myVar'=> array('name'=>'myVar','type'=>'string')
        * );
        * ?>
        * </code>
        *
        * @param string $name Type name
        * @param string $typeClass (complexType|simpleType|attribute)
        * @param string $phpType currently supported are array and struct (php assoc array)
        * @param string $compositor (all|sequence|choice)
        * @param string $restrictionBase namespace:name (http://schemas.xmlsoap.org/soap/encoding/:Array)
        * @param array $elements = array ( name = array(name=>'',type=>'') )
        * @param array $attrs = array(
        *       array(
        *               'ref' => "http://schemas.xmlsoap.org/soap/encoding/:arrayType",
        *               "http://schemas.xmlsoap.org/wsdl/:arrayType" => "string[]"
        *       )
        * )
        * @param string $arrayType namespace:name (http://www.w3.org/2001/XMLSchema:string)
        *
        */
        function addComplexType($name,$typeClass='complexType',$phpType='array',$compositor='',$restrictionBase='',$elements=array(),$attrs=array(),$arrayType='')
        {
                $this->_server->wsdl->addComplexType($name,$typeClass, $phpType,$compositor,$restrictionBase,$elements,$attrs,$arrayType);
        }

}

?>