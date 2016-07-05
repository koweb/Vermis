<?php

/**
 * =============================================================================
 * @file        UserTableTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: UserTableTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   UserTableTest
 */
class UserTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_table = Doctrine::getTable('User');
    }

    public function testTable()
    {
        $this->assertTrue($this->_table instanceof UserTable);
    }
    
    public function testGetUsersListQuery()
    {
        $query = $this->_table->getUsersListQuery()->orderBy('u.name ASC');
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertEquals(4, count($records));
        $this->assertEquals('admin', $records[0]['login']);
    }
    
    public function testFetchUsersAsOptions()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        $options = $this->_table->fetchUsersAsOptions();
        $this->assertType('array', $options);
        $this->assertArrayHasKey(0, $options);
        $this->assertEquals('- any -', $options[0]);
        $this->assertArrayHasKey($user->id, $options);
        $this->assertEquals($user->name, $options[$user->id]);
    }
    
}
