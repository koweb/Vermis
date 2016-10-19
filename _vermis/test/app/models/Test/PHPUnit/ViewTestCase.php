<?php

/**
 * =============================================================================
 * @file        Test/PHPUnit/ViewTestCase.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ViewTestCase.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Test_PHPUnit_ViewTestCase
 */
class Test_PHPUnit_ViewTestCase extends Test_PHPUnit_TestCase 
{
    
    protected $_view = null;
    
    public function setUp()
    {
        parent::setUp();

        Application::getInstance()
            ->setupConfig()
            ->setupFrontController()
            ->setupRouter()
            ->setupTranslator();

        $this->_view = new Zend_View;
        $this->_view->setScriptPath(VIEWS_SCRIPTS_DIR);
        $this->_view->addHelperPath('FreeCode/View/Helper', 'FreeCode_View_Helper');
        $this->_view->addHelperPath(VIEWS_HELPERS_DIR, 'View_Helper');
    }
    
}
