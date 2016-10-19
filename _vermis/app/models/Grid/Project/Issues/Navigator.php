<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Navigator.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Navigator.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
