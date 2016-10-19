<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Issues.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class Grid_Importer_Project_Issues
 * @brief Issues importer.
 */
class Grid_Importer_Project_Issues extends FreeCode_Grid_Importer_Doctrine_Abstract
{
    
    protected $_projectId = null;
    protected $_projectSlug = null;
    protected $_userId = null;
    
    public function __construct(array $params)
    {
        $this->_projectId = (isset($params['projectId']) ? (int) $params['projectId'] : null);
        $this->_projectSlug = (isset($params['projectSlug']) ? $params['projectSlug'] : null);
        $this->_userId = (isset($params['userId']) ? (int) $params['userId'] : null);
    }

    public function getCountQuery()
    {
        $query = Doctrine::getTable('Project_Issue')
            ->getIssuesQuery()
            ->select("COUNT(id)")
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR);

        $this->_addConstraints($query);
        
        return $query;
    }
    
    public function getRecordsQuery()
    {
        $grid = $this->getGrid();
        $pager = $grid->getPager()->setTotalRows($this->fetchCount());        
        $query = Doctrine::getTable('Project_Issue')->getIssuesQuery();
            
        $this->_addConstraints($query);
                
        return $query;
    }
    
    protected function _addConstraints($query)
    {
        if (!is_null($this->_projectId))
            $query->addWhere("i.project_id = ?", (int) $this->_projectId);
            
        if (is_null($this->_userId))
            $query->addWhere("p.is_private = false");
        else if (is_null($this->_projectId))
            $query->addWhere("((SELECT COUNT(*) FROM Project_Member pm WHERE pm.project_id = p.id AND pm.user_id = ?) != 0) OR p.is_private = false", (int) $this->_userId);
    }

}
