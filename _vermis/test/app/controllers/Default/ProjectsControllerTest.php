<?php

/**
 * =============================================================================
 * @file        Default/ProjectsControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ProjectsControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Default_ProjectsControllerTest
 */
class Default_ProjectsControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function testIndexAction()
    {
        $controller = $this->getController('ProjectsController');
        $controller->indexAction();
        $this->assertTrue(
            $controller->view->projectsGrid instanceof Grid_Projects);
    }
    
    public function testIndexAction_User()
    {
        $this->login('test-user1', 'xxx');
        $controller = $this->getController('ProjectsController');
        $controller->indexAction();
        $this->assertTrue(
            $controller->view->projectsGrid instanceof Grid_Projects);
    }
    
    public function testIndexAction_Admin()
    {
        $this->login('admin', 'admin');
        $controller = $this->getController('ProjectsController');
        $controller->indexAction();
        $this->assertTrue(
            $controller->view->projectsGrid instanceof Grid_Projects);
    }
    
    public function testNewAction_Success()
    {
        $this->login('admin', 'admin');
        
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'          => 'project name',
                'description'   => 'some description',
                'join_project'  => 1
            ));
            
        $controller = $this->getController('ProjectsController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project);
        $this->assertTrue($controller->view->success);
        
        // Check if project exists.
        $project = Doctrine::getTable('Project')->findOneByName('project name');
        $this->assertTrue($project instanceof Project);
        $this->assertEquals($project->name, 'project name');
        $this->assertEquals($project->slug, 'project-name');
        $this->assertEquals($project->description, 'some description');
        
        // Check if current identity is a member of this project.
        $isMember = false;
        $members = $project->getMembersQuery()->execute();
        foreach ($members as $m) {
            if ($m['user_id'] == $controller->getIdentity()->id)
                $isMember = true;
        }
        $this->assertTrue($isMember);
        
        $this->assertEquals($controller->getIdentity()->id, $project->author_id);
        $this->assertEquals($controller->getIdentity()->id, $project->changer_id);
        $this->assertTrue($project->create_time == $project->update_time);
    }
    
    public function testNewAction_DontJoinSuccess()
    {
        $this->login('admin', 'admin');
        
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'          => 'project name',
                'description'   => 'some description',
                'join_project'  => 0
            ));
            
        $controller = $this->getController('ProjectsController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project);
        $this->assertTrue($controller->view->success);
        
        // Check if project exists.
        $project = Doctrine::getTable('Project')->findOneByName('project name');
        $this->assertTrue($project instanceof Project);
        $this->assertEquals($project->name, 'project name');
        $this->assertEquals($project->slug, 'project-name');
        $this->assertEquals($project->description, 'some description');
        
        // Check if current identity is NOT a member of this project.
        $isMember = false;
        $members = $project->getMembersQuery()->execute();
        foreach ($members as $m) {
            if ($m['user_id'] == $controller->getIdentity()->id)
                $isMember = true;
        }
        $this->assertFalse($isMember);
    }
    
    public function testNewAction_Fail()
    {
        $this->login('admin', 'admin');
        
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'          => 'Project1',
                'description'   => 'some description'
            ));
            
        $controller = $this->getController('ProjectsController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project);
        $this->assertFalse($controller->view->success);
    }
    
    public function testNewAction_TooLongNameFail()
    {
        $this->login('admin', 'admin');
        
        $name = str_repeat('abc', 100); // 300 characters.
        
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'          => $name,
                'description'   => 'some description'
            ));
            
        $controller = $this->getController('ProjectsController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project);
        $this->assertFalse($controller->view->success);
    }
    
}
