<?php

/**
 * =============================================================================
 * @file        Default/ActivityControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ActivityControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
        $this->assertTrue(is_array($controller->view->activity));
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
        $this->assertTrue(is_array($controller->view->activity));
        $this->assertTrue(count($controller->view->activity) > 0);
        foreach ($controller->view->activity as $a) {
            $this->assertTrue($controller->getIdentity()->isMemberOf($a['project_id']));
        }
    }
        
}
