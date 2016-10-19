<?php

/**
 * =============================================================================
 * @file        FreeCode/Captcha/Image.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Image.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Captcha_Image
 * @brief   Captcha.   
 */
class FreeCode_Captcha_Image extends Zend_Captcha_Image
{
    
    /**
     * @note    Some modifications are needed in Zend_Captcha_Image.
     */

    public function __construct($options = null)
    {
        parent::__construct();
        
        $config = FreeCode_Config::getInstance();
        
        $this->setGcFreq(100);
        $this->setFont(FIXTURES_DIR.'/captcha.ttf');
        $this->setFontSize(16);
        $this->setWidth(100);
        $this->setHeight(30);
        $this->setTimeout(300);
        $this->setWordLen(4);
        $this->setImgDir(CAPTCHA_DIR);
        $this->setImgUrl($config->baseHost.$config->baseUri.CAPTCHA_URL);
    }
    
    /**
     * Generate image captcha
     * @param   string  $id   Captcha ID
     * @param   string  $word Captcha word
     * @return  void
     */
    protected function _generateImage($id, $word)
    {
        if (!extension_loaded("gd")) {
            require_once 'Zend/Captcha/Exception.php';
            throw new Zend_Captcha_Exception("Image CAPTCHA requires GD extension");
        }

        if (!function_exists("imagepng")) {
            require_once 'Zend/Captcha/Exception.php';
            throw new Zend_Captcha_Exception("Image CAPTCHA requires PNG support");
        }

        if (!function_exists("imageftbbox")) {
            require_once 'Zend/Captcha/Exception.php';
            throw new Zend_Captcha_Exception("Image CAPTCHA requires FT fonts support");
        }

        $font = $this->getFont();

        if (empty($font)) {
            require_once 'Zend/Captcha/Exception.php';
            throw new Zend_Captcha_Exception("Image CAPTCHA requires font");
        }

        $w     = $this->getWidth();
        $h     = $this->getHeight();
        $fsize = $this->getFontSize();

        $img_file   = $this->getImgDir() . $id . $this->getSuffix();
        if(empty($this->_startImage)) {
            $img        = imagecreatetruecolor($w, $h);
        } else {
            $img = imagecreatefrompng($this->_startImage);
            if(!$img) {
                require_once 'Zend/Captcha/Exception.php';
                throw new Zend_Captcha_Exception("Can not load start image");
            }
            $w = imagesx($img);
            $h = imagesy($img);
        }
        
        $text_color     = imagecolorallocate($img, 64, 64, 255);
        $bg_color       = imagecolorallocate($img, 200, 200, 255);
        $noise_color    = imagecolorallocate($img, 128, 128, 200);

        // Background.
        imagefilledrectangle($img, 0, 0, $w-1, $h-1, $bg_color);
        for ($i=0; $i<$this->_dotNoiseLevel; $i++) {
           imagefilledellipse($img, mt_rand(0,$w), mt_rand(0,$h), 2, 2, $noise_color);
        }
        for($i=0; $i<$this->_lineNoiseLevel; $i++) {
           imageline($img, mt_rand(0,$w), mt_rand(0,$h), mt_rand(0,$w), mt_rand(0,$h), $noise_color);
        }
        
        /**
         * @todo
         * There is a bug with imageftbbox. Wrong values returned.
         */
        /*
        var_dump($fsize);
        var_dump($font);
        var_dump($word);
        $textbox = imageftbbox($fsize, 0, $font, $word);
        var_dump($textbox);
        $x = ($w - ($textbox[2] - $textbox[0])) / 2;
        $y = ($h - ($textbox[7] - $textbox[1])) / 2;
        */
        
        $x = 25; $y = 22;
        imagefttext($img, $fsize, 0, $x, $y, $text_color, $font, $word);
        
        imagepng($img, $img_file);
        imagedestroy($img);
    }

}
