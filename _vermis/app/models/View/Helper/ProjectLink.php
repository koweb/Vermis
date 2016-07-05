<?php

/**
 * =============================================================================
 * @file        ProjectLink.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ProjectLink.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
