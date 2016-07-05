<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Component.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Component.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
