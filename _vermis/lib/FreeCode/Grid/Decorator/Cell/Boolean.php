<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Cell/Boolean.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Boolean.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Cell_Boolean
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Cell_Boolean extends FreeCode_Grid_Decorator_Abstract
{

    protected $_true = null;
    protected $_false = null;
    
    public function __construct($true = 'true', $false = 'false')
    {
        $this->_true = $true;
        $this->_false = $false;
    }
    
    public function render($content)
    {
        return $content ? $this->_true : $this->_false;
    }
    
}
