<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Reported.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Reported.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Issues_Reported
 * @brief Project issues grid.
 */
class Grid_Project_Issues_Reported extends Grid_Project_Issues
{
    
    public function __construct(array $params, $id = 'issues_reported')
    {
        parent::__construct($params, $id);
        $this->setImporter(new Grid_Importer_Project_Issues_Reported($params));
        
        $this->getColumn('reporter_name')->setHidden(true);
        
        $this
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption('reported_issues');
        
        $this->_setActionsForUserGrid($params);
    }
    
}
