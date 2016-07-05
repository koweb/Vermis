<?php

/**
 * =============================================================================
 * @file        ErrorController.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ErrorController.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
