<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/ProjectLinkTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ProjectLinkTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_ProjectLinkTest
 */
class Grid_Decorator_ProjectLinkTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase_Default()
    {
        $decorator = new Grid_Decorator_ProjectLink;
        $decorator->setView($this->_view);
        $decorator->setRow(array(
            'slug' => 'slug',
            'name' => 'name'
        ));
        $this->assertEquals(
            '<a href="http://localhost/project/slug" title="name">name</a>', 
            $decorator->render('content'));
    }
    
    public function testCase_SlugParam()
    {
        $decorator = new Grid_Decorator_ProjectLink('abc', 'def');
        $decorator->setView($this->_view);
        $decorator->setRow(array(
            'abc' => 'slug',
            'def' => 'name'
        ));
        $this->assertEquals(
            '<a href="http://localhost/project/slug" title="name">name</a>', 
            $decorator->render('content'));
    }
    
}
