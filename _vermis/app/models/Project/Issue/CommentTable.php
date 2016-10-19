<?php

/**
 * =============================================================================
 * @file        Project/Issue/CommentTable.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: CommentTable.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_Issue_CommentTable
 * @brief   Table for Project_Issue_Comment model.
 */
class Project_Issue_CommentTable extends FreeCode_Doctrine_Table
{
    
    /**
     * Get comments for issue.
     * @param $issueId
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getIssueCommentsQuery(
        $issueId, 
        $hydrationMode = Doctrine::HYDRATE_ARRAY
    )
    {
        return Doctrine_Query::create()
            ->select("c.*, u.name, u.slug")
            ->from("Project_Issue_Comment c, c.author u")
            ->addWhere("c.issue_id = ?", (int) $issueId)
            ->orderBy("c.time ASC, c.id ASC")
            ->setHydrationMode($hydrationMode);
    }
    
}
