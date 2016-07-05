<?php

/**
 * =============================================================================
 * @file        ApplicationTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ApplicationTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   ApplicationTest
 */
class ApplicationTest extends Test_PHPUnit_TestCase 
{

    public function testGetInstance()
    {
        $instance = Application::getInstance();
        $this->assertTrue($instance instanceof Application);
    }
    
    public function testExecute()
    {
        $this->markTestIncomplete();
    }
    
    public function testSetupIdentity()
    {
        $this->markTestIncomplete();
    }
    
    public function testSetupTranslator()
    {
        $app = Application::getInstance()->setupConfig();
        
        $app->setupTranslator();
        $this->assertEquals('Project', _T('Project'));

        // @TODO: Incomplete.
    }
    
    public function testIsDemo()
    {
        Zend_Registry::set('environmentName', 'test');
        $instance = Application::getInstance();
        $this->assertFalse($instance->isDemo());
        $env = Zend_Registry::get('environmentName');
        Zend_Registry::set('environmentName', 'demo');
        $this->assertTrue($instance->isDemo());
        Zend_Registry::set('environmentName', $env);
    }
    
}
