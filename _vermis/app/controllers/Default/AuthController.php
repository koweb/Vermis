<?php

/**
 * =============================================================================
 * @file        AuthController.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: AuthController.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   AuthController
 * @brief   Authorization controller.
 */
class AuthController extends Default_Controller
{

    public function init()
    {
        parent::init();
        
        // Clear previous crumbs to avoid duplications after using actionStack.
        $this->_breadCrumbs
            ->clear()
            ->addCrumb('Vermis', array(), 'index');
        
        $this->view->activeMenuTab = 'login';
        $this->view->headTitle()->prepend(_T('login'));
        $this->_breadCrumbs->addCrumb('login', array(), 'auth/login');
        
    }
    
    public function preDispatch()
    {
        // Detect AJAX request and reload whole page to the login screen.
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $url = $this->view->url(array(), 'index');
            echo '<script type="text/javascript">window.location="'.$url.'"</script>';
            if (!FreeCode_Test::isEnabled())
                die();
        }
    }
    
    public function loginAction()
    {
        $form = new Form_Login;
        $this->view->form = $form;
        $form->addCssClass('center');
        
        if ($data = $this->validateForm($form)) {
            if ($this->login($data['login'], $data['password'])) {
                $identity = Zend_Auth::getInstance()->getIdentity();
                $this->view->loginSuccess = true;
                if (    isset($_SERVER['HTTP_REFERER']) && 
                        strpos($_SERVER['HTTP_REFERER'], "login") === false)
                    $this->goToUrl($_SERVER['HTTP_REFERER']);
                else 
                    $this->goToAction(array(), 'index');
                
            } else {
                $this->view->loginSuccess = false;
                $this->_flashMessages->addError('invalid_username_or_password');
            }
        }
    }
    
    public function logoutAction()
    {
        $this
            ->disableView()
            ->disableLayout();
        $this->logout();
        $this->goToAction(array(), 'index');
    }
    
}
