<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Members.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Members.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Importer_Project_Members
 * @brief Members importer.
 */
class Grid_Importer_Project_Members extends FreeCode_Grid_Importer_Doctrine_Abstract
{

    protected $_projectId = null;
    
    public function __construct(array $params)
    {
        $this->_projectId = $params['projectId'];
    }

    public function getCountQuery()
    {
        return Doctrine::getTable('Project_Member')
            ->getProjectMembersQuery((int) $this->_projectId)
            ->select("COUNT(id)")
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR);
    }
    
    public function getRecordsQuery()
    {
        $grid = $this->getGrid();
        $pager = $grid->getPager()->setTotalRows($this->fetchCount());        
        return Doctrine::getTable('Project_Member')
            ->getProjectMembersQuery((int) $this->_projectId)
            ->addFrom("pm.project p")
            ->addSelect("u.slug AS slug, u.name AS name")
            ->addSelect("p.slug AS project_slug")
            ->orderBy($grid->getSortColumn()->getId()." ".$grid->getSortOrder())
            ->limit($pager->getRowsPerPage())
            ->offset($pager->getRowsOffset());
    }
    
}
