<?php

/**
 * =============================================================================
 * @file        Default/Controller.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Controller.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Default_Controller
 * @brief   Base controller for default module.
 */
class Default_Controller extends Controller
{
    
    public function init()
    {
        parent::init();
        $this->view->bigLinkUrl = $this->url(array(), 'index');
        if ($this->_identity)
            $this->view->bigLinkTitle = 'dashboard';
        else 
            $this->view->bigLinkTitle = 'home';
    }
}
