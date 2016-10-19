<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Latest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Latest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
