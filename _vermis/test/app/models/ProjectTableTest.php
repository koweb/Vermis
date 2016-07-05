<?php

/**
 * =============================================================================
 * @file        ProjectTableTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ProjectTableTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   ProjectTableTest
 */
class ProjectTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_table = Doctrine::getTable('Project');
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof ProjectTable);
    }
    
    public function testGetProjectsListQuery()
    {
        $query = $this->_table->getProjectsListQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertEquals(8, count($records));
        
        $this->assertEquals(1, $records[0]['num_issues']);
        $this->assertEquals(1, $records[1]['num_issues']);
        $this->assertEquals(4, $records[2]['num_issues']);
        $this->assertEquals(2, $records[3]['num_issues']);
        
        foreach ($records as $record) {
            $this->assertEquals('Admin-User', $record['author_slug']);
            $this->assertEquals('Admin User', $record['author_name']);
            $this->assertEquals('Admin-User', $record['changer_slug']);
            $this->assertEquals('Admin User', $record['changer_name']);
        }
    }
    
    public function testGetUserProjectsQuery()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user2');
        $query = $this->_table->getUserProjectsQuery($user->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertEquals(5, count($records));
        $this->assertEquals('โครงการ', $records[0]['name']);
        $this->assertEquals('項目', $records[1]['name']);
        $this->assertEquals('Project1', $records[2]['name']);
        $this->assertEquals('Project4', $records[3]['name']);
        $this->assertEquals('Project6', $records[4]['name']);

        $this->assertEquals(4, $records[2]['num_issues']);

        foreach ($records as $record) {
            $this->assertEquals('Admin-User', $record['author_slug']);
            $this->assertEquals('Admin User', $record['author_name']);
            $this->assertEquals('Admin-User', $record['changer_slug']);
            $this->assertEquals('Admin User', $record['changer_name']);
        }
    }
    
    public function testGetAvailableProjectsQuery()
    {
    	$member = Doctrine::getTable('User')->findOneByLogin('test-user1');
        $user = Doctrine::getTable('User')->findOneByLogin('test-user2');
        $query = $this->_table->getCommonProjectsQuery($member->id, $user->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertEquals(5, count($records));
        $this->assertEquals('โครงการ', $records[0]['name']);
        $this->assertEquals('項目', $records[1]['name']);
        $this->assertEquals('Project1', $records[2]['name']);
        $this->assertEquals('Project3', $records[3]['name']);
        $this->assertEquals('Project4', $records[4]['name']);
    }
    
    public function testGetPublicProjectsQuery()
    {
        $query = $this->_table->getPublicProjectsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertEquals(6, count($records));
        $this->assertEquals('โครงการ', $records[0]['name']);
        $this->assertEquals('項目', $records[1]['name']);
        $this->assertEquals('Project1', $records[2]['name']);
        $this->assertEquals('Project2', $records[3]['name']);
        $this->assertEquals('Project3', $records[4]['name']);
        $this->assertEquals('Project4', $records[5]['name']);
    }
    
}
