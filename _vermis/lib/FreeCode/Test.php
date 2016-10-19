<?php

/**
 * =============================================================================
 * @file        FreeCode/Test.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Test.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
