<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Cell/MailTo.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: MailTo.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Cell_MailTo
 * @brief   Grid decorator.
 */
class FreeCode_Grid_Decorator_Cell_MailTo extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $c = $this->getView()->escape($content);
        return '<a href="mailto:'.$c.'" title="'.$c.'">'.$c.'</a>';
    }
    
}
