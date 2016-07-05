<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Button.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Button.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Button
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Button extends FreeCode_Grid_Decorator_Abstract
{

    public function render($href)
    {
        $button = $this->getElement();
        $caption = $button->getCaption();
        $float = $button->getFloat();
        $uniqueId = $this->_getUniqueElementId();
        if (empty($href))
            $href = $button->getHref();
        return 
            '<a class="button" '.
            'id="'.$uniqueId.'" '.
            'style="float:'.$float.'" '.
            'href="'.$href.'" '.
            'title="'.$caption.'">'.
            _T($caption).
            '</a>';
    }
    
}
