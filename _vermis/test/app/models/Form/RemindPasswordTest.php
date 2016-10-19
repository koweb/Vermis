<?php

/**
 * =============================================================================
 * @file        Form/RemindPasswordTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: RemindPasswordTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Form_RemindPasswordTest
 */
class Form_RemindPasswordTest extends Test_PHPUnit_TestCase 
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
        $form = new Form_RemindPassword;
        $this->assertEquals(2, count($form->getElements()));
        $this->assertNotNull($form->getElement('email'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
