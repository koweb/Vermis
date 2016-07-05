<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Cell/Date.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Date.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Cell_Date
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Cell_Date extends FreeCode_Grid_Decorator_Abstract
{

    protected $_format = null;

    public function __construct($format = null)
    {
        $this->_format = $format;
    }
    
    public function render($content)
    {
        return $this->getView()->date($content, $this->_format);
    }
    
}
