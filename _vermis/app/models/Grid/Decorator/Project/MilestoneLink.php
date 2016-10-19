<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/MilestoneLink.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MilestoneLink.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
