<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/ReportedTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ReportedTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Project_Issues_ReportedTest
 */
class Grid_Project_Issues_ReportedTest extends Test_PHPUnit_GridTestCase 
{
    
    public function testSuite()
    {
        $grid = new Grid_Project_Issues_Reported(array(
            'userId' => 1,
            'userSlug' => 'administrator',
            'identityId' => 1
        ));

        $this->assertTrue($grid instanceof Grid_Project_Issues);
        $this->assertEquals(Grid::hashId('issues_reported'), $grid->getId());
        $this->assertTrue($grid->getImporter() 
            instanceof Grid_Importer_Project_Issues_Reported);
        $this->assertTrue($grid->getColumn('reporter_name')->isHidden());
        $this->assertIterativeTest($grid, array('doRestore' => true, 'doImport' => true));
    }
    
}
