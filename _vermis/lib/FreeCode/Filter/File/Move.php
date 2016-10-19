<?php

/**
 * =============================================================================
 * @file        FreeCode/Filter/File/Move.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Move.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Filter_File_Move
 * @brief   Move filter. 
 */
class FreeCode_Filter_File_Move extends FreeCode_Filter_File_Abstract implements Zend_Filter_Interface
{
    
    protected $_destinationPath = null;

    public function __construct($destinationPath)
    {
        $this->_destinationPath = $destinationPath;
    }

    public function filter($value)
    {
        $info = $this->_getFileInfo($value);
        $path = $this->_parsePath($this->_destinationPath, $info);
        @rename($value, $path);
        return $path;
    }

}
