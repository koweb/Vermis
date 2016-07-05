<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/MilestoneLink.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MilestoneLink.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_MilestoneLink
 * @brief Milestone link decorator.
 */
class Grid_Decorator_Project_MilestoneLink extends FreeCode_Grid_Decorator_Abstract
{

    protected $_milestoneSlugField = null;
    
    public function __construct($milestoneSlugField = 'slug')
    {
        $this->_milestoneSlugField = $milestoneSlugField;
    }
    
    public function render($content)
    {
        $row = $this->getRow();
        $view = $this->getView();
        return $view->milestoneLink(
            $row['project_slug'], $row[$this->_milestoneSlugField], $content);
    }
    
}
