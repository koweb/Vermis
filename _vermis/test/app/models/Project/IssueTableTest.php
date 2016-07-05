<?php

/**
 * =============================================================================
 * @file        Project/IssueTableTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssueTableTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_IssueTableTest
 */
class Project_IssueTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    protected $_project = null;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_table = Doctrine::getTable('Project_Issue');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');   
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof Project_IssueTable);
    }
    
    public function testGetIssuesQuery()
    {
        $query = $this->_table->getIssuesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $issues = $query->execute();
        $this->assertTrue(count($issues) > 0);
    }
    
    public function testGetProjectIssuesQuery()
    {
        $query = $this->_table->getProjectIssuesQuery($this->_project->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $issues = $query->execute();
        $this->assertTrue(count($issues) > 0);
        foreach ($issues as $issue) {
            $this->assertEquals($this->_project->id, $issue['project_id']);
        }
    }
    
    public function testGetUserIssuesQuery()
    {
        $user = Doctrine::getTable('User')->find(1);
        $query = $this->_table->getUserIssuesQuery($user->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $issues = $query->execute();
        $this->assertTrue(count($issues) > 0);
        foreach ($issues as $issue) {
            $this->assertEquals($user->id, $issue['assignee_id']);
        }
    }
    
    public function testGetMilestoneIssuesQuery()
    {
        $milestone = Doctrine::getTable('Project_Milestone')->find(1);
        $query = $this->_table->getMilestoneIssuesQuery($milestone->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $issues = $query->execute();
        $this->assertTrue(count($issues) > 0);
        foreach ($issues as $issue) {
            $this->assertEquals($milestone->id, $issue['milestone_id']);
        }
    }
    
    public function testGetComponentIssuesQuery()
    {
        $component = Doctrine::getTable('Project_Component')->find(1);
        $query = $this->_table->getComponentIssuesQuery($component->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $issues = $query->execute();
        $this->assertTrue(count($issues) > 0);
        foreach ($issues as $issue) {
            $this->assertEquals($component->id, $issue['component_id']);
        }
    }
    
    public function testFetchIssue()
    {
        $issue = $this->_table->fetchIssue($this->_project->id, 1);
        $this->assertTrue($issue instanceof Project_Issue);
        $this->assertEquals('issue 1', $issue->title);     
    }
    
    public function testFetchIssueId()
    {
        $id = $this->_table->fetchIssueId($this->_project->id, 1);
        $issue = $this->_table->find($id);
        $this->assertTrue($issue instanceof Project_Issue);
        $this->assertEquals('issue 1', $issue->title);     
    }
    
}
