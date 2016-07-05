<?php

/**
 * =============================================================================
 * @file        Project/Issue/FileTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: FileTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
