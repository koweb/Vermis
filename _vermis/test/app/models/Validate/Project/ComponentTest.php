<?php

/**
 * =============================================================================
 * @file        Validate/Project/ComponentTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ComponentTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Validate_Project_ComponentTest
 */
class Validate_Project_ComponentTest extends Test_PHPUnit_DbTestCase 
{
    
    public function testSuite()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $validator = new Validate_Project_Component($project->id);
        $this->assertFalse($validator->isValid('component 1'));
        $this->assertTrue($validator->isValid('new component'));
    }
    
}
