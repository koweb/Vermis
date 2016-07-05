<?php

/**
 * =============================================================================
 * @file        FreeCode/GuestsCounter.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: GuestsCounter.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_GuestsCounter
 * @brief   Guests counter. 
 */
class FreeCode_GuestsCounter 
{

    protected static $_instance;
    
    protected $_value = null;
    protected $_pdo = null;
    protected $_tableName = null;
    protected $_valueField = null;
    protected $_nameField = null;
    
    /**
     * Constructor. Setup session and increment if neccessary.
     */
    protected function __construct(
        $tableName = 'counter', 
        $valueField = 'value',
        $nameField = 'name'
    ) 
    {
        $this->_tableName = $tableName;
        $this->_valueField = $valueField;
        $this->_nameField = $nameField;
        
        $this->_pdo = FreeCode_PDO_Manager::getInstance()
            ->getCurrentConnection();
        
        if (!isset($_SESSION['FreeCode_GuestsCounter']) || $_SESSION['FreeCode_GuestsCounter'] != true) {
            $_SESSION['FreeCode_GuestsCounter'] = true;
            $this->_incrementValue();
        }

        $this->_fetchValue();
    }
    
    /**
     * Destruct. Destroy PDO object reference.
     */
    public function __destruct()
    {
        $this->_pdo = null;
    }
    
    /**
     * Create guests counter instance.
     * @param string $tableName
     * @param string $valueField
     * @param string $nameField
     * @return FreeCode_GuestsCounter
     */
    public static function start(
        $tableName = 'counter', 
        $valueField = 'value',
        $nameField = 'name'
    )
    {
        self::$_instance = null;
        self::$_instance = new self($tableName, $valueField, $nameField);
        return self::$_instance;
    }
    
    /**
     * Destroy singleton instance.
     * @return void
     */
    public static function free()
    {
        self::$_instance = null;
    }
    
    /**
     * Get instance.
     * @return  FreeCode_GuestsCounter
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance))
            throw new FreeCode_Exception('Use FreeCode_GuestsCounter::start first!');
        return self::$_instance;
    }
    
    /**
     * Check if guests counter is started.
     * @return boolean
     */
    public static function isStarted()
    {
        return isset(self::$_instance);
    }
    
    /**
     * Get current value.
     * @return integer
     */
    public function getValue()
    {
        return $this->_value;
    }
    
    protected function _fetchValue()
    {
        $sql = "SELECT {$this->_valueField} FROM {$this->_tableName} WHERE {$this->_nameField} = 'guests'";
        $records = $this->_pdo->executeAndFetch($sql);
        if (count($records) != 1)
            throw new FreeCode_Exception_Database('Corrupted table!');
        $this->_value = $records[0]['value'];        
    }
    
    protected function _incrementValue()
    {
        $sql = "UPDATE {$this->_tableName} SET {$this->_valueField} = {$this->_valueField} + 1 WHERE {$this->_nameField} = 'guests'";
        $this->_pdo->execute($sql);
    }
    
}
