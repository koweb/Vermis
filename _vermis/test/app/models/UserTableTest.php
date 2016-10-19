<?php

/**
 * =============================================================================
 * @file        UserTableTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UserTableTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
        $this->assertTrue(is_array($options));
        $this->assertArrayHasKey(0, $options);
        $this->assertEquals('- any -', $options[0]);
        $this->assertArrayHasKey($user->id, $options);
        $this->assertEquals($user->name, $options[$user->id]);
    }
    
}
