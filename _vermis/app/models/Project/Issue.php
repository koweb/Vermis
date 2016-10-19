<?php

/**
 * =============================================================================
 * @file        Project/Issue.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Issue.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_Issue
 * @brief   Project_Issue model.
 */
class Project_Issue extends FreeCode_Doctrine_Record
{
    
    const TYPE_TASK         = 'task';
    const TYPE_BUG          = 'bug';
    const TYPE_FEATURE      = 'feature';
    const TYPE_IMPROVEMENT  = 'improvement';
    const TYPE_REFACTORING  = 'refactoring';
    
    const PRIORITY_POSTPONED    = 1;
    const PRIORITY_LOW          = 2;
    const PRIORITY_NORMAL       = 3;
    const PRIORITY_HIGH         = 4;
    const PRIORITY_CRITICAL     = 5; 
    
    const STATUS_OPENED         = 'opened';
    const STATUS_IN_PROGRESS    = 'in_progress';
    const STATUS_RESOLVED       = 'resolved';
    const STATUS_CLOSED         = 'closed';
    
    public static $typeLabels = array(
        Project_Issue::TYPE_TASK        => 'task',
        Project_Issue::TYPE_BUG         => 'bug',
        Project_Issue::TYPE_FEATURE     => 'feature',
        Project_Issue::TYPE_IMPROVEMENT => 'improvement',
        Project_Issue::TYPE_REFACTORING => 'refactoring'
    );
    
    public static $priorityLabels = array(
        Project_Issue::PRIORITY_CRITICAL    => 'critical',
        Project_Issue::PRIORITY_HIGH        => 'high',
        Project_Issue::PRIORITY_NORMAL      => 'normal',
        Project_Issue::PRIORITY_LOW         => 'low',
        Project_Issue::PRIORITY_POSTPONED   => 'postponed'
    );
    
    public static $statusLabels = array(
        Project_Issue::STATUS_OPENED            => 'opened',
        Project_Issue::STATUS_IN_PROGRESS       => 'in_progress',
        Project_Issue::STATUS_RESOLVED          => 'resolved',
        Project_Issue::STATUS_CLOSED            => 'closed'
    );
    
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('project__issue');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('project_id', 'integer', null, array(
            'notnull'   => true
        ));
        $this->hasColumn('number', 'integer', null, array(
            'notnull'   => true
        ));
        $this->hasColumn('milestone_id', 'integer');
        $this->hasColumn('component_id', 'integer');
        
        $this->hasColumn('create_time', 'integer');
        $this->hasColumn('update_time', 'integer');
        
        $this->hasColumn('reporter_id', 'integer');
        $this->hasColumn('assignee_id', 'integer');
        $this->hasColumn('changer_id', 'integer');
        
        $this->hasColumn('title', 'string', 255, array(
            'notnull' => true
        ));
        $this->hasColumn('slug', 'string', 255, array(
            'notnull' => true
        ));
        $this->hasColumn('description', 'string');
        
        $this->hasColumn('type', 'enum', 16, array(
            'notnull'   => true,
            'values'    => array(
                self::TYPE_TASK,
                self::TYPE_BUG,
                self::TYPE_FEATURE,
                self::TYPE_IMPROVEMENT,
                self::TYPE_REFACTORING
            ),
            'default'   => self::TYPE_TASK
        ));
        
        $this->hasColumn('priority', 'integer', null, array(
            'notnull'   => true,
            'default'   => self::PRIORITY_NORMAL
        ));
        
        $this->hasColumn('status', 'enum', 32, array(
            'notnull'   => true,
            'values'    => array(
                self::STATUS_OPENED,
                self::STATUS_IN_PROGRESS,
                self::STATUS_RESOLVED,
                self::STATUS_CLOSED
            ),
            'default'   => self::STATUS_OPENED
        ));
        
        $this->hasColumn('progress', 'integer', null, array(
            'notnull'   => true,
            'default'   => 0
        ));

        $this->index('project__issue_unique_idx', array(
            'fields'    => array('project_id', 'number'),
            'primary'   => true,
            'type'      => 'unique'
        ));

