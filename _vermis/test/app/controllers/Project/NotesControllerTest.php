<?php

/**
 * =============================================================================
 * @file        Project/NotesControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NotesControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_NotesControllerTest
 */
class Project_NotesControllerTest extends Test_PHPUnit_ControllerTestCase 
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
        $controller = $this->getController('Project_NotesController');
        $controller->indexAction();
        $this->assertTrue($controller->view->project instanceof Project);
        $this->assertEquals($this->_project->slug, $controller->view->project->slug);
        $this->assertTrue(
            $controller->view->notesGrid 
            instanceof Grid_Project_Notes);
    }
    
    public function testNewAction_Success()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'title'    => 'note 4',
                'content'  => 'some content'
            ));
            
        $controller = $this->getController('Project_NotesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Note);
        $this->assertTrue($controller->view->success);
        
        $note = Doctrine::getTable('Project_Note')
            ->fetchNote($this->_project->id, 'note-4');
            
        $this->assertTrue($note instanceof Project_Note);
        $this->assertEquals($note->title, 'note 4');

        $this->assertEquals($note->author_id, $controller->getIdentity()->id);
        $this->assertEquals($note->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($note->create_time == $note->update_time);
    }
    
    public function testNewAction_Fail()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'title'   => 'note 1',
                'content' => 'some content'
            ));
            
        $controller = $this->getController('Project_NotesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Note);
        $this->assertFalse($controller->view->success);        
    }
    
    public function testNewAction_TitleTooLongFail()
    {
        $title = str_repeat('abc', 100); // 300 characters.
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'title'   => $title,
                'content' => 'some content'
            ));
            
        $controller = $this->getController('Project_NotesController');
        $controller->newAction();
        $this->assertTrue($controller->view->form instanceof Form_Project_Note);
        $this->assertFalse($controller->view->success);        
    }
    
    public function testShowAction()
    {
        $this->getRequest()->setParam('note_slug', 'note-1');
        $controller = $this->getController('Project_NotesController');
        $controller->showAction();
        $this->assertTrue($controller->view->note instanceof Project_Note);
        $this->assertEquals($controller->view->note->title, 'note 1');
    }
    
    public function testEditAction_OldTitleSuccess()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('note_slug', 'note-1')
            ->setPost(array(
                'title'   => 'note 1',
                'content' => 'some content'
            ));
            
        $controller = $this->getController('Project_NotesController');
        $controller->editAction();
        $this->assertTrue($controller->view->note instanceof Project_Note);
        $this->assertEquals($controller->view->note->title, 'note 1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Note);
        $this->assertTrue($controller->view->success);

        $note = $controller->view->note;
        $this->assertEquals($note->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($note->create_time <= $note->update_time);
    }
    
    public function testEditAction_NewTitleSuccess()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('note_slug', 'note-1')
            ->setPost(array(
                'title'   => 'note 4',
                'content' => 'some content'
            ));
            
        $controller = $this->getController('Project_NotesController');
        $controller->editAction();
        $this->assertTrue($controller->view->note instanceof Project_Note);
        $this->assertEquals($controller->view->note->title, 'note 4');
        $this->assertTrue($controller->view->form instanceof Form_Project_Note);
        $this->assertTrue($controller->view->success);

        $note = Doctrine::getTable('Project_Note')
            ->fetchNote($this->_project->id, 'note-4');
            
        $this->assertTrue($note instanceof Project_Note);
        $this->assertEquals($note->title, 'note 4');
        
        $this->assertEquals($note->changer_id, $controller->getIdentity()->id);
        $this->assertTrue($note->create_time <= $note->update_time);
    }
    
    public function testEditAction_Fail()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('note_slug', 'note-1')
            ->setPost(array(
                'title'   => 'note 2',
                'content' => 'some content'
            ));
            
        $controller = $this->getController('Project_NotesController');
        $controller->editAction();
        $this->assertTrue($controller->view->note instanceof Project_Note);
        $this->assertEquals($controller->view->note->title, 'note 1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Note);
        $this->assertFalse($controller->view->success);
    }
    
    public function testEditAction_TitleTooLongFail()
    {
        $title = str_repeat('abc', 100); // 300 characters.
        $this->getRequest()
            ->setMethod('POST')
            ->setParam('note_slug', 'note-1')
            ->setPost(array(
                'title'   => $title,
                'content' => 'some content'
            ));
            
        $controller = $this->getController('Project_NotesController');
        $controller->editAction();
        $this->assertTrue($controller->view->note instanceof Project_Note);
        $this->assertEquals($controller->view->note->title, 'note 1');
        $this->assertTrue($controller->view->form instanceof Form_Project_Note);
        $this->assertFalse($controller->view->success);
    }
    
    public function testDeleteAction()
    {
        $this->getRequest()->setParam('note_slug', 'note-1');
            
        $controller = $this->getController('Project_NotesController');
        $controller->deleteAction();

        $note = Doctrine::getTable('Project_Note')
            ->fetchNote($this->_project->id, 'note-1');
        $this->assertFalse($note);
    }
    
    public function testFetchComponent()
    {
        $this->getRequest()->setParam('note_slug', 'note-1');
        $controller = $this->getController('Project_NotesController');
        $note = $controller->fetchNote();
        $this->assertTrue($note instanceof Project_Note);
        $this->assertEquals('note-1', $note->slug);
        $this->assertEquals('note 1', $note->title);
        $this->assertEquals($this->_project->id, $note->project_id);
    }
    
}
