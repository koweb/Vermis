<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Button/Csv.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Csv.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
