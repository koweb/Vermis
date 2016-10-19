<?php

/**
 * =============================================================================
 * @file        Form/EditProfileTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: EditProfileTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Form_EditProfileTest
 */
class Form_EditProfileTest extends Test_PHPUnit_TestCase 
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
        $form = new Form_EditProfile();
        $this->assertEquals(5, count($form->getElements()));
        $this->assertNotNull($form->getElement('login'));
        $this->assertNotNull($form->getElement('name'));
        $this->assertNotNull($form->getElement('email'));
        $this->assertNotNull($form->getElement('email_notify'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
