<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/ProgressBarTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ProgressBarTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
