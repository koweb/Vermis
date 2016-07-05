<?php

/**
 * =============================================================================
 * @file        Form/Project/MemberTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MemberTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_Project_MemberTest
 */
class Form_Project_MemberTest extends Test_PHPUnit_DbTestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupTranslator();
    }
    
    public function testSuite()
    {
        $form = new Form_Project_Member(1);
        $this->assertEquals(3, count($form->getElements()));
        $this->assertNotNull($form->getElement('user_id'));
        $this->assertNotNull($form->getElement('role'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
