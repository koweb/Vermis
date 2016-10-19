<?php

/**
 * =============================================================================
 * @file        UserTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UserTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   UserTest
 */
class UserTest extends Test_PHPUnit_DbTestCase 
{

	protected $_user = null;
	
	public function setUp()
	{
		parent::setUp();
		
		Application::getInstance()->setupTranslator();
		
		$this->_user = Doctrine::getTable('User')->findOneBySlug('Test-User-1');
		$this->assertTrue($this->_user instanceof User);
	}
	
    public function testSlug()
    {
        $this->assertEquals('Test-User-1', $this->_user->slug);
    }
    
    public function testGetMyProjectsQuery()
    {
        $query = $this->_user->getMyProjectsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertEquals(6, count($records));
        $this->assertEquals('โครงการ', $records[0]['name']);
        $this->assertEquals('項目', $records[1]['name']);
        $this->assertEquals('Project1', $records[2]['name']);
        $this->assertEquals('Project3', $records[3]['name']);
        $this->assertEquals('Project4', $records[4]['name']);
        $this->assertEquals('Project5', $records[5]['name']);
    }
    
    public function testGetAssignedIssuesQuery()
    {
        $query = $this->_user->getAssignedIssuesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertTrue(count($records) > 0);
        foreach ($records as $record)
            $this->assertEquals($this->_user->id, $record['assignee_id']);
    }
    
    public function testGetReportedIssuesQuery()
    {
        $query = $this->_user->getReportedIssuesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(is_array($records));
        $this->assertTrue(count($records) > 0);
        foreach ($records as $record)
            $this->assertEquals($this->_user->id, $record['reporter_id']);
    }
    
    public function testGetActivityQuery()
    {
        $query = $this->_user->getActivityQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $activity = $query->execute();
        $this->assertTrue(count($activity) > 0);
    }
   
    public function testGetRoleLabel()
    {
        $this->assertEquals('Admin', User::getRoleLabel(User::ROLE_ADMIN));
        $this->assertEquals('User', User::getRoleLabel(User::ROLE_USER));
        $this->assertEquals('unknown', User::getRoleLabel('unknown'));
    }
    
    public function testGetStatusLabel()
    {
        $this->assertEquals('Active', User::getStatusLabel(User::STATUS_ACTIVE));
        $this->assertEquals('Inactive', User::getStatusLabel(User::STATUS_INACTIVE));
        $this->assertEquals('Banned', User::getStatusLabel(User::STATUS_BANNED));
        $this->assertEquals('unknown', User::getRoleLabel('unknown'));
    }
    
    public function testIsAdmin()
    {
        $user = Doctrine::getTable('User')->findOneByRole(User::ROLE_ADMIN);
        $this->assertTrue($user->isAdmin());
        
        $user = Doctrine::getTable('User')->findOneByRole(User::ROLE_USER);
        $this->assertFalse($user->isAdmin());
    }

}
