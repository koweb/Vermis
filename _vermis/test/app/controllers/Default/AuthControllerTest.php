<?php

/**
 * =============================================================================
 * @file        Default/AuthControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: AuthControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
