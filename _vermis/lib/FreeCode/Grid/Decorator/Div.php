<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Div.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Div.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
