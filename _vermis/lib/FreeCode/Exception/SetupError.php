<?php

/**
 * =============================================================================
 * @file        FreeCode/Exception/SetupError.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: SetupError.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
