<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Table.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Table.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
