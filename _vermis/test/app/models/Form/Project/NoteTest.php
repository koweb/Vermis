<?php

/**
 * =============================================================================
 * @file        Form/Project/NoteTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: NoteTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Form_Project_NoteTest
 */
class Form_Project_NoteTest extends Test_PHPUnit_TestCase 
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
        $form = new Form_Project_Note;
        $this->assertEquals(3, count($form->getElements()));
        $this->assertNotNull($form->getElement('title'));
        $this->assertNotNull($form->getElement('content'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
