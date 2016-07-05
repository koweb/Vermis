<?php

/**
 * =============================================================================
 * @file        FreeCode/Test.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Test.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Test
 * @brief   Unit testing.
 */
class FreeCode_Test
{
    
    protected static $_unitTestEnabled = false;
    
    protected function __construct() {}
    
    public static function enable()
    {
        self::$_unitTestEnabled = true;
    }
    
    public static function disable()
    {
        self::$_unitTestEnabled = false;
    }
    
    public static function isEnabled()
    {
        return self::$_unitTestEnabled;
    }
    
}
