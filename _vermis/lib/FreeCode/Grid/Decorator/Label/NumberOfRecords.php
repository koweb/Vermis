<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Label/NumberOfRecords.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: NumberOfRecords.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
