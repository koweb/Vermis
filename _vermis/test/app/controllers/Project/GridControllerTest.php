<?php

/**
 * =============================================================================
 * @file        Project/GridControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: GridControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_GridControllerTest
 */
class Project_GridControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function testIndexAction()
    {
        $this->login('test-user1', 'xxx');
        
        $this->getRequest()
            ->setParam('project_slug', 'Project1')
            ->setParam('component_slug', 'component-1')
            ->setParam('milestone_slug', '0-1');
            
        $controller = $this->getController('Project_GridController');
        $this->assertGrids(
            $controller, 
            array(
                'project_issuesProject1', 
                'project_notesProject1', 
                'project_milestonesProject1',
                'project_componentsProject1',
                'project_membersProject1',
                'project_issues_myProject1',
                'project_issues_componentProject1',
                'project_issues_milestoneProject1',
                'project_issues_latestProject1',
                'project_issues_navigatorProject1'
            )
        );
    }
    
}
