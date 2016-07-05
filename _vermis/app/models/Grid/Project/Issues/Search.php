<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Search.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Search.php 123 2011-01-29 23:37:30Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Issues_Search
 * @brief Project issues grid.
 */
class Grid_Project_Issues_Search extends Grid_Project_Issues
{
    
    public function __construct(array $params, $id = 'issues_search')
    {
        parent::__construct($params, $id);
        $this
            ->setImporter(new Grid_Importer_Project_Issues_Search($params));
    }
    
}
