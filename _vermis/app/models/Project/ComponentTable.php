<?php

/**
 * =============================================================================
 * @file        Project/ComponentTable.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentTable.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Project_ComponentTable
 * @brief   Table for Project_Component model.
 */
class Project_ComponentTable extends FreeCode_Doctrine_Table
{
    
    /**
     * Get components for a particular project.
     * @param int $projectId
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getProjectComponentsQuery(
        $projectId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $query = Doctrine_Query::create()
            ->select("c.*")
            ->addSelect('ca.name AS author_name, ca.slug AS author_slug')
            ->addSelect('cc.name AS changer_name, cc.slug AS changer_slug')
            ->addSelect('(SELECT COUNT(i.id) FROM Project_Issue i WHERE i.component_id = c.id) AS num_issues')
            ->from("Project_Component c, c.author ca, c.changer cc")
            ->addWhere("c.project_id = ?", $projectId)
            ->orderBy("c.name ASC")
            ->setHydrationMode($hydrationMode);
        return $query;
    }
    
    /**
     * Check if component exists.
     * @param int       $projectId
     * @param string    $slug
     * @return  boolean
     */
    public function componentExists($projectId, $slug)
    {
        return $this->fetchComponentId($projectId, $slug) != false ? true : false;
    }
    
    /**
     * Find component by project_id and slug.
     * @param int       $projectId
     * @param string    $slug
     * @return  Milestone
     */
    public function fetchComponent($projectId, $slug)
    {
        $id = $this->fetchComponentId($projectId, $slug);
        if ($id == false)
            return false;
        return $this->find($id);
    }
    
    /**
     * Find component by project_id and slug and fetch just an id.
     * @param int       $projectId
     * @param string    $slug
     * @return int
     */
    public function fetchComponentId($projectId, $slug)
    {
        $records = Doctrine_Query::create()
            ->select("c.id")
            ->from("Project_Component c")
            ->addWhere("c.project_id = ?", (int) $projectId)
            ->addWhere("c.slug = ?", $slug)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();
        if (count($records) == 0)
            return false;
        return $records[0]['id'];
    }
    
    /**
     * Fetch components as options.
     * @param int $projectId
     * @return array
     */
    public function fetchComponentsAsOptions($projectId)
    {
        $options = array();
        $options[0] = '- any -';
        $records = $this->getProjectComponentsQuery((int) $projectId)
            ->select("c.id, c.name")
            ->execute();
        foreach ($records as $record)
            $options[$record['id']] = $record['name'];
        return $options;
    }
    
}
