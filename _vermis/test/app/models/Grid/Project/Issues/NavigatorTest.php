<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/NavigatorTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NavigatorTest.php 124 2011-01-29 23:37:34Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_Project_Issues_NavigatorTest
 */
class Grid_Project_Issues_NavigatorTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Issues_Navigator(array());
        
        $this->assertTrue($grid instanceof Grid_Project_Issues);
        $this->assertEquals(Grid::hashId('issues_navigator'), $grid->getId());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Issues);
        
        $this->assertTrue($grid->getColumn('create_time')->isHidden());
        $this->assertFalse($grid->getColumn('update_time')->isHidden());
        
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
    
}
