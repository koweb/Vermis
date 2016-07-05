<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssuePriorityTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssuePriorityTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
