<?php

/**
 * =============================================================================
 * @file        FreeCode/PDO/Manager.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Manager.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_PDO_Manager
 * @brief   PDO manager.
 */
final class FreeCode_PDO_Manager
{
    
    protected $_connections = array();
    protected $_currentConn = null;
    
    protected function __construct() {}
    
    public static function getInstance()
    {
        static $instance;
        if (!isset($instance))
            $instance = new self;
        return $instance;
    }
    
    public function getNewConnection($dsn, $user = null, $password = null, $driverOptions = array('charset' => 'utf8'))
    {
        $conn = new FreeCode_PDO($dsn, $user, $password, $driverOptions);
        $this->_connections[] = $conn;
        $this->_currentConn = $conn;
        return $conn;
    }
    
    public function getCurrentConnection()
    {
        if (!isset($this->_currentConn))
            throw new FreeCode_Exception("No connection is available!");
        return $this->_currentConn;
    }
    
    public function getConnections()
    {
        return $this->_connections;
    }
    
    public function closeConnections()
    {
        if (class_exists('Doctrine_Manager')) {
            $connections = Doctrine_Manager::getInstance()->getConnections();
            foreach ($connections as $conn) {
                /**
                 * This is a crappy and ugly hack to go around doctrine bug DC-355
                 * http://www.doctrine-project.org/jira/browse/DC-355
                 */
                if (!($conn instanceof Doctrine_Connection_Mysql))
                    Doctrine_Manager::getInstance()->closeConnection($conn);
            }
        }
        
        foreach ($this->_connections as $conn) {
            $conn = null;
        }
        
        $this->_connections = array();
        $this->_currentConn = null;
        return $this;
    }
    
}
