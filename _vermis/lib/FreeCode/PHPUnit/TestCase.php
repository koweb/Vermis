<?php

/**
 * =============================================================================
 * @file        FreeCode/PHPUnit/TestCase.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: TestCase.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_PHPUnit_TestCase
 * @brief   Test case.
 */
abstract class FreeCode_PHPUnit_TestCase extends PHPUnit_Framework_TestCase
{
    
    public function assertImageFile($mime, $width, $height, $fileName)
    {
        $this->assertFileExists($fileName);
        $info = FreeCode_FileSystem::getImageInfo($fileName);
        $this->assertEquals($mime, $info['mime']);
        $this->assertEquals($width, $info['width']);
        $this->assertEquals($height, $info['height']);
    }
    
}
