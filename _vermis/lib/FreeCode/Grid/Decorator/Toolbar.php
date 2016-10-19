<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Toolbar.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Toolbar.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Toolbar
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Toolbar extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $grid = $this->getGrid();
        $toolbar = $this->getElement();
        $elements = $toolbar->getElements();
        $position = $toolbar->getPosition();
        
        if (count($elements) == 0)
            return $content;
            
        $html = '<div class="toolbar '.$position.'">';
        foreach ($elements as $element) {
            $decorator = $element->getDecorator();
            $decorator
                ->setView($this->getView())
                ->setGrid($grid)
                ->setElement($element);
            $html .= $decorator->render('');
        }
        $html .= '</div>';
        
        return $content.$html;
    }
    
}
