<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/Component.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Component.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
