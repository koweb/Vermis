<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/Search.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Search.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class Grid_Importer_Project_Issues_Search
 * @brief Issues importer.
 */
class Grid_Importer_Project_Issues_Search extends Grid_Importer_Project_Issues
{

    protected $_userId = null;
    protected $_publicOnly = false;
    protected $_isNewQuery = false;
    protected $_query = '';
    
    public function __construct(array $params = array())
    {
        $this->_userId = (int) (isset($params['userId']) ? $params['userId'] : null);
        $this->_publicOnly = (isset($params['publicOnly']) ? $params['publicOnly'] : false);
        
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $this->_query = $request->getParam('query');
        
        $session = new Zend_Session_Namespace('search');
        if (empty($this->_query))
            $this->_query = $session->query;
        else
            $this->_isNewQuery = true;
        $session->query = $this->_query;
    }
    
    public function getCountQuery()
    {
        return $this->_getSearchQuery()
            ->select("COUNT(id)")
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR);
    }
    
    public function getRecordsQuery()
    {
        $grid = $this->getGrid();
        $pager = $grid->getPager()->setTotalRows($this->fetchCount());

        if ($this->_isNewQuery)
            $pager->setPage(1);
        
        return $this->_getSearchQuery()
            ->orderBy($grid->getSortColumn()->getId()." ".$grid->getSortOrder())
            ->limit($pager->getRowsPerPage())
            ->offset($pager->getRowsOffset());
    }
    
    protected function _getSearchQuery()
    {
        $query = Doctrine::getTable('Project_Issue')
            ->getSearchQuery($this->_query);
            
        if ($this->_publicOnly)
            $query->addWhere("p.is_private = false");
            
        if ($this->_userId != 0)
            $query->addWhere("((SELECT COUNT(*) FROM Project_Member pm WHERE pm.project_id = p.id AND pm.user_id = ?) != 0)", (int) $this->_userId);
            
        return $query;
    }
    
}
