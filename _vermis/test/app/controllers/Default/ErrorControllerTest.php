<?php

/**
 * =============================================================================
 * @file        Default/ErrorControllerTest.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ErrorControllerTest.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
