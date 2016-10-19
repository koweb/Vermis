<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Button/Multiselect.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Multiselect.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
