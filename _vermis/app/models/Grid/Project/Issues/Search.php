<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues/Search.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Search.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
