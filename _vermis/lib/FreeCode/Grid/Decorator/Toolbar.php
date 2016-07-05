<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Toolbar.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Toolbar.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
