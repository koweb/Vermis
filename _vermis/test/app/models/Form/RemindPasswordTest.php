<?php

/**
 * =============================================================================
 * @file        Form/RemindPasswordTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: RemindPasswordTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
