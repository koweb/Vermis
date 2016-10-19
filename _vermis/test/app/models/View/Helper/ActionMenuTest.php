<?php

/**
 * =============================================================================
 * @file        View/Helper/ActionMenuTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ActionMenuTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   View_Helper_ActionMenuTest
 */
class View_Helper_ActionMenuTest extends Test_PHPUnit_TestCase 
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
        $html = $view->render('action_menu.phtml');
        $this->assertContains('Link 1', $html);
        $this->assertContains('Link 2', $html);
        $this->assertContains('link1', $html);
        $this->assertContains('link2', $html);
        $this->assertContains('float:left', $html);
        $this->assertContains('float:right', $html);
    }
    
}
