<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueTypeTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssueTypeTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_Project_IssueTypeTest
 */
class Grid_Decorator_Project_IssueTypeTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase()
    {
        $decorator = new Grid_Decorator_Project_IssueType;
        $decorator->setView($this->_view);
        $this->assertEquals(
            'Improvement', 
            $decorator->render(Project_Issue::TYPE_IMPROVEMENT));
    }
    
}
