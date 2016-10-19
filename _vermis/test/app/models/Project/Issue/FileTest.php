<?php

/**
 * =============================================================================
 * @file        Project/Issue/FileTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: FileTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_Issue_FileTest
 */
class Project_Issue_FileTest extends Test_PHPUnit_DbTestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupTranslator(); 
    }

    public function testCase()
    {
        $file = new Project_Issue_File;
        $this->markTestIncomplete();
    }
    
    public function download()
    {
        $this->markTestIncomplete();
    }
    
}
