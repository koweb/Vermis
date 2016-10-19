<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/ComponentLinkTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentLinkTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_Project_ComponentLinkTest
 */
class Grid_Decorator_Project_ComponentLinkTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase_Default()
    {
        $decorator = new Grid_Decorator_Project_ComponentLink;
        $decorator->setView($this->_view);
        $decorator->setRow(array(
            'project_slug' => 'project',
            'slug' => 'slug'
        ));
        $this->assertEquals(
            '<a href="http://localhost/project/project/component/slug" title="content">content</a>', 
            $decorator->render('content'));
    }
    
    public function testCase_SlugParam()
    {
        $decorator = new Grid_Decorator_Project_ComponentLink('abc');
        $decorator->setView($this->_view);
        $decorator->setRow(array(
            'project_slug' => 'project',
            'abc' => 'slug'
        ));
        $this->assertEquals(
            '<a href="http://localhost/project/project/component/slug" title="content">content</a>', 
            $decorator->render('content'));
    }
    
}
