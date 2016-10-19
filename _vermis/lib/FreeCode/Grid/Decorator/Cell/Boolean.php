<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Cell/Boolean.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Boolean.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
