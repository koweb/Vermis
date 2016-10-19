<?php

/**
 * =============================================================================
 * @file        Project/IssuesControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssuesControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Project_IssuesControllerTest
 */
class Project_IssuesControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    protected $_project = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->login('admin', 'admin');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');
        $this->getRequest()->setParam('project_slug', $this->_project->slug);
    }
    
    public function testIndexAction()
    {
        $controller = $this->getController('Project_IssuesController');
        $controller->indexAction();
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertEquals('Project1', $controller->view->project->slug);
        $this->assertEquals('Project1', $controller->view->project->name);
        $this->assertTrue(
            $controller->view->issuesGrid instanceof Grid_Project_Issues);
    }
    
    public function testIndexAction_Project()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('Project1');
        $this->getRequest()->setParam('project_slug', $project->slug);
        
        $controller = $this->getController('Project_IssuesController');
        $controller->indexAction();
        
        $grid = $controller->view->issuesGrid;
        $this->assertTrue($grid instanceof Grid_Project_Issues_Navigator);
        
        $rows = $grid->getRows();
        $this->assertEquals(4, count($rows));
        foreach ($rows as $row) {
            $this->assertEquals($project->id, $row['project_id']);
        }
    }
    
    public function testNewAction()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user2');
        
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'type'          => Project_Issue::TYPE_BUG,
                'title'         => 'issue title',
                'status'        => Project_Issue::STATUS_RESOLVED,
                'priority'      => Project_Issue::PRIORITY_HIGH,
                'milestone_id'  => 1,
                'assignee_id'   => $user->id,
                'component_id'  => 1,
                'description'   => "This is some issue's description!",
                'progress'      => 60
            ));
            
        $controller = $this->getController('Project_IssuesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Issue);
        $this->assertTrue($controller->view->success);
        
        $issue = Doctrine::getTable('Project_Issue')
            ->fetchIssue($this->_project->id, 5);

        $this->assertTrue($issue instanceof Project_Issue);
        $this->assertEquals($issue->type,           Project_Issue::TYPE_BUG);
        $this->assertEquals($issue->title,          'issue title');
        $this->assertEquals($issue->status,         Project_Issue::STATUS_RESOLVED);
        $this->assertEquals($issue->priority,       Project_Issue::PRIORITY_HIGH);
        $this->assertEquals($issue->milestone_id,   1);
        $this->assertEquals($issue->assignee_id,     $user->id);
        $this->assertEquals($issue->description,    "This is some issue's description!");
        $this->assertEquals($issue->slug,           'issue-title');
        $this->assertEquals($issue->reporter_id, FreeCode_Identity::getInstance()->id);
        
        // Check issue counter incrementation.
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $this->assertEquals(5, $project->issue_counter);

        $this->assertEquals($controller->getIdentity()->id, $issue->reporter_id);
        $this->assertEquals($controller->getIdentity()->id, $issue->changer_id);
        $this->assertTrue($issue->create_time == $issue->update_time);
    }
    
    public function testNewAction_JoinProject()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user3');
        $this->assertTrue($user instanceof User);
        $this->assertFalse($user->isMemberOf($this->_project->id));
        $this->login($user->login, 'xxx');
        
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'type'          => Project_Issue::TYPE_BUG,
                'title'         => 'issue title x',
                'status'        => Project_Issue::STATUS_RESOLVED,
                'priority'      => Project_Issue::PRIORITY_HIGH,
                'milestone_id'  => 1,
                'assignee_id'   => 0,
                'component_id'  => 1,
                'description'   => "This is some issue's description !!",
                'progress'      => 60
            ));
            
        $controller = $this->getController('Project_IssuesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Issue);
        $this->assertTrue($controller->view->success);

        $this->assertTrue($user->isMemberOf($this->_project->id));
    }
    
    public function testShowAction()
    {
        $this->getRequest()
            ->setParam('issue_number', 1)
            ->setParam('issue_slug', 'xxx');

        $controller = $this->getController('Project_IssuesController');
        $controller->showAction();
        $this->assertTrue($controller->view->issue instanceof Project_Issue);
        $this->assertEquals(1, $controller->view->issue->number);
        
        $this->assertTrue($controller->view->commentForm instanceof Form_Comment);
        
        $this->assertTrue(is_array($controller->view->comments));
        $this->assertTrue(count($controller->view->comments) > 0);
        foreach ($controller->view->comments as $comment) {
            $this->assertEquals($controller->view->issue->id, $comment['issue_id']);
        }
        
        $this->assertTrue($controller->view->uploadForm instanceof Form_Upload);
        $this->assertTrue(is_array($controller->view->files));
    }
    
    public function testEditAction()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user2');
        
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('project_slug', 'project1')
            ->setParam('issue_number', 1)
            ->setParam('issue_slug', 'xxx')
            ->setPost(array(
                'type'          => Project_Issue::TYPE_BUG,
                'title'         => 'عنوان شغلی',
                'status'        => Project_Issue::STATUS_RESOLVED,
                'priority'      => Project_Issue::PRIORITY_HIGH,
                'milestone_id'  => 1,
                'assignee_id'   => $user->id,
                'component_id'  => 1,
                'description'   => "This is some issue's description!",
                'progress'      => 30
            ));
            
        $controller = $this->getController('Project_IssuesController');
        $controller->editAction();
        $this->assertTrue($controller->view->issue instanceof Project_Issue);
        $this->assertEquals(1, $controller->view->issue->number);
        $this->assertTrue($controller->view->form instanceof Form_Project_Issue);
        $this->assertTrue($controller->view->success);
        
        $issue = Doctrine::getTable('Project_Issue')
            ->fetchIssue($this->_project->id, 1);

        $this->assertTrue($issue instanceof Project_Issue);
        $this->assertEquals($issue->type,           Project_Issue::TYPE_BUG);
        $this->assertEquals($issue->title,          'عنوان شغلی');
        $this->assertEquals($issue->status,         Project_Issue::STATUS_RESOLVED);
        $this->assertEquals($issue->priority,       Project_Issue::PRIORITY_HIGH);
        $this->assertEquals($issue->milestone_id,   1);
        $this->assertEquals($issue->assignee_id,     $user->id);
        $this->assertEquals($issue->description,    "This is some issue's description!");
        $this->assertEquals($issue->slug,           'عنوان-شغلی');
        
        $this->assertTrue($controller->view->uploadForm instanceof Form_Upload);
        $this->assertTrue(is_array($controller->view->files));

        $this->assertEquals($controller->getIdentity()->id, $issue->changer_id);
        $this->assertTrue($issue->create_time <= $issue->update_time);
        
    }
    
    public function testDeleteAction()
    {
        $this->getRequest()
            ->setParam('issue_number', 1)
            ->setParam('issue_slug', 'xxx');
                        
        $controller = $this->getController('Project_IssuesController');
        $controller->deleteAction();

        $issue = Doctrine::getTable('Project_Issue')
            ->fetchIssue($this->_project->id, 1);
        $this->assertFalse($issue);

        // Ensure that issue_counter has not changed.
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $this->assertEquals(4, $project->issue_counter);
    }
    
    public function testHistoryAction()
    {
        $issue = Doctrine::getTable('Project_Issue')
            ->fetchIssue($this->_project->id, 1);
        $issue->title = 'xxx';
        $issue->save();
        
        $this->getRequest()
            ->setParam('issue_number', 1)
            ->setParam('issue_slug', 'xxx');
                        
        $controller = $this->getController('Project_IssuesController');
        $controller->historyAction();

        $changes = $controller->view->changes;
        $this->assertTrue(is_array($changes));
        $this->assertEquals(2, count($changes));
        $this->assertEquals('xxx', $changes[0]['title']);
    }
    
    public function testFetchIssue()
    {
        $this->getRequest()
            ->setParam('issue_number', 1)
            ->setParam('issue_slug', 'xxx');
        $controller = $this->getController('Project_IssuesController');
        $issue = $controller->fetchIssue();
        $this->assertTrue($issue instanceof Project_Issue);
        $this->assertEquals(1, $issue->number);
        $this->assertEquals('issue 1', $issue->title);
        $this->assertEquals('issue-1', $issue->slug);
        $this->assertEquals($this->_project->id, $issue->project_id);
    }
    
}
