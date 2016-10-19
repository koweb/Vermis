<?php

/**
 * =============================================================================
 * @file        FreeCode/Filter/File/Abstract.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Abstract.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Filter_File_Abstract
 * @brief   Utility class. 
 */
abstract class FreeCode_Filter_File_Abstract
{
    
    protected function _getFileInfo($fileName)
    {
        return FreeCode_FileSystem::getFileInfo($fileName);
    }

    protected function _getImageInfo($fileName)
    {
        return FreeCode_FileSystem::getImageInfo($fileName);
    }

    protected function _parsePath($path, array $params = null)
    {
        return FreeCode_FileSystem::parsePath($path, $params);
    }

}
