<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/MilestonesTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MilestonesTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Importer_Project_MilestonesTest
 */
class Grid_Importer_Project_MilestonesTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_importer = null;
    
    public function setUp()
    {
        parent::setUp();

        Application::getInstance()->setupView();
        
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $grid = new Grid_Project_Milestones(array(
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
        $this->assertTrue(is_array($records));
        $this->assertEquals(3, count($records));
        $this->assertEquals('0.1', $records[0]['name']);
        $this->assertEquals('0.2', $records[1]['name']);
        $this->assertEquals('0.3 beta', $records[2]['name']);
        foreach ($records as $record)
            $this->assertEquals(1, $record['project_id']);
    }
    
}
