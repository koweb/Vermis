<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Navigator.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Navigator.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Issues_Navigator
 * @brief Project issues grid.
 */
class Grid_Project_Issues_Navigator extends Grid_Project_Issues
{
    
    public function __construct(array $params, $id = 'issues_navigator')
    {
        parent::__construct($params, $id);

        $this
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption('issues_navigator');
        
        $this->getColumn('update_time')->setHidden(false);
    }
    
}
