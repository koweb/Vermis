<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/UserLinkTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: UserLinkTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_UserLinkTest
 */
class Grid_Decorator_UserLinkTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase_Default()
    {
        $decorator = new Grid_Decorator_UserLink;
        $decorator->setView($this->_view);
        $decorator->setRow(array('slug' => 'slug'));
        $this->assertEquals(
            '<a href="http://localhost/user/slug" title="content">content</a>', 
            $decorator->render('content'));
    }
    
    public function testCase_SlugParam()
    {
        $decorator = new Grid_Decorator_UserLink('abc');
        $decorator->setView($this->_view);
        $decorator->setRow(array('abc' => 'slug'));
        $this->assertEquals(
            '<a href="http://localhost/user/slug" title="content">content</a>', 
            $decorator->render('content'));
    }
    
}
