<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Milestone.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Milestone.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
