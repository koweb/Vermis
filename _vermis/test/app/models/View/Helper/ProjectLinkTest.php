<?php

/**
 * =============================================================================
 * @file        View/Helper/ProjectLinkTest.php
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
 * @class   View_Helper_ProjectLinkTest
 */
class View_Helper_ProjectLinkTest extends Test_PHPUnit_TestCase 
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
        $html = $view->render('project_link.phtml');
        $this->assertEquals(
            'Deleted project|<a href="http://localhost/project/abc" title="def">def</a>',
            $html
        );
    }
    
}
