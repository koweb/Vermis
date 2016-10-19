<?php

/**
 * =============================================================================
 * @file        Test/PHPUnit/GridTestCase.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: GridTestCase.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Test_PHPUnit_GridTestCase
 */
class Test_PHPUnit_GridTestCase extends FreeCode_PHPUnit_GridTestCase 
{
    
    public function setUp()
    {
        /// @TODO Refactor!
        $db = new Test_PHPUnit_DbTestCase;
        $db->setUp();
        Application::getInstance()->setupView();
    }
    
    public function tearDown()
    {
        /// @TODO Refactor!
        $db = new Test_PHPUnit_DbTestCase;
        $db->tearDown();
    }
    
}
