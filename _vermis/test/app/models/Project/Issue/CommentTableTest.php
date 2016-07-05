<?php

/**
 * =============================================================================
 * @file        Project/Issue/CommentTableTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: CommentTableTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_Issue_CommentTableTest
 */
class Project_Issue_CommentTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    protected $_project = null;
    protected $_issue = null;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_table = Doctrine::getTable('Project_Issue_Comment');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');   
        $this->_issue = Doctrine::getTable('Project_Issue')->fetchIssue($this->_project->id, 1);
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof Project_Issue_CommentTable);
    }
    
    public function testGetIssuesCommentsQuery()
    {
        $query = $this->_table->getIssueCommentsQuery($this->_issue->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $comments = $query->execute();
        $this->assertTrue(count($comments) > 0);
        foreach ($comments as $comment) {
            $this->assertEquals($this->_issue->id, $comment['issue_id']);
        }
    }
        
}
