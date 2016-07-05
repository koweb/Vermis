<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Div.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Div.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Div
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Div extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $id = $this->getGrid()->getId();
        return 
            '<div id="'.$id.'" class="freecode_grid">'. 
            $content.
            '</div>';
    }
    
}
