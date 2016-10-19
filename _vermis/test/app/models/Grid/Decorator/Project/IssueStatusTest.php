<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueStatusTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueStatusTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
