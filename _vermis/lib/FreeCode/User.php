<?php

/**
 * =============================================================================
 * @file        FreeCode/User.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: User.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class FreeCode_User
 */
abstract class FreeCode_User extends FreeCode_Doctrine_Record
{
    
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ACTIVE   = 'active';
    const STATUS_BANNED   = 'banned';
    const STATUS_DELETED  = 'deleted';
    
    const ROLE_GUEST     = 'guest';
    const ROLE_USER      = 'user';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_ADMIN     = 'admin';
    
    public function setTableDefinition()
    {
        parent::setTableDefinition();
        $this->setTableName('users');
        
        $this->hasColumn('login', 'string',  64, array(
            'notnull'   => true, 
            'unique'    => true
        ));
        
        $this->hasColumn('name', 'string', 128, array(
            'notnull'   => true
        ));
        
        $this->hasColumn('password_hash', 'string', 32, array(
            'notnull' => true
        ));
        
        $this->hasColumn('email', 'string', 128, array(
            'notnull' => true
        ));
        
        $this->hasColumn('confirm_hash', 'string', 32, array(
            'notnull' => true
        ));
        
        $this->hasColumn('status', 'enum', 16, array(
            'notnull'   => true, 
            'default'   => self::STATUS_ACTIVE,
            'values'    => array(
                self::STATUS_INACTIVE,
                self::STATUS_ACTIVE,
                self::STATUS_BANNED,
                self::STATUS_DELETED
            ) 
        ));
        
        $this->hasColumn('role', 'enum', 16, array(
            'notnull'   => true,
            'default'   => self::ROLE_USER,
            'values'    => array(
                self::ROLE_USER,
                self::ROLE_MODERATOR,
                self::ROLE_ADMIN
            )
        ));
        
        $this->hasColumn('last_login_time', 'integer');
        
        $this->hasColumn('last_login_ip', 'string', 32, array(
            'notnull' => true, 
            'default' => '0.0.0.0'
        ));
        
        $this->hasColumn('last_user_agent', 'string', 128, array(
            'notnull' => true, 
            'default' => ''
        ));
        
        $this->hasColumn('create_time', 'integer', null, array(
            'notnull' => true
        ));
        
        $this->index('user_idx', array(
            'fields' => array('login', 'email')
        ));
    }
    
    public function preInsert($event)
    {
        $this->create_time = time();
        
        $this->generateConfirmHash();
        if ($this->password_hash == '')
            $this->generatePasswordHash();
    }
    
    public function isAdmin()
    {
        return ($this->role == self::ROLE_ADMIN ? true : false);
    }
    
    public function isModerator()
    {
        switch ($this->role) {
            case self::ROLE_ADMIN:
            case self::ROLE_MODERATOR;
                return true;
        }
        return false;
    }
    
    public function generateConfirmHash()
    {
        $hash = md5(rand());
        $this->confirm_hash = $hash;
        return $hash;
    }
    
    public function generatePasswordHash()
    {
        $password = FreeCode_String::random(8);
        $this->password_hash = FreeCode_Hash::encodePassword($password);
        return $password;
    }
    
    public function setLoginInfo()
    {
        $this->last_login_time = time();
        $this->last_login_ip = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        $this->last_user_agent = (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '');
    }
}
