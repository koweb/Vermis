<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Toolbars.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Toolbars.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Toolbars
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Toolbars extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $grid = $this->getGrid();
        $prepend = '';
        $append = '';
        
        $toolbars = $grid->getToolbars();
        foreach ($toolbars as $toolbar) {
            $decorator = $toolbar->getDecorator();
            $decorator
                ->setView($this->getView())
                ->setGrid($grid)
                ->setElement($toolbar);
            if ($toolbar->getPosition() == FreeCode_Grid_Toolbar::POSITION_TOP)
                $prepend .= $decorator->render('');
            else
                $append .= $decorator->render('');
        }

        return $prepend.$content.$append;
    }
    
}
