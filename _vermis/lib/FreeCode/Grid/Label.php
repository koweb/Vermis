<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Label.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Label.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
