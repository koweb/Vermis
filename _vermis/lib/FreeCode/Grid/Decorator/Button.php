<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Button.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Button.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
