<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Component.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Component.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class Grid_Project_Issues_Component
 * @brief Issues assigned to the component.
 */
class Grid_Project_Issues_Component extends Grid_Project_Issues
{
    
    public function __construct(array $params, $id = 'issues_component')
    {
        parent::__construct($params, $id);
        
        $this
            ->setImporter(new Grid_Importer_Project_Issues_Component($params))
            ->setAjaxAction($this->getView()->url(
                array(
                    'project_slug'      => $params['projectSlug'],
                    'component_slug'    => $params['componentSlug']
                ), 
                'project/grid_component'))
            ->setExportAction($this->getView()->url(
                array(
                    'project_slug'      => $params['projectSlug'],
                    'component_slug'    => $params['componentSlug']
                ), 
                'project/grid_component/export'));
                
        $this->getColumn('component_name')->setHidden(true);
    }
    
}
