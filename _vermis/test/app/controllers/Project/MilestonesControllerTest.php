<?php

/**
 * =============================================================================
 * @file        Project/MilestonesControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MilestonesControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_MilestonesControllerTest
 */
class Project_MilestonesControllerTest extends Test_PHPUnit_ControllerTestCase 
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
        $controller = $this->getController('Project_MilestonesController');
        $controller->indexAction();
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertEquals($this->_project->slug, $controller->view->project->slug);
        $this->assertTrue(
            $controller->view->milestonesGrid 
            instanceof Grid_Project_Milestones);
    }
    
    public function testNewAction_Success()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'        => 'version 0.4',
            	'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Milestone);
        $this->assertTrue($controller->view->success);
        
        $milestone = Doctrine::getTable('Project_Milestone')
            ->fetchMilestone($this->_project->id, 'version-0-4');
            
        $this->assertTrue($milestone instanceof Project_Milestone);
        $this->assertEquals($milestone->name, 'version 0.4');
        
        $this->assertEquals($milestone->author_id, $controller->getIdentity()->id);
        $this->assertEquals($milestone->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($milestone->create_time == $milestone->update_time);
    }
    
    public function testNewAction_Fail()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'        => '0.1',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Milestone);
        $this->assertFalse($controller->view->success);        
    }
    
    public function testNewAction_NameTooLongFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'        => $name,
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Milestone);
        $this->assertFalse($controller->view->success);        
    }
    
    public function testShowAction()
    {
        $this->getRequest()->setParam('milestone_slug', '0-1');
        $controller = $this->getController('Project_MilestonesController');
        $controller->showAction();
        $this->assertTrue($controller->view->milestone instanceof Project_Milestone);
        $this->assertEquals($controller->view->milestone->name, '0.1');
        $this->assertTrue(
            $controller->view->issuesGrid 
            instanceof Grid_Project_Issues_Milestone);
    }
    
    public function testEditAction_OldNameSuccess()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('milestone_slug', '0-1')
            ->setPost(array(
                'name'        => '0.1',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->editAction();
        $this->assertTrue($controller->view->milestone instanceof Project_Milestone);
        $this->assertEquals($controller->view->milestone->name, '0.1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Milestone);
        $this->assertTrue($controller->view->success);

        $milestone = $controller->view->milestone;
        $this->assertEquals($milestone->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($milestone->create_time <= $milestone->update_time);
    }
    
    public function testEditAction_NewNameSuccess()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('milestone_slug', '0-1')
            ->setPost(array(
                'name'        => '0.4',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->editAction();
        $this->assertTrue($controller->view->milestone instanceof Project_Milestone);
        $this->assertEquals($controller->view->milestone->name, '0.4');
        $this->assertTrue($controller->view->form instanceof Form_Project_Milestone);
        $this->assertTrue($controller->view->success);

        $milestone = Doctrine::getTable('Project_Milestone')
            ->fetchMilestone($this->_project->id, '0-4');
            
        $this->assertTrue($milestone instanceof Project_Milestone);
        $this->assertEquals($milestone->name, '0.4');

        $this->assertEquals($milestone->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($milestone->create_time <= $milestone->update_time);
    }
    
    public function testEditAction_Fail()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('milestone_slug', '0-1')
            ->setPost(array(
                'name'        => '0.2',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->editAction();
        $this->assertTrue($controller->view->milestone instanceof Project_Milestone);
        $this->assertEquals($controller->view->milestone->name, '0.1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Milestone);
        $this->assertFalse($controller->view->success);
    }
    
    public function testEditAction_NameTooLongFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('milestone_slug', '0-1')
            ->setPost(array(
                'name'        => $name,
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->editAction();
        $this->assertTrue($controller->view->milestone instanceof Project_Milestone);
        $this->assertEquals($controller->view->milestone->name, '0.1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Milestone);
        $this->assertFalse($controller->view->success);
    }
    
    public function testDeleteAction()
    {
        $this->getRequest()->setParam('milestone_slug', '0-1');
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->deleteAction();

        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $milestone = Doctrine::getTable('Project_Milestone')
            ->fetchMilestone($project->id, '0-1');
        $this->assertFalse($milestone);
    }
    
    public function testHistoryAction()
    {
        $this->getRequest()->setParam('milestone_slug', '0-1');
            
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $milestone = Doctrine::getTable('Project_Milestone')
            ->fetchMilestone($project->id, '0-1');
        $milestone->description = 'xxx';
        $milestone->save();
            
        $controller = $this->getController('Project_MilestonesController');
        $controller->historyAction();
        
        $changes = $controller->view->changes;
        $this->assertType('array', $changes);
        $this->assertEquals(2, count($changes));
        $this->assertEquals('xxx', $changes[0]['description']);
    }
    
    public function testFetchMilestone()
    {
        $this->getRequest()->setParam('milestone_slug', '0-1');
        $controller = $this->getController('Project_MilestonesController');
        $milestone = $controller->fetchMilestone();
        $this->assertTrue($milestone instanceof Project_Milestone);
        $this->assertEquals('0-1', $milestone->slug);
        $this->assertEquals('0.1', $milestone->name);
        $this->assertEquals($this->_project->id, $milestone->project_id);
    }
    
}