        $this->index('project__issue_fts_idx', array(
            'fields'    => array('title', 'slug'),
            'type'      => 'fulltext'
        ));
    }
    
    public function setUp()
    {
        parent::setUp();
        
        $this->actAs('Versionable', array(
            'excludeFields' => array(
                'slug',
                'number'
            )
        ));
       
        $this->hasOne('Project as project', array(
            'local'     => 'project_id',
            'foreign'   => 'id',
            'onDelete'  => 'CASCADE'
        ));
        
        $this->hasOne('Project_Milestone as milestone', array(
            'local'     => 'milestone_id',
            'foreign'   => 'id',
            'onDelete'  => 'SET NULL'
        ));
        
        $this->hasOne('Project_Component as component', array(
            'local'     => 'component_id',
            'foreign'   => 'id',
            'onDelete'  => 'SET NULL'
        ));
        
        $this->hasOne('User as reporter', array(
            'local'     => 'reporter_id',
            'foreign'   => 'id',
            'onDelete'  => 'SET NULL'
        ));
        
        $this->hasOne('User as assignee', array(
            'local'     => 'assignee_id',
            'foreign'   => 'id',
            'onDelete'  => 'SET NULL'
        ));

        $this->hasOne('User as changer', array(
            'local'     => 'changer_id',
            'foreign'   => 'id',
            'onDelete'  => 'SET NULL'
        ));
    }
    
    public function preInsert($event)
    {
        parent::preInsert($event);
        $time = time();
        $this->create_time = $time;
        $this->update_time = $time;
        $this->changer_id = $this->reporter_id;
        $this->slug = FreeCode_String::normalize($this->title);
    }
    
    public function preUpdate($event)
    {
        parent::preUpdate($event);
        $this->update_time = time();
        $this->slug = FreeCode_String::normalize($this->title);
    }
    
    public function preDelete($event)
    {
        parent::preDelete($event);
        
        // Delete all comments.
        $this
            ->getCommentsQuery(Doctrine::HYDRATE_RECORD)
            ->execute()
            ->delete();
            
        // Delete all files.
        $this
            ->getFilesQuery(Doctrine::HYDRATE_RECORD)
            ->execute()
            ->delete();
    }
    
    public function postInsert($event)
    {
        parent::postInsert($event);
        ActivityObserver::getInstance()->notifyIssue($this, Log::ACTION_INSERT);
    }

    public function postUpdate($event)
    {
        parent::postUpdate($event);
        $action = Log::ACTION_UPDATE;
        $modified = $this->getModified();
        if (array_key_exists('status', $modified)) {
            switch ($modified['status']) {
                case self::STATUS_OPENED: $action = Log::ACTION_ISSUE_OPENED; break;
                case self::STATUS_IN_PROGRESS: $action = Log::ACTION_ISSUE_IN_PROGRESS; break;
                case self::STATUS_RESOLVED: $action = Log::ACTION_ISSUE_RESOLVED; break;
                case self::STATUS_CLOSED: $action = Log::ACTION_ISSUE_CLOSED; break;
            }
            
        } 
        ActivityObserver::getInstance()->notifyIssue($this, $action);
    }
    
    public function postDelete($event)
    {
        parent::postDelete($event);
        ActivityObserver::getInstance()->notifyIssue($this, Log::ACTION_DELETE);
    }
    
    public static function getTypeLabel($type)
    {
        return (isset(self::$typeLabels[$type]) ? 
            _T(self::$typeLabels[$type]) : _T($type));
    }
    
    public static function getPriorityLabel($priority)
    {
        return (isset(self::$priorityLabels[$priority]) ?
            _T(self::$priorityLabels[$priority]) : _T($priority));
    }
    
    public static function getStatusLabel($status)
    {
        return (isset(self::$statusLabels[$status]) ?
            _T(self::$statusLabels[$status]) : _T($status));
    }
    
    /**
     * Get all comments.
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getCommentsQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Issue_Comment')
            ->getIssueCommentsQuery($this->id, $hydrationMode);
    }
    
    /**
     * Get all files.
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getFilesQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Issue_File')
            ->getIssueFilesQuery($this->id, $hydrationMode);
    }
    
    /**
     * Fetch versions.
     * @return array
     */
    public function fetchVersions($limit = null)
    {
        $sql = 
            "SELECT v.*, ".
            "uc.slug AS changer_slug, uc.name AS changer_name, ".
            "ur.slug AS reporter_slug, ur.name AS reporter_name, ".
            "ua.slug AS assignee_slug, ua.name AS assignee_name, ".
            "c.slug AS component_slug, c.name AS component_name, ".
            "m.slug AS milestone_slug, m.name AS milestone_name, ".
            "p.slug AS project_slug ".
            "FROM project__issue_version v ".
            "LEFT JOIN user uc ON uc.id = v.changer_id ".
            "LEFT JOIN user ur ON ur.id = v.reporter_id ".
            "LEFT JOIN user ua ON ua.id = v.assignee_id ".
            "LEFT JOIN project__component c ON c.id = v.component_id ".
            "LEFT JOIN project__milestone m ON m.id = v.milestone_id ".
            "LEFT JOIN project p ON p.id = v.project_id ".
            "WHERE v.id = :issue_id ".
            "ORDER BY v.version DESC"
            ;
        
        if (isset($limit))
            $sql .= ' LIMIT '.(int) $limit;
            
        $stmt = FreeCode_PDO_Manager::getInstance()
            ->getCurrentConnection()
            ->prepare($sql);
        $id = $this->id;
        $stmt->bindParam(':issue_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
