<?php

/**
 * =============================================================================
 * @file        FreeCode/PDO.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: PDO.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_PDO
 * @brief   PDO wrapper.
 */
class FreeCode_PDO extends PDO
{

    protected $_queriesNum = 0;
    protected $_fileHandle = null;
    protected $_config = null;
    
    /**
     * Constructor
     * @param   string  $dsn
     * @param   string  $username
     * @param   string  $password
     * @param   string  $driverOptions
     */
    public function __construct($dsn, $username = null, $password = null, $driverOptions = array())
    {
        $config = FreeCode_Config::getInstance();
        if (    isset($config->database) 
                && isset($config->database->debug) 
                && $config->database->debug) {
            // Try to open log file.
            $fileName = LOG_DIR.'/pdo.log';
            $this->_fileHandle = @fopen($fileName, 'a+');
            if (!$this->_fileHandle)
                throw new FreeCode_Exception_IOError($fileName);
            
            // Try to set permission.
            @chmod($fileName, 0666);
        }
        
        parent::__construct($dsn, $username, $password, $driverOptions);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * Get number of queries.
     * @return int
     */
    public function getQueriesNumber()
    {
        return $this->_queriesNum;
    }

    /**
     * Overridden for debugging.
     * @param   string  $sql
     * @param   array   $driverOptions
     * @return  PDOStatement
     */
    public function prepare($sql, $driverOptions = array())
    {
        $this->_log("prepare: '{$sql}'");
        $this->_queriesNum++;
        
        $result = parent::prepare($sql, $driverOptions);
        if($result === false) {
            $info = $this->errorInfo();
            throw new FreeCode_Exception_Database($info[2]);
        }
        
        return $result;
    }

    /**
     * Overridden for debugging.
     * @param   string  $sql
     * @return  int
     */
    public function exec($sql)
    {
        $this->_log("prepare: '{$sql}'");
        $this->_queriesNum++;
        
        $result = parent::exec($sql);
        if($result === false) {
            $info = $this->errorInfo();
            throw new FreeCode_Exception_Database($info[2]);
        }
        
        return $result;
    }

    /**
     * Overridden for debugging.
     * @return  int
     */
    public function query()
    {
        $args = func_get_args();
        $this->_log("query: '{$args[0]}'");
        $this->_queriesNum++;
        
        $result = call_user_func_array(array($this, 'parent::query'), $args);
        if($result === false) {
            $info = $this->errorInfo();
            throw new FreeCode_Exception_Database($info[2]);
        }
        
        return $result;
    }
    
    /**
     * Execute query.
     * @param   string  $sql
     * @return  PDOStatement
     */
    public function execute($sql)
    {
        $query = $this->prepare($sql);
        $query->execute();
        return $query;
    }
    
    /**
     * Execute query and fetch records.
     * @param   string  $sql
     * @return  array
     */
    public function executeAndFetch($sql)
    {
        $query = $this->prepare($sql);
        $query->execute();
        $records = $query->fetchAll(PDO::FETCH_ASSOC);
        return $records;
    }
    
    /**
     * Execute sql file.
     * @param   string  $fileName
     * @return  array
     */
    public function executeFile($fileName)
    {
        $sql = @file_get_contents($fileName, FILE_BINARY);
        if ($sql === false)
            throw new FreeCode_Exception_FileNotFound("Cannot load sql file '{$fileName}'!");
        
        $queries = explode(';', $sql);
        $this->beginTransaction();
        foreach ($queries as $query) {
            $query = trim(trim($query), ';');
            if (!empty($query))
                $this->exec($query);
        }
        $this->commit();
    }
    
    /**
     * Append log file.
     * @param   string  $message
     * @return  void
     */
    protected function _log($message)
    {
        if ($this->_fileHandle) {
            
            if ($this->_queriesNum == 0) {
                $requestUri = (isset($_SERVER['REQUEST_URI']) ? 
                    '['.$_SERVER['REQUEST_URI'].']' : '');
                fwrite($this->_fileHandle, 
                    "\n\n".'---------- ['.date('Y-m-d H:i:s').']'.$requestUri.' ----------'."\n\n");
            }
            
            fwrite($this->_fileHandle, $message."\n");
            fflush($this->_fileHandle);
        }
    }
    
}
