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
use_unit("classes.inc.php");
use_unit("controls.inc.php");
use_unit("extctrls.inc.php");

use_unit("Zend/framework/library/Zend/Acl.php");
use_unit('Zend/framework/library/Zend/Acl/Resource.php');
use_unit('Zend/framework/library/Zend/Acl/Role.php');

class ZACL extends Component
{
   protected $_lastroles = array();
   protected $_acl = null;

   function __construct($aowner = null)
   {
      //Calls inherited constructor
      parent::__construct($aowner);

      $this->_acl = new Zend_Acl();

      use_unit("acl.inc.php");

      global $aclmanager;

      //Set the global aclmanager to this object
      $aclmanager->addACL($this);

      /*  Test data
      $resources=array();
      $resources[]=array("type"=>'Page', "value1"=>"index.php", "value2"=>"","perm"=>"Allow", "right"=>"show,execute","parent"=>'');
      $resources[]=array("type"=>'Action', "value1"=>"ActnList1", "value2"=>"view_invoices", "perm"=>"Deny", "right"=>"execute","parent"=>'');
      $resources[]=array("type"=>'Control', "value1"=>"Button",    "value2"=>"btnReport",     "perm"=>"Allow", "right"=>"execute","parent"=>'');
      $resources[]=array("type"=>'Custom', "value1"=>"custom",    "value2"=>"custom",        "perm"=>"Deny", "right"=>"show","parent"=>'');

      $roles=array();
      $roles[]=array("type"=>"User","value"=>"pepe","parents"=>"");
      $roles[]=array("type"=>"Role","value"=>"managers","parents"=>"pepe");

      $rules=array();
      $rules[]=array("My Rule Description"=>array("Roles"=>$roles,"Resources"=>$resources));

      $this->_rules=$rules;
      */

   }

   protected $_rules = array();

   function getRules() { return $this->_rules; }
   function setRules($value) { $this->_rules = $value; $this->processRules(); }
   function defaultRules() { return array(); }

   function processRoles($roles)
   {
      $this->_lastroles = array();
      reset($roles);
      while(list($k, $role) = each($roles))
      {
         $roleobj = new Zend_Acl_Role($role['value']);
         $this->_lastroles[] = $role['value'];
         if($role['parents'] != '') $inheritsfrom = explode(",", $role['parents']);
         else $inheritsfrom = null;

         $this->_acl->addRole($roleobj, $inheritsfrom);
      }
   }

   function processResources($resources)
   {
      reset($resources);
      while(list($k, $resource) = each($resources))
      {
         $restype = $resource['type'];
         if($restype == 'Page') $resname = $resource['value1'];
         else if($restype == 'Custom')
         {
            $resname = $resource['value1'] . $resource['value2'];
            if(($resource['value1'] = '') || ($resource['value1'] = '*'))
            {
               $resname = null;
            }
         }
         else $resname = $resource['value1'] . '::' . $resource['value2'];

         if($resource['parent'] != '') $inheritsfrom = $resource['parent'];
         else $inheritsfrom = null;

         if($resource['right'] != '') $priv = explode(",", $resource['right']);
         else $priv = null;

         if($resname != '')
         {
            if(!$this->_acl->has($resname))
            {
               $this->_acl->add(new Zend_Acl_Resource($resname), $inheritsfrom);
            }
         }
         else $resname = null;

         if(strtolower($resource['perm']) == 'allow')
         {
            $this->_acl->allow($this->_lastroles, $resname, $priv);
         }
         else
         {
            $this->_acl->deny($this->_lastroles, $resname, $priv);
         }
      }
   }

   function add($resourcename)
   {
      if(!$this->_acl->has($resourcename))
      {
         $this->_acl->add(new Zend_Acl_Resource($resourcename));
      }
   }

   function isAllowed($role = null , $resource = null , $privilege = null)
   {
      return($this->_acl->isAllowed($role, $resource, $privilege));
   }

   function processRules()
   {
      reset($this->_rules);
      while(list($krule, $rulearray) = each($this->_rules))
      {
         list($description, $rule) = each($rulearray);
         $roles = $rule["Roles"];
         $this->processRoles($roles);

         $resources = $rule["Resources"];
         $this->processResources($resources);
      }
   }
}

?>