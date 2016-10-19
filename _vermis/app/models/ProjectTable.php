<?php

/**
 * =============================================================================
 * @file        ProjectTable.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProjectTable.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   ProjectTable
 * @brief   Table for Project model.
 */
class ProjectTable extends FreeCode_Doctrine_Table
{
	
    /**
     * Get projects list.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getProjectsListQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine_Query::create()
            ->select('p.*')
            ->addSelect('pa.name AS author_name, pa.slug AS author_slug')
            ->addSelect('pc.name AS changer_name, pc.slug AS changer_slug')
            ->addSelect('(SELECT COUNT(i.id) FROM Project_Issue i WHERE i.project_id = p.id) AS num_issues')
            ->from('Project p, p.author pa, p.changer pc')
            ->orderBy('p.name ASC')
            ->setHydrationMode($hydrationMode);
    }
    
    /**
     * Get projects that user participate.
     * @param int $userId
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getUserProjectsQuery($userId, $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getProjectsListQuery($hydrationMode)
            ->addFrom('p.members u')
            ->addWhere('u.id = ?', (int) $userId);
    }
    
    /**
     * Get projects available for an user.
     * @param int $userId
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getAvailableProjectsQuery($userId, $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getProjectsListQuery($hydrationMode)
            ->addWhere("((SELECT COUNT(*) FROM Project_Member pm WHERE pm.project_id = p.id AND pm.user_id = ?) != 0 OR p.is_private = false)", (int) $userId);
    }
    
    /**
     * Get projects where each project has the $memberId member and is available
     * for the $userId user.
     * @param int $memberId
     * @param int $userId
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getCommonProjectsQuery($memberId, $userId = null, $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $query = $this->getProjectsListQuery($hydrationMode)
            ->addFrom('p.members u')
            ->addWhere('u.id = ?', (int) $memberId);
            
        if (isset($userId) && $userId != $memberId)
            $query->addWhere("((SELECT COUNT(*) FROM Project_Member pm WHERE pm.project_id = p.id AND pm.user_id = ?) != 0 OR p.is_private = false)", (int) $userId);
            
        return $query;
    }
    
    /**
     * Get public projects.
     * @param int $hydrationMode
     * @return Doctrine_Query
     */
    public function getPublicProjectsQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getProjectsListQuery($hydrationMode)
            ->addWhere("p.is_private = false");
    }
    
}
