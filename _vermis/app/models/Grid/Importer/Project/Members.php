<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Members.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Members.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
