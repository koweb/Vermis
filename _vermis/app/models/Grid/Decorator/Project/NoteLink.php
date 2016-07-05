<?php

/**
 * =============================================================================
 * @file        Grid/Decorator/Project/NoteLink.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NoteLink.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Decorator_Project_NoteLink
 * @brief Note link decorator.
 */
class Grid_Decorator_Project_NoteLink extends FreeCode_Grid_Decorator_Abstract
{

    public function render($content)
    {
        $row = $this->getRow();
        $view = $this->getView();
        $link = $view->noteLink(
            $row['project_slug'], $row['slug'], $content);
        return '<strong>'.$link.'</strong>';
    }
    
}
