<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/EqualPasswordHash.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: EqualPasswordHash.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
