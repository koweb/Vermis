<?php

/**
 * =============================================================================
 * @file        FreeCode/Csv/Exporter.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Exporter.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Csv_Exporter
 * @brief   Export data to CSV format.
 */
class FreeCode_Csv_Exporter
{

    protected $_separator = null;
    
    protected function __construct($separator) 
    {
        $this->_separator = $separator;
    }
    
    /**
     * Export data to the CSV format.
     * @param array     $data
     * @param string    $separator
     * @return string
     */
    public static function export($data, $separator = ';')
    {
        $exporter = new self($separator);
        return $exporter->_exportData($data);
    }
    
    /**
     * Export single row to the CSV format.
     * @param array     $row
     * @param string    $separator
     * @return string
     */
    public static function exportRow($row, $separator = ';')
    {
        $exporter = new self($separator);
        return $exporter->_exportRow($row)."\n";
    }
    
    protected function _exportData($data)
    {
        if (!is_array($data)) {
            return $this->_exportCell((string) $data)."\n";
        }
        
        $output = '';
        foreach ($data as $row) {
            $output .= $this->_exportRow($row)."\n";
        }
        return $output;
    }
    
    protected function _exportRow($row)
    {
        if (!is_array($row)) {
            return $this->_exportCell((string) $row);
        }
        
        $output = '';
        $isFirst = true;
        foreach ($row as $cell) {
            if (!$isFirst)
                $output .= $this->_separator;
            $isFirst = false;
            $output .= $this->_exportCell($cell);
        }
        return $output;
    }
    
    protected function _exportCell($cell)
    {
        if ($cell === 0)
            return '0';
        if (empty($cell))
            return '""';
        $quote = false;
        if (strstr($cell, '"')) {
            $quote = true;
            $cell = str_replace('"', '""', $cell);
        }
        if (strstr($cell, ',') || strstr($cell, ';'))
            $quote = true;
        if (str_word_count($cell) > 1)
            $quote = true;
        if ($quote)
            $cell = '"'.$cell.'"';
        return $cell;
    }
    
}
