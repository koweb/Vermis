<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueIdTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueIdTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_Project_IssueIdTest
 */
class Grid_Decorator_Project_IssueIdTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase()
    {
        $decorator = new Grid_Decorator_Project_IssueId;
        $decorator->setView($this->_view);
        $decorator->setRow(array(
            'project_slug' => 'project',
            'project_name' => 'project name',
            'slug' => 'slug',
            'number' => 666
        ));
        $this->assertEquals(
            '<strong><a href="http://localhost/project/project/issue/666/slug" title="project name-666">project name-666</a></strong>', 
            $decorator->render('content'));
    }
    
}
