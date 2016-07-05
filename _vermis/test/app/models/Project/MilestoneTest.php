<?php

/**
 * =============================================================================
 * @file        Project/MilestoneTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MilestoneTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_MilestoneTest
 */
class Project_MilestoneTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_milestone = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_milestone = Doctrine::getTable('Project_Milestone')->find(1);
    }

    public function testGetIssuesQuery()
    {
        $query = $this->_milestone->getIssuesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(count($records) > 0);
        foreach ($records as $record) {
            $this->assertEquals($this->_milestone->id, $record['milestone_id']);
        }
    }
    
    public function testFetchVersions()
    {
        $this->_milestone->description = 'xxx';
        $this->_milestone->save();
        
        $versions = $this->_milestone->fetchVersions();
        $this->assertType('array', $versions);
        $this->assertEquals(2, count($versions));
        $this->assertEquals('xxx', $versions[0]['description']);
    }
    
}
