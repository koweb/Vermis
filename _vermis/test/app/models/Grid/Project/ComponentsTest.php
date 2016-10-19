<?php

/**
 * =============================================================================
 * @file        Grid/Project/ComponentsTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentsTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Project_ComponentsTest
 */
class Grid_Project_ComponentsTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Components(array(
            'projectId' => 1,
            'projectSlug' => 'project1'
        ));

        $this->assertEquals(7, count($grid->getColumns()));
        $this->assertNotNull($grid->getColumn('name'));
        $this->assertNotNull($grid->getColumn('description'));
        $this->assertNotNull($grid->getColumn('num_issues'));
        $this->assertNotNull($grid->getColumn('author_name'));
        $this->assertNotNull($grid->getColumn('changer_name'));
        $this->assertNotNull($grid->getColumn('create_time'));
        $this->assertNotNull($grid->getColumn('update_time'));
        $this->assertEquals(Grid::hashId('components'), $grid->getId());
        $this->assertTrue($grid->hasIndicator());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Components);
        $this->assertEquals('name', $grid->getSortColumn()->getId());
        $this->assertEquals('ASC', $grid->getSortOrder());
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
    
}
