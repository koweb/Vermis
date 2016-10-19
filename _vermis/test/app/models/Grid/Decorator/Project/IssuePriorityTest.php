<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssuePriorityTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssuePriorityTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_Project_IssuePriorityTest
 */
class Grid_Decorator_Project_IssuePriorityTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase()
    {
        $decorator = new Grid_Decorator_Project_IssuePriority;
        $decorator->setView($this->_view);
        $this->assertEquals(
            '<span class="issue-priority black">Normal</span>', 
            $decorator->render(Project_Issue::PRIORITY_NORMAL));
    }
    
}
