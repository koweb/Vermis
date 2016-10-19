<?php

/**
 * =============================================================================
 * @file        Project/ActivityControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ActivityControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
        $this->assertTrue(is_array($controller->view->activity));
        $this->assertTrue($controller->view->pager instanceof Doctrine_Pager);
        foreach ($controller->view->activity as $a) {
        	$this->assertEquals($this->_project->id, $a['project_id']);
        }
    }
        
}
