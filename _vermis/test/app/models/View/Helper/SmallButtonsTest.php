<?php

/**
 * =============================================================================
 * @file        View/Helper/SmallButtonsTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: SmallButtonsTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
