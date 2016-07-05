<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Latest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Latest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Issues_Latest
 * @brief Project issues grid.
 */
class Grid_Project_Issues_Latest extends Grid_Project_Issues
{
    
    public function __construct(array $params, $id = 'issues_latest')
    {
        parent::__construct($params, $id);

        $this
            ->setSortColumn('update_time')
            ->setSortOrder('desc');
        
        $this->getColumn('assignee_name')->setHidden(true);
        $this->getColumn('reporter_name')->setHidden(true);
        $this->getColumn('component_name')->setHidden(true);
        $this->getColumn('milestone_name')->setHidden(true);

        $this
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption('latest_issues');
    }
    
}
