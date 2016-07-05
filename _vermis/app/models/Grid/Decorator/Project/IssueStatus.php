<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueStatus.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssueStatus.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
