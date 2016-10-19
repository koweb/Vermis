<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/Milestone.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Milestone.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
