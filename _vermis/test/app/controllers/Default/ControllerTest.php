<?php

/**
 * =============================================================================
 * @file        Default/ControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Default_ControllerTest
 */
class Default_ControllerTest extends Test_PHPUnit_ControllerTestCase 
{
    
    public function testInstance()
    {
        $this->login('admin', 'admin');
        $controller = $this->getController('Default_Controller');
        /// @TODO: Crash!
        //$this->markTestIncomplete();
    }

}
