<?php

/**
 * =============================================================================
 * @file        Test/PHPUnit/ControllerTestCase.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ControllerTestCase.php 123 2011-01-29 23:37:30Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Test_PHPUnit_ControllerTestCase
 */
class Test_PHPUnit_ControllerTestCase extends FreeCode_PHPUnit_ControllerTestCase 
{

    public function setUp()
    {
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
            ->setupDoctrine()
            ->setupTranslator()
            ->setupFrontController()
            ->setupRouter()
            ->setupView();
            
        $this->logout();
        
        Zend_Registry::set('disableMailer', false);
    }
    
    public function tearDown()
    {
        FreeCode_Builder::getInstance()
            ->dropDatabase();
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
    
    /**
     * Clear identity.
     */
    public function logout()
    {
        FreeCode_Identity::clear();
        Zend_Auth::getInstance()->clearIdentity();
    }
    
    /**
     * Run grid controller test.
     * @param $controller
     * @param $expectedGrids
     * @return void
     */
    public function assertGrids($controller, array $expectedGrids)
    {
        $grids = $controller->getGrids();
        
        $this->assertEquals(count($grids), count($expectedGrids));
        
        $exp = array();
        foreach ($expectedGrids as $gid)
            $exp[Grid::hashId($gid)] = Grid::hashId($gid);
            
        foreach ($grids as $id => $grid) {
            $this->assertArrayHasKey($id, $exp);
        }
    }
            
}
