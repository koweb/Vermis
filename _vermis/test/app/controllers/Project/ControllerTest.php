<?php

/**
 * =============================================================================
 * @file        Project/ControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_ControllerTest
 */
class Project_ControllerTest extends Test_PHPUnit_ControllerTestCase 
{
    
    public function testInit_ProjectNotFound()
    {
        $this->login('admin', 'admin');
        
        $this->getRequest()
            ->setMethod('GET')
            ->setParam('project_slug', 'unknown-project');
            
        $this->setExpectedException('FreeCode_Exception_RecordNotFound');
        $this->getController('Project_Controller');
    }

    public function testInit_ProjectFound()
    {
        $this->login('admin', 'admin');
        
        $this->getRequest()
            ->setMethod('GET')
            ->setParam('project_slug', 'Project1');
            
        $this->getController('Project_Controller');
        $this->assertTrue(Zend_Registry::isRegistered('projectId'));
        $project = Doctrine::getTable('Project')
            ->find(Zend_Registry::get('projectId'));
        $this->assertEquals('Project1', $project->slug);
    }

}
