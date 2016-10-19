<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/ComponentLink.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentLink.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
