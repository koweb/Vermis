<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Label/NumberOfRecords.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: NumberOfRecords.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Label_NumberOfRecords
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Label_NumberOfRecords extends FreeCode_Grid_Decorator_Label
{

    public function render($content)
    {
        $label = $this->getElement();
        $pager = $this->getGrid()->getPager();
        return parent::render($label->getCaption().' '.$pager->getTotalRows());
    }
    
}
