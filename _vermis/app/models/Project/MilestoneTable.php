<?php

/**
 * =============================================================================
 * @file        Project/MilestoneTable.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MilestoneTable.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_MilestoneTable
 * @brief   Table for Project_Milestone model.
 */
class Project_MilestoneTable extends FreeCode_Doctrine_Table
{
    
    /**
     * Get milestones for a particular project.
     * @param int $projectId
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getProjectMilestonesQuery(
        $projectId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $query = Doctrine_Query::create()
            ->select("m.*")
            ->addSelect('ma.name AS author_name, ma.slug AS author_slug')
            ->addSelect('mc.name AS changer_name, mc.slug AS changer_slug')
            ->addSelect('(SELECT COUNT(i.id) FROM Project_Issue i WHERE i.milestone_id = m.id) AS num_issues')
            ->from("Project_Milestone m, m.author ma, m.changer mc")
            ->addWhere("m.project_id = ?", $projectId)
            ->orderBy("m.name DESC")
            ->setHydrationMode($hydrationMode);
        return $query;
    }
    
    /**
     * Check if milestone exists.
     * @param int       $projectId
     * @param string    $slug
     * @return  boolean
     */
    public function milestoneExists($projectId, $slug)
    {
        return $this->fetchMilestoneId($projectId, $slug) != false ? true : false;
    }
    
    /**
     * Find milestone by project_id and slug.
     * @param int       $projectId
     * @param string    $slug
     * @return  Milestone
     */
    public function fetchMilestone($projectId, $slug)
    {
        $id = $this->fetchMilestoneId($projectId, $slug);
        if ($id == false)
            return false;
        return $this->find($id);
    }
    
    /**
     * Find milestone by project_id and slug and fetch just an id.
     * @param int       $projectId
     * @param string    $slug
     * @return int
     */
    public function fetchMilestoneId($projectId, $slug)
    {
        $records = Doctrine_Query::create()
            ->select("m.id")
            ->from("Project_Milestone m")
            ->addWhere("m.project_id = ?", (int) $projectId)
            ->addWhere("m.slug = ?", $slug)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();
        if (count($records) == 0)
            return false;
        return $records[0]['id'];
    }
    
    /**
     * Fetch milestones as options.
     * @param int $projectId
     * @return array
     */
    public function fetchMilestonesAsOptions($projectId)
    {
        $options = array();
        $options[0] = '- any -';
        $records = $this->getProjectMilestonesQuery((int) $projectId)
            ->select("m.id, m.name")
            ->execute();
        foreach ($records as $record)
            $options[$record['id']] = $record['name'];
        return $options;
    }
    
}
