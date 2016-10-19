<?php

/**
 * =============================================================================
 * @file        FreeCode/View/Helper/Date.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Date.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_View_Helper_Date
 * @brief   View helper for rendering a date.
 */
class FreeCode_View_Helper_Date
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function date($time, $format = null)
    {
        if (isset($format))
            return date($format, $time);
        
        $config = FreeCode_Config::getInstance();
        if (isset($config->dateFormat))
            $format = $config->dateFormat;
        else
            $format = 'Y-m-d H:i:s';
            
        return date($format, $time);
    }

}
