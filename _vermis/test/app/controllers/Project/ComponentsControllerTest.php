<?php

/**
 * =============================================================================
 * @file        Project/ComponentsControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ComponentsControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_ComponentsControllerTest
 */
class Project_ComponentsControllerTest extends Test_PHPUnit_ControllerTestCase 
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
        $controller = $this->getController('Project_ComponentsController');
        $controller->indexAction();
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertEquals($this->_project->slug, $controller->view->project->slug);
        $this->assertTrue(
            $controller->view->componentsGrid 
            instanceof Grid_Project_Components);
    }
    
    public function testNewAction_Success()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'        => 'component 4',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Component);
        $this->assertTrue($controller->view->success);
        
        $component = Doctrine::getTable('Project_Component')
            ->fetchComponent($this->_project->id, 'component-4');
            
        $this->assertTrue($component instanceof Project_Component);
        $this->assertEquals($component->name, 'component 4');

        $this->assertEquals($component->author_id, $controller->getIdentity()->id);
        $this->assertEquals($component->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($component->create_time == $component->update_time);
    }
    
    public function testNewAction_Fail()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'        => 'component 1',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Component);
        $this->assertFalse($controller->view->success);        
    }
    
    public function testNewAction_TooLongNameFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'name'        => $name,
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Component);
        $this->assertFalse($controller->view->success);        
    }
    
    public function testShowAction()
    {
        $this->getRequest()->setParam('component_slug', 'component-1');
        $controller = $this->getController('Project_ComponentsController');
        $controller->showAction();
        $this->assertTrue($controller->view->component instanceof Project_Component);
        $this->assertEquals($controller->view->component->name, 'component 1');
        $this->assertTrue(
            $controller->view->issuesGrid 
            instanceof Grid_Project_Issues_Component);
    }
    
    public function testEditAction_OldNameSuccess()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('component_slug', 'component-1')
            ->setPost(array(
                'name'        => 'component 1',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->editAction();
        $this->assertTrue($controller->view->component instanceof Project_Component);
        $this->assertEquals($controller->view->component->name, 'component 1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Component);
        $this->assertTrue($controller->view->success);

        $component = $controller->view->component;
        $this->assertEquals($component->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($component->create_time <= $component->update_time);
    }
    
    public function testEditAction_NewNameSuccess()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('component_slug', 'component-1')
            ->setPost(array(
                'name'        => 'component 4',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->editAction();
        $this->assertTrue($controller->view->component instanceof Project_Component);
        $this->assertEquals($controller->view->component->name, 'component 4');
        $this->assertTrue($controller->view->form instanceof Form_Project_Component);
        $this->assertTrue($controller->view->success);

        $component = Doctrine::getTable('Project_Component')
            ->fetchComponent($this->_project->id, 'component-4');
            
        $this->assertTrue($component instanceof Project_Component);
        $this->assertEquals($component->name, 'component 4');
        
        $this->assertEquals($component->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($component->create_time <= $component->update_time);
    }
    
    public function testEditAction_Fail()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('component_slug', 'component-1')
            ->setPost(array(
                'name'        => 'component 2',
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->editAction();
        $this->assertTrue($controller->view->component instanceof Project_Component);
        $this->assertEquals($controller->view->component->name, 'component 1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Component);
        $this->assertFalse($controller->view->success);
    }
    
    public function testEditAction_NameTooLongFail()
    {
        $name = str_repeat('abc', 100); // 300 characters.
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('component_slug', 'component-1')
            ->setPost(array(
                'name'        => $name,
                'description' => 'some description'
            ));
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->editAction();
        $this->assertTrue($controller->view->component instanceof Project_Component);
        $this->assertEquals($controller->view->component->name, 'component 1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Component);
        $this->assertFalse($controller->view->success);
    }
    
    public function testDeleteAction()
    {
        $this->getRequest()->setParam('component_slug', 'component-1');
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->deleteAction();

        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $component = Doctrine::getTable('Project_Component')
            ->fetchComponent($project->id, 'component-1');
        $this->assertFalse($component);
    }
    
    public function testHistoryAction()
    {
        $this->getRequest()->setParam('component_slug', 'component-1');
            
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $component = Doctrine::getTable('Project_Component')
            ->fetchcomponent($project->id, 'component-1');
        $component->description = 'xxx';
        $component->save();
            
        $controller = $this->getController('Project_ComponentsController');
        $controller->historyAction();
        
        $changes = $controller->view->changes;
        $this->assertType('array', $changes);
        $this->assertEquals(2, count($changes));
        $this->assertEquals('xxx', $changes[0]['description']);
    }
    
    public function testFetchComponent()
    {
        $this->getRequest()->setParam('component_slug', 'component-1');
        $controller = $this->getController('Project_ComponentsController');
        $component = $controller->fetchComponent();
        $this->assertTrue($component instanceof Project_Component);
        $this->assertEquals('component-1', $component->slug);
        $this->assertEquals('component 1', $component->name);
        $this->assertEquals($this->_project->id, $component->project_id);
    }
        
}
