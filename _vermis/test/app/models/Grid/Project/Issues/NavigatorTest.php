<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/NavigatorTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: NavigatorTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
