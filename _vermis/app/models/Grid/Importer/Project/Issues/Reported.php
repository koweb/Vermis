<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/Reported.php
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
