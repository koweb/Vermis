<?php

/**
 * =============================================================================
 * @file        Grid/Importer/ProjectsTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProjectsTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Importer_ProjectsTest
 */
class Grid_Importer_ProjectsTest extends Test_PHPUnit_DbTestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupView();
    }
    
    public function testGetCountQuery_Admin()
    {
        $query = $this->_getImporterForUser('admin')->getCountQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $this->assertEquals(8, $query->execute());
    }
    
    public function testGetCountQuery_TestUser1()
    {
        $query = $this->_getImporterForUser('test-user1')->getCountQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $this->assertEquals(7, $query->execute());
    }
    
    public function testGetCountQuery_Guest()
    {
        $query = $this->_getImporterForGuest()->getCountQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $this->assertEquals(6, $query->execute());
    }
    
    public function testGetRecordsQuery_Admin()
    {
        $query = $this->_getImporterForUser('admin')->getRecordsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertEquals(8, count($records));
        
        $this->assertEquals('โครงการ', $records[0]['name']);
        $this->assertEquals('項目', $records[1]['name']);
        $this->assertEquals('Project1', $records[2]['name']);
        $this->assertEquals('Project2', $records[3]['name']);
        $this->assertEquals('Project3', $records[4]['name']);
        $this->assertEquals('Project4', $records[5]['name']);
        $this->assertEquals('Project5', $records[6]['name']);
        $this->assertEquals('Project6', $records[7]['name']);
        
        $this->assertEquals(4, $records[2]['num_issues']);
        $this->assertEquals(2, $records[3]['num_issues']);

        foreach ($records as $record) {
            $this->assertEquals('Admin-User', $record['author_slug']);
            $this->assertEquals('Admin User', $record['author_name']);
            $this->assertEquals('Admin-User', $record['changer_slug']);
            $this->assertEquals('Admin User', $record['changer_name']);
        }
        
    }
    
    public function testGetRecordsQuery_TestUser1()
    {
        $query = $this->_getImporterForUser('test-user1')->getRecordsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertEquals(7, count($records));
        $this->assertEquals('โครงการ', $records[0]['name']);
        $this->assertEquals('項目', $records[1]['name']);
        $this->assertEquals('Project1', $records[2]['name']);
        $this->assertEquals('Project2', $records[3]['name']);
        $this->assertEquals('Project3', $records[4]['name']);
        $this->assertEquals('Project4', $records[5]['name']);
        $this->assertEquals('Project5', $records[6]['name']);
        
        $this->assertEquals(4, $records[2]['num_issues']);
        $this->assertEquals(2, $records[3]['num_issues']);
    }
    
    public function testGetRecordsQuery_Guest()
    {
        $query = $this->_getImporterForGuest()->getRecordsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertEquals(6, count($records));
        $this->assertEquals('โครงการ', $records[0]['name']);
        $this->assertEquals('項目', $records[1]['name']);
        $this->assertEquals('Project1', $records[2]['name']);
        $this->assertEquals('Project2', $records[3]['name']);
        $this->assertEquals('Project3', $records[4]['name']);
        $this->assertEquals('Project4', $records[5]['name']);
        
        $this->assertEquals(4, $records[2]['num_issues']);
        $this->assertEquals(2, $records[3]['num_issues']);
    }
    
    protected function _getImporterForUser($userLogin)
    {
        $user = Doctrine::getTable('User')->findOneByLogin($userLogin);
        $this->assertTrue($user instanceof User);
        $grid = new Grid_Projects(array(
            'userId' => ($user->isAdmin() ? null : $user->id)
        ));
        $importer = $grid->getImporter();
        $importer->setGrid($grid);
        return $importer;
    }
    
    protected function _getImporterForGuest()
    {
        $grid = new Grid_Projects(array(
            'publicOnly' => true
        ));
        $importer = $grid->getImporter();
        $importer->setGrid($grid);
        return $importer;
    }
    
}
