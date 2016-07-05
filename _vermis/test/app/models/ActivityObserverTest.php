<?php

/**
 * =============================================================================
 * @file        ActivityObserverTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ActivityObserverTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   ActivityObserverTest
 * @todo    This test needs to be executed after ControllerTest because of
 *          authorization. 
 */
class ActivityObserverTest extends Test_PHPUnit_DbTestCase 
{

    protected $_ao = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_ao = ActivityObserver::getInstance();
    }
    
    public function testGetInstance()
    {
        $this->assertTrue($this->_ao instanceof ActivityObserver);
    }
    
    public function testNotifyProject()
    {
        $project = Doctrine::getTable('Project')->find(1);
        
        $ao = $this->_ao->notifyProject($project, Log::ACTION_NOTICE);
        $this->assertTrue($ao instanceof ActivityObserver);
        
        $l = $this->_fetchLastLogEntry();
        
        $this->assertEquals($project->id, $l['project_id']);
        $this->assertEquals($project->id, $l['resource_id']);
        $this->assertEquals(Log::TYPE_PROJECT, $l['resource_type']);
        $this->assertEquals(Log::ACTION_NOTICE, $l['action']);
        $this->assertEquals($project->name, $l['message']);

        $params = unserialize($l['params']);
        $this->assertEquals(1, count($params));
        $this->assertEquals($project->slug, $params['project_slug']);
    }
    
    public function testNotifyComponent()
    {
        $component = Doctrine::getTable('Project_Component')->find(1);
        
        $ao = $this->_ao->notifyComponent($component, Log::ACTION_NOTICE);
        $this->assertTrue($ao instanceof ActivityObserver);
        
        $l = $this->_fetchLastLogEntry();
        
        $this->assertEquals($component->project->id, $l['project_id']);
        $this->assertEquals($component->id, $l['resource_id']);
        $this->assertEquals(Log::TYPE_COMPONENT, $l['resource_type']);
        $this->assertEquals(Log::ACTION_NOTICE, $l['action']);
        $this->assertEquals($component->name, $l['message']);

        $params = unserialize($l['params']);
        $this->assertEquals(2, count($params));
        $this->assertEquals($component->project->slug, $params['project_slug']);
        $this->assertEquals($component->slug, $params['component_slug']);
    }
    
    public function testNotifyMilestone()
    {
        $milestone = Doctrine::getTable('Project_Milestone')->find(1);
        
        $ao = $this->_ao->notifyMilestone($milestone, Log::ACTION_NOTICE);
        $this->assertTrue($ao instanceof ActivityObserver);
        
        $l = $this->_fetchLastLogEntry();
        
        $this->assertEquals($milestone->project->id, $l['project_id']);
        $this->assertEquals($milestone->id, $l['resource_id']);
        $this->assertEquals(Log::TYPE_MILESTONE, $l['resource_type']);
        $this->assertEquals(Log::ACTION_NOTICE, $l['action']);
        $this->assertEquals($milestone->name, $l['message']);

        $params = unserialize($l['params']);
        $this->assertEquals(2, count($params));
        $this->assertEquals($milestone->project->slug, $params['project_slug']);
        $this->assertEquals($milestone->slug, $params['milestone_slug']);
    }
    
    public function testNotifyIssue()
    {
        $issue = Doctrine::getTable('Project_Issue')->find(1);
        
        $ao = $this->_ao->notifyIssue($issue, Log::ACTION_NOTICE);
        $this->assertTrue($ao instanceof ActivityObserver);
        
        $l = $this->_fetchLastLogEntry();
        
        $this->assertEquals($issue->project->id, $l['project_id']);
        $this->assertEquals($issue->id, $l['resource_id']);
        $this->assertEquals(Log::TYPE_ISSUE, $l['resource_type']);
        $this->assertEquals(Log::ACTION_NOTICE, $l['action']);
        $this->assertEquals(
            "{$issue->project->name}-{$issue->number} # {$issue->title}", 
            $l['message']);

        $params = unserialize($l['params']);
        $this->assertEquals(3, count($params));
        $this->assertEquals($issue->project->slug, $params['project_slug']);
        $this->assertEquals($issue->slug, $params['issue_slug']);
        $this->assertEquals($issue->number, $params['issue_number']);
    }
    
    public function testNotifyNote()
    {
        $note = Doctrine::getTable('Project_Note')->find(1);
        
        $ao = $this->_ao->notifyNote($note, Log::ACTION_NOTICE);
        $this->assertTrue($ao instanceof ActivityObserver);
        
        $l = $this->_fetchLastLogEntry();
        
        $this->assertEquals($note->project->id, $l['project_id']);
        $this->assertEquals($note->id, $l['resource_id']);
        $this->assertEquals(Log::TYPE_NOTE, $l['resource_type']);
        $this->assertEquals(Log::ACTION_NOTICE, $l['action']);
        $this->assertEquals($note->title, $l['message']);

        $params = unserialize($l['params']);
        $this->assertEquals(2, count($params));
        $this->assertEquals($note->project->slug, $params['project_slug']);
        $this->assertEquals($note->slug, $params['note_slug']);
    }
    
    protected function _fetchLastLogEntry()
    {
        $records = Doctrine::getTable('Log')->getLogQuery()
            ->limit(1)
            ->execute();
        return $records[0];
    }
    
}
