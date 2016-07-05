<?php

/**
 * =============================================================================
 * @file        ProgressBar.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ProgressBar.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class View_Helper_ProgressBar
 * @brief Helper for progress bar rendering.
 */
class View_Helper_ProgressBar
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    /**
     * @param int $progress
     * @param int $width
     * @return string
     */
    public function progressBar($progress, $width = null)
    {
        if ($progress >= 66) $color = '1cb318';
        else if ($progress > 33) $color = 'ffde03';
        else $color = 'e03500';
        
        if (isset($width))
            $width = ' width:'.$width.'px';

        $html = 
            '<div style="border:1px solid #444444; background:#ffffff; margin:2px;'.$width.'">' .
            '<div style="width:'.$progress.'%; background:#'.$color.'; height:11px;"></div>' . 
            '</div>';
        return $html;
    }

}
