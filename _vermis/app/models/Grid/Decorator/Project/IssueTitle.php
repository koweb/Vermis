<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/IssueTitle.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueTitle.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
