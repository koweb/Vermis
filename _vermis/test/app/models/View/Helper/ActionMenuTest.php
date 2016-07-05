<?php

/**
 * =============================================================================
 * @file        View/Helper/ActionMenuTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ActionMenuTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
