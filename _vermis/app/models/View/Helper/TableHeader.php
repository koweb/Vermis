<?php

/**
 * =============================================================================
 * @file        TableHeader.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: TableHeader.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   View_Helper_TableHeader
 * @brief   View helper for rendering the table header.
 */
class View_Helper_TableHeader
{

    protected $_view = null;
    protected $_request = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
        $this->_request = Zend_Controller_Front::getInstance()->getRequest();
    }

    public function tableHeader($title, $field, $params = array(), $router = null)
    {
        $sortField = '';
        $sortOrder = '';
        
        if ($this->_request) {
            $sortField = $this->_request->getParam('sort-field');
            $sortOrder = $this->_request->getParam('sort-order');
        }
        
        $sortOrder = strtolower($sortOrder);
        if ($sortOrder != 'asc' && $sortOrder != 'desc')
            $sortOrder = false;
            
        if (empty($sortField))
            $sortOrder = false;
            
        $title = $this->_view->spacesToNbsp($title);
            
        /*
         * If current sorting is by given field then create link for reverse order.
         */
        if ($sortField == $field) {
            $img = '<img style="float:left" src="gfx/'.$sortOrder.'.png" alt="" />';         
            $sortOrder = ($sortOrder == 'asc' ? 'desc' : 'asc');
            $url = $this->_view->url($params, $router).'?'.$this->_getParams($sortField, $sortOrder);
            $html = '<a class="strong" href="'.$url.'">'.$img.$title.'</a>';
            
        } else {
            $url = $this->_view->url($params, $router).'?'.$this->_getParams($field, 'asc');
            $html = '<a href="'.$url.'">'.$title.'</a>';
        }
        
        return $html; 
    }
    
    protected function _getParams($sortField, $sortOrder)
    {
        $page = 1;
        if ($this->_request) {
            $page = (int) $this->_request->getParam('page', 1);
            $query = $this->_request->getParam('query');
        }
        $ret = "page={$page}&amp;sort-field={$sortField}&amp;sort-order={$sortOrder}";
        if (!empty($query))
            $ret .= '&amp;query='.$query;
        return $ret;
    }

}
