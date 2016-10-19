<?php

/**
 * =============================================================================
 * @file        Project/IssueTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
        $this->assertTrue(is_array($versions));
        $this->assertEquals(2, count($versions));
        $this->assertEquals('xxx', $versions[0]['description']);
    }
    
}
