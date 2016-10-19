<?php

/**
 * =============================================================================
 * @file        Default/GridControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: GridControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Default_GridControllerTest
 */
class Default_GridControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function testIndexAction_Guest()
    {
        $controller = $this->getController('GridController');
        $this->assertGrids(
            $controller, 
            array(
                'projects', 
                'issues_search',
                'issues_latest_dashboard',
                'issues_navigator_dashboard'
            )
        );
    }
    
    public function testIndexAction_LoggedUser()
    {
        $this->login('test-user1', 'xxx');
        
        $this->getRequest()->setParam('user_slug', 'Admin-User');
        $controller = $this->getController('GridController');
        $this->assertGrids(
            $controller, 
            array(
                'projects', 
                'users', 
                'issues_search',
                'issues_my_dashboard',
                'issues_assigned',
                'issues_reported',
                'issues_latest_dashboard',
                'issues_navigator_dashboard'
            )
        );
    }
    
}
