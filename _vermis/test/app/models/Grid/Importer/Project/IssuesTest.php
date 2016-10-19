<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/IssuesTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssuesTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Importer_Project_IssuesTest
 */
class Grid_Importer_Project_IssuesTest extends Test_PHPUnit_DbTestCase 
{
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupView();
    }
    
    public function testGetCountQuery()
    {
        $grid = new Grid_Project_Issues(array());
        $importer = $grid->getImporter();
        $importer->setGrid($grid);
        
        $query = $importer->getCountQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $this->assertEquals(8, $query->execute());
    }
    
    public function testGetCountQuery_ProjectId()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        
        $grid = new Grid_Project_Issues(array(
            'projectId' => $project->id,
            'projectSlug' => $project->slug
        ));
        $importer = $grid->getImporter();
        $importer->setGrid($grid);

        $query = $importer->getCountQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $this->assertEquals(4, $query->execute());
    }
    
    public function testGetRecordsQuery()
    {
        $grid = new Grid_Project_Issues(array());
        $importer = $grid->getImporter();
        $importer->setGrid($grid);
        
        $query = $importer->getRecordsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertEquals(8, count($records));
    }
    
    public function testGetRecordsQuery_ProjectId()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        
        $grid = new Grid_Project_Issues(array(
            'projectId' => $project->id,
            'projectSlug' => $project->slug
        ));
        $importer = $grid->getImporter();
        $importer->setGrid($grid);

        $query = $importer->getRecordsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertEquals(4, count($records));
        foreach ($records as $record)
            $this->assertEquals(1, $record['project_id']);
    }
    
    public function testAddConstraints_ProjectId()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        
        $grid = new Grid_Project_Issues(array(
            'projectId' => $project->id,
            'projectSlug' => $project->slug
        ));
        $importer = $grid->getImporter();
        $importer->setGrid($grid);

        $count = $importer->fetchCount();
        $this->assertEquals(4, $count);
        
        $records = $importer->fetchRecords();
        $this->assertEquals($count, count($records));
        
        foreach ($records as $record) {
            $this->assertEquals($project->id, $record['project_id']);
        }
    }
    
    public function testAddConstraints_NoProjectId()
    {
        $grid = new Grid_Project_Issues(array());
        $importer = $grid->getImporter();
        $importer->setGrid($grid);
        
        $count = $importer->fetchCount();
        $this->assertEquals(8, $count);
        
        $records = $importer->fetchRecords();
        $this->assertEquals($count, count($records));
        
        foreach ($records as $record) {
            $project = Doctrine::getTable('Project')->find($record['project_id']);
            $this->assertFalse($project->is_private);
        }
    }
    
    public function testAddConstraints_LatestIssuesAllProjects()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        
        $grid = new Grid_Project_Issues(array(
            'userId' => $user->id,
            'userSlug' => $user->slug
        ), 'issues_latest');
        $importer = $grid->getImporter();
        $importer->setGrid($grid);
        
        $count = $importer->fetchCount();
        $this->assertEquals(8, $count);
        
        $records = $importer->fetchRecords();
        $this->assertEquals($count, count($records));
        
        foreach ($records as $record) {
            $project = Doctrine::getTable('Project')->find($record['project_id']);
            $this->assertTrue(
                $user->isMemberOf($record['project_id']) ||
                !$project->is_private);
        }
    }
}
