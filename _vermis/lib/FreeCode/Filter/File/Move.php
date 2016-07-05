<?php

/**
 * =============================================================================
 * @file        FreeCode/Filter/File/Move.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Move.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
