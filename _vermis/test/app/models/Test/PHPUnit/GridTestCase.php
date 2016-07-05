<?php

/**
 * =============================================================================
 * @file        Test/PHPUnit/GridTestCase.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: GridTestCase.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
