<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/UserLink.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: UserLink.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_UserLink
 * @brief User link decorator.
 */
class Grid_Decorator_UserLink extends FreeCode_Grid_Decorator_Abstract
{

    protected $_slugField = null;
    
    public function __construct($slugField = 'slug')
    {
        $this->_slugField = $slugField;
    }
    
    public function render($content)
    {
        $row = $this->getRow();
        $view = $this->getView();
        return $view->userLink($row[$this->_slugField], $content);
    }
    
}
