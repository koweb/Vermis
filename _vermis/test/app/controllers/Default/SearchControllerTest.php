<?php

/**
 * =============================================================================
 * @file        Default/SearchControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: SearchControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Default_SearchControllerTest
 */
class Default_SearchControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function setUp()
    {
        parent::setUp();
        $this->login('admin', 'admin');
    }
    
    public function testIndexAction()
    {
        $this->getRequest()->setParam('query', 'issue');
        $controller = $this->getController('SearchController');
        $controller->indexAction();
        $this->assertTrue(
            $controller->view->searchGrid 
            instanceof Grid_Project_Issues_Search);
    }
    
    public function testIndexAction_GoToIssue()
    {
        $this->getRequest()->setParam('query', 'project1-1');
        $controller = $this->getController('SearchController');
        $controller->indexAction();
        $this->assertTrue($controller->view->redirection);
        $this->assertEquals(1, $controller->view->issue->number);
        $this->assertEquals('Project1', $controller->view->issue->project->slug);
    }
    
    public function testIndexAction_GoToIssue2()
    {
        $this->getRequest()->setParam('query', 'project1 2');
        $controller = $this->getController('SearchController');
        $controller->indexAction();
        $this->assertTrue($controller->view->redirection);
        $this->assertEquals(2, $controller->view->issue->number);
        $this->assertEquals('Project1', $controller->view->issue->project->slug);
    }
    
    public function testIndexAction_GoToIssueFail()
    {
        $this->getRequest()->setParam('query', 'project1 123');
        $controller = $this->getController('SearchController');
        $controller->indexAction();
        $this->assertFalse($controller->view->redirection);
    }
    
    public function testIndexAction_ShortString()
    {
        $this->getRequest()->setParam('query', 'is');
        $controller = $this->getController('SearchController');
        $controller->indexAction();
        $issues = $controller->view->searchGrid->getRows();
        foreach ($issues as $issue) {
            $this->assertTrue(
                strpos($issue['title'], 'is') || 
                strpos($issue['description'], 'is'));
        }
    }
    
}
