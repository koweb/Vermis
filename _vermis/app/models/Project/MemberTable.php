<?php

/**
 * =============================================================================
 * @file        Project/MemberTable.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MemberTable.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_MemberTable
 * @brief   Table for Project_Member model.
 */
class Project_MemberTable extends FreeCode_Doctrine_Table
{
	
    /**
     * Check if an user is the member of the project.
     * @param $projectId
     * @param $userId
     * @return boolean
     */
    public function memberExists($projectId, $userId)
    {
        $query = Doctrine_Query::create()
            ->select("pm.*")
            ->from("Project_Member pm")
            ->addWhere("pm.project_id = ?", (int) $projectId)
            ->addWhere("pm.user_id = ?", (int) $userId)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY);
        $records = $query->execute();
        return (count($records) < 1 ? false : true);
    } 
    
    /**
     * Add an user to the project.
     * @param $projectId
     * @param $userId
     * @return boolean
     */
    public function addMember($projectId, $userId, $role)
    {
        if ($this->memberExists($projectId, $userId))
            return false;
            
        $pm = new Project_Member;
        $pm->project_id = $projectId;
        $pm->user_id = $userId;
        $pm->role = $role;
        $pm->save();
            
        return true;
    }
    
    /**
     * Delete an user from the project.
     * @param $projectId
     * @param $memberId
     * @return void
     */
    public function deleteMember($projectId, $userId)
    {
        $query = Doctrine_Query::create()
            ->delete('pm')
            ->from('Project_Member pm')
            ->addWhere("pm.project_id = ?", (int) $projectId)
            ->addWhere("pm.user_id = ?", (int) $userId)
            ->execute();
    }
    
    /**
     * Get users whom are involved into the project.
     * @param $projectId
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getProjectMembersQuery($projectId, $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $query = Doctrine_Query::create()
            ->select("pm.*, u.*")
            ->from("Project_Member pm, pm.user u")
            ->addWhere("pm.project_id = ?", (int) $projectId)
            ->orderBy("u.name ASC")
            ->setHydrationMode($hydrationMode);
        return $query;
    }
    
    /**
     * Get users whom are not involved into the project.
     * @param $projectId
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getProjectNonMembersQuery($projectId, $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $query = Doctrine_Query::create()
            ->select("u.*")
            ->from("User u")
            ->addWhere("((SELECT COUNT(*) FROM Project_Member pm WHERE pm.user_id = u.id AND pm.project_id = ?) = 0)", $projectId)
            ->orderBy("u.name ASC")
            ->setHydrationMode($hydrationMode);
        return $query;
    }
    
    /**
     * Get a count of non members.
     * @param $projectId
     * @return  int
     */
    public function getProjectNonMembersCount($projectId)
    {
        $results = $this->getProjectNonMembersQuery($projectId)
            ->select("COUNT(u.id) AS cnt")
            ->execute();
        if (count($results) == 0)
            return false;
        return $results[0]['cnt'];
    }
    
    /**
     * Get role of the member.
     * @param $projectId
     * @param $userId
     * @return string | Project_Member::ROLE_OBSERVER
     */
    public function getRole($projectId, $userId)
    {
        $query = Doctrine_Query::create()
            ->select("pm.*")
            ->from("Project_Member pm")
            ->addWhere("pm.project_id = ?", (int) $projectId)
            ->addWhere("pm.user_id = ?", (int) $userId)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY);
        $records = $query->execute();
        return (count($records) < 1 ? 
            Project_Member::ROLE_OBSERVER : 
            $records[0]['role']);
    }
    
    /**
     * Fetch project members as options.
     * @param int $projectId
     * @return array
     */
    public function fetchMembersAsOptions($projectId)
    {
        $options = array();
        $options[0] = '- any -';
        $records = $this->getProjectMembersQuery((int) $projectId)
            ->select("pm.user_id, u.name as user_name")
            ->execute();
        foreach ($records as $record)
            $options[$record['user_id']] = $record['user_name'];
        return $options;
    }
    
}
