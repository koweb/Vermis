<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Users.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Users.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Importer_Users
 * @brief Users importer.
 */
class Grid_Importer_Users extends FreeCode_Grid_Importer_Doctrine_Abstract
{

    public function getCountQuery()
    {
        return Doctrine::getTable('User')
            ->getUsersListQuery()
            ->select("COUNT(id)")
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR);
    }
    
    public function getRecordsQuery()
    {
        $grid = $this->getGrid();
        $pager = $grid->getPager()->setTotalRows($this->fetchCount());        
        return Doctrine::getTable('User')
            ->getUsersListQuery()
            ->orderBy($grid->getSortColumn()->getId()." ".$grid->getSortOrder())
            ->limit($pager->getRowsPerPage())
            ->offset($pager->getRowsOffset());
    }
    
}
