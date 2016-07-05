<?php

/**
 * =============================================================================
 * @file        Form/Project/SimpleIssueTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: SimpleIssueTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_Project_SimpleIssueTest
 */
class Form_Project_SimpleIssueTest extends Test_PHPUnit_DbTestCase 
{

    protected $_user = null;
    protected $_form = null;
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupTranslator();
        $this->_user = Doctrine::getTable('User')->findOneByLogin('test-user1');
        $this->_form = new Form_Project_SimpleIssue($this->_user->id);
    }
    
    public function testSuite()
    {
        $this->assertEquals(5, count($this->_form->getElements()));
        $this->assertNotNull($this->_form->getElement('project_id'));
        $this->assertNotNull($this->_form->getElement('type'));
        $this->assertNotNull($this->_form->getElement('title'));
        $this->assertNotNull($this->_form->getElement('description'));
        $this->assertNotNull($this->_form->getElement('submit'));
    }
    
    public function testFetchProjectsAsOptions()
    {
        $options = $this->_form->fetchProjectsAsOptions();
        $this->assertType('array', $options);
        $this->assertTrue(count($options) > 0);
        foreach ($options as $id => $name) {
            $project = Doctrine::getTable('Project')->find($id);
            $this->assertTrue(!$project->is_private || $this->_user->isMemberOf($id));
            $this->assertEquals($name, $project->name);
        }
    }
    
}
