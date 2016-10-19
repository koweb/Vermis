<?php

/**
 * =============================================================================
 * @file        Project/MilestoneTableTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MilestoneTableTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_MilestoneTableTest
 */
class Project_MilestoneTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    protected $_project = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_table = Doctrine::getTable('Project_Milestone');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');   
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof Project_MilestoneTable);
    }
    
    public function testGetProjectMilestonesQuery()
    {
        $query = $this->_table->getProjectMilestonesQuery($this->_project->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $milestones = $query->execute();
        $this->assertEquals(3, count($milestones));
        $this->assertEquals('0.3 beta', $milestones[0]['name']);
        foreach ($milestones as $milestone) {
            $this->assertEquals($this->_project->id, $milestone['project_id']);
        }
        
        $this->assertEquals(0, $milestones[0]['num_issues']);
        $this->assertEquals(1, $milestones[1]['num_issues']);
        $this->assertEquals(3, $milestones[2]['num_issues']);

        foreach ($milestones as $milestone) {
            $this->assertEquals('Admin-User', $milestone['author_slug']);
            $this->assertEquals('Admin User', $milestone['author_name']);
            $this->assertEquals('Admin-User', $milestone['changer_slug']);
            $this->assertEquals('Admin User', $milestone['changer_name']);
        }
    }
    
    public function testMilestoneExists()
    {
        $this->assertTrue($this->_table->milestoneExists($this->_project->id, '0-1'));
        $this->assertFalse($this->_table->milestoneExists($this->_project->id, '0-4'));
    }
    
    public function testFetchMilestone()
    {
        $milestone = $this->_table->fetchMilestone($this->_project->id, '0-1');
        $this->assertTrue($milestone instanceof Project_Milestone);
        $this->assertEquals('0.1', $milestone->name);     
    }
    
    public function testFetchMilestoneId()
    {
        $id = $this->_table->fetchMilestoneId($this->_project->id, '0-1');
        $milestone = $this->_table->find($id);
        $this->assertTrue($milestone instanceof Project_Milestone);
        $this->assertEquals('0.1', $milestone->name);     
    }
    
    public function testFetchMilestonesAsOptions()
    {
        $options = $this->_table->fetchMilestonesAsOptions($this->_project->id);
        $this->assertEquals(4, count($options));
        $this->assertEquals('- any -', $options[0]);
        $this->assertEquals('0.3 beta', $options[3]);
        $this->assertEquals('0.2', $options[2]);
        $this->assertEquals('0.1', $options[1]);
    }
    
}
