<?php

/**
 * =============================================================================
 * @file        SeleniumTests.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: SeleniumTests.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
