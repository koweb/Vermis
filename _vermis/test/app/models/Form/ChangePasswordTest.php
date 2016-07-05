<?php

/**
 * =============================================================================
 * @file        Form/ChangePasswordTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ChangePasswordTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_ChangePasswordTest
 */
class Form_ChangePasswordTest extends Test_PHPUnit_TestCase 
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
        $form = new Form_ChangePassword();
        $this->assertEquals(4, count($form->getElements()));
        $this->assertNotNull($form->getElement('old_password'));
        $this->assertNotNull($form->getElement('new_password'));
        $this->assertNotNull($form->getElement('password_repeat'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
