<?php

/**
 * =============================================================================
 * @file        Form/Project/ComponentTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Form_Project_ComponentTest
 */
class Form_Project_ComponentTest extends Test_PHPUnit_TestCase 
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
        $form = new Form_Project_Component;
        $this->assertEquals(3, count($form->getElements()));
        $this->assertNotNull($form->getElement('name'));
        $this->assertNotNull($form->getElement('description'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
