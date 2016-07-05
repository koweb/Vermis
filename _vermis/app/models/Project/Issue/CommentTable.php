<?php

/**
 * =============================================================================
 * @file        Project/Issue/CommentTable.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: CommentTable.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
