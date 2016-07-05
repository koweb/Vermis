<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueType.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssueType.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_IssueType
 * @brief Issue type decorator.
 */
class Grid_Decorator_Project_IssueType extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        return Project_Issue::getTypeLabel($content);
    }
    
}
