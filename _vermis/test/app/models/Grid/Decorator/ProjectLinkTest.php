<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/ProjectLinkTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProjectLinkTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
