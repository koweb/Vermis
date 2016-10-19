<?php

/**
 * =============================================================================
 * @file        FreeCode/Controller/Plugin/Acl.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Acl.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Controller_Plugin_Acl
 * @brief   Access control list plugin.
 */
class FreeCode_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

    protected $_acl = null;
    protected $_role = null;

    /**
     * Constructor.
     * @param   Zend_Acl    $acl    
     * @param   string      $role
     */
    public function __construct($acl, $role)
    {
        $this->_acl = $acl;
        $this->_role = $role;
    }

    /**
     * Before dispatch.
     * @param   Zend_Controller_Request_Abstract    $request    
     * @return  void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if (!$this->isAllowedToRequest($request))
            $this->_denyAccess();
    }
    
    /**
     * Check acl for request.
     * @param   Zend_Controller_Request_Abstract    $request    
     * @return  boolean
     */
    public function isAllowedToRequest(Zend_Controller_Request_Abstract $request)
    {
        if (!$this->_acl)
            return true;
        
        $module = $request->getModuleName();
        $controller = $this->_getFixedModuleName($request).$request->getControllerName();
        $action = $this->_getFixedModuleName($request).$request->getControllerName().'/'.$request->getActionName();
        
        if ($this->_acl->has($action)) {
            if ($this->_acl->isAllowed($this->_role, $action))
                return true;
            
        } else if ($this->_acl->has($controller)) {
            if ($this->_acl->isAllowed($this->_role, $controller))
                return true;
            
        } else if ($this->_acl->has($module)) {
            if ($this->_acl->isAllowed($this->_role, $module))
                return true;
            
        } else {
            return true;
        }
        
        return false;
    }

    /**
     * Check if role has access to resource.
     * @param   string  $resource
     * @return  boolean
     */
    public function isAllowed($resource)
    {
        if (!$this->_acl || !$this->_acl->has($resource) || $this->_acl->isAllowed($this->_role, $resource))
            return true;
        return false;
    }

    /**
     * Get module name.
     * @param   Zend_Controller_Request_Abstract    $request 
     * @return  string
     */
    protected function _getFixedModuleName(Zend_Controller_Request_Abstract $request)
    {
        return ($request->getModuleName() != 'default' ? $request->getModuleName().'/' : '');
    }

    /**
     *Denying access to the module/controller/action.
     * @return  void
     */
    protected function _denyAccess()
    {
        // @TODO: It would be nice, but it causes problems with login screen.
        //FreeCode_FlashMessages::getInstance()->addError('Access denied!');
        
        // @TODO: Don't set module to have multiple login screens.
        $this->_request->setModuleName('default');
        $this->_request->setControllerName('auth');
        $this->_request->setActionName('login');
    }

}
