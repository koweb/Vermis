<?php

/**
 * =============================================================================
 * @file        Form/Project/NoteTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NoteTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
