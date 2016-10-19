<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueType.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueType.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
