<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/MembersTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: MembersTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_Importer_Project_MembersTest
 */
class Grid_Importer_Project_MembersTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_importer = null;
    
    public function setUp()
    {
        parent::setUp();

        Application::getInstance()->setupView();
        
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $grid = new Grid_Project_Members(array(
            'projectId' => $project->id,
            'projectSlug' => $project->slug
        ));
        $this->_importer = $grid->getImporter();
        $this->_importer->setGrid($grid);
    }
    
    public function testGetCountQuery()
    {
        $query = $this->_importer->getCountQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $this->assertEquals(2, $query->execute());
    }
    
    public function testGetRecordsQuery()
    {
        $query = $this->_importer->getRecordsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertType('array', $records);
        $this->assertEquals(2, count($records));
        $this->assertEquals('Test User 1', $records[0]['name']);
        $this->assertEquals('Test User 2', $records[1]['name']);
        foreach ($records as $record)
            $this->assertEquals(1, $record['project_id']);
    }
    
}
