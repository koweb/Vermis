<?php

/**
 * =============================================================================
 * @file        Default/Controller.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Controller.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
