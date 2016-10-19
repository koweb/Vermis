<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Projects.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Projects.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class Grid_Importer_Projects
 * @brief Projects importer.
 */
class Grid_Importer_Projects extends FreeCode_Grid_Importer_Doctrine_Abstract
{

    protected $_userId = null;
    protected $_publicOnly = false;
    
    public function __construct(array $params)
    {
        $this->_userId = (int) (isset($params['userId']) ? $params['userId'] : null);
        $this->_publicOnly = (isset($params['publicOnly']) ? $params['publicOnly'] : false);
    }
    
    public function getCountQuery()
    {
        return $this->_getProjectsQuery()
            ->select("COUNT(p.id)")
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR);
    }
    
    public function getRecordsQuery()
    {
        $grid = $this->getGrid();
        $pager = $grid->getPager()->setTotalRows($this->fetchCount());        
        return $this->_getProjectsQuery()
            ->orderBy($grid->getSortColumn()->getId()." ".$grid->getSortOrder())
            ->limit($pager->getRowsPerPage())
            ->offset($pager->getRowsOffset());
    }
    
    protected function _getProjectsQuery()
    {
        $title = $this->getGrid()->getToolbar('top')->getElement('title');        
        $table = Doctrine::getTable('Project');
        if ($this->_userId != 0) {
            $query = $table->getAvailableProjectsQuery($this->_userId);
            $title->setCaption('Available projects');
            
        } else {
            $query = $table->getProjectsListQuery();
            $title->setCaption('All projects');
        }
            
        if ($this->_publicOnly) {
            $query->addWhere("p.is_private = false");
            $title->setCaption('Public projects');
        }
            
        return $query;
    }
    
}
