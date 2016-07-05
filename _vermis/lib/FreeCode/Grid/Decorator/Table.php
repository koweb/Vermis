<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Table.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Table.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Table
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Table extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        return
            '<div class="container"><table>'.
            $content.
            '</table></div>';
    }
    
}
