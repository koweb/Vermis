<?php

/**
 * =============================================================================
 * @file        Project/Issues/CommentsControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: CommentsControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_Issues_CommentsControllerTest
 */
class Project_Issues_CommentsControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    protected $_project = null;
    protected $_issue = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->login('admin', 'admin');
        
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $this->getRequest()->setParam('project_slug', $this->_project->slug);
        
        $this->_issue = Doctrine::getTable('Project_Issue')->fetchIssue($this->_project->id, 1);
        $this->getRequest()->setParam('issue_number', $this->_issue->number);
    }
    
    public function testAddAction()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(array(
                'content' => 'test content'
            ));
            
        $controller = $this->getController('Project_Issues_CommentsController');
        $controller->addAction();
        $this->assertTrue($controller->view->success);

        $comments = $this->_issue->getCommentsQuery()
            ->orderBy('c.id DESC')
            ->limit(1)
            ->execute();
        $this->assertEquals(1, count($comments));
        $this->assertEquals('test content', $comments[0]['content']);
        $this->assertEquals($this->_issue->id, $comments[0]['issue_id']);
        $this->assertEquals($controller->getIdentity()->id, $comments[0]['author_id']);
    }
    
    public function testDeleteAction()
    {
        $comments = $this->_issue->getCommentsQuery()
            ->limit(1)
            ->execute();
            
        $this->assertEquals(1, count($comments));
        
        $this->getRequest()->setParam('comment_id', $comments[0]['id']);
        $controller = $this->getController('Project_Issues_CommentsController');
        $controller->deleteAction();
        
        $comment = Doctrine::getTable('Project_Issue_Comment')->find($comments[0]['id']);
        $this->assertFalse($comment);
    }
    
}
