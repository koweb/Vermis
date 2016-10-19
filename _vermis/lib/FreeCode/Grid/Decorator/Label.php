<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Label.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Label.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Label
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Label extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $label = $this->getElement();
        $float = $label->getFloat();
        if (empty($content))
            $content = $label->getCaption();
        return
            '<div class="label" style="float:'.$float.'">'. 
            _T($content).
            '</div>';
    }
    
}
