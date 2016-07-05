<?php

/**
 * =============================================================================
 * @file        Project/Issues/FilesControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: FilesControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_Issues_FilesControllerTest
 */
class Project_Issues_FilesControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    protected $_project = null;
    protected $_issue = null;
    
    public function setUp()
    {
        parent::setUp();
        $this->login('admin', 'admin');
        
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('project1');
        $this->getRequest()->setParam('project_slug', $this->_project->slug);
        
        $this->_issue = Doctrine::getTable('Project_Issue')->fetchIssue($this->_project->id, 1);
        $this->getRequest()->setParam('issue_number', $this->_issue->number);
    }

    public function testUploadAction()
    {
        /// @TODO: Process isolation bug!
        //$this->markTestIncomplete();
    }
    
    public function testDownloadAction()
    {
        /// @TODO: Process isolation bug!
        //$this->markTestIncomplete();
    }
    
    public function testDeleteAction()
    {
        /// @TODO: Process isolation bug!
        //$this->markTestIncomplete();
    }
    
}
