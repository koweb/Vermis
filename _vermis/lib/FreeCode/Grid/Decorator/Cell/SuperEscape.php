<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Cell/SuperEscape.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: SuperEscape.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Cell_SuperEscape
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Cell_SuperEscape extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        return $this->getView()->superEscape($content);
    }
    
}
