<?php

/**
 * =============================================================================
 * @file        FreeCode/View/Helper/Pager.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Pager.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class FreeCode_View_Helper_Pager
 * @brief Helper for pager rendering.
 */
class FreeCode_View_Helper_Pager
{
    
    static public $imagesPath = 'gfx/pager';
    
    protected $_view = null;
    protected $_pager = null;
    protected $_route = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function pager($pager, $route = null)
    {
        $this->_pager = $pager;
        $this->_route = $route;

        $imgPath = self::$imagesPath;
        
        echo '<div class="pager">';
        echo '<a href="'.$this->_view->url(array('page' => $pager->getFirstPage()), $route).$this->_queryString().'" title="'.FreeCode_Translator::_('First page').'"><img src="'.$imgPath.'/first.png" alt="first" /></a>';
        echo '<a href="'.$this->_view->url(array('page' => $pager->getPreviousPage()), $route).$this->_queryString().'" title="'.FreeCode_Translator::_('Previous page').'"><img src="'.$imgPath.'/prev.png" alt="prev" /></a>';
        $this->_prev();
        echo '<a class="active" href="'.$this->_view->url().$this->_queryString().'">['.$pager->getPage().']</a>';
        $this->_next();
        echo '<a href="'.$this->_view->url(array('page' => $pager->getNextPage()), $route).$this->_queryString().'" title="'.FreeCode_Translator::_('Next page').'"><img src="'.$imgPath.'/next.png" alt="next" /></a>';
        echo '<a href="'.$this->_view->url(array('page' => $pager->getLastPage()), $route).$this->_queryString().'" title="'.FreeCode_Translator::_('Last page').'"><img src="'.$imgPath.'/last.png" alt="last" /></a>';
        echo '</div>';
    }
    
    protected function _prev()
    {
        $page = $this->_pager->getPage();
        for ($n = 5; $n >= 1; $n--) {
            $p = $page - $n;
            if ($p >= $this->_pager->getFirstPage()) {
                $url = $this->_view->url(array('page' => $p), $this->_route).$this->_queryString();
                echo '<a href="'.$url.'">'.$p.'</a>';
            }
        }
    }
    
    protected function _next()
    {
        $page = $this->_pager->getPage();
        for ($n = 1; $n <= 5; $n++) {
            $p = $page + $n;
            if ($p <= $this->_pager->getLastPage()) {
                $url = $this->_view->url(array('page' => $p), $this->_route).$this->_queryString();
                echo '<a href="'.$url.'">'.$p.'</a>';
            }
        }
    }
    
    protected function _queryString()
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            $qs = '?'.str_replace('&', '&amp;', $_SERVER['QUERY_STRING']);
            return ($qs == '?' ? '' : $qs);
        }
        return '';
    }
    
}
