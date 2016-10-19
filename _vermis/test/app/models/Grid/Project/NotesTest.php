<?php

/**
 * =============================================================================
 * @file        Grid/Project/NotesTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: NotesTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Grid_Project_NotesTest
 */
class Grid_Project_NotesTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Notes(array(
            'projectId' => 1,
            'projectSlug' => 'project1'
        ));

        $this->assertEquals(1, count($grid->getColumns()));
        $this->assertNotNull($grid->getColumn('title'));
        $this->assertEquals(Grid::hashId('notes'), $grid->getId());
        $this->assertTrue($grid->hasIndicator());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Notes);
        $this->assertEquals('title', $grid->getSortColumn()->getId());
        $this->assertEquals('ASC', $grid->getSortOrder());
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
    
}
