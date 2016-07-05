<?php

/**
 * =============================================================================
 * @file        View/Helper/SmallButtonsTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: SmallButtonsTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   View_Helper_SmallButtonsTest
 */
class View_Helper_SmallButtonsTest extends Test_PHPUnit_TestCase 
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
        $html = $view->render('small_buttons.phtml');
        $this->assertContains('class="small-button"', $html);
        $this->assertContains('href="http://url"', $html);
        $this->assertContains('title="the title"', $html);
        $this->assertContains('gfx/icons/10/the-icon.png', $html);
        $this->assertContains('alt="the-icon"', $html);
    }
    
}
