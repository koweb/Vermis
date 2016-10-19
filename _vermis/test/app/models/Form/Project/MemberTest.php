<?php

/**
 * =============================================================================
 * @file        Form/Project/MemberTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MemberTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
