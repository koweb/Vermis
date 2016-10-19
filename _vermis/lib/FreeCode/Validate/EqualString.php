<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/EqualString.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: EqualString.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Validate_EqualString
 * @brief   Equal string validator.
 */
class FreeCode_Validate_EqualString extends Zend_Validate_Abstract
{

    const STRINGS_NOT_EQUAL = 'stringsNotEqual';

    protected $_messageTemplates = array(
        self::STRINGS_NOT_EQUAL => 'Given values are not equal'
    );

    protected $_string = null;
    protected $_caseSensitive = null;

    /**
     * Constructor.
     * @param   string  $string
     * @param   string  $caseSensitive
     */
    public function __construct($string, $caseSensitive = false)
    {
        $this->_string = $string;
        $this->_caseSensitive = $caseSensitive;
    }

    /**
     * Validation.
     * @param   string  $value 
     * @return  boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if ($this->_caseSensitive) {
            if (strcasecmp($value, $this->_string) != 0) {
                $this->_error(null);
                return false;
            }


        } else {
            if (strcmp($value, $this->_string) != 0) {
                $this->_error(null);
                return false;
            }
        }

        return true;
    }

}
