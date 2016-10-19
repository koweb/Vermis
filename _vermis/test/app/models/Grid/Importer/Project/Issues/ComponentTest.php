<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/ComponentTest.php
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
 * @class   Grid_Importer_Project_Issues_ComponentTest
 */
class Grid_Importer_Project_Issues_ComponentTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_importer = null;
    
    public function setUp()
    {
        parent::setUp();
        
        Application::getInstance()->setupView();
        
        $component = Doctrine::getTable('Project_Component')->findOneBySlug('component-1');
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $grid = new Grid_Project_Issues_Component(array(
            'componentId' => $component->id,
            'componentSlug' => $component->slug,
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
        $this->assertTrue(is_array($records));
        $this->assertEquals(2, count($records));
        foreach ($records as $record)
            $this->assertEquals(1, $record['component_id']);
    }
    
}
