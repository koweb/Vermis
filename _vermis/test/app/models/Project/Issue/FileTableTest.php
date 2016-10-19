<?php

/**
 * =============================================================================
 * @file        Project/Issue/FileTableTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: FileTableTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_Issue_FileTableTest
 */
class Project_Issue_FileTableTest extends Test_PHPUnit_DbTestCase 
{
    
    protected $_table = null;
    protected $_project = null;
    protected $_issue = null;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_table = Doctrine::getTable('Project_Issue_File');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('Project1');   
        $this->_issue = Doctrine::getTable('Project_Issue')->fetchIssue($this->_project->id, 1);
    }
    
    public function testTable()
    {
        $this->assertTrue($this->_table instanceof Project_Issue_FileTable);
    }
    
    public function testGetIssueFilesQuery()
    {
        $query = $this->_table->getIssueFilesQuery($this->_issue->id);
        $this->assertTrue($query instanceof Doctrine_Query);
        $files = $query->execute();
        $this->assertTrue(count($files) > 0);
        foreach ($files as $file) {
            $this->assertEquals($this->_issue->id, $file['issue_id']);
        }
    }
        
}
