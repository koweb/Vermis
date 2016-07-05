<?php

/**
 * =============================================================================
 * @file        FreeCode/Translator.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Translator.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Translator
 * @brief   Translation engine.
 */
class FreeCode_Translator
{

    protected static $_instance = null;
    
    protected function __construct() {}
    
    /**
     * Factory pattern.
     * @param   string  $fileName   Translation file name.
     * @param   string  $locale     Locale name.
     * @return  Zend_Translate
     */
    public static function load($fileName, $locale)
    {
        if (!file_exists($fileName) || !is_readable($fileName))
            throw new FreeCode_Exception_FileNotFound("Cannot load translation file '{$fileName}'!");
            
        $translation = @include $fileName;
        if (!is_array($translation))
            throw new FreeCode_Exception_InvalidFormat("Invalid translation file '{$fileName}'!");
            
        if (count($translation) == 0)
            $translation[''] = '';
            
        self::$_instance = new Zend_Translate('array', $translation, $locale);
        self::$_instance->setLocale($locale);
        
        return self::$_instance;
    }
    
    /**
     * Singleton pattern.
     * @return  Zend_Translate
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance))
            throw new FreeCode_Exception("Use FreeCode_Translator::load first!");
        return self::$_instance;
    }
    
    /**
     * Translate.
     * @param   string  $text   Text to translate.
     * @return  string
     */
    public static function _($text)
    {
        if (!isset(self::$_instance))
            throw new FreeCode_Exception("Use Translator::load first!");
        return self::$_instance->_($text);
    }
    
}

/**
 * Translate string.
 * @param   string  $text Text to translate.
 * @return  string
 */
function _T($text)
{
    return FreeCode_Translator::_($text);
}
