<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Cell/MailTo.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: MailTo.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
