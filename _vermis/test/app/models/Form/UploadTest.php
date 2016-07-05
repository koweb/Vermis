<?php

/**
 * =============================================================================
 * @file        Form/UploadTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: UploadTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_UploadTest
 */
class Form_UploadTest extends Test_PHPUnit_TestCase 
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
        $form = new Form_Upload;
        $this->assertTrue($form->isUploadEnabled());
        $this->assertEquals(2, count($form->getElements()));
        $this->assertNotNull($form->getElement('file'));
        $this->assertNotNull($form->getElement('submit'));
    }
    
}
