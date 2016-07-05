<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/Milestone.php
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
 * @class Grid_Importer_Project_Issues_Milestone
 * @brief Issues importer.
 */
class Grid_Importer_Project_Issues_Milestone extends Grid_Importer_Project_Issues
{
    
    protected $_milestoneId = null;
    
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->_milestoneId = $params['milestoneId'];
    }
    
    public function getCountQuery()
    {
        return parent::getCountQuery()
            ->addWhere("i.milestone_id = ?", (int) $this->_milestoneId);
    }
    
    public function getRecordsQuery()
    {
        return parent::getRecordsQuery()
            ->addWhere("i.milestone_id = ?", (int) $this->_milestoneId);
    }
    
}
