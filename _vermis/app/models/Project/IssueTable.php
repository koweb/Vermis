<?php

/**
 * =============================================================================
 * @file        Project/IssueTable.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueTable.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Project_IssueTable
 * @brief   Table for Project_Issue model.
 */
class Project_IssueTable extends FreeCode_Doctrine_Table
{
    
    /**
     * Get issues query.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getIssuesQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine_Query::create()
            ->select(
                "i.*, r.name as reporter_name, r.slug as reporter_slug, ".
                "a.name as assignee_name, a.slug as assignee_slug, ".
                "m.name as milestone_name, m.slug as milestone_slug, ".
                "c.name as component_name, c.slug as component_slug, ".
                "p.name as project_name, p.slug as project_slug")
            ->from("Project_Issue i, i.reporter r, i.assignee a, i.milestone m, i.component c, i.project p")
            ->orderBy("i.id DESC")
            ->setHydrationMode($hydrationMode);
    }
    
    /**
     * Get issues for the particular project.
     * @param int   $projectId
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getProjectIssuesQuery(
        $projectId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getIssuesQuery($hydrationMode)
            ->addWhere("i.project_id = ?", (int) $projectId);
    }
    
    /**
     * Get all issues assigned to the user.
     * @param int   $userId
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getUserIssuesQuery(
        $userId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getIssuesQuery($hydrationMode)
            ->addWhere("i.assignee_id = ?", (int) $userId);
    }
    
    /**
     * Get all issues assigned to the milestone.
     * @param int   $milestoneId
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getMilestoneIssuesQuery(
        $milestoneId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getIssuesQuery($hydrationMode)
            ->addWhere("i.milestone_id = ?", (int) $milestoneId);
    }
    
    /**
     * Get all issues assigned to the component.
     * @param int   $componentId
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getComponentIssuesQuery(
        $componentId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getIssuesQuery($hydrationMode)
            ->addWhere("i.component_id = ?", (int) $componentId);
    }
    
    /**
     * Fetch issue.
     * @param int $projectId
     * @param int $issueNumber
     * @return  Project_Issue
     */
    public function fetchIssue($projectId, $issueNumber)
    {
        $id = $this->fetchIssueId($projectId, $issueNumber);
        if ($id == false)
            return false;
        return $this->find($id);
    }
    
    /**
     * Fetch issue id by project_id and issue_number.
     * @param int $projectId
     * @param int $issueNumber
     * @return int
     */
    public function fetchIssueId($projectId, $issueNumber)
    {
        $records = Doctrine_Query::create()
            ->select("i.id")
            ->from("Project_Issue i")
            ->addWhere("i.project_id = ?", (int) $projectId)
            ->addWhere("i.number = ?", (int) $issueNumber)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();
        if (count($records) == 0)
            return false;
        return $records[0]['id'];
    }

    /**
     * Get fulltext search query.
     * @param $noodle Pattern
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getSearchQuery($noodle, $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        /**
         * @TODO:
         * You who read this, please forgive me the code I wrote below.
         */
        
        $query = $this->getIssuesQuery($hydrationMode);
        
        // Check if just a number.
        if (preg_match('/^[0-9]+$/', $noodle)) {
            return $query->addWhere("i.number = ? OR i.title LIKE '%{$noodle}%'", (int) $noodle);
        }
        
        /// @TODO: SQL injection?
        $noodle = str_replace('*', '', $noodle);
        $noodle = str_replace('+', '', $noodle);
        $noodle = str_replace('-', '', $noodle);
        $noodle = str_replace('\'', '', $noodle);
        $noodle = str_replace('\\', '', $noodle);
        $noodle = str_replace('\'', '', $noodle);
        $noodle = str_replace('"', '', $noodle);
        $noodle = addslashes(trim($noodle));
        $ftsNoodle = FreeCode_String::mysqlFtsQuery($noodle, '*', '*');
        
        // FTS.
        $where = 
            "MATCH(title, slug) " .
            "AGAINST ('{$ftsNoodle}' IN BOOLEAN MODE) OR title LIKE '%{$noodle}%'";
        $query->addWhere($where);
        
        return $query;
    }
    
}
