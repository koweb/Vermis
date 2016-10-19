<?php

/**
 * =============================================================================
 * @file        ProjectTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProjectTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   ProjectTest
 */
class ProjectTest extends Test_PHPUnit_DbTestCase 
{

	protected $_project = null;
	
	public function setUp()
	{
		parent::setUp();
		$this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');
	}
	
    public function testGetMembersQuery()
    {
        $query = $this->_project->getMembersQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $users = $query->execute();
        $this->assertEquals(2, count($users));
        $this->assertEquals('test-user1', $users[0]['user']['login']);
        $this->assertEquals('test-user2', $users[1]['user']['login']);
    }
    
    public function testGetNonMembersQuery()
    {
        $query = $this->_project->getNonMembersQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $users = $query->execute();
        $this->assertEquals(2, count($users));
        $this->assertEquals('admin', $users[0]['login']);
    }
    
    public function testGetNonMembersCount()
    {
        $count = $this->_project->getNonMembersCount();
		$this->assertEquals(2, $count);
    }
    
    public function testGetLeadersQuery()
    {
        $query = $this->_project->getLeadersQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        /// @TODO: Process isolation bug!
    	//$this->markTestIncomplete();
    }
    
    public function testGetDevelopersQuery()
    {
        $query = $this->_project->getDevelopersQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        /// @TODO: Process isolation bug!
    	//$this->markTestIncomplete();
    }
    
    public function testGetObserversQuery()
    {
        $query = $this->_project->getObserversQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        /// @TODO: Process isolation bug!
    	//$this->markTestIncomplete();
    }
    
    public function testGetMilestonesQuery()
    {
        $query = $this->_project->getMilestonesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $milestones = $query->execute();
        $this->assertEquals(3, count($milestones));
        $this->assertEquals('0.1', $milestones[2]['name']);
    }
    
    public function testGetComponentsQuery()
    {
        $query = $this->_project->getComponentsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $components = $query->execute();
        $this->assertEquals(3, count($components));
        $this->assertEquals('component 1', $components[0]['name']);
    }
    
    public function testGetIssuesQuery()
    {
        $query = $this->_project->getIssuesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $issues = $query->execute();
        $this->assertEquals(4, count($issues));
        $this->assertEquals('other issue', $issues[1]['title']);
    }
    
    public function testGetActivityQuery()
    {
        $query = $this->_project->getActivityQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $activity = $query->execute();
        foreach ($activity as $record) {
        	$this->assertEquals($this->_project->id, $record['project_id']);
        	$this->assertEquals($this->_project->name, $record['project']['name']);
        }
    }
    
    public function testGetNotesQuery()
    {
        $query = $this->_project->getNotesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $notes = $query->execute();
        $this->assertEquals(3, count($notes));
        $this->assertEquals('note 1', $notes[0]['title']);
    }
    
    public function testFetchVersions()
    {
        $this->_project->name = 'abc';
        $this->_project->description = 'def';
        $this->_project->save();
        
        $versions = $this->_project->fetchVersions();
        
        $this->assertTrue(is_array($versions));
        $this->assertEquals(2, count($versions));
        
        foreach ($versions as $version) {
            $this->assertArrayHasKey('changer_name', $version);
            $this->assertArrayHasKey('changer_slug', $version);
        }
    }
    
}
