<?php

/**
 * =============================================================================
 * @file        Log.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Log.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Log
 * @brief   Log model.
 */
class Log extends FreeCode_Doctrine_Record
{   

    const TYPE_PROJECT      = 'project';
    const TYPE_MILESTONE    = 'milestone';
    const TYPE_COMPONENT    = 'component';
    const TYPE_ISSUE        = 'issue';
    const TYPE_NOTE         = 'note';
    
    const ACTION_INSERT         = 'insert';
    const ACTION_UPDATE         = 'update';
    const ACTION_DELETE         = 'delete';
    const ACTION_NOTICE         = 'notice';
    
    // Comments
    const ACTION_COMMENT_ADD    = 'comment-add';
    const ACTION_COMMENT_DELETE = 'comment-delete';
    
    // Files
    const ACTION_FILE_ADD    = 'file-add';
    const ACTION_FILE_DELETE = 'file-delete';
    
    // Issues
    const ACTION_ISSUE_OPENED       = 'issue-opened';
    const ACTION_ISSUE_IN_PROGRESS  = 'issue-in-progress';
    const ACTION_ISSUE_RESOLVED     = 'issue-resolved';
    const ACTION_ISSUE_CLOSED       = 'issue-closed';
    
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('log');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('time', 'integer');
        $this->hasColumn('user_id', 'integer');
        $this->hasColumn('project_id', 'integer');
        $this->hasColumn('resource_id', 'integer', null, array(
            'notnull'   => true
        ));
        $this->hasColumn('resource_type', 'enum', 16, array(
            'notnull'   => true,
            'values'    => array(
                self::TYPE_PROJECT,
                self::TYPE_MILESTONE,
                self::TYPE_COMPONENT,
                self::TYPE_ISSUE,
                self::TYPE_NOTE
            )
        ));
        $this->hasColumn('action', 'enum', 24, array(
            'notnull'   => true,
            'values'    => array(
                self::ACTION_INSERT,
                self::ACTION_UPDATE,
                self::ACTION_DELETE,
                self::ACTION_NOTICE,
                self::ACTION_COMMENT_ADD,
                self::ACTION_COMMENT_DELETE,
                self::ACTION_FILE_ADD,
                self::ACTION_FILE_DELETE,
                self::ACTION_ISSUE_OPENED,
                self::ACTION_ISSUE_IN_PROGRESS,
                self::ACTION_ISSUE_RESOLVED,
                self::ACTION_ISSUE_CLOSED
            )
        ));
        $this->hasColumn('message', 'string');
        $this->hasColumn('params', 'string'); /// @TODO: default is serialize(array())
    }
    
    public function setUp()
    {
        parent::setUp();
        
        $this->hasOne('Project as project', array(
            'local'     => 'project_id',
            'foreign'   => 'id',
            'onDelete'  => 'SET NULL'
        ));
        
        $this->hasOne('User as user', array(
            'local'     => 'user_id',
            'foreign'   => 'id',
            'onDelete'  => 'SET NULL'
        ));
    }
    
    public function preInsert($event)
    {
        parent::preInsert($event);
        $this->time = time();
    }
    
    public static function append(
        $userId,
        $projectId,
        $resourceId,
        $resourceType,
        $action,
        $message = '',
        $params = array())
    {
        $log = new Log;
        $log->user_id = $userId;
        $log->project_id = $projectId;
        $log->resource_id = $resourceId;
        $log->resource_type = $resourceType;
        $log->action = $action;
        $log->message = $message;
        $log->params = serialize($params);
        $log->save();
        
        return $log->id;
    }
    
}
