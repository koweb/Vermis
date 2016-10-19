<?php

/**
 * =============================================================================
 * @file        FreeCode/View/Helper/BoolLabel.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: BoolLabel.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_View_Helper_BoolLabel
 * @brief   View helper for rendering a boolean variable.
 */
class FreeCode_View_Helper_BoolLabel
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function boolLabel($bool, $trueLabel = null, $falseLabel = null)
    {
        $label = ($bool ? $trueLabel : $falseLabel);
        return (empty($label) ? null : _T($label));
    }

}
