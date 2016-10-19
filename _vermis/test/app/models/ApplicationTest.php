<?php

/**
 * =============================================================================
 * @file        ApplicationTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ApplicationTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
