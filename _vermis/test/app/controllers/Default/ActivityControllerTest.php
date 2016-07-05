<?php

/**
 * =============================================================================
 * @file        Default/ActivityControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ActivityControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Default_ActivityControllerTest
 */
class Default_ActivityControllerTest extends Test_PHPUnit_ControllerTestCase 
{
    
    public function testIndexAction_Guest()
    {
        
        $controller = $this->getController('ActivityController');
        $controller->indexAction();
        $this->assertTrue($controller->view->pager instanceof Doctrine_Pager);
        
        // Only public projects on the activity list.
        $this->assertType('array', $controller->view->activity);
        $this->assertTrue(count($controller->view->activity) > 0);
        foreach ($controller->view->activity as $a) {
            $project = Doctrine::getTable('Project')->find($a['project_id']);
            $this->assertFalse($project->is_private);
        }
    }
        
    public function testIndexAction_User()
    {
        $this->login('test-user1', 'xxx');
        $controller = $this->getController('ActivityController');
        $controller->indexAction();
        $this->assertTrue($controller->view->pager instanceof Doctrine_Pager);
        
        // Only public projects on the activity list.
        $this->assertType('array', $controller->view->activity);
        $this->assertTrue(count($controller->view->activity) > 0);
        foreach ($controller->view->activity as $a) {
            $this->assertTrue($controller->getIdentity()->isMemberOf($a['project_id']));
        }
    }
        
}
