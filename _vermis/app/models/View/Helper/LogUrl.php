<?php

/**
 * =============================================================================
 * @file        LogUrl.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: LogUrl.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class View_Helper_LogUrl
 * @brief Helper for url rendering.
 */
class View_Helper_LogUrl
{

    protected $_view = null;

    protected $_routes = array(
        Log::TYPE_PROJECT   => 'project',
        Log::TYPE_MILESTONE => 'project/milestones/show',
        Log::TYPE_COMPONENT => 'project/components/show',
        Log::TYPE_ISSUE     => 'project/issues/show',
        Log::TYPE_NOTE      => 'project/notes/show',
    );
        
    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function logUrl($resourceType, $params)
    {
        $p = (is_array($params) ? $params : unserialize($params));
        return (isset($this->_routes[$resourceType]) 
            ? $this->_view->url($p, $this->_routes[$resourceType])
            : false);
    }

}
