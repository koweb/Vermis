<?php

/**
 * =============================================================================
 * @file        FreeCode/View/Helper/BreadCrumbs.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: BreadCrumbs.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_View_Helper_BreadCrumbs
 * @brief   View helper for rendering the bread crumbs.
 */
class FreeCode_View_Helper_BreadCrumbs
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function breadCrumbs($bc)
    {
        $html = '';
        
        $n = count($bc->getCrumbs());
        foreach ($bc->getCrumbs() as $crumb) {
            $n--;

            if ($crumb['isUrl'])
                $url = $crumb['url'];
            else
                $url = $this->_view->url($crumb['options'], $crumb['route']);

            $title = FreeCode_Translator::_($crumb['title']);
            if ($n > 0)
                $html .= '<span class="bread-crumb"><a href="'.$url.'" title="'.$title.'">'.$title.'</a></span><span class="bread-crumb separator">&raquo;</span>';
            else
                $html .= '<span class="bread-crumb"><a class="active" href="'.$url.'" title="'.$title.'">'.$title.'</a></span>';
        }
        
        return $html;
    }

}
