<?php

/**
 * =============================================================================
 * @file        ProgressBar.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProgressBar.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
