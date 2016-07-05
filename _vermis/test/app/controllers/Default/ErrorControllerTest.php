<?php

/**
 * =============================================================================
 * @file        Default/ErrorControllerTest.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ErrorControllerTest.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Default_ErrorControllerTest
 */
class Default_ErrorControllerTest extends Test_PHPUnit_ControllerTestCase 
{

    public function testErrorAction()
    {
        //$this->setExpectedException('FreeCode_Exception');
        $this->dispatch('/error/error');
        $this->assertController('error');
        $this->assertAction('error');
    }
    
}
