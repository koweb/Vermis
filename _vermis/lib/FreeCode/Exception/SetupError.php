<?php

/**
 * =============================================================================
 * @file        FreeCode/Exception/SetupError.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: SetupError.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Exception_SetupError
 * @brief   Invalid system configuration exception.
 */
class FreeCode_Exception_SetupError extends FreeCode_Exception
{
    
    protected $_tip = '';
    
    public function __construct($message = '', $tip = '') 
    {
        parent::__construct($message, 0);
        $this->_tip = $tip;
    }
    
    public function getTip()
    {
        return $this->_tip;
    }
    
}
