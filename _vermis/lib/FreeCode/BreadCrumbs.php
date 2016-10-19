<?php

/**
 * =============================================================================
 * @file        FreeCode/BreadCrumbs.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: BreadCrumbs.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_BreadCrumbs
 * @brief   Bread crumbs.
 */
class FreeCode_BreadCrumbs
{

    protected $_crumbs = array();

    protected function __construct() {}
    
    /**
     * Singleton pattern.
     * @return  FreeCode_BreadCrumbs
     */
    public static function getInstance()
    {
        static $instance;
        if (!isset($instance))
            $instance = new self;
        return $instance;
    }
    
    /**
     * Add crumb.
     * @param   string  $title      
     * @param   string  $options    
     * @param   string  $route      
     * @return  FreeCode_BreadCrumbs
     */
    public function addCrumb($title, $options = array(), $route = null)
    {
        $this->_crumbs[] = array(
            'title' => $title,
            'options' => $options,
            'route' => $route,
            'isUrl' => false
        );
        return $this;
    }

    /**
     * Add simple url crumb.
     * @param   string  $title
     * @param   string  $url
     * @return  FreeCode_BreadCrumbs
     */
    public function addCrumbUrl($title, $url)
    {
        $this->_crumbs[] = array(
            'title' => $title,
            'url' => $url,
            'isUrl' => true
        );
        return $this;
    }

    /**
     * Remove all crumbs.
     * @return  FreeCode_BreadCrumbs
     */
    public function clear()
    {
        $this->_crumbs = array();
        return $this;
    }

    /**
     * Get crumbs map.
     * @return  array
     */
    public function getCrumbs()
    {
        return $this->_crumbs;
    }

}
