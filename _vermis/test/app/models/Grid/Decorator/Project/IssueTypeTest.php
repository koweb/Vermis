<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueTypeTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueTypeTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
