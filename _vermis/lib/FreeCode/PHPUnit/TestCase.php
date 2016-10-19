<?php

/**
 * =============================================================================
 * @file        FreeCode/PHPUnit/TestCase.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: TestCase.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
