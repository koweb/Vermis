<?php

/**
 * =============================================================================
 * @file        FreeCode/Filter/File/Thumbnail.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Thumbnail.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Filter_File_Thumbnail
 * @brief   Thumbnailer. 
 */
class FreeCode_Filter_File_Thumbnail extends FreeCode_Filter_File_Abstract implements Zend_Filter_Interface
{

    protected $_options = array();
    protected $_info = null;
    protected $_value = null;
    
    public function __construct(array $options)
    {
        $this->_options = $options;
    }
    
    public function filter($value)
    {
        $this->_value = $value;
        $this->_info = $this->_getFileInfo($value);

        foreach ($this->_options as $options) {
            if (    !isset($options['width']) 
                    || !isset($options['height'])
                    || !isset($options['path']))
                throw new FreeCode_Exception_InvalidFormat("Thumb options are invalid!");
            $this->_thumbnail($options['width'], $options['height'], $options['path']);
        }
        
        return $value;
    }

    protected function _thumbnail($width, $height, $path)
    {
        $path = $this->_parsePath($path, $this->_info);

        $thumbnail = new FreeCode_Thumbnail($width, $height);
        $thumbnail
            ->load($this->_value)
            ->thumb()
            ->save($path);
    }

}
