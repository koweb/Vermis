<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Exporter/Csv.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Csv.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Exporter_Csv
 * @brief   Grid Exporter.
 */
class FreeCode_Grid_Exporter_Csv extends FreeCode_Grid_Exporter_Abstract
{

    /**
     * Construct.
     * @param string $name
     */
    public function __construct($name = 'csv')
    {
        parent::__construct($name);
        $this
            ->setContentType('text/x-csv')
            ->setFileName('export.csv');
    }
    
    public function export()
    {
        return FreeCode_Csv_Exporter::export(parent::export(), ',');
    }
    
    public function exportAll()
    {
        return FreeCode_Csv_Exporter::export(parent::exportAll(), ',');
    }
    
}
