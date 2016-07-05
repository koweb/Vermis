<?php

/**
 * =============================================================================
 * @file        Form/CommentTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: CommentTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_CommentTest
 */
class Form_CommentTest extends Test_PHPUnit_TestCase 
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
        $form = new Form_Comment;
        $this->assertEquals(2, count($form->getElements()));
        $this->assertNotNull($form->getElement('content'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
