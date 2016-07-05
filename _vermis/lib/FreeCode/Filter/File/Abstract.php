<?php

/**
 * =============================================================================
 * @file        FreeCode/Filter/File/Abstract.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Abstract.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
