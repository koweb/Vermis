<?php

/**
 * =============================================================================
 * @file        UserLink.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: UserLink.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class View_Helper_UserLink
 * @brief Helper for link rendering.
 */
class View_Helper_UserLink
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function userLink($slug, $title, $router = 'users/show')
    {
        if (!isset($slug))
            return _T('nobody');
        $url = FreeCode_Config::getInstance()->baseHost;
        $url .= $this->_view->url(array('user_slug' => $slug), $router);
        $title = $this->_view->escape($title);
        return '<a href="'.$url.'" title="'.$title.'">'.$title.'</a>';
    }

}
