<?php

/**
 * =============================================================================
 * @file        FreeCode/Csv/Writer.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Writer.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
    public static function write($data, $fileName, $separator = ';')
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
    public static function writeRow($data, $fileName, $separator = ';')
    {
        $csv = FreeCode_Csv_Exporter::exportRow($data, $separator);
        return @file_put_contents($fileName, $csv);
    }
    
}
