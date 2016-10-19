<?php

/**
 * =============================================================================
 * @file        ProjectLink.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProjectLink.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class View_Helper_ProjectLink
 * @brief Helper for link rendering.
 */
class View_Helper_ProjectLink
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function projectLink($slug, $title, $router = 'project')
    {
        if (!isset($slug))
            return 'Deleted project';
        $url = FreeCode_Config::getInstance()->baseHost;
        $url .= $this->_view->url(array('project_slug' => $slug), $router);
        $title = $this->_view->escape($title);
        return '<a href="'.$url.'" title="'.$title.'">'.$title.'</a>';
    }

}
