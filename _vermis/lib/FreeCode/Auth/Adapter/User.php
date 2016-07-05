<?php

/**
 * =============================================================================
 * @file        FreeCode/Auth/Adapter/User.php
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
 * @class   FreeCode_Auth_Adapter_User
 * @brief   Authorization adapter for FreeCode_User.
 */
class FreeCode_Auth_Adapter_User implements Zend_Auth_Adapter_Interface
{
    
    protected $_login = null;
    protected $_passwordHash  = null;
    protected $_modelName = null;
    protected $_user = null;
    
    /**
     * Constructor.
     * @param   string  $login          Login.
     * @param   string  $passwordHash   Password hash.
     * @param   string  $modelName      Doctrine model class name.
     */
    public function __construct($login, $passwordHash, $modelName = 'User')
    {
        $this->_login = $login;
        $this->_passwordHash = $passwordHash;
        $this->_modelName = $modelName;
    }
    
    /**
     * Get user record as array.
     * @return  array
     */
    public function getUserAsArray()
    {
        return $this->_user;
    }
    
    /**
     * Authenticate.
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        $resultCode = Zend_Auth_Result::FAILURE;
        $resultIdentity = null;
        $resultMessages = array();

        // Get user record from database.
        $table = Doctrine::getTable($this->_modelName);
        $user = $table->findOneByLogin($this->_login);
        if (!$user)
            $user = $table->findOneByEmail($this->_login);

        // Throw error if user is not found.
        if (!$user) {
            $resultCode = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
            $resultMessages[] = 'Failure identity not found!';
            return new Zend_Auth_Result($resultCode, $resultIdentity, $resultMessages);
        }

        // Throw error if password mismatch.
        if ($user->password_hash != $this->_passwordHash) {
            $resultCode = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $resultMessages[] = 'Failure credential invalid!';
            return new Zend_Auth_Result($resultCode, $resultIdentity, $resultMessages);
        }
        
        // Throw error if user is not activated.
        if ($user->status == User::STATUS_INACTIVE) {
            $resultMessages[] = 'Failure user is not activated yet!';
            return new Zend_Auth_Result($resultCode, $resultIdentity, $resultMessages);
        }

        // Throw error if user is banned.
        if ($user->status == User::STATUS_BANNED) {
            $resultMessages[] = 'Failure user is banned!';
            return new Zend_Auth_Result($resultCode, $resultIdentity, $resultMessages);
        }

        // Throw error if user is deleted.
        if ($user->status == User::STATUS_DELETED) {
            $resultMessages[] = 'Failure user is deleted!';
            return new Zend_Auth_Result($resultCode, $resultIdentity, $resultMessages);
        }
        
        $this->_user = $user->toArray();

        // Success.
        $resultCode = Zend_Auth_Result::SUCCESS;
        $resultMessages[] = 'Success!';
        $resultIdentity = $user->toArray();
        return new Zend_Auth_Result($resultCode, $resultIdentity, $resultMessages);
        
    }
    
}
