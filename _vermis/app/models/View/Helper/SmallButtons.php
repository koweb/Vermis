<?php

/**
 * =============================================================================
 * @file        SmallButtons.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: SmallButtons.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class View_Helper_SmallButtons
 * @brief Helper for small buttons rendering.
 */
class View_Helper_SmallButtons
{

    protected $_view = null;
    protected $_controller = null;
    protected $_action = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function smallButtons($buttons)
    {
        $ctrl = Zend_Controller_Front::getInstance();
        
        if ($request = $ctrl->getRequest()) {
            $this->_controller = $request->getControllerName();
            $this->_action = $request->getActionName();
        }

        $html = '';
        foreach ($buttons as $button) {
            $html .= $this->_showButton($button);
        }
        return $html;
    }

    protected function _showButton($button)
    {
        if (isset($button['blank']) && $button['blank'] == true) {
            return '<a class="small-button"><img src="gfx/icons/10/blank.png" alt="blank" /></a>';
        }

        $controller = (isset($button['controller']) ? $button['controller'] : $this->_controller);
        $action = (isset($button['action']) ? $button['action'] : $this->_action);
        $url = (isset($button['url']) ? $button['url'] : $this->_view->url($this->_parseParams($button)));
        $title = FreeCode_Translator::_($button['title']);
        $icon = (isset($button['icon']) ? $button['icon'] : $action);
        $confirmMsg = FreeCode_Translator::_(isset($button['confirmMsg']) ? $button['confirmMsg'] : 'Are you sure?');
        $confirmJs = "return confirm('{$confirmMsg}')";
        $confirm = (isset($button['confirm']) && $button['confirm'] == true ? $button = 'onclick="'.$confirmJs.'"' : '');
        $id = (isset($button['id']) ? 'id="'.$button['id'].'"' : '');
        return '<a '.$id.' class="small-button" href="'.$url.'" title="'.$title.'" '.$confirm.'><img src="gfx/icons/10/'.$icon.'.png" alt="'.$icon.'" title="'.$title.'" /></a>';
    }

    protected function _parseParams($item)
    {
        $params = array();
        foreach ($item as $key => $value) {
            if ($key != 'title' && $key != 'confirm' && $key != 'icon' && $key != 'blank' && $key != 'url')
                $params[$key] = $value;
        }
        return $params;
    }

}
