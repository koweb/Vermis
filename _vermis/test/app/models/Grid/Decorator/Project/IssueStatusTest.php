<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueStatusTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssueStatusTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_Project_IssueStatusTest
 */
class Grid_Decorator_Project_IssueStatusTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase()
    {
        $decorator = new Grid_Decorator_Project_IssueStatus;
        $decorator->setView($this->_view);
        $this->assertEquals(
            '<span class="issue-status orange">In progress</span>', 
            $decorator->render(Project_Issue::STATUS_IN_PROGRESS));
    }
    
}
