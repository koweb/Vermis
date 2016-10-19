<?php

/**
 * =============================================================================
 * @file        FreeCode/Config.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Config.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Config
 * @brief   Base application config.
 */
class FreeCode_Config
{
    
    protected static $_config = null;
    
    protected function __construct() {}
    
    /**
     * Check if FreeCode_Config is loaded.
     * @return boolean
     */
    public static function isLoaded()
    {
        return isset(self::$_config);
    }
    
    /**
     * Factory. Load config from array or file.
     * @param   string|array    $mixed      File name or array.
     * @param   string          $envName    Environment name.
     * @return  Zend_Config
     */
    public static function load($mixed = array(), $envName = null)
    {
        if (is_string($mixed))
            $array = self::_loadFromFile($mixed, $envName);
        else
            $array = $mixed;

        if (isset($array['environment']) && !isset($envName))
            $envName = $array['environment'];
            
        if (isset($envName)) {                    
            if (!isset($array[$envName]) || !is_array($array[$envName]))
                throw new FreeCode_Exception_InvalidFormat("Environment is not defined!");
            self::$_config = new Zend_Config($array[$envName]);
        } else 
            self::$_config = new Zend_Config($array);

        Zend_Registry::set('config', self::$_config);
        Zend_Registry::set('environmentName', $envName);
        
        return self::$_config;
    }
    
    /**
     * Singleton. Get instance of Zend_Config.
     * @return Zend_Config
     */
    public static function getInstance()
    {
        if (!self::isLoaded())
            throw new FreeCode_Exception("Use FreeCode_Config::load first!");
        return self::$_config;
    }
    
    /**
     * Load config array from file.
     * @param   string  $fileName
     * @return  array
     */
    protected static function _loadFromFile($fileName)
    {
        if (!is_string($fileName) || !file_exists($fileName) || !is_readable($fileName)) {
            throw new FreeCode_Exception_FileNotFound("Cannot load config file '{$fileName}'!");    
        }
        
        $array = @include $fileName;
        
        if (!is_array($array))
            throw new FreeCode_Exception_InvalidFormat("Invalid config!");

        return $array;
    }
    
}
