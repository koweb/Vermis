<?php

/**
 * =============================================================================
 * @file        bootstrap.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version     $Id: bootstrap.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

$rootDir = dirname(dirname(__FILE__));
require_once $rootDir.'/bootstrap.php';

/**
 * Disable possibility of executing this script from a browser.
 */
$sapi = substr(php_sapi_name(), 0, 3);
if ($sapi != 'cli') {
    throw new Exception("This script can be executed only from a command line!");
}

function executeTask($taskName)
{
    try {
    
        FreeCode_Config::load(CONFIG_DIR.'/config.php');
        $builder = FreeCode_Builder::getInstance();
        
        $env = Zend_Registry::get('environmentName');
        
        switch ($taskName) {
            case 'create-database':     
                $builder->createDatabase();
                break;
            
            case 'drop-database':       
                $builder->dropDatabase(); 
                break;
            
            case 'populate-sql-fixtures':     
                $builder->populateSqlFixtures(ROOT_DIR.'/fixtures/'.$env.'/sql'); 
                break;
                
            case 'doctrine-create-tables':
                $builder->doctrineCreateTables();
                break;
                
            case 'doctrine-populate-fixtures':
                $builder->doctrinePopulateFixtures(ROOT_DIR.'/fixtures/'.$env.'/yml');
                break;
                
            case 'dump-sql':
                $builder->dumpSql(ROOT_DIR.'/database.sql');
                break;
            
            default: throw new Exception("Task '{$taskName}' is not implemented yet!");
        }
    
    } catch (Exception $exc) {
        echo $exc->getMessage()."\n";
        exit(-1);
    }

    exit(0);
}
