<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/ComponentLink.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ComponentLink.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_ComponentLink
 * @brief Component link decorator.
 */
class Grid_Decorator_Project_ComponentLink extends FreeCode_Grid_Decorator_Abstract
{

    protected $_componentSlugField = null;
    
    public function __construct($componentSlugField = 'slug')
    {
        $this->_componentSlugField = $componentSlugField;
    }
    
    public function render($content)
    {
        $row = $this->getRow();
        $view = $this->getView();
        return $view->componentLink(
            $row['project_slug'], $row[$this->_componentSlugField], $content);
    }
    
}
