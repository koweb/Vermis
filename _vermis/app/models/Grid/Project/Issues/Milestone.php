<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Milestone.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Milestone.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class Grid_Project_Issues_Milestone
 * @brief Issues assigned to the component.
 */
class Grid_Project_Issues_Milestone extends Grid_Project_Issues
{
    
    public function __construct(array $params, $id = 'issues_milestone')
    {
        parent::__construct($params, $id);
        
        $this
            ->setImporter(new Grid_Importer_Project_Issues_Milestone($params))
            ->setAjaxAction($this->getView()->url(
                array(
                    'project_slug'      => $params['projectSlug'],
                    'milestone_slug'    => $params['milestoneSlug']
                ), 
                'project/grid_milestone'))
            ->setExportAction($this->getView()->url(
                array(
                    'project_slug'      => $params['projectSlug'],
                    'milestone_slug'    => $params['milestoneSlug']
                ), 
                'project/grid_milestone/export'));
                
        $this->getColumn('milestone_name')->setHidden(true);
    }
    
}
