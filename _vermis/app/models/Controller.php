<?php

/**
 * =============================================================================
 * @file        Controller.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Controller.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Controller
 * @brief   Default base controller.
 */
class Controller extends FreeCode_Controller_Action
{
    
    protected $_config = null;
    protected $_flashMessages = null;
    protected $_breadCrumbs = null;
    
    /**
     * Set config.
     * @param Zend_Config $config
     * @return Controller
     */
    public function setConfig($config)
    {
        $this->_config = $config;
        return $this;
    }
    
    /**
     * Get config.
     * @return Zend_Config
     */
    public function getConfig()
    {
        return $this->_config;
    }
    
    /**
     * Set flash messages.
     * @param FreeCode_FlashMessages $flashMessages
     * @return Controller
     */
    public function setFlashMessages($flashMessages)
    {
        $this->_flashMessages = $flashMessages;
        return $this;
    }
    
    /**
     * Get flash messages.
     * @return FreeCode_FlashMessages
     */
    public function getFlashMessages()
    {
        return $this->_flashMessages;
    }
    
    /**
     * Set bread crumbs.
     * @param FreeCode_BreadCrumbs $breadCrumbs
     * @return Controller
     */
    public function setBreadCrumbs($breadCrumbs)
    {
        $this->_breadCrumbs;
        return $this;
    }
    
    /**
     * Get bread crumbs.
     * @return FreeCode_BreadCrumbs
     */
    public function getBreadCrumbs()
    {
        return $this->_breadCrumbs;
    }
    
    public function init()
    {
        parent::init(); 

        $this->view->moduleName = $this->_request->getModuleName();
        $this->view->controllerName = $this->_request->getControllerName();
        $this->view->actionName = $this->_request->getActionName();
        
        $this->_config = FreeCode_Config::getInstance();
        $this->view->config = $this->_config;
        
        $this->_flashMessages = FreeCode_FlashMessages::getInstance();
        $this->view->flashMessages = $this->_flashMessages;
        
        $this->_breadCrumbs = FreeCode_BreadCrumbs::getInstance();
        $this->view->breadCrumbs = $this->_breadCrumbs;
        $this->_breadCrumbs->addCrumb('Vermis', array(), 'index');

        $this->view->activeModule = $this->_request->getModuleName();
        
        $this->view->headTitle()->setSeparator(' :: ');
        $this->view->headTitle(_T('Vermis Issue Tracker'));
        
        if ($this->_identity) {
            $identityProjects = $this->_identity->getMyProjectsQuery()->execute();
        
        } else {
            $identityProjects = Doctrine::getTable('Project')
                ->getProjectsListQuery()
                ->addWhere("p.is_private = false")
                ->execute();
        }
        $this->view->identityProjects = $identityProjects;
    }
    
    /**
     * @brief   Login identity.
     * @param   $login      string
     * @param   $password   string
     * @return  boolean
     */
    public function login($login, $password)
    {
        $auth = Zend_Auth::getInstance();
        $authAdapter = new FreeCode_Auth_Adapter_User($login, FreeCode_Hash::encodePassword($password));
        if ($auth->authenticate($authAdapter)->isValid()) {
            
            // Save.
            $identity = $authAdapter->getUserAsArray();
            $auth->getStorage()->write($identity);

            // Update.
            $user = Doctrine::getTable('User')->find($identity['id']);
            $user->setLoginInfo();
            $user->save();
            
            // Check acl.
            $acl = new Acl;
            $aclPlugin = new FreeCode_Controller_Plugin_Acl($acl, $identity['role']);
            if ($aclPlugin->isAllowedToRequest($this->_request)) {
                return true;
            }
        }

        $this->logout();
        return false;
    }
    
    /**
     * @brief   Logout identity.
     * @return  void
     */
    public function logout()
    {
        Zend_Auth::getInstance()->clearIdentity();
        @session_destroy();
    }
    
    /**
     * Bind sorting parameters.
     * @param $query
     * @return Doctrine_Query
     */
    public function bindSortParams(Doctrine_Query $query, $defaultField = null, $defaultOrder = 'asc')
    {
        $sortField = $this->_request->getParam('sort-field');
        $sortOrder = $this->_request->getParam('sort-order');
        
        if ($sortOrder != 'asc' && $sortOrder != 'desc')
            $sortOrder = $defaultOrder;
        
        if (empty($sortField))
            $sortField = $defaultField;

        if (!empty($sortField))
            $query->orderBy($sortField.' '.$sortOrder);
        
        return $query;
    } 
    
}
