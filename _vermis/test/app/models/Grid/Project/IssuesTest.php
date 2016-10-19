<?php

/**
 * =============================================================================
 * @file        Grid/Project/IssuesTest.php
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
 * @class   Grid_Project_IssuesTest
 */
class Grid_Project_IssuesTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Issues(array(
            'projectId' => 1,
            'projectSlug' => 'project1'
        ));
        
        $this->assertEquals(17, count($grid->getColumns()));
        $this->assertNotNull($grid->getColumn('project_id'));
        $this->assertNotNull($grid->getColumn('component_id'));
        $this->assertNotNull($grid->getColumn('milestone_id'));
        $this->assertNotNull($grid->getColumn('reporter_id'));
        $this->assertNotNull($grid->getColumn('assignee_id'));
        $this->assertNotNull($grid->getColumn('number'));
        $this->assertNotNull($grid->getColumn('title'));
        $this->assertNotNull($grid->getColumn('type'));
        $this->assertNotNull($grid->getColumn('status'));
        $this->assertNotNull($grid->getColumn('priority'));
        $this->assertNotNull($grid->getColumn('assignee_name'));
        $this->assertNotNull($grid->getColumn('reporter_name'));
        $this->assertNotNull($grid->getColumn('component_name'));
        $this->assertNotNull($grid->getColumn('milestone_name'));
        $this->assertNotNull($grid->getColumn('create_time'));
        $this->assertNotNull($grid->getColumn('update_time'));
        $this->assertNotNull($grid->getColumn('progress'));
        $this->assertEquals(Grid::hashId('issues'), $grid->getId());
        $this->assertTrue($grid->hasIndicator());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Issues);
        $this->assertEquals('update_time', $grid->getSortColumn()->getId());
        $this->assertEquals('DESC', $grid->getSortOrder());
        $this->assertIterativeTest($grid);
              
        $this->assertTrue($grid->getColumn('create_time')->isHidden());
        $this->assertTrue($grid->getColumn('update_time')->isHidden());
        
        $this->assertTrue($grid->hasFilter());
    }
    
    public function testProjectFilterForGuest()
    {
        $grid = new Grid_Project_Issues(array());
        
        $filter = $grid->getColumn('number')->getFilter();
        $this->assertTrue($filter instanceof FreeCode_Grid_Filter);
        $this->assertEquals('project_id', $filter->getAlias());
        
        // project_name - project_id
        $options = $filter->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(7, count($options));
        $this->assertEquals('- any -', $options[0]);
        $this->assertEquals('Project1', $options[1]);
        $this->assertEquals('Project2', $options[2]);
        $this->assertEquals('Project3', $options[3]);
        $this->assertEquals('Project4', $options[4]);
        $this->assertEquals('項目', $options[7]);
        $this->assertEquals('โครงการ', $options[8]);
        
        $this->assertIterativeTest($grid);
    }
    
    public function testProjectFilterForUser()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        
        $grid = new Grid_Project_Issues(array(
            'userId' => $user->id,
            'userSlug' => $user->slug
        ));
        
        $filter = $grid->getColumn('number')->getFilter();
        $this->assertTrue($filter instanceof FreeCode_Grid_Filter);
        $this->assertEquals('project_id', $filter->getAlias());
        
        // project_name - project_id
        $options = $filter->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(8, count($options));
        $this->assertEquals('- any -', $options[0]);
        $this->assertEquals('Project1', $options[1]);
        $this->assertEquals('Project2', $options[2]);
        $this->assertEquals('Project3', $options[3]);
        $this->assertEquals('Project4', $options[4]);
        $this->assertEquals('Project5', $options[5]);
        $this->assertEquals('項目', $options[7]);
        $this->assertEquals('โครงการ', $options[8]);
        
        $this->assertIterativeTest($grid);
    }
    
    public function testProjectFilterForAdmin()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('admin');
        
        $grid = new Grid_Project_Issues(array(
            'userId' => $user->id,
            'userSlug' => $user->slug
        ));
        
        $filter = $grid->getColumn('number')->getFilter();
        $this->assertTrue($filter instanceof FreeCode_Grid_Filter);
        $this->assertEquals('project_id', $filter->getAlias());
        
        // project_name - project_id
        $options = $filter->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(8, count($options));
        $this->assertEquals('- any -', $options[0]);
        $this->assertEquals('Project1', $options[1]);
        $this->assertEquals('Project2', $options[2]);
        $this->assertEquals('Project3', $options[3]);
        $this->assertEquals('Project4', $options[4]);
        $this->assertEquals('Project6', $options[6]);
        $this->assertEquals('項目', $options[7]);
        $this->assertEquals('โครงการ', $options[8]);
        
        $this->assertIterativeTest($grid);
    }
    
    public function testProjectFilterWhenProjectIsSpecified()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        
        $grid = new Grid_Project_Issues(array(
            'projectId' => $project->id,
            'projectSlug' => $project->slug
        ));
        
        $filter = $grid->getColumn('number')->getFilter();
        $this->assertTrue($filter instanceof FreeCode_Grid_Filter);
        
        // Check if filter has not been set up!
        $this->assertNull($filter->getAlias());

        $this->assertIterativeTest($grid);
    }
    
    public function testMilestonesFilterWhenProjectIsSpecified()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        
        $grid = new Grid_Project_Issues(array(
            'projectId' => $project->id,
            'projectSlug' => $project->slug
        ));
        
        $filter = $grid->getColumn('milestone_name')->getFilter();
        $this->assertTrue($filter instanceof FreeCode_Grid_Filter);
        $this->assertEquals('milestone_id', $filter->getAlias());
        
        $options = $filter->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(4, count($options));
        $this->assertEquals('- any -', $options[0]);
        $this->assertEquals('0.3 beta', $options[3]);
        $this->assertEquals('0.2', $options[2]);
        $this->assertEquals('0.1', $options[1]);

        $this->assertIterativeTest($grid);
    }
    
    public function testMilestonesFilterWhenProjectIsNotSpecified()
    {
        $grid = new Grid_Project_Issues(array());
        $filter = $grid->getColumn('milestone_name')->getFilter();
        $this->assertTrue($filter instanceof FreeCode_Grid_Filter);
        $this->assertNull($filter->getAlias());

        $this->assertIterativeTest($grid);
    }
    
    public function testComponentsFilterWhenProjectIsSpecified()
    {
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        
        $grid = new Grid_Project_Issues(array(
            'projectId' => $project->id,
            'projectSlug' => $project->slug
        ));
        
        $filter = $grid->getColumn('component_name')->getFilter();
        $this->assertTrue($filter instanceof FreeCode_Grid_Filter);
        $this->assertEquals('component_id', $filter->getAlias());
        
        $options = $filter->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(4, count($options));
        $this->assertEquals('- any -', $options[0]);
        $this->assertEquals('component 1', $options[1]);
        $this->assertEquals('component 2', $options[2]);
        $this->assertEquals('component 3', $options[3]);

        $this->assertIterativeTest($grid);
    }
    
    public function testComponentsFilterWhenProjectIsNotSpecified()
    {
        $grid = new Grid_Project_Issues(array());
        $filter = $grid->getColumn('component_name')->getFilter();
        $this->assertTrue($filter instanceof FreeCode_Grid_Filter);
        $this->assertNull($filter->getAlias());

        $this->assertIterativeTest($grid);
    }
    
}
