<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Toolbars.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Toolbars.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
