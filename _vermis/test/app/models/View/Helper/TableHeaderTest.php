<?php

/**
 * =============================================================================
 * @file        View/Helper/TableHeaderTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: TableHeaderTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   View_Helper_TableHeaderTest
 */
class View_Helper_TableHeaderTest extends Test_PHPUnit_TestCase 
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
        $view->addHelperPath('FreeCode/View/Helper', 'FreeCode_View_Helper');
        $view->addHelperPath(VIEWS_HELPERS_DIR, 'View_Helper');
        $html = $view->render('table_header.phtml');
        $this->assertEquals('<a href="/index?page=1&amp;sort-field=name&amp;sort-order=asc">Name</a>', $html);
    }
    
}
