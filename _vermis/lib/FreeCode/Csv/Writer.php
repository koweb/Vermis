<?php

/**
 * =============================================================================
 * @file        FreeCode/Csv/Writer.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Writer.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Csv_Writer
 * @brief   Write data to a CSV file.
 */
class FreeCode_Csv_Writer
{

    protected function __construct() {}

    /**
     * Write data to a CSV file.
     * @param array     $data
     * @param string    $fileName
     * @param string    $separator
     * @return boolean
     */
    public function write($data, $fileName, $separator = ';')
    {
        $csv = FreeCode_Csv_Exporter::export($data, $separator);
        return @file_put_contents($fileName, $csv);
    }
    
    /**
     * Write a row to a CSV file.
     * @param array     $data
     * @param string    $fileName
     * @param string    $separator
     * @return boolean
     */
    public function writeRow($data, $fileName, $separator = ';')
    {
        $csv = FreeCode_Csv_Exporter::exportRow($data, $separator);
        return @file_put_contents($fileName, $csv);
    }
    
}
