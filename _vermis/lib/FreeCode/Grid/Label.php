<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Label.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Label.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Label
 * @brief   Grid label.
 */
class FreeCode_Grid_Label extends FreeCode_Grid_Element
{

    protected $_caption = '';
    
    /**
     * Constructor.
     * @param string $id
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this
            ->setDecorator(new FreeCode_Grid_Decorator_Label)
            ->setFloat(FreeCode_Grid_Element::FLOAT_LEFT);
    }
    
    /**
     * Set caption.
     * @param string $caption
     * @return FreeCode_Grid_Label
     */
    public function setCaption($caption)
    {
        $this->_caption = $caption;
        return $this;
    }
    
    /**
     * Get caption.
     * @return string
     */
    public function getCaption()
    {
        return $this->_caption;
    }
    
}
