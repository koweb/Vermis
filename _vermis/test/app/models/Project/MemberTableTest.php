<?php

/**
 * =============================================================================
 * @file        Project/MemberTableTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MemberTableTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_MemberTableTest
 */
class Project_MemberTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_table = Doctrine::getTable('Project_Member');
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof Project_MemberTable);
    }
    
    public function testMemberExists()
    {
        $project = $this->_getProject('Project1');
        $user = $this->_getUser('test-user1');
        $this->assertTrue($this->_table->memberExists($project->id, $user->id));
        $user = $this->_getUser('test-user3');
        $this->assertFalse($this->_table->memberExists($project->id, $user->id));
    }
    
    public function testAddMember()
    {
        $project = $this->_getProject('Project1');
        $user = $this->_getUser('test-user1');
        $this->assertFalse($this->_table->addMember($project->id, $user->id, Project_Member::ROLE_LEADER));
        $user = $this->_getUser('test-user3');
        $this->assertTrue($this->_table->addMember($project->id, $user->id, Project_Member::ROLE_LEADER));
    }

    public function testDeleteMember()
    {
        $project = $this->_getProject('Project1');
        $user = $this->_getUser('test-user1');
        $this->_table->deleteMember($project->id, $user->id);
        $this->assertFalse($this->_table->memberExists($project->id, $user->id));
    }
    
    public function testGetProjectMembersQuery()
    {
        $project = $this->_getProject('Project1');
        $query = $this->_table->getProjectMembersQuery($project->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $users = $query->execute();
        $this->assertEquals(2, count($users));
        $this->assertEquals('test-user1', $users[0]['user']['login']);
        $this->assertEquals('test-user2', $users[1]['user']['login']);
    }
    
    public function testGetProjectNonMembersQuery()
    {
        $project = $this->_getProject('Project1');
        $query = $this->_table->getProjectNonMembersQuery($project->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $users = $query->execute();
        $this->assertEquals(2, count($users));
        $this->assertEquals('admin', $users[0]['login']);
    }
    
    public function testGetProjectNonMembersCount()
    {
        $project = $this->_getProject('Project1');
        $count = $this->_table->getProjectNonMembersCount($project->id);
        $this->assertEquals(2, $count);
    }

    public function testGetRole()
    {
        $project = $this->_getProject('Project1');
        $user = $this->_getUser('test-user1');
        $this->assertEquals(Project_Member::ROLE_OBSERVER, 
            $this->_table->getRole($project->id, $user->id));
    } 
    
    public function testFetchMembersAsOptions()
    {
        $user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        $options = $this->_table->fetchMembersAsOptions($this->_getProject('Project1')->id);
        $this->assertType('array', $options);
        $this->assertArrayHasKey(0, $options);
        $this->assertEquals('- any -', $options[0]);
        $this->assertArrayHasKey($user->id, $options);
        $this->assertEquals($user->name, $options[$user->id]);
    }
    
    protected function _getProject($slug)
    {
        return Doctrine::getTable('Project')->findOneBySlug($slug);
    }
    
    protected function _getUser($login)
    {
        return Doctrine::getTable('User')->findOneByLogin($login);
    }
    
}
