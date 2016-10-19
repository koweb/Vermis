<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/LatestTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: LatestTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Grid_Project_Issues_LatestTest
 */
class Grid_Project_Issues_LatestTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Issues_Latest(array());
        
        $this->assertTrue($grid instanceof Grid_Project_Issues);
        $this->assertEquals(Grid::hashId('issues_latest'), $grid->getId());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Issues);
        
        $this->assertTrue($grid->getColumn('assignee_name')->isHidden());
        $this->assertTrue($grid->getColumn('reporter_name')->isHidden());
        $this->assertTrue($grid->getColumn('create_time')->isHidden());
        $this->assertTrue($grid->getColumn('update_time')->isHidden());
        
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
    
    public function testGuest_DashboardContent()
    {
        $grid = new Grid_Project_Issues_Latest(array());
        $grid->import();
        $rows = $grid->getRows();
        $this->assertTrue(count($rows) > 0);
        
        foreach ($rows as $row) {
            $project = Doctrine::getTable('Project')->find($row['project_id']);
            $this->assertFalse($project->is_private);
        }
    }
    
    public function testGuest_ProjectContent()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $grid = new Grid_Project_Issues_Latest(array(
            'projectSlug' => $project->slug,
            'projectId' => $project->id
        ));
        $grid->import();
        $rows = $grid->getRows();
        $this->assertTrue(count($rows) > 0);
        
        foreach ($rows as $row) {
            $this->assertEquals($row['project_id'], $project->id);
        }
    }
    
    public function testUser_DashboardContent()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        $grid = new Grid_Project_Issues_Latest(array(
            'userId' => $user->id,
            'userSlug' => $user->slug
        ));
        $grid->import();
        $rows = $grid->getRows();
        $this->assertTrue(count($rows) > 0);
        
        foreach ($rows as $row) {
            $project = Doctrine::getTable('Project')->find($row['project_id']);
            $this->assertTrue(
                $user->isMemberOf($row['project_id']) ||
                !$project->is_private);
        }
    }
    
    public function testUser_ProjectContent()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $grid = new Grid_Project_Issues_Latest(array(
            'userId' => $user->id,
            'userSlug' => $user->slug,
            'projectSlug' => $project->slug,
            'projectId' => $project->id
        ));
        $grid->import();
        $rows = $grid->getRows();
        $this->assertTrue(count($rows) > 0);
        
        foreach ($rows as $row) {
            $this->assertTrue($user->isMemberOf($row['project_id']));
            $this->assertEquals($row['project_id'], $project->id);
        }
    }
    
}
