<?php

/**
 * =============================================================================
 * @file        Project/Issue/CommentTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: CommentTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_Issue_CommentTest
 */
class Project_Issue_CommentTest extends Test_PHPUnit_DbTestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupTranslator(); 
    }

    public function testCase()
    {
        $comment = new Project_Issue_Comment;
        $this->markTestIncomplete();
    }
    
}
