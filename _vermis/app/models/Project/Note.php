<?php

/**
 * =============================================================================
 * @file        Project/Note.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Note.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Project_Note
 * @brief   Project_Note model.
 */
class Project_Note extends FreeCode_Doctrine_Record
{
    
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('project__note');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('project_id', 'integer', null, array(
            'notnull'   => true
        ));
        
        $this->hasColumn('create_time', 'integer');
        $this->hasColumn('update_time', 'integer');
        
        $this->hasColumn('author_id', 'integer');
        $this->hasColumn('changer_id', 'integer');
        
        $this->hasColumn('title', 'string', 128, array(
            'notnull' => true
        ));
        $this->hasColumn('slug', 'string', 128, array(
            'notnull' => true
        ));
        $this->hasColumn('content', 'string');
        
        $this->index('project__note_unique_idx', array(
            'fields'    => array('project_id', 'slug', 'title'),
            'primary'   => true,
            'type'      => 'unique'
        ));
        
        $this->index('project__note_fts_idx', array(
            'fields'    => array('title', 'slug', 'content'),
            'type'      => 'fulltext'
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
        $this->changer_id = $this->author_id;
        $this->slug = FreeCode_String::normalize($this->title);
    }
    
    public function preUpdate($event)
    {
        parent::preUpdate($event);
        $this->update_time = time();
        $this->slug = FreeCode_String::normalize($this->title);
    }
    
    public function postInsert($event)
    {
        parent::postInsert($event);
        ActivityObserver::getInstance()->notifyNote($this, Log::ACTION_INSERT);
    }
    
    public function postUpdate($event)
    {
        parent::postUpdate($event);
        ActivityObserver::getInstance()->notifyNote($this, Log::ACTION_UPDATE);
    }
    
    public function postDelete($event)
    {
        parent::postDelete($event);
        ActivityObserver::getInstance()->notifyNote($this, Log::ACTION_DELETE);
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
            "FROM project__note_version v ".
            "LEFT JOIN user uc ON uc.id = v.changer_id ".
            "WHERE v.id = :note_id ".
            "ORDER BY v.version DESC"
            ;
        
        if (isset($limit))
            $sql .= ' LIMIT '.(int) $limit;
            
        $stmt = FreeCode_PDO_Manager::getInstance()
            ->getCurrentConnection()
            ->prepare($sql);
        $id = $this->id;
        $stmt->bindParam(':note_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
