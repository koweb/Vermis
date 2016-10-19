<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Button.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Button.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Button
 * @brief   Grid button.
 */
class FreeCode_Grid_Button extends FreeCode_Grid_Label
{

    protected $_href = 'javascript:void(0)';
    
    /**
     * Constructor.
     * @param string $id
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this
            ->setDecorator(new FreeCode_Grid_Decorator_Button)
            ->setFloat(FreeCode_Grid_Element::FLOAT_RIGHT);
    }
    
    /**
     * Set href parameter.
     * @param   string  $href
     * @return FreeCode_Grid_Button
     */
    public function setHref($href)
    {
        $this->_href = $href;
        return $this;
    }
    
    /**
     * Get href parameter.
     * @return string
     */
    public function getHref()
    {
        return $this->_href;
    }
    
}
