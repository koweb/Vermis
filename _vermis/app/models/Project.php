<?php

/**
 * =============================================================================
 * @file        Project.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Project.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project
 * @brief   Project model.
 */
class Project extends FreeCode_Doctrine_Record
{

    protected $_disableNotify = false;
    
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('project');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('author_id', 'integer');
        $this->hasColumn('changer_id', 'integer');
        $this->hasColumn('slug', 'string', 128, array(
            'notnull'   => true,
            'unique'    => true
        ));
        $this->hasColumn('name', 'string', 128, array(
            'notnull'   => true,
            'unique'    => true
        ));
        $this->hasColumn('description', 'string');
        $this->hasColumn('create_time', 'integer');
        $this->hasColumn('update_time', 'integer');
        $this->hasColumn('issue_counter', 'integer', null, array(
            'notnull'   => true,
            'default'   => 0
        ));
        $this->hasColumn('is_private', 'boolean', null, array(
            'notnull'   => true,
            'default'   => false
        ));

        $this->index('project_name_idx', array('fields' => array('name')));
    }
	
    public function setUp()
    {
	   parent::setUp();
	   
	   $this->actAs('Versionable', array(
	       'excludeFields' => array(
	           'issue_counter',
	           'slug'
	       )
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
       
	   $this->hasMany('User as members', array(
	       'local'     => 'project_id',
	       'foreign'   => 'user_id',
	       'refClass'  => 'Project_Member'
	   ));
	   
	   $this->hasMany('Project_Milestone as milestones', array(
	       'local'     => 'id',
	       'foreign'   => 'project_id'
	   ));
	   
       $this->hasMany('Project_Component as components', array(
           'local'     => 'id',
           'foreign'   => 'project_id'
       ));
       
	   $this->hasMany('Project_Issue as issues', array(
	       'local'     => 'id',
	       'foreign'   => 'project_id'
	   ));

	   $this->hasMany('Project_Note as notes', array(
           'local'     => 'id',
           'foreign'   => 'project_id'
       ));
    }   
	
    public function preInsert($event)
    {
        parent::preInsert($event);
        $time = time();
        $this->create_time = $time;
        $this->update_time = $time;
        $this->changer_id = $this->author_id;
        $this->slug = FreeCode_String::normalize($this->name);
    }
    
    public function preUpdate($event)
    {
        parent::preUpdate($event);
        $modified = $this->getModified();
        $this->_disableNotify = false;
        if (!(array_key_exists('issue_counter', $modified) && count($modified) == 1)) {
            $this->update_time = time();
            $this->slug = FreeCode_String::normalize($this->name);
        } else {
            $this->_disableNotify = true;
        }
    }
    
    public function postUpdate($event)
    {
        parent::postUpdate($event);
        if (!$this->_disableNotify) {
            ActivityObserver::getInstance()->notifyProject($this, Log::ACTION_UPDATE);
        }
    }
    
    public function postInsert($event)
    {
        parent::postInsert($event);
        ActivityObserver::getInstance()->notifyProject($this, Log::ACTION_INSERT);
    }
    
    public function preDelete($event)
    {
        parent::preDelete($event);
        
        /// @TODO: MyISAM does not have foreign keys :<

        // Remove all issues.
        $this
            ->getIssuesQuery(Doctrine::HYDRATE_RECORD)
            ->execute()
            ->delete();
        
        // Remove all components.
        $this
            ->getComponentsQuery(Doctrine::HYDRATE_RECORD)
            ->execute()
            ->delete();
        
        // Remove all milestones.
        $this
            ->getMilestonesQuery(Doctrine::HYDRATE_RECORD)
            ->execute()
            ->delete();
        
        // Remove all notes.
        $this
            ->getNotesQuery(Doctrine::HYDRATE_RECORD)
            ->execute()
            ->delete();
        
        // Remove all members.
        $this
            ->getMembersQuery(Doctrine::HYDRATE_RECORD)
            ->execute()
            ->delete();
        
        ActivityObserver::getInstance()->notifyProject($this, Log::ACTION_DELETE);
    }
    
    /**
     * Get project members query.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getMembersQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Member')
            ->getProjectMembersQuery($this->id, $hydrationMode);
    }
	
    /**
     * Get project leaders query.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getLeadersQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getMembersQuery()
            ->addWhere("pm.role = ?", Project_Member::ROLE_LEADER);
    }
    
    /**
     * Get project developers query.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getDevelopersQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getMembersQuery()
            ->addWhere("pm.role = ?", Project_Member::ROLE_DEVELOPER);
    }
    
    /**
     * Get project observers query.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getObserversQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return $this->getMembersQuery()
            ->addWhere("pm.role = ?", Project_Member::ROLE_OBSERVER);
    }
    
    /**
     * Get project non members query.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getNonMembersQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Member')
            ->getProjectNonMembersQuery($this->id, $hydrationMode);
    }
    
    /**
     * Get a count of non members.
     * @param $projectId
     * @return  int
     */
    public function getNonMembersCount()
    {
        return Doctrine::getTable('Project_Member')
            ->getProjectNonMembersCount($this->id);
    }
    
    /**
     * Get project milestones.
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getMilestonesQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Milestone')
            ->getProjectMilestonesQuery($this->id, $hydrationMode);
    }
    
    /**
     * Get project components.
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getComponentsQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Component')
            ->getProjectComponentsQuery($this->id, $hydrationMode);
    }
    
    /**
     * Get project issues.
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getIssuesQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Issue')
            ->getProjectIssuesQuery($this->id, $hydrationMode);
    }
    
    /**
     * Get Activity.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getActivityQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Log')
            ->getLogQuery($hydrationMode)
            ->addWhere("l.project_id = ?", $this->id);
    }
    
    /**
     * Get project notes.
     * @param $hydrationMode
     * @return  Doctrine_Query
     */
    public function getNotesQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Note')
            ->getProjectNotesQuery($this->id, $hydrationMode);
    }
    
    /**
     * Fetch versions.
     * @param $hydrationMode
     * @return array
     */
    public function fetchVersions($limit = null)
    {
        $sql = 
            "SELECT v.*, ".
            "uc.slug AS changer_slug, uc.name AS changer_name ".
            "FROM project_version v ".
            "LEFT JOIN user uc ON uc.id = v.changer_id ".
            "WHERE v.id = :project_id ".
            "ORDER BY v.version DESC"
            ;
            
        if (isset($limit))
            $sql .= ' LIMIT '.(int) $limit;
            
        $stmt = FreeCode_PDO_Manager::getInstance()
            ->getCurrentConnection()
            ->prepare($sql);
        $id = $this->id;
        $stmt->bindParam(':project_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
