<?php

/**
 * =============================================================================
 * @file        Form/ProjectTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProjectTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
