<?php

/**
 * =============================================================================
 * @file        Project/ComponentTableTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentTableTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_ComponentTableTest
 */
class Project_ComponentTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    protected $_project = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_table = Doctrine::getTable('Project_Component');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');   
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof Project_ComponentTable);
    }
    
    public function testGetProjectComponentsQuery()
    {
        $query = $this->_table->getProjectComponentsQuery($this->_project->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $components = $query->execute();
        $this->assertEquals(3, count($components));
        $this->assertEquals('component 1', $components[0]['name']);
        foreach ($components as $component) {
            $this->assertEquals($this->_project->id, $component['project_id']);
        }

        $this->assertEquals(2, $components[0]['num_issues']);
        $this->assertEquals(1, $components[1]['num_issues']);
        $this->assertEquals(0, $components[2]['num_issues']);

        foreach ($components as $component) {
            $this->assertEquals('Admin-User', $component['author_slug']);
            $this->assertEquals('Admin User', $component['author_name']);
            $this->assertEquals('Admin-User', $component['changer_slug']);
            $this->assertEquals('Admin User', $component['changer_name']);
        }
    }
    
    public function testComponentExists()
    {
        $this->assertTrue($this->_table->componentExists($this->_project->id, 'component-1'));
        $this->assertFalse($this->_table->componentExists($this->_project->id, 'component-4'));
    }
    
    public function testFetchComponent()
    {
        $component = $this->_table->fetchComponent($this->_project->id, 'component-1');
        $this->assertTrue($component instanceof Project_Component);
        $this->assertEquals('component 1', $component->name);     
    }
    
    public function testFetchComponentId()
    {
        $id = $this->_table->fetchComponentId($this->_project->id, 'component-1');
        $component = $this->_table->find($id);
        $this->assertTrue($component instanceof Project_Component);
        $this->assertEquals('component 1', $component->name);     
    }
    
    public function testFetchComponentsAsOptions()
    {
        $options = $this->_table->fetchComponentsAsOptions($this->_project->id);
        $this->assertEquals(4, count($options));
        $this->assertEquals('- any -', $options[0]);
        $this->assertEquals('component 1', $options[1]);
        $this->assertEquals('component 2', $options[2]);
        $this->assertEquals('component 3', $options[3]);
    }
    
}
