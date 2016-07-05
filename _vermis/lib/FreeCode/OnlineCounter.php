<?php

/**
 * =============================================================================
 * @file        FreeCode/OnlineCounter.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: OnlineCounter.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_OnlineCounter
 * @brief   Online counter. 
 */
class FreeCode_OnlineCounter 
{

    protected static $_instance;
    
    protected $_value = null;
    protected $_pdo = null;
    protected $_identity = null;
    protected $_timeOut = null;
    protected $_tableName = null;
    protected $_sessionIdField = null;
    protected $_unixTimeField = null;
    protected $_userIdField = null;
    
    /**
     * Constructor. Start counter and update results.
     * @param integer   $timeOut
     * @param string    $tableName
     * @param string    $sessionIdField
     * @param string    $unixTimeField
     * @param string    $userIdField
     */
    protected function __construct(
        $timeOut = 120,
        $tableName = 'online_counter',
        $sessionIdField = 'session_id',
        $unixTimeField = 'unix_time',
        $userIdField = 'user_id'
    ) 
    {
        $this->_timeOut = $timeOut;
        $this->_tableName = $tableName;
        $this->_sessionIdField = $sessionIdField;
        $this->_unixTimeField = $unixTimeField;
        $this->_userIdField = $userIdField;
        
        $this->_pdo = FreeCode_PDO_Manager::getInstance()
            ->getCurrentConnection();
        $this->_identity = FreeCode_Identity::getInstance();
        $this->_update();
    }
    
    /**
     * Destruct. Destroy PDO object reference.
     */
    public function __destruct()
    {
        $this->_pdo = null;
    }
    
    /**
     * Create instance.
     * @param integer   $timeOut
     * @param string    $tableName
     * @param string    $sessionIdField
     * @param string    $unixTimeField
     * @param string    $userIdField
     * @return  FreeCode_OnlineCounter
     */
    public static function start(
        $timeOut = 120,
        $tableName = 'online_counter',
        $sessionIdField = 'session_id',
        $unixTimeField = 'unix_time',
        $userIdField = 'user_id'
    )
    {
        self::$_instance = null;
        self::$_instance = new self(
            $timeOut, 
            $tableName, 
            $sessionIdField,
            $unixTimeField,
            $userIdField
        );
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
     * @return FreeCode_OnlineCounter
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance))
            throw new FreeCode_Exception('Use FreeCode_OnlineCounter::start first!');
        return self::$_instance;
    }
    
    /**
     * Check if online counter is started.
     * @return boolean
     */
    public static function isStarted()
    {
        return isset(self::$_instance);
    }
    
    /**
     * Get the number of current online sessions.
     * @return integer
     */
    public function getValue()
    {
        return $this->_value;
    }
    
    protected function _update()
    {
        $uid = ($this->_identity ? $this->_identity['id'] : 0);
        $sid = Zend_Session::getId();
        $time = time();
        $timeOut = $time - $this->_timeOut;
        
        // Remove all timeouts and current session.
        $sql = 
            "DELETE FROM {$this->_tableName} " . 
            "WHERE {$this->_unixTimeField} < {$timeOut} " .
            "OR {$this->_sessionIdField} = '{$sid}'";
        $this->_pdo->execute($sql);
        
        // Insert current session.
        $sql = 
            "INSERT INTO {$this->_tableName} ({$this->_sessionIdField}, {$this->_unixTimeField}, {$this->_userIdField}) " .
            "VALUES ('{$sid}', {$time}, {$uid})";
        $this->_pdo->execute($sql);
        
        // Fetch value.
        $sql = "SELECT COUNT({$this->_sessionIdField}) as cnt FROM {$this->_tableName}";
        $records = $this->_pdo->executeAndFetch($sql);
        if (count($records) != 1)
            throw new FreeCode_Exception_Database('Corrupted table!');
        $this->_value = $records[0]['cnt'];
    }
    
}
