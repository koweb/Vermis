<?php

/**
 * =============================================================================
 * @file        Default/AuthControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: AuthControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Default_AuthControllerTest
 */
class Default_AuthControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function testLoginAction_Success()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login' => 'admin',
                'password' => 'admin'
            ));
            
        $controller = $this->getController('AuthController');
        $controller->loginAction();
        $this->assertTrue($controller->view->loginSuccess);
    }
    
    public function testLoginAction_Failure()
    {
        $this->request
            ->setMethod('POST')
            ->setPost(array(
                'login' => 'unknown user',
                'password' => 'wrong password !@#$%'
            ));
            
        $controller = $this->getController('AuthController');
        $controller->loginAction();
        $this->assertFalse($controller->view->loginSuccess);
    }

    public function testLogoutAction()
    {
        $this->dispatch('/auth/logout');
        $this->assertController('auth');
        $this->assertAction('logout');
        $this->assertNull(Zend_Auth::getInstance()->getIdentity());        
    }
    
}
