<?php

/**
 * =============================================================================
 * @file        User.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: User.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   User
 * @brief   User model.
 */
class User extends FreeCode_User
{
    
    public static $roleLabels = array(
        self::ROLE_ADMIN    => 'Admin',
        self::ROLE_USER     => 'User'
    );
    
    public static $statusLabels = array(
        self::STATUS_ACTIVE     => 'Active',
        self::STATUS_INACTIVE   => 'Inactive',
        self::STATUS_BANNED     => 'Banned'
    );
	
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('user');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('role', 'enum', 16, array(
            'notnull'   => true,
            'default'   => self::ROLE_USER,
            'values'    => array(
                self::ROLE_USER,
                self::ROLE_ADMIN
            )
        ));
        
        $this->hasColumn('slug', 'string', 128, array(
            'notnull'   => true,
            'unique'    => true
        ));
        
        $this->hasColumn('email_notify', 'boolean', null, array('default' => true));
    }
    
    public function setUp()
    {
        parent::setUp();
        
        $this->hasMany('Project as created_projects', array(
            'local'     => 'id',
            'foreign'   => 'author_id'
        ));
        
        $this->hasMany('Project as projects', array(
            'local'     => 'user_id',
            'foreign'   => 'project_id',
            'refClass'  => 'Project_Member'
        ));
    }
    
    public function preInsert($event)
    {
        parent::preInsert($event);
        $this->slug = FreeCode_String::normalize($this->name);
    }
    
    public function postInsert($event)
    {
        parent::postInsert($event);
        ActivityMailer::getInstance()->notifyAdminsAboutNewcomer($this);
    }
    
    public function preUpdate($event)
    {
        parent::preUpdate($event);
        $this->slug = FreeCode_String::normalize($this->name);
    }
    
    /**
     * Get projects that user participate.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getMyProjectsQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project')
            ->getUserProjectsQuery($this->id, $hydrationMode);
    }
    
    /**
     * Get issues assigned to me.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getAssignedIssuesQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Issue')
            ->getUserIssuesQuery($this->id, $hydrationMode);
    }
    
    /**
     * Get issues reported by me.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getReportedIssuesQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Project_Issue')
            ->getIssuesQuery($hydrationMode)
            ->addWhere("i.reporter_id = ?", $this->id);
    }
    
    /**
     * Get Activity.
     * @param $hydrationMode
     * @return Doctrine_Query
     */
    public function getActivityQuery($hydrationMode = Doctrine::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('Log')->getLogQuery($hydrationMode)
            ->addWhere("((SELECT COUNT(*) FROM Project_Member pm WHERE pm.project_id = p.id AND pm.user_id = ?) != 0)", (int) $this->id);
    }
	
    /**
     * Get role label.
     * @param string $role
     * @return string
     */
    public static function getRoleLabel($role)
    {
        return (isset(self::$roleLabels[$role]) ? 
            _T(self::$roleLabels[$role]) : _T($role));
    }
    
    /**
     * Get status label.
     * @param string $status
     * @return string
     */
    public static function getStatusLabel($status)
    {
        return (isset(self::$statusLabels[$status]) ? 
            _T(self::$statusLabels[$status]) : _T($status));
    }
    
    /**
     * Check if user is an admin.
     * @return boolean
     */
    public function isAdmin()
    {
        return ($this->role == self::ROLE_ADMIN ? true : false);
    }
    
    public function isMemberOf($projectId)
    {
        return Doctrine::getTable('Project_Member')
            ->memberExists($projectId, $this->id);
    }
    
}
