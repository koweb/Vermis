<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/NoteLinkTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NoteLinkTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_Decorator_Project_NoteLinkTest
 */
class Grid_Decorator_Project_NoteLinkTest extends Test_PHPUnit_ViewTestCase 
{
    
    public function testCase()
    {
        $decorator = new Grid_Decorator_Project_NoteLink;
        $decorator->setView($this->_view);
        $decorator->setRow(array(
            'project_slug' => 'project',
            'slug' => 'slug'
        ));
        $this->assertEquals(
            '<strong><a href="http://localhost/project/project/note/slug" title="content">content</a></strong>', 
            $decorator->render('content'));
    }
    
}
