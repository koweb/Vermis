<?php

/**
 * =============================================================================
 * @file        Grid/Project/MembersTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MembersTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Project_MembersTest
 */
class Grid_Project_MembersTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Members(array(
            'projectId' => 1,
            'projectSlug' => 'project1'
        ));
        
        $this->assertEquals(3, count($grid->getColumns()));
        $this->assertNotNull($grid->getColumn('name'));
        $this->assertNotNull($grid->getColumn('role'));
        $this->assertNotNull($grid->getColumn('user_id'));
        
        $this->assertTrue($grid->getColumn('user_id')->isHidden());
        
        $this->assertEquals(Grid::hashId('members'), $grid->getId());
        $this->assertTrue($grid->hasIndicator());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Members);
        $this->assertEquals('name', $grid->getSortColumn()->getId());
        $this->assertEquals('ASC', $grid->getSortOrder());
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
    
}
