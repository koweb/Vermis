<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/NotesTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NotesTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid_Importer_Project_NotesTest
 */
class Grid_Importer_Project_NotesTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_importer = null;
    
    public function setUp()
    {
        parent::setUp();

        Application::getInstance()->setupView();
        
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $grid = new Grid_Project_Notes(array(
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
        $this->assertEquals(3, $query->execute());
    }
    
    public function testGetRecordsQuery()
    {
        $query = $this->_importer->getRecordsQuery();
        $this->assertTrue($query instanceof Doctrine_Query);
        $records = $query->execute();
        $this->assertType('array', $records);
        $this->assertEquals(3, count($records));
        $this->assertEquals('note 1', $records[0]['title']);
        $this->assertEquals('note 2', $records[1]['title']);
        $this->assertEquals('note 3', $records[2]['title']);
        foreach ($records as $record)
            $this->assertEquals(1, $record['project_id']);
    }
    
}
