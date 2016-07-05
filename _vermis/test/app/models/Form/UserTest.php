<?php

/**
 * =============================================================================
 * @file        Dashboard/Form/UserTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: UserTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_UserTest
 */
class Form_UserTest extends Test_PHPUnit_TestCase 
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
        $form = new Form_User;
        $this->assertEquals(9, count($form->getElements()));
        $this->assertNotNull($form->getElement('login'));
        $this->assertNotNull($form->getElement('role'));
        $this->assertNotNull($form->getElement('password'));
        $this->assertNotNull($form->getElement('password_repeat'));
        $this->assertNotNull($form->getElement('name'));
        $this->assertNotNull($form->getElement('email'));
        $this->assertNotNull($form->getElement('status'));
        $this->assertNotNull($form->getElement('email_notify'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
