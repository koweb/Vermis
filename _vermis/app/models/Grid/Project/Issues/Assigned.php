<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Assigned.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Assigned.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
