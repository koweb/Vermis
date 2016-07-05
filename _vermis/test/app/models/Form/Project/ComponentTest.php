<?php

/**
 * =============================================================================
 * @file        Form/Project/ComponentTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ComponentTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
