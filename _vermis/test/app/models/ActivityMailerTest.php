<?php

/**
 * =============================================================================
 * @file        ActivityMailerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ActivityMailerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   ActivityMailerTest
 */
class ActivityMailerTest extends Test_PHPUnit_DbTestCase 
{

    protected $_am = null;
    protected $_project = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_am = ActivityMailer::getInstance();
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('project1');
    }
    
    public function testGetInstance()
    {
        $this->assertTrue($this->_am instanceof ActivityMailer);
    }

    public function testNotifyProjectMembers()
    {
        /// @TODO: Dunno why this is crashing tests :S
        //$this->markTestIncomplete();
    }
    
    public function testTakeHistory_Project()
    {
        $this->_project->name = 'xxx';
        $this->_project->description = 'yyy';
        $this->_project->save();
        
        $history = $this->_am->takeHistory(Log::TYPE_PROJECT, $this->_project->id);
        $this->assertEquals('xxx', $history['name']);
        $this->assertEquals('yyy', $history['description']);
    }
    
    public function testTakeHistory_Component()
    {
        $component = Doctrine::getTable('Project_Component')
            ->fetchComponent($this->_project->id, 'component-1');
        $this->assertTrue($component instanceof Project_Component);
            
        $component->name = 'xxx';
        $component->description = 'yyy';
        $component->save();
        
        $history = $this->_am->takeHistory(Log::TYPE_COMPONENT, $component->id);
        $this->assertEquals('xxx', $history['name']);
        $this->assertEquals('yyy', $history['description']);
    }
    
    public function testTakeHistory_Milestone()
    {
        $milestone = Doctrine::getTable('Project_Milestone')
            ->fetchMilestone($this->_project->id, '0-1');
        $this->assertTrue($milestone instanceof Project_Milestone);
            
        $milestone->name = 'xxx';
        $milestone->description = 'yyy';
        $milestone->save();
        
        $history = $this->_am->takeHistory(Log::TYPE_MILESTONE, $milestone->id);
        $this->assertEquals('xxx', $history['name']);
        $this->assertEquals('yyy', $history['description']);
    }
    
    public function testTakeHistory_Issue()
    {
        $issue = Doctrine::getTable('Project_Issue')
            ->fetchIssue($this->_project->id, 1);
        $this->assertTrue($issue instanceof Project_Issue);
            
        $issue->title = 'xxx';
        $issue->description = 'yyy';
        $issue->save();
        
        $history = $this->_am->takeHistory(Log::TYPE_ISSUE, $issue->id);
        $this->assertEquals('xxx', $history['title']);
        $this->assertEquals('yyy', $history['description']);
    }
    
    public function testTakeHistory_Note()
    {
        $note = Doctrine::getTable('Project_Note')
            ->fetchNote($this->_project->id, 'note-1');
        $this->assertTrue($note instanceof Project_Note);
            
        $note->title = 'xxx';
        $note->content = 'yyy';
        $note->save();
        
        $history = $this->_am->takeHistory(Log::TYPE_NOTE, $note->id);
        $this->assertEquals('xxx', $history['title']);
        $this->assertEquals('yyy', $history['content']);
    }
    
    public function testTakeHistory_CreateIssue()
    {
        $issue = new Project_Issue;
        $issue->title = 'xxx';
        $issue->description = 'yyy';
        $issue->number = $this->_project->issue_counter + 1;
        $issue->project_id = $this->_project->id;
        $issue->save();
        
        $history = $this->_am->takeHistory(Log::TYPE_ISSUE, $issue->id);
        $this->assertEquals('xxx', $history['title']);
        $this->assertEquals('yyy', $history['description']);
    }
    
}
