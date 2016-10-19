<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Cell.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Cell.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Cell
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Cell extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        return $this->getView()->escape($content);
    }
    
}
