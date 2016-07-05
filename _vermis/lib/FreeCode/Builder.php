<?php

/**
 * =============================================================================
 * @file        FreeCode/Builder.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Builder.php 73 2011-01-24 21:52:27Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Builder
 * @brief   Builder.
 */
class FreeCode_Builder
{

    protected $_app = null;
    protected $_config = null;
    
    protected function __construct() 
    {
        $this->_config = FreeCode_Config::getInstance();
        $this->_app = FreeCode_Application::getInstance();
    }
    
    /**
     * @brief   Singleton pattern.
     * @return  FreeCode_Builder
     */
    public static function getInstance()
    {
        static $instance;
        if (!isset($instance))
            $instance = new self;
        return $instance;
    }
    
    /**
     * Create a database.
     * @return FreeCode_Builder
     */
    public function createDatabase()
    {
        /*
         * Ugly hack to set utf8 encoding in a mysql database.
         */
        $sql = "CREATE DATABASE {$this->_config->database->name}";
        if (strtolower($this->_config->database->driver) == 'mysql')
            $sql .= " CHARACTER SET utf8 COLLATE utf8_general_ci";
        $this->dropDatabase();
        $pdo = $this->_getUniqueConnection();
        $pdo->exec($sql);
        $pdo = null;
        return $this;
    }
    
    /**
     * Drop a database.
     * @return FreeCode_Builder
     */
    public function dropDatabase()
    {
        $pdo = $this->_getUniqueConnection();
        $pdo->exec("DROP DATABASE IF EXISTS {$this->_config->database->name}");
        $pdo = null;
        return $this;   
    }
    
    /**
     * Execute all sql scripts.
     * @param   string  $dirPath    SQL fixtures directory.
     * @return FreeCode_Builder
     */
    public function populateSqlFixtures($dirPath = SQL_FIXTURES_DIR)
    {
        $this->_app->setupPDO($this->_config->database);
        $pdo = FreeCode_PDO_Manager::getInstance()->getCurrentConnection();
        
        if ($handle = @opendir($dirPath)) {

            while ($dir = readdir($handle)) {
                $path = $dirPath.'/'.$dir;
                if (    $dir{0} != '.' && 
                        !is_dir($path) &&
                        substr($path, -4) == '.sql') {
                    $pdo->executeFile($path);
                }
            }
            
            closedir($handle);

        } else {
            throw new Exception("Cannot load sql fixtures from '{$dirPath}'!");
        }
        
        $pdo = null;
        
        return $this;
    }
    
    /**
     * Create tables.
     * @return FreeCode_Builder
     */
    public function doctrineCreateTables()
    {
        $this->_app
            ->setupPDO()
            ->setupDoctrine();
        Doctrine::loadModels(MODELS_DIR);
        Doctrine::createTablesFromModels();
        return $this;
    }
    
    /**
     * Populate yml fixtures.
     * @param   string  $dirPath    YML fixtures directory.
     * @return FreeCode_Builder
     */
    public function doctrinePopulateFixtures($dirPath = YML_FIXTURES_DIR)
    {
        // Hack to avoid email sending during building process.
        Zend_Registry::set('disableMailer', true);
        
        $this->_app
            ->setupPDO()
            ->setupDoctrine();
        Doctrine::loadModels(MODELS_DIR);
        $models = Doctrine::getLoadedModels();

        $data = new Doctrine_Data();
        $data->importData($dirPath, 'yml', $models, true);
        
        return $this;
    }
    
    /**
     * Dump a database to a SQL file.
     * Execute a shell command (mysqldump or pg_dump).
     * @param string $sqlFile
     * @return FreeCode_Builder
     */
    public function dumpSql($sqlFile)
    {
        switch (strtolower($this->_config->database->driver)) {
            case 'mysql':
                $cmd =
                    'mysqldump '.
                    '--user="'.$this->_config->database->user.'" '.
                    '--password="'.$this->_config->database->password.'" '.
                    '-h '.$this->_config->database->host.' '.
                    ($this->_config->database->port != '' ? '-P '.$this->_config->database->port.' ' : '').
                    $this->_config->database->name.
                    ' > '.$sqlFile;
                break;
                
            case 'pgsql':
                $cmd = 
                    'PGPASSWORD="'.$this->_config->database->password.'"; export PGPASSWORD; '.
                    'pg_dump -U '.$this->_config->database->user.
                    ' -h '.$this->_config->database->host.' '.
                    ($this->_config->database->port != '' ? '-p '.$this->_config->database->port.' ' : '').
                    $this->_config->database->name.
                    ' > '.$sqlFile;
                break;
                
            default: throw new FreeCode_Exception("Unsupported driver!");
        }
        
        system($cmd);
        return $this;
    }
    
    /**
     * Import a SQL file to a database.
     * Execute a shell command (mysql or psql).
     * @param string $sqlFile
     * @return FreeCode_Builder
     */
    public function importSql($sqlFile)
    {
        if (!file_exists($sqlFile))
            throw new FreeCode_Exception("File '{$sqlFile}' does not exist!");
        
        switch (strtolower($this->_config->database->driver)) {
            case 'mysql':
                $cmd =
                    'mysql '.
                    '--user="'.$this->_config->database->user.'" '.
                    '--password="'.$this->_config->database->password.'" '.
                    '-h '.$this->_config->database->host.' '.
                    ($this->_config->database->port != '' ? '-P '.$this->_config->database->port.' ' : '').
                    $this->_config->database->name.
                    ' < '.$sqlFile;
                break;
            
            case 'pgsql':
                $cmd = 
                    'PGPASSWORD="'.$this->_config->database->password.'"; export PGPASSWORD; '.
                    'psql -U '.$this->_config->database->user.
                    ' -h '.$this->_config->database->host.' '.
                    ($this->_config->database->port != '' ? '-p '.$this->_config->database->port.' ' : '').
                    $this->_config->database->name.
                    ' -f '.$sqlFile;
                break;
        }

        system($cmd);
        return $this;
    }
    
    /**
     * Setup a single instance of the PDO.
     * Close all other connections.
     * @return FreeCode_PDO
     */
    protected function _getUniqueConnection()
    {
        $db = $this->_config->database;
        
        $dsn =
            $db->driver.':'.
            'host='.$db->host.';';
        if (isset($db->port))
            $dsn .= 'port='.$db->port.';';
            
        return FreeCode_PDO_Manager::getInstance()
            ->closeConnections()
            ->getNewConnection($dsn, $db->user, $db->password);
    }
    
}
