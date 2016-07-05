<?php

/**
 * =============================================================================
 * @file        LogTableTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: LogTableTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
