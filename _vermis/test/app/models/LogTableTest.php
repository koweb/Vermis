<?php

/**
 * =============================================================================
 * @file        LogTableTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: LogTableTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   LogTableTest
 */
class LogTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_table = Doctrine::getTable('Log');
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof LogTable);
    }
    
    public function testGetLogQuery()
    {
        $query = $this->_table->getLogQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        
        $this->assertTrue(count($records) > 0);
        $log = $records[0];
        
        $this->assertTrue(isset($log['user_id']));
        $this->assertTrue(isset($log['project_id']));
        $this->assertTrue(isset($log['resource_id']));
        $this->assertTrue(isset($log['resource_type']));
        $this->assertTrue(isset($log['action']));
        $this->assertTrue(isset($log['message']));
        $this->assertTrue(isset($log['params']));
        $this->assertTrue(isset($log['user']['name']));
        $this->assertTrue(isset($log['user']['login']));
        $this->assertTrue(isset($log['user']['slug']));
        $this->assertTrue(isset($log['project']['name']));
        $this->assertTrue(isset($log['project']['slug']));
    }
    
}
