<?php

/**
 * =============================================================================
 * @file        FreeCode/View/Helper/JQueryCascadingMenu.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: JQueryCascadingMenu.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_View_Helper_JQueryCascadingMenu
 * @brief   View helper for rendering the cascading menu.
 */
class FreeCode_View_Helper_JQueryCascadingMenu
{

    static protected $_idCounter = 0;
    
    protected $_view = null;
    protected $_html = '';
    protected $_acl = null;
    protected $_identity = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function jQueryCascadingMenu($menu)
    {
        /// @TODO: The bad design :(
        if (class_exists('Acl', false))
            $this->_acl = new Acl;
        $this->_identity = FreeCode_Identity::getInstance();
        $this->_html = '';
        foreach ($menu as $id => $m) {
            if ($this->_view->activeMenuTab == $id)
                $this->_generateMenu($m, true);
            else
                $this->_generateMenu($m);
        }
        return $this->_html;
    }
    
    protected function _generateMenu($menu, $isActive = false)
    {
        $title = FreeCode_Translator::_($menu['title']);
        $url = $menu['url'];
        $menuId = $this->_getNextId('menu');
        $linkId = $this->_getNextId('link');
        
        if (isset($menu['role']) && !$this->_checkRole($menu['role']))
            return $menuId;
        
        $this->_html .= '<div id="'.$menuId.'" class="menu">';
        $this->_html .= '<div id="'.$linkId.'" class="link'.($isActive ? ' active' : '').'"><a href="'.$url.'">'.$title.'</a></div>';
        if (isset($menu['submenu'])) {
            $subMenuId = $this->_generateSubMenu($menu['submenu']);
            $this->_generateHover($menuId, $subMenuId);
        }
        $this->_html .= '</div><span></span>';
        return $menuId;
    }
    
    protected function _generateSubMenu($submenu, $isNested = false)
    {
        $class = 'submenu'.($isNested ? ' nested' : '');
        $subMenuId = $this->_getNextId('submenu');
        
        $this->_html .= '<div id="'.$subMenuId.'" class="'.$class.'">';
        foreach ($submenu as $link) {
            $title = FreeCode_Translator::_($link['title']);
            $url = $link['url'];
            $subLinkId = $this->_getNextId('sublink');
            
            if (isset($link['role']) && !$this->_checkRole($link['role']))
                continue;
        
            if (isset($link['submenu'])) {
                $this->_html .= '<div id="'.$subLinkId.'" class="sublink">';
                $nestMenuId = $this->_generateSubMenu($link['submenu'], true);
                $this->_html .= '<div><a class="arrow" href="'.$url.'">'.$title.'</a></div>';
                $this->_generateHover($subLinkId, $nestMenuId);
                $this->_html .= '</div>';
                
            } else {
                $this->_html .= '<div id="'.$subLinkId.'" class="sublink"><a href="'.$url.'">'.$title.'</a></div>';
            }
        }
        $this->_html .= '</div>';
        return $subMenuId;
    }
    
    protected function _generateHover($link, $menu)
    {
        $this->_html .= '<script type="text/javascript">';
        $this->_html .= 
            'var '.$menu.'_lock = false;'.
            '$("#'.$link.'").hover('.
            'function(){ '.$menu.'_lock = true; $("#'.$menu.'").css({"z-index": "1000"}).show("fast"); },'.
            'function(){ '.$menu.'_lock = false; $("#'.$menu.'").css({"z-index": "900"}).delay(333, function(){ if ('.$menu.'_lock == false) { $("#'.$menu.'").hide("fast"); } }); }'.
            ');';
        $this->_html .= '</script>';
    }
    
    protected function _getNextId($prefix)
    {
        return '_cm_'.$prefix.((string) ++self::$_idCounter);
    }

    protected function _checkRole($role)
    {
        if (!isset($this->_identity) || !isset($this->_acl))
           return false;
        if (    $this->_identity->role != $role &&
                !$this->_acl->inheritsRole($this->_identity->role, $role))
           return false;
        return true;
    }

}
