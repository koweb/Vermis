<?php

/**
 * =============================================================================
 * @file        View/Helper/ProjectLinkTest.php
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
