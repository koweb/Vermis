<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/MilestoneTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MilestoneTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Project_Issues_MilestoneTest
 */
class Grid_Project_Issues_MilestoneTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Issues_Milestone(array(
            'projectId' => 1,
            'projectSlug' => 'project1',
            'milestoneId' => 1,
            'milestoneSlug' => 'milestone1'
        ));

        $this->assertTrue($grid instanceof Grid_Project_Issues);
        $this->assertEquals(Grid::hashId('issues_milestone'), $grid->getId());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Issues_Milestone);
        $this->assertTrue($grid->getColumn('milestone_name')->isHidden());
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
    
}
