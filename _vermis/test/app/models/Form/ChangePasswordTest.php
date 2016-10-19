<?php

/**
 * =============================================================================
 * @file        Form/ChangePasswordTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ChangePasswordTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
