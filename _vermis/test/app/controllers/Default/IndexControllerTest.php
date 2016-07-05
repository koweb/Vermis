<?php

/**
 * =============================================================================
 * @file        Default/IndexControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IndexControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Default_IndexControllerTest
 */
class Default_IndexControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function testIndexAction_Guest()
    {
        $controller = $this->getController('IndexController');
        $controller->indexAction();
        
        // Only public projects on the projects list.
        $this->assertTrue(is_array($controller->view->identityProjects));
        $this->assertEquals(6, count($controller->view->identityProjects));
        foreach ($controller->view->identityProjects as $project) {
            $this->assertFalse($project['is_private']);
        }
        
        // Only public projects on the activity list.
        $this->assertTrue(is_array($controller->view->activity));
        $this->assertTrue(count($controller->view->activity) > 0);
        foreach ($controller->view->activity as $a) {
            $project = Doctrine::getTable('Project')->find($a['project_id']);
            $this->assertFalse($project->is_private);
        }

        $this->assertTrue(
            $controller->view->latestGrid 
            instanceof Grid_Project_Issues_Latest);
    }
    
    public function testIndexAction_User()
    {
        $this->login('test-user1', 'xxx');
        $controller = $this->getController('IndexController');
        $controller->indexAction();
        
        // My projects on the projects list.
        $this->assertTrue(is_array($controller->view->identityProjects));
        $this->assertEquals(6, count($controller->view->identityProjects));
        foreach ($controller->view->identityProjects as $project) {
            $this->assertTrue($controller->getIdentity()->isMemberOf($project['id']));
        }
        
        // My projects on the activity list.
        $this->assertTrue(is_array($controller->view->activity));
        $this->assertTrue(count($controller->view->activity) > 0);
        foreach ($controller->view->activity as $a) {
            $this->assertTrue($controller->getIdentity()->isMemberOf($a['project_id']));
        }

        $this->assertTrue(
            $controller->view->myGrid 
            instanceof Grid_Project_Issues_My);
    }
    
}
