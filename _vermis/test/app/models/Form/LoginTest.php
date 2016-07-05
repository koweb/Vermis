<?php

/**
 * =============================================================================
 * @file        Form/LoginTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: LoginTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
