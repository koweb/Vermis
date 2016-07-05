<?php

/**
 * =============================================================================
 * @file        Default/ControllerTest.php
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
