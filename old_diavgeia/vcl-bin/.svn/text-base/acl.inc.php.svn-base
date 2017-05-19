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
* Manager class for ACL system
*
* This class holds a list of all ACL objects used to control the way resources
* are accessed by the application.
*
* Normally you don't have to use this class if you are not a component developer, unless
* you want to develop an application that uses ACL at a higher level.
*
*/
class ACLManager
{
   private $acl_objects = array();

   function __get($nm)
   {
      $method = 'get' . $nm;
      if(method_exists($this, $method)) return($this->$method());
      else
      {
         $method = 'read' . $nm;

         if(method_exists($this, $method)) return($this->$method());
         else
         {
            throw new EPropertyNotFound($this->ClassName() . '->' . $nm);
         }
      }
   }

   function __set($nm, $val)
   {
      $method = 'set' . $nm;

      if(method_exists($this, $method)) $this->$method($val);
      else
      {
         $method = 'write' . $nm;

         if(method_exists($this, $method)) $this->$method($val);
         else
         {
            throw new EPropertyNotFound($this->ClassName() . '->' . $nm);
         }
      }
   }


   protected $_role = "";

   /**
   * Holds the role to be used when querying about allowed actions
   *
   * This property should be set to the user/role you want to use when querying
   * the ACL system, tipically the user name or the group name
   *
   * @see acl_addresource()
   *
   * @return string
   */
   function getRole() { return $this->_role; }
   function setRole($value) { $this->_role = $value; }
   function defaultRole() { return ""; }

   /**
   * Adds an ACL object to the athentication chain
   *
   * Use this method to add your ACL object to the authentication chain
   * used when isAllowed is called. Adding your object will cause the method
   * isAllowed of your object to be called when a resource is to be accessed
   *
   * @see isAllowed
   *
   * @param object $acl ACL object to add
   */
   function addACL($acl)
   {
      //TODO: Check for duplicates here
      $this->acl_objects[] = $acl;
   }

   /**
   * Use this method to check if an specific role (user/group/etc) is allowed to access a resource
   *
   * This method is called by components to know if they are able to perform an specific action
   * and you can also use it to check if a user has access to some resource of your app.
   * Iterates through all the ACL objects added using addACL and call the method isAllowed of each
   * of them until gets a positive.
   *
   * @see addACL
   *
   * @param string $role
   * @param string $resource
   * @param string $privilege
   * @return boolean True if $role is allowed to access the specific $resource and $privilege
   */
   function isAllowed($role = null , $resource = null , $privilege = null)
   {
      //No acl objects registered, all actions allowed
      if(count($this->acl_objects) == 0) return(true);

      $result = false;
      reset($this->acl_objects);
      while(list($k, $acl) = each($this->acl_objects))
      {
         if($acl->isAllowed($role, $resource, $privilege))
         {
            $result = true;
            break;
         }
      }
      return($result);
   }

   /**
   * Use this method to add a resource to the ACL system, so you can query later for it
   *
   * This method is useful for you to add a resource to the ACL system, that is,
   * 'something' in your application which access is restricted for 'someone'.
   *
   * By default, all pages and all controls are added as resources, so you can specify
   * rules to control the access to pages, even to the control level.
   *
   * @see isAllowed
   *
   * @param string $resourcename
   */
   function addResource($resourcename)
   {
      //No acl objects registered, all actions allowed
      if(count($this->acl_objects) != 0)
      {
         reset($this->acl_objects);
         while(list($k, $acl) = each($this->acl_objects))
         {
            $acl->add($resourcename);
         }
      }
   }
}

global $aclmanager;

$aclmanager = new ACLManager();

/**
* This global function is used to add an object or resource to the ACL system
*
* This function is used by components to add themselves to the ACL system, controls
* are added using their classname::name as identifiers.
*
* @see ACLManager::addResource
*
* @param string|object $object Object or string identifier for the resource to be added
*/
function acl_addresource($object)
{
   global $aclmanager;
   if(is_object($object)) $aclmanager->addResource($object->classname() . '::' . $object->Name);
   else $aclmanager->addResource($object);
}

/**
* This function can be used to know if an specific resource and privilege are allowed
* for the current user/role.
*
* This method uses ACLManager to query the registered ACL objects about specific resources/privileges.
*
* @see ACLManager::isAllowed()
*
* @return boolean True if the resource and privilege are allowed
*/
function acl_isallowed($resource = null , $privilege = null)
{
   global $aclmanager;

   if(!is_object($aclmanager))
   {
      //TODO: Improve this to prevent aclmanager substitution
      die("ACL security issue");
   }
   return($aclmanager->isAllowed($aclmanager->getRole(), $resource, $privilege));
}
?>