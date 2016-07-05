<?php

/**
 * =============================================================================
 * @file        SeleniumTests.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: SeleniumTests.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

require_once 'bootstrap.php';

/**
 * @class   SeleniumTests
 */
class SeleniumTests 
{

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('vermis-selenium');

        $suite->addTestSuite('WebTest');
        
        return $suite;
    }
    
}
