<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/Component.php
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
 * @class Grid_Importer_Project_Issues_Component
 * @brief Issues importer.
 */
class Grid_Importer_Project_Issues_Component extends Grid_Importer_Project_Issues
{
    
    protected $_componentId = null;
    
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->_componentId = $params['componentId'];
    }
    
    public function getCountQuery()
    {
        return parent::getCountQuery()
            ->addWhere("i.component_id = ?", (int) $this->_componentId);
    }
    
    public function getRecordsQuery()
    {
        return parent::getRecordsQuery()
            ->addWhere("i.component_id = ?", (int) $this->_componentId);
    }
    
}
