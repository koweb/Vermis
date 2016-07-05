<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Label.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Label.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
