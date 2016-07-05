<?php

/**
 * =============================================================================
 * @file        Project/IssueTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssueTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_IssueTest
 */
class Project_IssueTest extends Test_PHPUnit_DbTestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupTranslator(); 
    }

    public function testGetTypeLabel()
    {
        $this->assertEquals('Task', 
            Project_Issue::getTypeLabel(Project_Issue::TYPE_TASK));
        $this->assertEquals('unknown', Project_Issue::getTypeLabel('unknown'));
    }
    
    public function testGetPriorityLabel()
    {
        $this->assertEquals('Normal', 
            Project_Issue::getPriorityLabel(Project_Issue::PRIORITY_NORMAL));
        $this->assertEquals(123, Project_Issue::getPriorityLabel(123));
    }
    
    public function testGetStatusLabel()
    {
        $this->assertEquals('Opened', 
            Project_Issue::getStatusLabel(Project_Issue::STATUS_OPENED));
        $this->assertEquals('unknown', Project_Issue::getStatusLabel('unknown'));
    }
    
    public function testGetCommentsQuery()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('Project1');
        $issue = Doctrine::getTable('Project_Issue')->fetchIssue($project->id, 1);
        
        $query = $issue->getCommentsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $comments = $query->execute();
        $this->assertTrue(count($comments) > 0);
        foreach ($comments as $comment) {
            $this->assertEquals($issue->id, $comment['issue_id']);
        }
    }
    
    public function testGetFilesQuery()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('Project1');
        $issue = Doctrine::getTable('Project_Issue')->fetchIssue($project->id, 1);
        
        $query = $issue->getFilesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $files = $query->execute();
        $this->assertTrue(count($files) > 0);
        foreach ($files as $file) {
            $this->assertEquals($issue->id, $file['issue_id']);
        }
    }
    
    public function testFetchVersions()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('Project1');
        $issue = Doctrine::getTable('Project_Issue')->fetchIssue($project->id, 1);
        
        $issue->description = "xxx";
        $issue->save();
        
        $versions = $issue->fetchVersions();
        $this->assertType('array', $versions);
        $this->assertEquals(2, count($versions));
        $this->assertEquals('xxx', $versions[0]['description']);
    }
    
}
