<?php

/**
 * =============================================================================
 * @file        Validate/Project/NoteTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: NoteTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Validate_Project_NoteTest
 */
class Validate_Project_NoteTest extends Test_PHPUnit_DbTestCase 
{
    
    public function testSuite()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $validator = new Validate_Project_Note($project->id);
        $this->assertFalse($validator->isValid('note 1'));
        $this->assertTrue($validator->isValid('new note'));
    }
    
}
