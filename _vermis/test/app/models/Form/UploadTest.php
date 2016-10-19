<?php

/**
 * =============================================================================
 * @file        Form/UploadTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UploadTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
