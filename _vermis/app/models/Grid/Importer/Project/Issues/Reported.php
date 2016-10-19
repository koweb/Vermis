<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/Reported.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Reported.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class Grid_Importer_Project_Issues_Reported
 * @brief Issues importer.
 */
class Grid_Importer_Project_Issues_Reported extends Grid_Importer_Project_Issues
{
    
    protected $_userId = null;
    protected $_identityId = null;
    
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->_userId = (int) $params['userId'];
        $this->_identityId = (int) $params['identityId'];
    }
    
    protected function _addConstraints($query)
    {
        $query->addWhere("i.reporter_id = ?", $this->_userId);
        if ($this->_userId != $this->_identityId)
            $query->addWhere("((SELECT COUNT(*) FROM Project_Member pm WHERE pm.project_id = p.id AND pm.user_id = ?) != 0) OR p.is_private = false", (int) $this->_identityId);
        return $query;
    }
    
}
