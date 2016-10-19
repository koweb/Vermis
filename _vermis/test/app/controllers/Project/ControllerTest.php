<?php

/**
 * =============================================================================
 * @file        Project/ControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
