<?php

/**
 * =============================================================================
 * @file        Grid/UsersTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: UsersTest.php 124 2011-01-29 23:37:34Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_UsersTest
 */
class Grid_UsersTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testCase()
    {
        $grid = new Grid_Users;
        $this->assertEquals(4, count($grid->getColumns()));
        $this->assertNotNull($grid->getColumn('login'));
        $this->assertNotNull($grid->getColumn('name'));
        $this->assertNotNull($grid->getColumn('email'));
        $this->assertNotNull($grid->getColumn('create_time'));
        $this->assertEquals(Grid::hashId('users'), $grid->getId());
        $this->assertTrue($grid->hasIndicator());
        $this->assertTrue($grid->getImporter() instanceof Grid_Importer_Users);
        $this->assertEquals('login', $grid->getSortColumn()->getId());
        $this->assertEquals('ASC', $grid->getSortOrder());
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
        
}
