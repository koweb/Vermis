<?php

/**
 * =============================================================================
 * @file        AuthController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: AuthController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
