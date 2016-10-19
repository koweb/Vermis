<?php

/**
 * =============================================================================
 * @file        Validate/Project/ComponentTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
