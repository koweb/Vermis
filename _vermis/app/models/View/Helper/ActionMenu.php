<?php

/**
 * =============================================================================
 * @file        ActionMenu.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ActionMenu.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class View_Helper_ActionMenu
 * @brief Helper for action menu rendering.
 */
class View_Helper_ActionMenu
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function actionMenu($menu)
    {
        $html = '';
        $controller = '';
        $action = '';
        $ctrl = Zend_Controller_Front::getInstance();

        if ($request = $ctrl->getRequest()) {
            $controller = $request->getControllerName();
            $action = $request->getActionName();
        }

        foreach ($menu as $button) {
            if (!isset($button['controller']))
                $button['controller'] = $controller;

            $url = (isset($button['url']) ? $button['url'] : $this->_view->url($this->_parseParams($button)));
            $title = FreeCode_Translator::_($button['title']);
            $isActive = (($button['controller'] == $controller && isset($button['action']) && $button['action'] == $action) ? true : false);
            $confirm = FreeCode_Translator::_(isset($button['confirm']) ? $button['confirm'] : false);
            $id = (isset($button['id']) ? $button['id'] : null);
            $float = (isset($button['float']) ? $button['float'] : null);
            
            $html .= $this->_showButton($url, $title, $isActive, $confirm, $id, $float);
        }

        return $html;
    }

    protected function _showButton(
        $url, 
        $title,  
        $isActive = false, 
        $confirm = false, 
        $id = null,
        $float = null)
    {
        if ($confirm) {
            $confirmMsg = FreeCode_Translator::_('Are you sure?');
            $confirmJs = "return confirm('{$confirmMsg}')";
            $confirm = ' onclick="'.$confirmJs.'"';
        }
        $class = '';
        if ($isActive)
            $class = ' class="active"';
        if (isset($id))
            $id = ' id="'.$id.'"';
        if (isset($float))
            $float = ' style="float:'.$float.'"';
        return "<a{$id}{$float} href=\"{$url}\"{$class}{$confirm}>{$title}</a>";
    }

    protected function _parseParams($item)
    {
        $params = array();
        foreach ($item as $key => $value) {
            if ($key != 'title' && $key != 'confirm' && $key != 'icon' && $key != 'url')
                $params[$key] = $value;
        }
        return $params;
    }

}
