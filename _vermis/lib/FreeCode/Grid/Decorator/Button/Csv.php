<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Button/Csv.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Csv.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Button_Csv
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Button_Csv extends FreeCode_Grid_Decorator_Button
{

    public function render($content)
    {
        $grid = $this->getGrid();
        $href = $grid->getExportAction().
            '?id='.$grid->getId().
            '&exporter=csv'.
            '&sort='.$grid->getSortColumn()->getId().
            '&order='.strtolower($grid->getSortOrder()).
            '&page='.$grid->getPager()->getPage();
        return parent::render($href);
    }
    
}
