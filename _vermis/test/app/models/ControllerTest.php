<?php

/**
 * =============================================================================
 * @file        ControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   ControllerTest
 */
class ControllerTest extends Test_PHPUnit_ControllerTestCase 
{
    
    public function testInstance()
    {
        $this->login('admin', 'admin');
        $controller = $this->getController('Controller');
        
        $this->assertTrue($controller->getIdentity() instanceof User);
        $this->assertTrue($controller->getConfig() instanceof Zend_Config);
        $this->assertTrue($controller->getFlashMessages() instanceof FreeCode_FlashMessages);
        $this->assertTrue($controller->getBreadCrumbs() instanceof FreeCode_BreadCrumbs);
    }
    
    public function testSetGetConfig()
    {
    	$config = FreeCode_Config::getInstance();
    	$controller = $this->getController('Controller');
        $this->assertTrue($controller->setConfig($config) instanceof Controller);
        $this->assertTrue($controller->getConfig() instanceof Zend_Config);
    }
    
    public function testSetGetFlashMessages()
    {
        $controller = $this->getController('Controller');
        $c = $controller->setFlashMessages(FreeCode_FlashMessages::getInstance());
        $this->assertTrue($c instanceof Controller);
        $this->assertTrue($controller->getFlashMessages() instanceof FreeCode_FlashMessages);
    }
    
    public function testSetGetBreadCrumbs()
    {
        $controller = $this->getController('Controller');
        $bs = FreeCode_BreadCrumbs::getInstance();
        $this->assertTrue($controller->setBreadCrumbs($bs) instanceof Controller);
        $this->assertTrue($controller->getBreadCrumbs() instanceof FreeCode_BreadCrumbs);
    }
    
    public function testLogin()
    {
        $controller = $this->getController('Controller');
        
        $result = $controller->login('unknown user', 'wrong password');
        $this->assertFalse($result);
        
        $result = $controller->login('admin', 'wrong password');
        $this->assertFalse($result);
        
        $result = $controller->login('unknown user', 'admin');
        $this->assertFalse($result);
        
        $result = $controller->login('admin', 'admin');
        $this->assertTrue($result);
        
        $identity = Zend_Auth::getInstance()->getIdentity();
        $this->assertEquals('admin', $identity['login']);
        $this->assertEquals(FreeCode_Hash::encodePassword('admin'), $identity['password_hash']);
    }
    
    public function testLogout()
    {
        $controller = $this->getController('Controller');
        $controller->logout();
        $this->assertNull(Zend_Auth::getInstance()->getIdentity());
    }
    
}
