<?php

/**
 * =============================================================================
 * @file        Project/Issue/FileTable.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: FileTable.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_Issue_FileTable
 * @brief   Table for Project_Issue_File model.
 */
class Project_Issue_FileTable extends FreeCode_Doctrine_Table
{
    
    /**
     * Get files for issue.
     * @param $issueId
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getIssueFilesQuery(
        $issueId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY
    )
    {
        return Doctrine_Query::create()
            ->select("f.*")
            ->from("Project_Issue_File f")
            ->addWhere("f.issue_id = ?", (int) $issueId)
            ->orderBy("f.id ASC")
            ->setHydrationMode($hydrationMode);
    }
    
}
