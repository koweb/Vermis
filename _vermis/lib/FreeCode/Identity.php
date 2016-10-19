<?php

/**
 * =============================================================================
 * @file        FreeCode/Identity.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Identity.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Identity
 * @brief   Identity wrapper.
 */
class FreeCode_Identity
{
    
    protected $_identity = null;

    protected static $_instance;
    
    protected function __construct($className) 
    {
        $this->_fetchIdentity($className);
    }
    
    /**
     * Get identity instance.
     * @param   string  $className  User model class name.
     * @return  User | null
     */
    public static function getInstance($className = 'User')
    {
        if (!isset(self::$_instance))
            self::$_instance = new FreeCode_Identity($className);
        return self::$_instance->_identity;
    }
    
    /**
     * Reload identity.
     * @param string $className
     * @return User | null
     */
    public static function reload($className = 'User')
    {
        if (!isset(self::$_instance))
            return self::getInstance($className);
        return self::$_instance->_fetchIdentity($className);
    }
    
    /**
     * Clear.
     */
    public static function clear()
    {
        self::$_instance = null;
    }
    
    protected function _fetchIdentity($className)
    {
        $authIdentity = Zend_Auth::getInstance()->getIdentity();
        if (isset($authIdentity) && isset($authIdentity['id'])) {
            $this->_identity = Doctrine::getTable($className)->find($authIdentity['id']);
            return $this->_identity;
        }
        return null;
    }
    
}
