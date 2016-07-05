<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/EqualPasswordHash.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: EqualPasswordHash.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Validate_EqualPasswordHash
 * @brief   Equal password validator.
 */
class FreeCode_Validate_EqualPasswordHash extends Zend_Validate_Abstract
{

    const PASSWORDS_NOT_EQUAL = 'passwordsNotEqual';

    protected $_messageTemplates = array(
        self::PASSWORDS_NOT_EQUAL => 'Password does not match'
    );

    protected $_passwordHash = null;

    /**
     * Constructor.
     * @param   string  $_passwordHash
     */
    public function __construct($passwordHash)
    {
        $this->_passwordHash = $passwordHash;
    }

    /**
     * Validation.
     * @param   string  $value 
     * @return  boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if (FreeCode_Hash::encodePassword($value) != $this->_passwordHash) {
            $this->_error(null);
            return false;
        }

        return true;
    }

}
