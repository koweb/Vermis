<?php

/**
 * =============================================================================
 * @file        FreeCode/Thumbnail.php
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
 * @class   FreeCode_Thumbnail
 * @brief   Thumbnailer engine.
 */
class FreeCode_Thumbnail
{

    protected $_thumbImage = null;
    protected $_thumbWidth = 0;
    protected $_thumbHeight = 0;

    protected $_sourceImage = null;
    protected $_sourceWidth = 0;
    protected $_sourceHeight = 0;
    protected $_fileType = null;

    /**
     * @param int       $width Thumb width.
     * @param int       $height Thumb height.
     * @param string    $fileName Source image path.
     * @throws BluePaprica_Exception
     */
    public function __construct($width, $height, $fileName = null)
    {
        if (!function_exists('imagecreate'))
            throw new FreeCode_Exception('GD module is not installed!');

        $this->_createThumb($width, $height);
        if (isset($fileName))
            $this->load($fileName);
    }

    public function __destruct()
    {
        $this->_destroyThumb();
        $this->_destroySource();
    }

    /**
     * Get thumb width.
     * @return  int
     */
    public function getThumbWidth() 
    { 
        return $this->_thumbWidth; 
    }

    /**
     * Get thumb height.
     * @return  int
     */
    public function getThumbHeight() 
    { 
        return $this->_thumbHeight;
    }
    
    /**
     * Get source width.
     * @return int
     */
    public function getSourceWidth()
    {
        return $this->_sourceWidth;
    }
    
    /**
     * Get source height.
     * @return int
     */
    public function getSourceHeight()
    {
        return $this->_sourceHeight;
    }

    /**
     * Allocate space for thumb.
     * @param   int $width  Thumb width.
     * @param   int $height Thumb height.
     * @throws  FreeCode_Exception
     * @return  FreeCode_Thumbnail
     */
    protected function _createThumb($width, $height)
    {
        $this->_thumbImage = @imagecreatetruecolor($width, $height);
        if (!$this->_thumbImage)
            throw new FreeCode_Exception("Cannot create thumb image!");

        $this->_thumbWidth = $width;
        $this->_thumbHeight = $height;

        return $this;
    }

    protected function _destroyThumb()
    {
        if (isset($this->_thumbImage))
            imagedestroy($this->_thumbImage);
    }

    /**
     * Load source image.
     * @param   string  $fileName Path.
     * @throws  FreeCode_Exception
     * @return  FreeCode_Thumbnail
     */
    public function load($fileName)
    {
        $this->_destroySource();

        if (!file_exists($fileName))
            throw new FreeCode_Exception_FileNotFound("File '{$fileName}' not found!");
        
        $imageInfo = getimagesize($fileName);
        if (!$imageInfo)
            throw new FreeCode_Exception_InvalidFormat("Cannot get image size from '{$fileName}'!");

        switch ($imageInfo['mime']) {
            case 'image/jpeg':
                $this->_sourceImage = @imagecreatefromjpeg($fileName);
                $this->_fileType = 'jpeg';
                break;

            case 'image/png':
                $this->_sourceImage = @imagecreatefrompng($fileName);
                $this->_fileType = 'png';
                break;
            
            case 'image/gif':
                $this->_sourceImage = @imagecreatefromgif($fileName);
                $this->_fileType = 'gif';
                break;
                
            default:
                throw new FreeCode_Exception_InvalidFormat("Unsupported file type '{$fileName}'!");
        }

        if (!$this->_sourceImage)
            throw new FreeCode_Exception_InvalidFormat("Cannot load image from file '{$fileName}'!");

        $this->_sourceWidth = imagesx($this->_sourceImage);
        $this->_sourceHeight = imagesy($this->_sourceImage);

        return $this;
    }

    protected function _destroySource()
    {
        if (isset($this->_sourceImage))
            imagedestroy($this->_sourceImage);
    }

