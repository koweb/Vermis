<?php

/**
 * =============================================================================
 * @file        Project/ComponentTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ComponentTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_ComponentTest
 */
class Project_ComponentTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_component = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->_component = Doctrine::getTable('Project_Component')->find(1);
    }

    public function testGetIssuesQuery()
    {
        $query = $this->_component->getIssuesQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertTrue(count($records) > 0);
        foreach ($records as $record) {
            $this->assertEquals($this->_component->id, $record['component_id']);
        }
    }
    
    public function testFetchVersions()
    {
        $this->_component->description = 'xxx';
        $this->_component->save();
        
        $versions = $this->_component->fetchVersions();
        $this->assertType('array', $versions);
        $this->assertEquals(2, count($versions));
        $this->assertEquals('xxx', $versions[0]['description']);
    }
    
}
