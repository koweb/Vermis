<?php

/**
 * =============================================================================
 * @file        Form/Project/IssueTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Form_Project_IssueTest
 */
class Form_Project_IssueTest extends Test_PHPUnit_DbTestCase 
{

    protected $_project = null;
    protected $_form = null;
    
    public function setUp()
    {
        parent::setUp();
        Application::getInstance()->setupTranslator();
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $this->_form = new Form_Project_Issue($this->_project->id);
    }
    
    public function testSuite()
    {
        $this->assertEquals(10, count($this->_form->getElements()));
        $this->assertNotNull($this->_form->getElement('type'));
        $this->assertNotNull($this->_form->getElement('title'));
        $this->assertNotNull($this->_form->getElement('priority'));
        $this->assertNotNull($this->_form->getElement('status'));
        $this->assertNotNull($this->_form->getElement('component_id'));
        $this->assertNotNull($this->_form->getElement('milestone_id'));
        $this->assertNotNull($this->_form->getElement('assignee_id'));
        $this->assertNotNull($this->_form->getElement('description'));
        $this->assertNotNull($this->_form->getElement('progress'));
        $this->assertNotNull($this->_form->getElement('submit'));
    }
    
    public function testFetchComponentsAsOptions()
    {
        $component = Doctrine::getTable('Project_Component')
            ->fetchComponent($this->_project->id, 'component-2');
        $options = $this->_form->fetchComponentsAsOptions();
        $this->assertTrue(is_array($options));
        $this->assertArrayHasKey(0, $options);
        $this->assertEquals('- none -', $options[0]);
        $this->assertArrayHasKey($component->id, $options);
        $this->assertEquals('component 2', $options[$component->id]);
    }
    
    public function testFetchMilestonesAsOptions()
    {
        $milestone = Doctrine::getTable('Project_Milestone')
            ->fetchMilestone($this->_project->id, '0-3-beta');
        $options = $this->_form->fetchMilestonesAsOptions();
        $this->assertTrue(is_array($options));
        $this->assertArrayHasKey(0, $options);
        $this->assertEquals('- none -', $options[0]);
        $this->assertArrayHasKey($milestone->id, $options);
        $this->assertEquals('0.3 beta', $options[$milestone->id]);
    }
    
    public function testGetProgressOptions()
    {
        $options = $this->_form->getProgressOptions();
        $this->assertEquals(11, count($options));
    }
    
}
