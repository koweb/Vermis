<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/AssignedTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: AssignedTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Project_Issues_AssignedTest
 */
class Grid_Project_Issues_AssignedTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Issues_Assigned(array(
            'userId' => 1,
            'userSlug' => 'administrator',
            'identityId' => 1
        ));

        $this->assertTrue($grid instanceof Grid_Project_Issues);
        $this->assertEquals(Grid::hashId('issues_assigned'), $grid->getId());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Issues_Assigned);
        $this->assertTrue($grid->getColumn('assignee_name')->isHidden());
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
    
}
