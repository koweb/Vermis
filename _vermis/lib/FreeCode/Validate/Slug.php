<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/Slug.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Slug.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Validate_Slug
 * @brief   Slug validator.
 */
class FreeCode_Validate_Slug extends Zend_Validate_Abstract
{

    const INVALID_SLUG = 'invalidSlug';

    protected $_messageTemplates = array(
        self::INVALID_SLUG => 'Invalid slug string'
    );

    /**
     * Validation.
     * @param   string  $value 
     * @return  boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if ($value != FreeCode_String::normalize($value)) {
            $this->_error(null);
            return false;
        }

        return true;
    }

}
