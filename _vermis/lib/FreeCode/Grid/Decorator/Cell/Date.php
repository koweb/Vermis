<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Cell/Date.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Date.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
