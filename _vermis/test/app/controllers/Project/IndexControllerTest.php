<?php

/**
 * =============================================================================
 * @file        Project/IndexControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IndexControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_IndexControllerTest
 */
class Project_IndexControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    protected $_project = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->login('admin', 'admin');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');
        $this->getRequest()->setParam('project_slug', $this->_project->slug);
    }
    
    public function testAccessDenied()
    {
        $this->login('test-user1', 'xxx');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project6');
        $this->getRequest()->setParam('project_slug', $this->_project->slug);

        $this->setExpectedException('FreeCode_Exception_AccessDenied');
        
        $controller = $this->getController('Project_IndexController');
        $controller->indexAction();
    }
    
    public function testIndexAction()
    {
        $controller = $this->getController('Project_IndexController');
        $controller->indexAction();
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertEquals($this->_project->slug, $controller->view->project->slug);
        
        $this->assertTrue(is_array($controller->view->milestones));
        $this->assertTrue(is_array($controller->view->components));
        $this->assertTrue(is_array($controller->view->leaders));
        $this->assertTrue(is_array($controller->view->developers));
        $this->assertTrue(is_array($controller->view->observers));

        $this->assertTrue(
            $controller->view->myGrid 
            instanceof Grid_Project_Issues_My);
            
        $this->assertTrue(is_array($controller->view->activity));
        $this->assertTrue(count($controller->view->activity) > 0);
        foreach ($controller->view->activity as $a) {
            $this->assertEquals($this->_project->id, $a['project_id']);
        }
    }
    
    public function testEditAction_NewNameSuccess()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'          => 'project name',
                'description'   => 'some description'
            ));
            
        $controller = $this->getController('Project_IndexController');
        $controller->editAction();
        $this->assertTrue($controller->view->form instanceof Form_Project);
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertTrue($controller->view->success);
        
        $project = Doctrine::getTable('Project')->findOneByName('project name');
        $this->assertTrue($project instanceof Project);
        $this->assertEquals($project->name, 'project name');
        $this->assertEquals($project->slug, 'project-name');
        $this->assertEquals($project->description, 'some description');

        $this->assertEquals($controller->getIdentity()->id, $project->changer_id);
        $this->assertTrue($project->create_time <= $project->update_time);
    }
    
    public function testEditAction_OldNameSuccess()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'          => 'Project1',
                'description'   => 'some description'
            ));
            
        $controller = $this->getController('Project_IndexController');
        $controller->editAction();
        $this->assertTrue($controller->view->form instanceof Form_Project);
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertTrue($controller->view->success);
        
        $project = Doctrine::getTable('Project')->findOneByName('Project1');
        $this->assertTrue($project instanceof Project);
        $this->assertEquals($project->name, 'Project1');
        $this->assertEquals($project->slug, 'Project1');
        $this->assertEquals($project->description, 'some description');

        $this->assertEquals($controller->getIdentity()->id, $project->changer_id);
        $this->assertTrue($project->create_time <= $project->update_time);
    }
    
    public function testEditAction_Fail()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'          => 'Project2',
                'description'   => 'some description'
            ));
            
        $controller = $this->getController('Project_IndexController');
        $controller->editAction();
        $this->assertTrue($controller->view->form instanceof Form_Project);
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertFalse($controller->view->success);
    }
    
    public function testEditAction_TooLongNameFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'          => $name,
                'description'   => 'some description'
            ));
            
        $controller = $this->getController('Project_IndexController');
        $controller->editAction();
        $this->assertTrue($controller->view->form instanceof Form_Project);
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertFalse($controller->view->success);
    }
    
    public function testDeleteAction()
    {
        $countBefore = Doctrine::getTable('Project')->count();
        $controller = $this->getController('Project_IndexController');
        $controller->deleteAction();
        $this->assertEquals(Doctrine::getTable('Project')->count(), $countBefore - 1);
        
        // Check if all issues were removed.
        $issues = Doctrine::getTable('Project_Issue')
            ->getProjectIssuesQuery($this->_project->id)
            ->execute();
        $this->assertEquals(0, count($issues));

        // Check if all components were removed.
        $components = Doctrine::getTable('Project_Component')
            ->getProjectComponentsQuery($this->_project->id)
            ->execute();
        $this->assertEquals(0, count($components));

        // Check if all milestones were removed.
        $milestones = Doctrine::getTable('Project_Milestone')
            ->getProjectMilestonesQuery($this->_project->id)
            ->execute();
        $this->assertEquals(0, count($milestones));

        // Check if all members were removed.
        $members = Doctrine::getTable('Project_Member')
            ->getProjectMembersQuery($this->_project->id)
            ->execute();
        $this->assertEquals(0, count($members));
    }
    
    public function testHistoryAction()
    {
        $this->_project->description = 'xxx';
        $this->_project->save();
        
        $controller = $this->getController('Project_IndexController');
        $controller->historyAction();
        $changes = $controller->view->changes;
        
        $this->assertTrue(is_array($changes));
        $this->assertEquals(2, count($changes));
        
        $this->assertEquals($this->_project->id, $changes[0]['id']);
        $this->assertEquals($controller->getIdentity()->id, $changes[0]['changer_id']);
        $this->assertEquals('xxx', $changes[0]['description']);
        $this->assertEquals('Admin-User', $changes[0]['changer_slug']);
    }
        
}
