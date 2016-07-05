<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Components.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Components.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Importer_Project_Components
 * @brief Components importer.
 */
class Grid_Importer_Project_Components extends FreeCode_Grid_Importer_Doctrine_Abstract
{
    
    protected $_projectId = null;
    
    public function __construct(array $params)
    {
        $this->_projectId = $params['projectId'];
    }

    public function getCountQuery()
    {
        return Doctrine::getTable('Project_Component')
            ->getProjectComponentsQuery((int) $this->_projectId)
            ->select("COUNT(id)")
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR);
    }
    
    public function getRecordsQuery()
    {
        $grid = $this->getGrid();
        $pager = $grid->getPager()->setTotalRows($this->fetchCount());        
        return Doctrine::getTable('Project_Component')
            ->getProjectComponentsQuery((int) $this->_projectId)
            ->addSelect("p.slug AS project_slug")
            ->addFrom("c.project p")
            ->orderBy($grid->getSortColumn()->getId()." ".$grid->getSortOrder())
            ->limit($pager->getRowsPerPage())
            ->offset($pager->getRowsOffset());
    }
    
}
