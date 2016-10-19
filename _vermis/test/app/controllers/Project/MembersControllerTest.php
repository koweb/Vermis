<?php

/**
 * =============================================================================
 * @file        Project/MembersControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MembersControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_MembersControllerTest
 */
class Project_MembersControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    protected $_project = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->login('admin', 'admin');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $this->getRequest()->setParam('project_slug', $this->_project->slug);
    }
    
    public function testIndexAction()
    {
        $controller = $this->getController('Project_MembersController');
        $controller->indexAction();
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertEquals($this->_project->slug, $controller->view->project->slug);
        $this->assertTrue(
            $controller->view->membersGrid 
            instanceof Grid_Project_Members);
    }
        
    public function testAddAction()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user3');
        
        $this->getRequest()->setParam('user_id', $user->id);
 
        $controller = $this->getController('Project_MembersController');
        $controller->addAction();
        $this->assertTrue(Doctrine::getTable('Project_Member')
            ->memberExists($this->_project->id, $user->id));
    }

    public function testDeleteAction()
    {
        $table = Doctrine::getTable('User');
        $user1 = $table->findOneByLogin('test-user1');
        $user2 = $table->findOneByLogin('test-user2');
        
        $selected = array($user1->id, $user2->id);
        
        $this->getRequest()->setParam('selected', $selected);
            
        $controller = $this->getController('Project_MembersController');
        $controller->deleteAction();
        
        $table = Doctrine::getTable('Project_Member');
        $this->assertFalse($table->memberExists($this->_project->id, $user1->id));
        $this->assertFalse($table->memberExists($this->_project->id, $user2->id));
    }
    
    public function testJoinAction()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        $project = Doctrine::getTable('Project')->findOneBySlug('project2');
        
        // User test-user1 is not a member of project2.
        $this->login('test-user1', 'xxx');
        $this->getRequest()->setParam('project_slug', 'project2');
        
        $controller = $this->getController('Project_MembersController');
        $controller->joinAction();
        $this->assertTrue(Doctrine::getTable('Project_Member')
            ->memberExists($project->id, $user->id));
    }

    public function testJoinAction_AccessDenied()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        
        // User test-user1 is not a member of the private project6.
        $this->login('test-user1', 'xxx');
        $this->getRequest()->setParam('project_slug', 'project6');

        $this->setExpectedException('FreeCode_Exception_AccessDenied');
        $controller = $this->getController('Project_MembersController');
        $controller->joinAction();
    }

    public function testLeaveAction()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        $project = Doctrine::getTable('Project')->findOneBySlug('project5');
        
        // User test-user1 is a member of the private project5.
        $this->login('test-user1', 'xxx');
        $this->getRequest()->setParam('project_slug', 'project5');

        $controller = $this->getController('Project_MembersController');
        $controller->leaveAction();
        $this->assertFalse(Doctrine::getTable('Project_Member')
            ->memberExists($project->id, $user->id));
    }
    
}
