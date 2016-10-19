<?php

/**
 * =============================================================================
 * @file        Project/ComponentTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ComponentTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
        $this->assertTrue(is_array($versions));
        $this->assertEquals(2, count($versions));
        $this->assertEquals('xxx', $versions[0]['description']);
    }
    
}
