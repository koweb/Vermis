<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/NoteLinkTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: NoteLinkTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
