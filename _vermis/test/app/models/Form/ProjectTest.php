<?php

/**
 * =============================================================================
 * @file        Form/ProjectTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ProjectTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_ProjectTest
 */
class Form_ProjectTest extends Test_PHPUnit_TestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()
            ->setupConfig()
            ->setupTranslator();
    }
    
    public function testNewForm()
    {
        $form = new Form_Project(Form_Project::TYPE_NEW);
        $this->assertEquals(5, count($form->getElements()));
        $this->assertNotNull($form->getElement('name'));
        $this->assertNotNull($form->getElement('description'));
        $this->assertNotNull($form->getElement('join_project'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
    public function testEditForm()
    {
        $form = new Form_Project;
        $this->assertEquals(4, count($form->getElements()));
        $this->assertNotNull($form->getElement('name'));
        $this->assertNotNull($form->getElement('description'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
