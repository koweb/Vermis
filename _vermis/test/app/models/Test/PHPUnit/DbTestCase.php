<?php

/**
 * =============================================================================
 * @file        Test/PHPUnit/DbTestCase.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: DbTestCase.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Test_PHPUnit_DbTestCase
 */
class Test_PHPUnit_DbTestCase extends Test_PHPUnit_TestCase 
{

    public function setUp()
    {
        FreeCode_PDO_Manager::getInstance()->closeConnections();
        parent::setUp();    

        FreeCode_Config::load(CONFIG_DIR.'/config.php');
        
        FreeCode_Builder::getInstance()
            ->createDatabase()
            ->doctrineCreateTables()
            //->doctrinePopulateFixtures()
            ->doctrinePopulateFixtures(TEST_DIR.'/fixtures/yml')
            //->populateSqlFixtures()
            ->populateSqlFixtures(TEST_DIR.'/fixtures/sql');
        
        Application::getInstance()
            ->setupConfig()
            ->setupSession()
            ->setupDoctrine();            
    }
    
    public function tearDown()
    {
        FreeCode_Builder::getInstance()
            ->dropDatabase();
    }
    
    public function assertDoctrineCrud($modelName)
    {
        $record = new $modelName;
        $record->save();
        $id = $record->id;
        
        $record = Doctrine::getTable($modelName)->find($id);
        $this->assertTrue($record != false);
        $record->save();
        
        $record->delete();
        
        $record = Doctrine::getTable($modelName)->find($id);
        $this->assertFalse($record);
    }
    
    public function getUser($login)
    {
        $user = Doctrine::getTable('User')->findOneByLogin($login);
        $this->assertNotNull($user);
        $this->assertEquals('User', get_class($user));
        return $user;
    }
    
    /**
     * @brief   Setup identity.
     * @param   $login      string
     * @param   $password   string
     * @return  void
     */
    public function login($login, $password)
    {
        $auth = Zend_Auth::getInstance();
        $authAdapter = new FreeCode_Auth_Adapter_User($login, FreeCode_Hash::encodePassword($password));
        $this->assertTrue($auth->authenticate($authAdapter)->isValid());
        
        // Save.
        $identity = $authAdapter->getUserAsArray();
        $auth->getStorage()->write($identity);
    }
    
}
