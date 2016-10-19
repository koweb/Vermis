<?php

/**
 * =============================================================================
 * @file        Grid/Importer/Project/Issues/AssignedTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: AssignedTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Grid_Importer_Project_Issues_AssignedTest
 */
class Grid_Importer_Project_Issues_AssignedTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_importer = null;
    
    public function setUp()
    {
        parent::setUp();

        Application::getInstance()->setupView();
        
        $user = Doctrine::getTable('User')->findOneBySlug('Admin-User');
        $project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $grid = new Grid_Project_Issues_Assigned(array(
            'userId' => $user->id,
            'userSlug' => $user->slug,
            'projectId' => $project->id,
            'projectSlug' => $project->slug,
            'identityId' => $user->id
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
            $this->assertEquals(1, $record['assignee_id']);
    }
    
}
