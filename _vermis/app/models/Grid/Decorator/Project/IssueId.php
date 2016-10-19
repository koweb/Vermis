<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueId.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueId.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_IssueId
 * @brief Issue link decorator.
 */
class Grid_Decorator_Project_IssueId extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $row = $this->getRow();
        $view = $this->getView();
        $link = $view->issueLink(
            $row['project_slug'], $row['number'], $row['slug'], 
            $row['project_name'].'-'.$row['number']);
        return '<strong>'.$link.'</strong>';
    }
    
}
