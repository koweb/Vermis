<?php

/**
 * =============================================================================
 * @file        FreeCode/View/Helper/BreadCrumbs.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: SpacesToNbsp.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class FreeCode_View_Helper_SpacesToNbsp
 * @brief Replace all spaces by &nbsp;
 */
class FreeCode_View_Helper_SpacesToNbsp
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function spacesToNbsp($text)
    {
        $text = str_replace(' ', '&nbsp;', $text);
        $text = str_replace("\n", '&nbsp;', $text);
        $text = str_replace("\t", '&nbsp;', $text);
        $text = str_replace("\r", '&nbsp;', $text);
        return $text;
    }

}
