<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/ComponentLinkTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ComponentLinkTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
