<?php

/**
 * =============================================================================
 * @file        Validate/Project/MilestoneTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MilestoneTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Validate_Project_MilestoneTest
 */
class Validate_Project_MilestoneTest extends Test_PHPUnit_DbTestCase 
{
    
    public function testSuite()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $validator = new Validate_Project_Milestone($project->id);
        $this->assertFalse($validator->isValid('0.1'));
        $this->assertTrue($validator->isValid('new milestone'));
    }
    
}
