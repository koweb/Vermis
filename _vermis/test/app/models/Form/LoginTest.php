<?php

/**
 * =============================================================================
 * @file        Form/LoginTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: LoginTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Form_LoginTest
 */
class Form_LoginTest extends Test_PHPUnit_TestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()
            ->setupConfig()
            ->setupTranslator();
    }
    
    public function testSuite()
    {
        $form = new Form_Login;
        $this->assertEquals(3, count($form->getElements()));
        $this->assertNotNull($form->getElement('login'));
        $this->assertNotNull($form->getElement('password'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
