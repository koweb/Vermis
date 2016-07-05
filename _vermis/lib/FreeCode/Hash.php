<?php

/**
 * =============================================================================
 * @file        FreeCode/Hash.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Hash.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Hash
 * @brief   Hashing utility class.
 */
class FreeCode_Hash
{

    /**
     * Encode password.
     * @note    Used by FreeCode_Validate_EqualString.
     * @param   string  $token
     * @return  string
     */
    public static function encodePassword($token)
    {
        return md5($token);
    }
    
}
