<?php

/**
 * =============================================================================
 * @file        FreeCode/FileSystem.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: FileSystem.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_FileSystem
 * @brief   String manipulations.
 */
class FreeCode_FileSystem
{
    
    protected function __construct() {}

    /**
     * Get file info
     * @param   string $fileName
     * @return  array
     */
    public static function getFileInfo($fileName)
    {
        if (!file_exists($fileName))
            throw new FreeCode_Exception_FileNotFound($fileName);

        $pathInfo = pathinfo($fileName);

        $info = array();
        $info['path']        = $fileName;
        $info['size']        = filesize($fileName);
        $info['fileName']    = $pathInfo['basename'];
        $info['destination'] = $pathInfo['dirname'];
        $info['baseName']    = $pathInfo['filename'];
        $info['extension']   = $pathInfo['extension'];
        $info['md5']         = md5_file($fileName);
        $info['sha1']        = sha1_file($fileName);

        return $info;
    }

    /**
     * Get image file info.
     * @param   string $fileName
     * @return  array
     */
    public static function getImageInfo($fileName)
    {
        if (!file_exists($fileName))
            throw new FreeCode_Exception_FileNotFound($fileName);
        
        $imageInfo = getimagesize($fileName);

        $info = array();
        $info['width']    = $imageInfo[0];
        $info['height']   = $imageInfo[1];
        $info['bits']     = $imageInfo['bits'];
        //$info['channels'] = $imageInfo['channels'];// @todo deprecated?
        $info['mime']     = $imageInfo['mime'];

        return $info;
    }

    /**
     * Parse file path.
     * @note    Used in FreeCode_Filter_File*
     * @param   string  $path
     * @param   array   $params
     * @return  array
     */
    public static function parsePath($path, array $params = null)
    {
        if (!isset($params))
            $params = $this->_getFileInfo();

        foreach ($params as $key => $value)
            $path = str_replace('<'.$key.'>', $value, $path);

        return $path;
    }

}
