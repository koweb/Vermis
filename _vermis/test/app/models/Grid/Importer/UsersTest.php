<?php

/**
 * =============================================================================
 * @file        Grid/Importer/UsersTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UsersTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Importer_UsersTest
 */
class Grid_Importer_UsersTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_importer = null;
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupView();
        $grid = new Grid_Users();
        $this->_importer = $grid->getImporter();
        $this->_importer->setGrid($grid);
    }
    
    public function testGetCountQuery()
    {
        $query = $this->_importer->getCountQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $this->assertEquals(4, $query->execute());
    }
    
    public function testGetRecordsQuery()
    {
        $query = $this->_importer->getRecordsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertEquals(4, count($records));
        $this->assertEquals('Admin User', $records[0]['name']);
        $this->assertEquals('Test User 1', $records[1]['name']);
        $this->assertEquals('Test User 2', $records[2]['name']);
        $this->assertEquals('Test User 3', $records[3]['name']);
    }
    
}
