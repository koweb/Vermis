<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Assigned.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Assigned.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Issues_Assigned
 * @brief Project issues grid.
 */
class Grid_Project_Issues_Assigned extends Grid_Project_Issues
{
    
    public function __construct(array $params, $id = 'issues_assigned')
    {
        parent::__construct($params, $id);
        $this->setImporter(new Grid_Importer_Project_Issues_Assigned($params));
            
        $this->getColumn('assignee_name')->setHidden(true);
        
        $this
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption('assigned_issues');
        
        $this->_setActionsForUserGrid($params);
    }
    
}
