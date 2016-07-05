<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/RowsPerPage.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: RowsPerPage.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_RowsPerPage
 * @brief   Grid rows per page.
 */
class FreeCode_Grid_RowsPerPage extends FreeCode_Grid_Element
{
    
    protected $_options = array(
        10 => 10,
        20 => 20,
        50 => 50,
        100 => 100
    );

    /**
     * Constructor.
     * @param string $id
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this
            ->setDecorator(new FreeCode_Grid_Decorator_RowsPerPage)
            ->setFloat(FreeCode_Grid_Element::FLOAT_RIGHT);
    }
    
    /**
     * Set options.
     * @param array $options
     * @return FreeCode_Grid_RowsPerPage
     */
    public function setOptions(array $options)
    {
        $this->_options = $options;
        return $this;
    }
    
    /**
     * Get options.
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }
    
}
