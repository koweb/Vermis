<?php

/**
 * =============================================================================
 * @file        FreeCode/Validate/Doctrine/UniqueSlug.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: UniqueSlug.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Validate_Doctrine_UniqueSlug
 * @brief   Unique slug validator.
 */
class FreeCode_Validate_Doctrine_UniqueSlug extends FreeCode_Validate_Doctrine_Unique
{

    /**
     * Validation.
     * @param   string  $value 
     * @return  boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);
        $value = FreeCode_String::normalize($value);
        
        $record = Doctrine::getTable($this->_modelName)
            ->findByDql("{$this->_columnName} = '{$value}'", array(), Doctrine::HYDRATE_ARRAY);
        if ($record) {
            $this->_error(null);
            return false;
        }
            
        return true;
    }

}
