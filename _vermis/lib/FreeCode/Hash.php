<?php

/**
 * =============================================================================
 * @file        FreeCode/Hash.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Hash.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
