<?php

/**
 * =============================================================================
 * @file        Project/Issue/Comment.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Comment.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_Issue_Comment
 * @brief   Comment model.
 */
class Project_Issue_Comment extends FreeCode_Doctrine_Record
{   

    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('project__issue__comment');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('content', 'string');
        $this->hasColumn('time', 'integer');
        $this->hasColumn('author_id', 'integer');
        $this->hasColumn('issue_id', 'integer');
    }
    
    public function setUp()
    {
        parent::setUp();

        $this->hasOne('Project_Issue as issue', array(
            'local'     => 'issue_id',
            'foreign'   => 'id',
            'onDelete'  => 'CASCADE'
        ));
        
        $this->hasOne('User as author', array(
            'local'     => 'author_id',
            'foreign'   => 'id',
            'onDelete'  => 'CASCADE'
        ));
    }

    public function preInsert($event)
    {
        parent::preInsert($event);
        $this->time = time();
    }
    
    public function postInsert($event)
    {
        parent::postInsert($event);
        ActivityObserver::getInstance()->notifyIssue(
            $this->issue, 
            Log::ACTION_COMMENT_ADD, 
            array('comment' => $this->content));
    }
    
    public function postDelete($event)
    {
        parent::postDelete($event);
        ActivityObserver::getInstance()->notifyIssue($this->issue, Log::ACTION_COMMENT_DELETE);
    }
    
}
