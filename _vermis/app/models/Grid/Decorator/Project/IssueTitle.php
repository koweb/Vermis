<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueTitle.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssueTitle.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_IssueTitle
 * @brief Issue title decorator.
 */
class Grid_Decorator_Project_IssueTitle extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $row = $this->getRow();
        $view = $this->getView();
        $link = $view->issueLink(
            $row['project_slug'], $row['number'], $row['slug'], $content);
        return '<strong>'.$link.'</strong>';
    }
    
}
