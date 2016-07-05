<?php

/**
 * =============================================================================
 * @file        Default/IssuesControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssuesControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Default_IssuesControllerTest
 */
class Default_IssuesControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function testIndexAction_Guest()
    {
        $controller = $this->getController('IssuesController');
        $controller->indexAction();
        
        $grid = $controller->view->issuesGrid;
        $this->assertTrue($grid instanceof Grid_Project_Issues_Navigator);
        
        $rows = $grid->getRows();
        $this->assertEquals(8, count($rows));
        foreach ($rows as $row) {
            $project = Doctrine::getTable('Project')->find($row['project_id']);
            $this->assertFalse($project->is_private);
        }
    }
    
    public function testIndexAction_User()
    {
        $this->login('test-user1', 'xxx');
        
        $controller = $this->getController('IssuesController');
        $controller->indexAction();
        
        $grid = $controller->view->issuesGrid;
        $this->assertTrue($grid instanceof Grid_Project_Issues_Navigator);
        
        $rows = $grid->getRows();
        $this->assertEquals(8, count($rows));
        foreach ($rows as $row) {
            $project = Doctrine::getTable('Project')->find($row['project_id']);
            $this->assertTrue(
                $controller->getIdentity()->isMemberOf($row['project_id']) || 
                !$project->is_private);
        }
    }
    
    public function testNewAction()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $user = Doctrine::getTable('User')->findOneByLogin('test-user3');
        $this->assertTrue($user instanceof User);
        $this->assertFalse($user->isMemberOf($project->id));
        $this->login($user->login, 'xxx');
        
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'project_id'    => $project->id,
                'type'          => Project_Issue::TYPE_BUG,
                'title'         => 'issue title x',
                'description'   => "This is some issue's description !!"
            ));
            
        $controller = $this->getController('IssuesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_SimpleIssue);
        $this->assertTrue($controller->view->success);

        $this->assertTrue($user->isMemberOf($project->id));
    }
    
}
