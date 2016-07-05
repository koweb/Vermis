<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/ProjectLink.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ProjectLink.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_ProjectLink
 * @brief Project link decorator.
 */
class Grid_Decorator_ProjectLink extends FreeCode_Grid_Decorator_Abstract
{

    protected $_slugField = null;
    protected $_nameField = null;
    
    public function __construct($slugField = 'slug', $nameField = 'name')
    {
        $this->_slugField = $slugField;
        $this->_nameField = $nameField;
    }
    
    public function render($content)
    {
        $row = $this->getRow();
        $view = $this->getView();
        return $view->projectLink($row[$this->_slugField], $row[$this->_nameField]);
    }
    
}
