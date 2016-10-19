<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssuePriority.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssuePriority.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_IssuePriority
 * @brief Issue priority decorator.
 */
class Grid_Decorator_Project_IssuePriority extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        return $this->getView()->issuePriority($content);
    }
    
}
