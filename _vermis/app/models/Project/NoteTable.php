<?php

/**
 * =============================================================================
 * @file        Project/NoteTable.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NoteTable.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_NoteTable
 * @brief   Table for Project_Note model.
 */
class Project_NoteTable extends FreeCode_Doctrine_Table
{
    
    /**
     * Get notes for a particular project.
     * @param int $projectId
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getProjectNotesQuery(
        $projectId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        $query = Doctrine_Query::create()
            ->select("n.*")
            ->from("Project_Note n")
            ->addWhere("n.project_id = ?", $projectId)
            ->orderBy("n.title ASC")
            ->setHydrationMode($hydrationMode);
        return $query;
    }
    
    /**
     * Check if a note exists.
     * @param int       $projectId
     * @param string    $slug
     * @return  boolean
     */
    public function noteExists($projectId, $slug)
    {
        return $this->fetchNoteId($projectId, $slug) != false ? true : false;
    }
    
    /**
     * Find a note by project_id and slug.
     * @param int       $projectId
     * @param string    $slug
     * @return  Milestone
     */
    public function fetchNote($projectId, $slug)
    {
        $id = $this->fetchNoteId($projectId, $slug);
        if ($id == false)
            return false;
        return $this->find($id);
    }
    
    /**
     * Find a note by project_id and slug and fetch just an id.
     * @param int       $projectId
     * @param string    $slug
     * @return int
     */
    public function fetchNoteId($projectId, $slug)
    {
        $records = Doctrine_Query::create()
            ->select("n.id")
            ->from("Project_Note n")
            ->addWhere("n.project_id = ?", (int) $projectId)
            ->addWhere("n.slug = ?", $slug)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();
        if (count($records) == 0)
            return false;
        return $records[0]['id'];
    }
    
}
