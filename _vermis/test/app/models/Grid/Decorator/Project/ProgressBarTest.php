<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/ProgressBarTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProgressBarTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_Project_ProgressBarTest
 */
class Grid_Decorator_Project_ProgressBarTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase()
    {
        $decorator = new Grid_Decorator_Project_ProgressBar;
        $decorator->setView($this->_view);
        $this->assertEquals(
            '<div style="border:1px solid #444444; background:#ffffff; margin:2px;"><div style="width:50%; background:#ffde03; height:11px;"></div></div>', 
            $decorator->render(50));
    }
    
}
