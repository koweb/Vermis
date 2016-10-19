<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueStatus.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueStatus.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_IssueStatus
 * @brief Issue status decorator.
 */
class Grid_Decorator_Project_IssueStatus extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        return $this->getView()->issueStatus($content);
    }
    
}
