<?php

/**
 * =============================================================================
 * @file        View/Helper/LogUrlTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: LogUrlTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   View_Helper_LogUrlTest
 */
class View_Helper_LogUrlTest extends Test_PHPUnit_TestCase 
{
    
    public function setUp()
    {
        Application::getInstance()
            ->setupConfig()
            ->setupFrontController()
            ->setupRouter()
            ->setupTranslator();
    }

    public function testCase()
    {
        $view = new Zend_View;
        $view->setScriptPath(TEST_DIR.'/fixtures');
        $view->addHelperPath(VIEWS_HELPERS_DIR, 'View_Helper');
        $html = $view->render('log_url.phtml');
        $this->assertContains('/project/project-1', $html);
        $this->assertContains('/project/project-2/milestone/milestone-a', $html);
        $this->assertContains('/project/project-3/component/component-a', $html);
        $this->assertContains('/project/project-4/issue/123/this-is-an-issue-slug', $html);
        $this->assertContains('/project/project-5/note/note-a', $html);
    }
    
}
