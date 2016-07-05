<?php

/**
 * =============================================================================
 * @file        Project/Milestone.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Milestone.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_Milestone
 * @brief   Project_Milestone model.
 */
class Project_Milestone extends FreeCode_Doctrine_Record
{
    
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('project__milestone');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('slug', 'string', 128, array(
            'notnull'   => true
        ));
        $this->hasColumn('name', 'string', 128, array(
            'notnull'   => true
        ));
        $this->hasColumn('description', 'string');
        $this->hasColumn('project_id', 'integer');
        
        $this->hasColumn('create_time', 'integer');
        $this->hasColumn('update_time', 'integer');
        
        $this->hasColumn('author_id', 'integer');
        $this->hasColumn('changer_id', 'integer');
        
        $this->index('project__milestone_unique_idx', array(
            'fields'    => array('project_id', 'slug', 'name'),
            'primary'   => true,
            'type'      => 'unique'
        ));
    }
    
    public function setUp()
    {
        parent::setUp();
        
        $this->actAs('Versionable');
       
        $this->hasOne('Project as project', array(
            'local'     => 'project_id',
            'foreign'   => 'id',
            'onDelete'  => 'CASCADE'
        ));

        $this->hasOne('User as author', array(
            'local'     => 'author_id',
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
        if ($this->changer_id == null)
            $this->changer_id = $this->author_id;
        $this->slug = FreeCode_String::normalize($this->name);
    }
    
    public function preUpdate($event)
    {
        parent::preUpdate($event);
        $this->update_time = time();
        $this->slug = FreeCode_String::normalize($this->name);
    }
    
    public function postInsert($event)
    {
        parent::postInsert($event);
        ActivityObserver::getInstance()->notifyMilestone($this, Log::ACTION_INSERT);
    }
    
    public function postUpdate($event)
    {
        parent::postUpdate($event);
        ActivityObserver::getInstance()->notifyMilestone($this, Log::ACTION_UPDATE);
    }
    
    public function postDelete($event)
    {
        parent::postDelete($event);
        ActivityObserver::getInstance()->notifyMilestone($this, Log::ACTION_DELETE);
    }
    
    /**
     * Get project issues.
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getIssuesQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Issue')
            ->getMilestoneIssuesQuery($this->id, $hydrationMode);
    }
    
    /**
     * Fetch versions.
     * @return array
     */
    public function fetchVersions($limit = null)
    {
        $sql = 
            "SELECT v.*, ".
            "uc.slug AS changer_slug, uc.name AS changer_name ".
            "FROM project__milestone_version v ".
            "LEFT JOIN user uc ON uc.id = v.changer_id ".
            "WHERE v.id = :milestone_id ".
            "ORDER BY v.version DESC"
            ;
        
        if (isset($limit))
            $sql .= ' LIMIT '.(int) $limit;
            
        $stmt = FreeCode_PDO_Manager::getInstance()
            ->getCurrentConnection()
            ->prepare($sql);
        $id = $this->id;
        $stmt->bindParam(':milestone_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
