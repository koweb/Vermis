<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Button/Multiselect.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Multiselect.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Button_Multiselect
 * @brief   Grid button.
 */
class FreeCode_Grid_Button_Multiselect extends FreeCode_Grid_Button
{

    /**
     * Constructor.
     * @param string $id
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->setDecorator(new FreeCode_Grid_Decorator_Button_Multiselect);
    }
    
}
