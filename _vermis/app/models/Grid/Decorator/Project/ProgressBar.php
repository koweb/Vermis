<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/ProgressBar.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProgressBar.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_ProgressBar
 * @brief Progress bar decorator.
 */
class Grid_Decorator_Project_ProgressBar extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        return $this->getView()->progressBar($content);
    }
    
}
