<?php

/**
 * =============================================================================
 * @file        ErrorController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ErrorController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   ErrorController
 * @brief   Error controller.
 */
class ErrorController extends Default_Controller
{

    public function errorAction()
    {
        $this->setLayoutScript('layout.error');
        //throw new FreeCode_Exception('Error 404: Page not found!');
    }
    
}
