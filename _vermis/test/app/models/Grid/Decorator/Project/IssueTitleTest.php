<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueTitleTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueTitleTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_Project_IssueTitleTest
 */
class Grid_Decorator_Project_IssueTitleTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase()
    {
        $decorator = new Grid_Decorator_Project_IssueTitle;
        $decorator->setView($this->_view);
        $decorator->setRow(array(
            'project_slug' => 'project',
            'slug' => 'slug',
            'number' => 666
        ));
        $this->assertEquals(
            '<strong><a href="http://localhost/project/project/issue/666/slug" title="content">content</a></strong>', 
            $decorator->render('content'));
    }
    
}
