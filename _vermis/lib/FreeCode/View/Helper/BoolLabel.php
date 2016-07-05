<?php

/**
 * =============================================================================
 * @file        FreeCode/View/Helper/BoolLabel.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: BoolLabel.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
