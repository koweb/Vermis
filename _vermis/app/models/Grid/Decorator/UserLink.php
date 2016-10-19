<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/UserLink.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UserLink.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
