<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/EqualString.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: EqualString.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