    /**
     * Thumbnail.
     * @return  FreeCode_Thumbnail
     */
    public function thumb()
    {
        imagecopyresampled(
            $this->_thumbImage,
            $this->_sourceImage,
            0, 0,
            0, 0,
            $this->_thumbWidth, $this->_thumbHeight,
            $this->_sourceWidth, $this->_sourceHeight
        );

        return $this;
    }

    /**
     * Thumbnail.
     * @return  FreeCode_Thumbnail
     */
    public function thumbCenter()
    {
        $thumbAspectRatio = $this->_thumbWidth / $this->_thumbHeight;
        $sourceAspectRatio = $this->_sourceWidth / $this->_sourceHeight;

        if ($sourceAspectRatio >= 1.0) {
            $cropWidth = $this->_sourceHeight * $thumbAspectRatio;
            $cropHeight = $this->_sourceHeight;
            $cropX = ($this->_sourceWidth - $cropWidth) / 2;
            $cropY = 0;

        } else {
            $cropHeight = $this->_sourceWidth * $thumbAspectRatio;
            $cropWidth = $this->_sourceWidth;
            $cropY = ($this->_sourceHeight - $cropHeight) / 2;
            $cropX = 0;
        }

        imagecopyresampled(
            $this->_thumbImage,
            $this->_sourceImage,
            0, 0,
            $cropX, $cropY,
            $this->_thumbWidth, $this->_thumbHeight,
            $cropWidth, $cropHeight
        );

        return $this;
    }

    /**
     * Crop image and resample if necessary.
     * @param   int $srcX   Crop left position.
     * @param   int $srcY   Crop top position.
     * @param   int $width  Crop area width.
     * @param   int $height Crop area height.
     * @return  FreeCode_Thumbnail
     */
    public function crop($srcX, $srcY, $width, $height)
    {
        if ($width == $this->_thumbWidth && $height == $this->_thumbHeight) {
            imagecopy(
                $this->_thumbImage,
                $this->_sourceImage,
                0, 0,
                $srcX, $srcY,
                $width, $height
            );

        } else {
            imagecopyresampled(
                $this->_thumbImage,
                $this->_sourceImage,
                0, 0,
                $srcX, $srcY,
                $this->_thumbWidth, $this->_thumbHeight,
                $width, $height
            );
        }

        return $this;
    }

    /**
     * Save thumb to jpeg file.
     * @param   string  $fileName
     * @throws  FreeCode_Exception
     * @return  FreeCode_Thumbnail
     */
    public function saveJpeg($fileName)
    {
        if (!@imagejpeg($this->_thumbImage, $fileName))
            throw new FreeCode_Exception("Cannot save thumb to jpeg file '{$fileName}'!");
        return $this;
    }

    /**
     * Save thumb to png file.
     * @param   string  $fileName
     * @throws  FreeCode_Exception
     * @return  FreeCode_Thumbnail
     */
    public function savePng($fileName)
    {
        if (!@imagepng($this->_thumbImage, $fileName))
            throw new FreeCode_Exception("Cannot save thumb to png file '{$fileName}'!");
        return $this;
    }

    /**
     * Save thumb to gif file.
     * @param   string  $fileName
     * @throws  FreeCode_Exception
     * @return  FreeCode_Thumbnail
     */
    public function saveGif($fileName)
    {
        if (!@imagegif($this->_thumbImage, $fileName))
            throw new FreeCode_Exception("Cannot save thumb to gif file '{$fileName}'!");
        return $this;
    }
    
    
    /**
     * Save thumb to png/jpg/gif file.
     * @param   string  $fileName
     * @throws  FreeCode_Exception
     * @return  FreeCode_Thumbnail
     */
    public function save($fileName)
    {
        $ext = FreeCode_String::getFileNameExtension($fileName);
        switch(strtolower($ext)) {
            case 'png':
                $this->savePng($fileName);
            break;
            case 'jpeg':
            case 'jpg':
                $this->saveJpeg($fileName);
            break;
            case 'gif':
                $this->saveGif($fileName);
            break;
            default:
                throw new FreeCode_Exception("Unsupported file type '{$ext}'!");
        }
        
        return $this;
    }
}
