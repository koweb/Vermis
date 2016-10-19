<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/ProjectLink.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProjectLink.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
