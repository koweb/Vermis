<?php

/**
 * =============================================================================
 * @file        Project/Issue/FileTable.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: FileTable.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
