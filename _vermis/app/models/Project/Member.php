<?php

/**
 * =============================================================================
 * @file        Project/Member.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Member.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Project_Member
 * @brief   Project_Member model.
 */
class Project_Member extends FreeCode_Doctrine_Record
{

    const ROLE_LEADER       = 'leader';
    const ROLE_DEVELOPER    = 'developer';
    const ROLE_OBSERVER     = 'observer';
    
    public static $roleLabels = array(
        self::ROLE_LEADER       => 'Leader',
        self::ROLE_DEVELOPER    => 'Developer',
        self::ROLE_OBSERVER     => 'Observer'
    );
    
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('project__member');
        $this->option('type', 'MYISAM');
        
        $this->hasColumn('project_id', 'integer', null, array('primary' => true));
        $this->hasColumn('user_id', 'integer', null, array('primary' => true));
        $this->hasColumn('role', 'enum', 16, array(
            'values' => array(
                self::ROLE_LEADER,
                self::ROLE_DEVELOPER,
                self::ROLE_OBSERVER
            ),
            'default' => self::ROLE_OBSERVER
        ));

        $this->index('project__member_idx', array(
            'fields'    => array('project_id', 'user_id'),
            'primary'   => true,
            'type'      => 'unique'
        ));
    }
	
    public function setUp()
    {
        parent::setUp();
        
        $this->hasOne('Project as project', array(
            'local'     => 'project_id',
            'foreign'   => 'id',
            'onDelete'  => 'CASCADE'
        ));
        
        $this->hasOne('User as user', array(
            'local'     => 'user_id',
            'foreign'   => 'id',
            'onDelete'  => 'CASCADE'
        ));
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
	
}
