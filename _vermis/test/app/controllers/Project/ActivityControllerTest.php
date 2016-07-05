<?php

/**
 * =============================================================================
 * @file        Project/ActivityControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ActivityControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_ActivityControllerTest
 */
class Project_ActivityControllerTest extends Test_PHPUnit_ControllerTestCase 
{
    
	protected $_project = null;
	
    public function setUp()
    {
        parent::setUp();
        $this->login('admin', 'admin');
        $this->_project = Doctrine::getTable('Project')->findOneBySlug('project1');
    	$this->getRequest()->setParam('project_slug', $this->_project->slug);
    }
    
    public function testIndexAction()
    {
        $controller = $this->getController('Project_ActivityController');
        $controller->indexAction();
        $this->assertType('array', $controller->view->activity);
        $this->assertTrue($controller->view->pager instanceof Doctrine_Pager);
        foreach ($controller->view->activity as $a) {
        	$this->assertEquals($this->_project->id, $a['project_id']);
        }
    }
        
}
